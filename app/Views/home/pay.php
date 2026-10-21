<?= $this->extend('layouts/main') ?>

<?php
$rate = (int) ($settings['rate'] ?? 18450);
$minPay = (int) ($settings['min_pay_usd'] ?? 5);
$feePct = $settings['admin_fee_pct'] ?? 4;
$feeMin = number_format((float) ($settings['admin_fee_min'] ?? 30000), 0, ',', '.');
$waText = rawurlencode("Halo SaldoKita, saya ingin menggunakan jasa bayar PayPal untuk item luar negeri senilai US$ " . $minPay . ".");
$whatsappUrl = 'https://wa.me/' . ($settings['whatsapp'] ?? '6281234567890') . '?' . $waText;
?>

<?= $this->section('page_header') ?>
<section class="page-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="eyebrow-pill pill-gold mb-2">Layanan Checkout Merchant</span>
                <h1 class="display-6 fw-bold mb-1">Jasa Pembayaran Online PayPal</h1>
                <p class="text-muted small mb-0">Kami bayarkan tagihan produk belanja atau langganan software luar negeri Anda.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= route_to('home') ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jasa Bayar</li>
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
                <h3 class="fw-bold mb-3">Checkout Belanja Global Tanpa Perlu Akun PayPal</h3>
                <p class="text-muted leading-relaxed">
                    Punya barang, jasa, atau lisensi software yang ingin dibeli dari situs luar negeri namun terkendala ketiadaan kartu kredit? Cukup berikan link produk atau invoice tagihannya. <strong>Tim SaldoKita akan melunasi pesanan Anda</strong> langsung dari rekening PayPal bisnis kami.
                </p>
                <p class="text-muted leading-relaxed">
                    Biaya penanganan transparan dan wajar: <strong><?= esc($feePct) ?>% atau minimal Rp <?= $feeMin ?></strong>. Seluruh proses terdokumentasi dengan bukti pelunasan merchant yang sah.
                </p>

                <h5 class="fw-bold mt-4 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3 text-warning"></i> Alur Pemesanan Jasa Bayar
                </h5>
                <?php
                $steps = [
                    ['Masuk atau Daftar Akun', 'Gunakan akun yang telah terdaftar di SaldoKita.'],
                    ['Isi Form Jasa Bayar', 'Tempel link produk atau invoice item beserta nilai harga dalam USD.'],
                    ['Transfer Nilai Belanja', 'Bayarkan total nominal rupiah (harga item + biaya admin) ke rekening SaldoKita.'],
                    ['Item Sukses Dilunasi', 'Tim kami memproses pembayaran di merchant luar negeri dan mengunggah bukti pelunasan.'],
                ];
                for ($i = 0; $i < count($steps); $i++) : [$t, $d] = $steps[$i]; ?>
                    <div class="d-flex gap-3 mb-3">
                        <div class="step-num-badge flex-shrink-0" style="width: 2rem; height: 2rem; font-size: 0.85rem; background: #d97706;">
                            <?= $i + 1 ?>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-ink"><?= esc($t) ?></h6>
                            <p class="text-muted small mb-0"><?= esc($d) ?></p>
                        </div>
                    </div>
                <?php endfor; ?>

                <div class="p-3 rounded-3 mt-4 border border-warning-subtle" style="background: #fffbeb;">
                    <div class="d-flex align-items-start gap-2 small" style="color: #92400e;">
                        <i class="bi bi-info-circle-fill fs-5 mt-n1"></i>
                        <div>
                            <strong>Catatan Belanja:</strong> Pastikan toko online tujuan Anda menerima metode pembayaran PayPal. Kami tidak menerima pembayaran pada situs-situs yang melanggar hukum perundang-undangan di Indonesia.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <?= view('partials/sim', ['type' => 'pay', 'rate' => $rate, 'min' => $minPay, 'settings' => $settings]) ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
