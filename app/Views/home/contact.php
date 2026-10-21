<?= $this->extend('layouts/main') ?>

<?php
$rate = $settings['rate'] ?? 18450;
$waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '6281234567890');
$waText = rawurlencode("Halo SaldoKita, saya membutuhkan bantuan seputar transaksi PayPal.");
$whatsappUrl = 'https://wa.me/' . $waNumber . '?' . $waText;
?>

<?= $this->section('page_header') ?>
<section class="page-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="eyebrow-pill mb-2">Bantuan Pelanggan</span>
                <h1 class="display-6 fw-bold mb-1">Hubungi SaldoKita</h1>
                <p class="text-muted small mb-0">Tim kami siap memberikan panduan dan menjawab pertanyaan seputar transaksi Anda.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= route_to('home') ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 h-100" style="border: 1px solid var(--border-subtle) !important;">
                <h4 class="fw-bold mb-4">Saluran Komunikasi Resmi</h4>

                <div class="d-flex gap-3 mb-4">
                    <div class="service-icon-wrap flex-shrink-0" style="background: var(--emerald-bg); color: var(--emerald-text); border-color: var(--emerald-border); width: 2.75rem; height: 2.75rem; font-size: 1.25rem;">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-ink">WhatsApp Chat Konsultasi</h6>
                        <p class="text-muted small mb-2">Saluran tercepat untuk konsultasi dan konfirmasi transaksi.</p>
                        <a class="btn btn-outline-brand btn-sm d-inline-flex align-items-center gap-2" href="<?= esc($whatsappUrl) ?>" target="_blank" rel="noopener">
                            <i class="bi bi-whatsapp text-success"></i> Chat Tim Customer Service
                        </a>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="service-icon-wrap flex-shrink-0" style="width: 2.75rem; height: 2.75rem; font-size: 1.25rem;">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-ink">Surat Elektronik (Email)</h6>
                        <p class="text-muted small mb-0">halo@saldokita.test</p>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="service-icon-wrap flex-shrink-0" style="background: var(--amber-bg); color: var(--amber-text); border-color: var(--amber-border); width: 2.75rem; height: 2.75rem; font-size: 1.25rem;">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-ink">Jam Operasional Layanan</h6>
                        <p class="text-muted small mb-0">
                            Senin – Jumat: 08.00 – 21.00 WIB<br>
                            Sabtu – Minggu: 08.00 – 17.00 WIB
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <div class="service-icon-wrap flex-shrink-0" style="background: var(--surface-soft); color: var(--ink-700); border-color: var(--border-subtle); width: 2.75rem; height: 2.75rem; font-size: 1.25rem;">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-ink">Kantor Operasional</h6>
                        <p class="text-muted small mb-0">Jl. Embong Malang No. 12, Surabaya, Jawa Timur, Indonesia</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 h-100" style="border: 1px solid var(--border-subtle) !important;">
                <h4 class="fw-bold mb-2">Tinggalkan Pesan</h4>
                <p class="text-muted small mb-4">Isi formulir di bawah ini untuk pertanyaan atau kerja sama kemitraan.</p>

                <form id="contactForm" method="post" action="<?= site_url('contact') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label" for="c-name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="c-name" name="name" required minlength="3" placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="c-email">Alamat Email</label>
                        <input type="email" class="form-control" id="c-email" name="email" required placeholder="nama@email.com">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="c-msg">Pesan atau Pertanyaan</label>
                        <textarea class="form-control" id="c-msg" name="message" rows="4" required minlength="10" placeholder="Tuliskan pesan Anda secara jelas..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-brand w-100 py-2">
                        <span class="btn-text"><i class="bi bi-send me-1"></i> Kirim Pesan</span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </form>
                <div id="contactResult" class="mt-3 d-none"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('page_scripts') ?>
<script>
$('#contactForm').on('submit', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    const $btn = $(this).find('button[type=submit]');
    $btn.prop('disabled', true).find('.btn-text').text('Mengirim...');
    setTimeout(() => {
        $('#contactResult').removeClass('d-none').html(
            '<div class="alert alert-success mb-0 small"><i class="bi bi-check-circle me-1"></i> Pesan berhasil dikirim. Tim kami akan segera menghubungi Anda melalui email.</div>'
        );
        $btn.prop('disabled', false).find('.btn-text').html('<i class="bi bi-send me-1"></i> Kirim Pesan');
    }, 600);
});
</script>
<?= $this->endSection() ?>
