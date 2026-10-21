<?= $this->extend('layouts/main') ?>

<?php $whatsappUrl = 'https://wa.me/' . ($settings['whatsapp'] ?? '6281234567890'); ?>

<?= $this->section('page_header') ?>
<section class="page-hero">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="eyebrow-pill mb-2">Pusat Pengetahuan</span>
                <h1 class="display-6 fw-bold mb-1">Blog &amp; Edukasi Transaksi</h1>
                <p class="text-muted small mb-0">Panduan seputar pembayaran digital, tips keamanan PayPal, dan trik belanja global.</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= route_to('home') ?>">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row g-4">
        <?php foreach ($posts as $post) : ?>
            <div class="col-md-6 col-lg-4">
                <article class="card h-100 border-0 shadow-sm rounded-4 p-4 d-flex flex-column transition-all" style="border: 1px solid var(--border-subtle) !important;">
                    <div class="d-flex align-items-center gap-2 small text-muted mb-3">
                        <i class="bi bi-calendar3"></i>
                        <span><?= date('d M Y', strtotime($post['date'])) ?></span>
                        <span class="mx-1">&bull;</span>
                        <span class="text-brand fw-semibold">Panduan</span>
                    </div>
                    <h5 class="fw-bold mb-2 text-ink" style="line-height: 1.35;"><?= esc($post['title']) ?></h5>
                    <p class="text-muted small flex-grow-1" style="line-height: 1.6;"><?= esc($post['excerpt']) ?></p>
                    <a href="<?= route_to('blog') ?>#<?= esc($post['slug']) ?>" class="stretched-link text-brand small fw-bold d-inline-flex align-items-center gap-1 mt-3">
                        Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                    </a>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
