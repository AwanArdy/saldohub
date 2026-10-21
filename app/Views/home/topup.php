<?= $this->extend('layouts/main') ?>

<?php
$rate = (int) ($settings['rate'] ?? 18450);
$minTopup = (int) ($settings['min_topup_usd'] ?? 30);
$waText = rawurlencode("Halo SaldoHub, saya ingin top up saldo PayPal senilai US$ " . $minTopup . " dengan kurs Rp " . number_format($rate, 0, ',', '.') . ".");
$whatsappUrl = 'https://wa.me/' . ($settings['whatsapp'] ?? '6281234567890') . '?' . $waText;
?>

<?= $this->section('page_header') ?>
<section class="page-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="eyebrow-pill mb-2">Layanan Pengisian Saldo</span>
                <h1 class="display-6 fw-bold mb-1">Top Up Saldo PayPal</h1>
                <p class="text-muted small mb-0">Isi saldo langsung masuk ke akun PayPal pribadi milik Anda.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= route_to('home') ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Top Up PayPal</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 h-100">
                <h3 class="fw-bold mb-3">Isi Saldo PayPal Tanpa Kartu Kredit</h3>
                <p class="text-muted leading-relaxed">
                    Layanan pengisian saldo PayPal dari SaldoHub dirancang untuk memenuhi kebutuhan pembayaran digital secara mandiri. Cukup lakukan <strong>transfer melalui bank lokal atau QRIS</strong>, saldo dollar akan kami kirimkan langsung ke email akun PayPal Anda.
                </p>
                <p class="text-muted leading-relaxed">
                    Kami menerapkan <strong>kurs flat yang bersaing</strong> tanpa potongan tersembunyi. Seluruh saldo dijamin legal, bersumber dari pendapatan kontrak pekerjaan resmi, dan dilengkapi garansi dana masuk.
                </p>

                <h5 class="fw-bold mt-4 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3 text-brand"></i> Prosedur Pengisian Saldo
                </h5>
                <?php
                $steps = [
                    ['Buat Akun atau Masuk', 'Daftar secara gratis atau masuk ke dashboard bila sudah memiliki akun.'],
                    ['Ajukan Order Top Up', 'Pilih menu Top Up di dashboard, tentukan nominal dollar dan masukkan email PayPal Anda.'],
                    ['Lakukan Pembayaran', 'Transfer nilai rupiah ke rekening bank yang tercantum pada instruksi order.'],
                    ['Saldo Sukses Terkirim', 'Order diverifikasi dan saldo dollar dikirim ke akun Anda dalam hitungan menit.'],
                ];
                for ($i = 0; $i < count($steps); $i++) : [$t, $d] = $steps[$i]; ?>
                    <div class="d-flex gap-3 mb-3">
                        <div class="step-num-badge flex-shrink-0" style="width: 2rem; height: 2rem; font-size: 0.85rem;">
                            <?= $i + 1 ?>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-ink"><?= esc($t) ?></h6>
                            <p class="text-muted small mb-0"><?= esc($d) ?></p>
                        </div>
                    </div>
                <?php endfor; ?>

                <div class="p-3 bg-brand-soft rounded-3 mt-4 border border-subtle">
                    <div class="d-flex align-items-start gap-2 small">
                        <i class="bi bi-shield-check text-brand fs-5 mt-n1"></i>
                        <div>
                            <strong>Jaminan Garansi Saldo Masuk:</strong> Apabila terjadi kendala teknis dari sistem PayPal dalam pengiriman saldo, kami memberikan garansi tindak lanjut tuntas atau refund 100%.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <?= view('partials/sim', ['type' => 'topup', 'rate' => $rate, 'min' => $minTopup, 'settings' => $settings]) ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
