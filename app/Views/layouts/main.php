<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' — SaldoKita' : 'SaldoKita — Jasa Top Up & Bayar Online PayPal Terpercaya di Indonesia' ?></title>
    <meta name="description" content="<?= isset($description) ? esc($description) : 'Layanan top up saldo PayPal dan jasa checkout belanja luar negeri tanpa kartu kredit. Kurs transparan, proses instan, dan 100% bergaransi resmi.' ?>">
    
    <!-- Bespoke Financial Favicon SVG -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 48'><rect width='48' height='48' rx='12' fill='%231d4ed8'/><path d='M14 17h20M14 24h14M14 31h18' stroke='%23ffffff' stroke-width='3.5' stroke-linecap='round'/><circle cx='34' cy='24' r='4' fill='%23fbbf24'/></svg>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<?= $this->include('partials/navbar') ?>

<main class="site-main">
    <?= $this->renderSection('page_header') ?>
    
    <div class="site-content">
        <?php if (session()->getFlashdata('error') || session()->getFlashdata('success') || session()->getFlashdata('message') || session()->getFlashdata('warning')) : ?>
            <div class="container pt-3">
                <?= view('partials/flash') ?>
            </div>
        <?php endif; ?>
        
        <?= $this->renderSection('content') ?>
    </div>
</main>

<?= $this->include('partials/footer') ?>

<!-- Floating WhatsApp VIP Concierge -->
<div class="wa-float-container">
    <div class="wa-float-pill">
        <span class="pulse-dot me-1"></span> CS Siap Membantu
    </div>
    <a href="<?= esc($whatsappUrl ?? 'https://wa.me/6281234567890') ?>" target="_blank" rel="noopener" class="wa-float-btn" aria-label="Konsultasi WhatsApp">
        <i class="bi bi-whatsapp"></i>
        <span class="wa-online-dot"></span>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>const SIM_API = '<?= site_url('api/simulate') ?>';</script>
<script src="/assets/js/app.js"></script>
<?= $this->renderSection('page_scripts') ?>
</body>
</html>
