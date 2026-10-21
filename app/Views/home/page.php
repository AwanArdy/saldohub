<?= $this->extend('layouts/main') ?>

<?php
$titles = [
    'privacy-policy'   => 'Kebijakan Privasi',
    'terms-of-service' => 'Syarat dan Ketentuan',
    'how-to-order'     => 'Tata Cara Order',
];
$whatsappUrl = 'https://wa.me/' . ($settings['whatsapp'] ?? '6281234567890');
?>

<?= $this->section('page_header') ?>
<section class="page-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="eyebrow-pill mb-2">Dokumentasi Legal</span>
                <h1 class="display-6 fw-bold mb-1"><?= esc($titles[$slug] ?? ucfirst($slug)) ?></h1>
                <p class="text-muted small mb-0">Informasi resmi seputar hak, ketentuan, dan prosedur operasional layanan SaldoHub.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= route_to('home') ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= esc($titles[$slug] ?? ucfirst($slug)) ?></li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5" style="border: 1px solid var(--border-subtle) !important;">
                <div class="article-content leading-relaxed">
                    <?= view('home/pages/' . str_replace('-', '_', $slug)) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
