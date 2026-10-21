<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\Calculator;
use App\Models\OrderModel;
use App\Models\SettingModel;
use CodeIgniter\Controller;

class Home extends Controller
{
    private array $data;

    public function __construct()
    {
        $settings      = (new SettingModel())->all();
        $this->data    = [
            'calculator' => new Calculator(),
            'settings'   => $settings,
        ];
    }

    public function index()
    {
        return view('home/index', $this->data);
    }

    public function topup()
    {
        return view('home/topup', $this->data);
    }

    public function payService()
    {
        return view('home/pay', $this->data);
    }

    public function contact()
    {
        return view('home/contact', $this->data);
    }

    public function page(string $slug)
    {
        $view = 'home/pages/' . str_replace('-', '_', $slug);

        if (! is_file(APPPATH . 'Views/' . $view . '.php')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->data['slug'] = $slug;

        return view('home/page', $this->data);
    }

    public function blog()
    {
        $posts = [
            [
                'slug'    => 'cara-top-up-paypal',
                'title'   => 'Cara Mudah Mengisi Saldo PayPal untuk Pengguna di Indonesia',
                'excerpt' => 'Pengguna PayPal di Indonesia tidak perlu punya kartu kredit sendiri. Berikut alur proses pengisian saldo yang dipakai di platform kami.',
                'date'    => '2026-10-05',
            ],
            [
                'slug'    => 'perbedaan-gns-dan-fnf',
                'title'   => 'Perbedaan PayPal Goods and Services dengan Friends and Friends',
                'excerpt' => 'Sebelum transaksi, pahami dulu dua mode kirim uang pada PayPal: biayanya, keuntungiannya, dan kapan sebaiknya digunakan.',
                'date'    => '2026-09-18',
            ],
            [
                'slug'    => 'tentang-biaya-paypal',
                'title'   => 'Mengenal Ongkos Transaksi PayPal dan Cara Menghitungnya',
                'excerpt' => 'Deretan persentase dan tambahan nominal pada invoice PayPal sering membuat orang bingung. Simak rincian umum biaya PayPal di artikel ini.',
                'date'    => '2026-08-30',
            ],
        ];

        $this->data['posts'] = $posts;

        return view('home/blog', $this->data);
    }
}
