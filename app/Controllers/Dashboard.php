<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\Calculator;
use App\Models\SettingModel;
use App\Models\UserModel;
use App\Models\OrderModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    private Calculator $calc;

    public function __construct()
    {
        $this->calc = new Calculator();
        helper(['form']);
    }

    public function index()
    {
        $orders = (new OrderModel())->forUser((int) session()->get('userId'));

        $stats = [
            'total'    => count($orders),
            'pending'  => count(array_filter($orders, static fn ($o) => $o['status'] === 'pending')),
            'done'     => count(array_filter($orders, static fn ($o) => $o['status'] === 'done')),
        ];

        return view('dashboard/index', [
            'orders'      => $orders,
            'stats'       => $stats,
            'rate'        => $this->calc->rate(),
            'minTopup'    => $this->calc->minTopup(),
            'minPay'      => $this->calc->minPay(),
        ]);
    }

    public function topupForm()
    {
        return view('dashboard/order_topup', [
            'rate'     => $this->calc->rate(),
            'minUsd'   => $this->calc->minTopup(),
            'settings' => (new SettingModel())->all(),
        ]);
    }

    public function payForm()
    {
        return view('dashboard/order_pay', [
            'rate'     => $this->calc->rate(),
            'minUsd'   => $this->calc->minPay(),
            'feePct'   => (float) ((new SettingModel())->find('admin_fee_pct')['value'] ?? 4),
            'feeMin'   => (float) ((new SettingModel())->find('admin_fee_min')['value'] ?? 30000),
            'settings' => (new SettingModel())->all(),
        ]);
    }

    public function storeTopup()
    {
        $amount = (float) $this->request->getPost('amount');

        if ($amount < $this->calc->minTopup()) {
            return redirect()->back()->withInput()
                ->with('error', 'Nominal minimal top up adalah $' . $this->calc->minTopup() . '.');
        }

        $paypal = trim($this->request->getPost('paypal_acc') ?? '');

        if ($paypal === '') {
            return redirect()->back()->withInput()->with('error', 'Akun PayPal wajib diisi.');
        }

        $sim = $this->calc->topup($amount);

        $id = (new OrderModel())->insert([
            'user_id'      => (int) session()->get('userId'),
            'type'         => 'topup',
            'amount'       => $amount,
            'rate'         => $sim['rate'],
            'admin_fee'    => 0,
            'total_rupiah' => $sim['rupiah'],
            'paypal_acc'   => $paypal,
            'note'         => $this->request->getPost('note'),
            'status'       => 'pending',
        ], true);

        return redirect()->route('dashboard.show', [$id])->with(
            'success',
            'Order berhasil dibuat. Selesaikan pembayaran sesuai detail di bawah.'
        );
    }

    public function storePay()
    {
        $amount = (float) $this->request->getPost('amount');

        if ($amount < $this->calc->minPay()) {
            return redirect()->back()->withInput()
                ->with('error', 'Nominal minimal jasa bayar adalah $' . $this->calc->minPay() . '.');
        }

        $itemUrl = trim($this->request->getPost('item_url') ?? '');

        if ($itemUrl === '' || ! filter_var($itemUrl, FILTER_VALIDATE_URL)) {
            return redirect()->back()->withInput()->with('error', 'Link item wajib berupa URL yang valid.');
        }

        $sim = $this->calc->payService($amount);

        $id = (new OrderModel())->insert([
            'user_id'      => (int) session()->get('userId'),
            'type'         => 'pay',
            'amount'       => $amount,
            'rate'         => $sim['rate'],
            'admin_fee'    => $sim['fee'],
            'total_rupiah' => $sim['rupiah'],
            'item_url'     => $itemUrl,
            'note'         => $this->request->getPost('note'),
            'status'       => 'pending',
        ], true);

        return redirect()->route('dashboard.show', [$id])->with(
            'success',
            'Order berhasil dibuat. Kami akan meninjau item lalu mengirimkan instruksi pembayaran.'
        );
    }

    public function show(int $id)
    {
        $order = (new OrderModel())->where('user_id', (int) session()->get('userId'))->find($id);

        if ($order === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('dashboard/show', [
            'order'    => $order,
            'settings' => (new SettingModel())->all(),
        ]);
    }

    public function invoice(int $id)
    {
        $order = (new OrderModel())
            ->where('user_id', (int) session()->get('userId'))
            ->find($id);

        if ($order === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $user     = (new UserModel())->find((int) session()->get('userId'));
        $settings = (new SettingModel())->all();

        $html = view('dashboard/invoice_pdf', [
            'order'    => $order,
            'user'     => $user,
            'settings' => $settings,
        ]);

        $dompdf = new \Dompdf\Dompdf([
            'isRemoteEnabled' => false,
            'defaultFont'     => 'Helvetica',
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader(
                'Content-Disposition',
                'attachment; filename="invoice-INV-' . str_pad((string) $order['id'], 5, '0', STR_PAD_LEFT) . '.pdf"'
            )
            ->setBody($dompdf->output());
    }

    public function profile()
    {
        $user = (new UserModel())->find((int) session()->get('userId'));

        return view('dashboard/profile', ['user' => $user]);
    }

    public function saveProfile()
    {
        $rules = [
            'name'    => 'required|min_length[3]|max_length[120]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = new UserModel();
        $data  = [
            'name'       => $this->request->getPost('name'),
            'paypal_acc' => $this->request->getPost('paypal_acc'),
        ];

        $password = $this->request->getPost('password');

        if (! empty($password)) {
            $data['password'] = $password;
        }

        $users->update((int) session()->get('userId'), $data);

        session()->set('name', $data['name']);

        return redirect()->back()->with('success', 'Profil berhasil disimpan.');
    }
}
