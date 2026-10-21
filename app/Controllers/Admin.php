<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\SettingModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Admin extends Controller
{
    public function orders()
    {
        $orders = (new OrderModel())->withUser();

        return view('admin/orders', [
            'orders' => $orders,
            'stats'  => [
                'total'   => count($orders),
                'pending' => count(array_filter($orders, static fn ($o) => $o['status'] === 'pending')),
                'done'    => count(array_filter($orders, static fn ($o) => $o['status'] === 'done')),
            ],
        ]);
    }

    public function users()
    {
        return view('admin/users', [
            'users' => (new UserModel())->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    /**
     * Upload bukti pengiriman utk satu order:
     * - gambar diresize (maks 1000px) lalu dikompres ke JPEG kualitas 72
     * - status order otomatis menjadi "done"
     * - email berisi lampiran bukti dikirim ke pelanggan (bila SMTP diisi)
     */
    public function uploadProof(int $orderId)
    {
        $rule = [
            'proof' => [
                'label' => 'Bukti pengiriman',
                'rules' => 'uploaded[proof]|is_image[proof]|max_size[proof,5120]|mime_in[proof,image/jpg,image/jpeg,image/png,image/webp]',
            ],
        ];

        if (! $this->validate($rule)) {
            return redirect()->back()->with('error', $this->validator->getError('proof'));
        }

        $order = (new OrderModel())->find($orderId);

        if ($order === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Simpan hasil kompresi ke writable/uploads/proofs
        $img    = \Config\Services::image();
        $source = $this->request->getFile('proof')->getTempName();

        try {
            $img->withFile($source)
                ->resize(1000, 1000, true, 'width')
                ->save(WRITEPATH . 'uploads/proofs/proof-' . $orderId . '.jpg', 72);
        } catch (\CodeIgniter\Images\Exceptions\ImageException $e) {
            return redirect()->back()->with('error', 'Gagal memproses gambar: ' . $e->getMessage());
        }

        $path = 'uploads/proofs/proof-' . $orderId . '.jpg';

        (new OrderModel())->update($orderId, [
            'proof_path' => $path,
            'status'     => 'done',
        ]);

        $emailSent = $this->notifyCustomer($order, $path);

        return redirect()->back()->with(
            'success',
            $emailSent
                ? 'Bukti diunggah, order #' . $orderId . ' selesai, dan email notif terkirim. Space yang dipakai: ' .
                    round(filesize(WRITEPATH . $path) / 1024) . ' KB (hasil kompres otomatis).'
                : 'Bukti diunggah dan order #' . $orderId . ' selesai. Email gagal terkirim — cek konfigurasi SMTP di .env.'
        );
    }

    public function updateStatus(int $orderId)
    {
        $order = (new OrderModel())->find($orderId);

        if ($order === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $status = $this->request->getPost('status');

        if (! in_array($status, ['pending', 'processing', 'done', 'cancelled'], true)) {
            return redirect()->back()->with('error', 'Status tidak dikenal.');
        }

        (new OrderModel())->update($orderId, ['status' => $status]);

        return redirect()->back()->with('success', 'Status order #' . $orderId . ' diperbarui menjadi ' . $status . '.');
    }

    /**
     * Streaming bukti (img access) — pemilik order atau admin saja.
     */
    public function proof(int $orderId)
    {
        $order = (new OrderModel())->find($orderId);

        $allowedAdmin  = session()->get('role') === 'admin';
        $allowedOwner  = (int) session()->get('userId') === (int) ($order['user_id'] ?? 0);

        if ($order === null || empty($order['proof_path']) || (! $allowedAdmin && ! $allowedOwner)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $fullPath = WRITEPATH . $order['proof_path'];

        if (! is_file($fullPath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response->setContentType('image/jpeg')->setBody(file_get_contents($fullPath));
    }

    /**
     * Kirim email notif ke pelanggan (menggantikan alur manual s/d Google Drive).
     */
    private function notifyCustomer(array $order, string $proofPath): bool
    {
        $user = (new UserModel())->find((int) $order['user_id']);

        if ($user === null) {
            return false;
        }

        $noInvoice = 'INV-' . str_pad((string) $order['id'], 5, '0', STR_PAD_LEFT);
        $proofUrl  = site_url('proof/' . $order['id']);

        $email = service('email');

        try {
            $email->setTo($user['email']);
            $email->setSubject('Order #' . $noInvoice . ' — saldonya sudah dikirim (bukti terlampir)');
            $email->setMessage(view('admin/email_proof', [
                'order'    => $order,
                'user'     => $user,
                'invNo'    => $noInvoice,
                'proofUrl' => $proofUrl,
            ]));
            $email->attach(WRITEPATH . $proofPath, 'inline', 'bukti-' . $noInvoice . '.jpg', 'image/jpeg');

            return (bool) $email->send();
        } catch (\Throwable $e) {
            log_message('error', 'Email notif gagal: {e}', ['e' => $e->getMessage()]);

            return false;
        }
    }
}
