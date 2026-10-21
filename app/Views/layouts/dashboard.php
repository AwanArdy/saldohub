<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' — SaldoHub' : 'Dashboard — SaldoHub Digital FX & Escrow' ?></title>
    
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
<body class="dash-body">
<div class="d-flex">
    <!-- Desktop Sidebar -->
    <aside class="dash-sidebar d-none d-lg-flex">
        <a class="brand-wrapper mb-4" href="<?= route_to('home') ?>">
            <div class="brand-logo-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L3 7V12C3 17.5 7 21.5 12 22C17 21.5 21 17.5 21 12V7L12 2Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 12H15M12 9V15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <div class="brand-text">Saldo<span>Hub</span></div>
                <span class="brand-submark">Digital FX Desk</span>
            </div>
        </a>

        <div class="small fw-bold text-uppercase text-muted mb-2 px-2" style="font-size: 0.7rem; letter-spacing: 0.08em;">
            Menu Pengguna
        </div>
        
        <a class="dash-link <?= url_is('dashboard') || url_is('dashboard/') ? 'active' : '' ?>" href="<?= route_to('dashboard.index') ?>">
            <i class="bi bi-grid-1x2"></i>
            <span>Ringkasan Order</span>
        </a>
        <a class="dash-link <?= url_is('dashboard/top-up*') ? 'active' : '' ?>" href="<?= route_to('dashboard.topup') ?>">
            <i class="bi bi-cash-coin"></i>
            <span>Order Top Up</span>
        </a>
        <a class="dash-link <?= url_is('dashboard/jasa-bayar*') ? 'active' : '' ?>" href="<?= route_to('dashboard.pay') ?>">
            <i class="bi bi-credit-card-2-front"></i>
            <span>Order Jasa Bayar</span>
        </a>
        <a class="dash-link <?= url_is('dashboard/profil*') ? 'active' : '' ?>" href="<?= route_to('dashboard.profile') ?>">
            <i class="bi bi-person-gear"></i>
            <span>Pengaturan Profil</span>
        </a>

        <?php if (session()->get('role') === 'admin') : ?>
            <div class="small fw-bold text-uppercase text-muted mt-4 mb-2 px-2" style="font-size: 0.7rem; letter-spacing: 0.08em;">
                Panel Pengelola
            </div>
            <a class="dash-link <?= url_is('admin') || (url_is('admin/') && !url_is('admin/pelanggan*')) ? 'active' : '' ?>" href="<?= route_to('admin.orders') ?>">
                <i class="bi bi-inbox-fill"></i>
                <span>Kelola Transaksi</span>
            </a>
            <a class="dash-link <?= url_is('admin/pelanggan*') ? 'active' : '' ?>" href="<?= route_to('admin.users') ?>">
                <i class="bi bi-people-fill"></i>
                <span>Daftar Pelanggan</span>
            </a>
        <?php endif; ?>

        <div class="mt-auto pt-4 border-top border-subtle">
            <div class="d-flex align-items-center gap-2 mb-3 px-2">
                <div class="rounded-circle bg-brand-soft text-brand d-flex align-items-center justify-content-center fw-bold" style="width: 2.2rem; height: 2.2rem; font-size: 0.85rem;">
                    <?= strtoupper(substr(session()->get('name') ?? 'U', 0, 1)) ?>
                </div>
                <div class="overflow-hidden">
                    <div class="fw-bold small text-truncate text-ink"><?= esc(session()->get('name')) ?></div>
                    <div class="text-muted small" style="font-size: 0.72rem;"><?= esc(session()->get('role') === 'admin' ? 'Administrator' : 'Pelanggan') ?></div>
                </div>
            </div>
            <a class="dash-link text-danger" href="<?= route_to('auth.logout') ?>">
                <i class="bi bi-box-arrow-left"></i>
                <span>Keluar Akun</span>
            </a>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="flex-grow-1 d-flex flex-column" style="min-width: 0;">
        <nav class="navbar dash-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-brand btn-sm d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mnav" aria-label="Open menu">
                    <i class="bi bi-list"></i>
                </button>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold text-ink fs-6"><i class="bi bi-speedometer2 text-brand me-2"></i>Dashboard</span>
                    <span class="badge bg-brand-soft text-brand small d-none d-sm-inline-block">
                        <?= session()->get('role') === 'admin' ? 'Admin Mode' : 'Customer Workspace' ?>
                    </span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="<?= route_to('home') ?>" class="btn btn-outline-brand btn-sm d-none d-md-inline-flex align-items-center gap-1">
                    <i class="bi bi-globe"></i>
                    <span>Lihat Website</span>
                </a>
                <div class="small text-muted d-none d-sm-block">
                    Hai, <strong class="text-ink"><?= esc(session()->get('name')) ?></strong>
                </div>
            </div>
        </nav>

        <div class="p-3 p-lg-4 flex-grow-1">
            <div class="container-fluid px-0" style="max-width: 1200px;">
                <?= view('partials/flash') ?>
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start" id="mnav" tabindex="-1">
    <div class="offcanvas-header border-bottom border-subtle">
        <a class="brand-wrapper" href="<?= route_to('home') ?>">
            <div class="brand-logo-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L3 7V12C3 17.5 7 21.5 12 22C17 21.5 21 17.5 21 12V7L12 2Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 12H15M12 9V15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <div class="brand-text">Saldo<span>Hub</span></div>
            </div>
        </a>
        <button class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <a class="dash-link" href="<?= route_to('dashboard.index') ?>"><i class="bi bi-grid-1x2"></i> Beranda</a>
        <a class="dash-link" href="<?= route_to('dashboard.topup') ?>"><i class="bi bi-cash-coin"></i> Order Top Up</a>
        <a class="dash-link" href="<?= route_to('dashboard.pay') ?>"><i class="bi bi-credit-card-2-front"></i> Order Jasa Bayar</a>
        <a class="dash-link" href="<?= route_to('dashboard.profile') ?>"><i class="bi bi-person-gear"></i> Profil</a>
        
        <?php if (session()->get('role') === 'admin') : ?>
            <hr class="my-2 border-subtle">
            <a class="dash-link" href="<?= route_to('admin.orders') ?>"><i class="bi bi-inbox-fill"></i> Kelola Order</a>
            <a class="dash-link" href="<?= route_to('admin.users') ?>"><i class="bi bi-people-fill"></i> Pelanggan</a>
        <?php endif; ?>

        <a class="dash-link mt-auto text-danger" href="<?= route_to('auth.logout') ?>"><i class="bi bi-box-arrow-left"></i> Keluar</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>const SIM_API = '<?= site_url('api/simulate') ?>';</script>
<script src="/assets/js/app.js"></script>
<?= $this->renderSection('page_scripts') ?>
</body>
</html>
