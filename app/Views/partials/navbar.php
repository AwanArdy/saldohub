<nav class="navbar navbar-expand-lg site-nav">
    <div class="container">
        <a class="brand-wrapper" href="<?= route_to('home') ?>">
            <div class="brand-logo-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L3 7V12C3 17.5 7 21.5 12 22C17 21.5 21 17.5 21 12V7L12 2Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 12H15M12 9V15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <div class="brand-text">Saldo<span>Hub</span></div>
                <span class="brand-submark">Digital FX &amp; Escrow</span>
            </div>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Toggle navigation">
            <i class="bi bi-list fs-2 text-ink"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link <?= url_is('/') ? 'active text-brand' : '' ?>" href="<?= route_to('home') ?>">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= url_is('jasa-*') ? 'active text-brand' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Layanan
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="<?= route_to('service.topup') ?>">
                                <i class="bi bi-cash-coin text-brand"></i>
                                <div>
                                    <div class="fw-semibold">Top Up Saldo PayPal</div>
                                    <small class="text-muted d-block" style="font-size: 0.76rem;">Beli saldo langsung ke akunmu</small>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="<?= route_to('service.pay') ?>">
                                <i class="bi bi-credit-card-2-front text-brand"></i>
                                <div>
                                    <div class="fw-semibold">Jasa Pembayaran Online</div>
                                    <small class="text-muted d-block" style="font-size: 0.76rem;">Checkout item dari merchant global</small>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= url_is('blog*') ? 'active text-brand' : '' ?>" href="<?= route_to('blog') ?>">Edukasi &amp; Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= url_is('contact*') ? 'active text-brand' : '' ?>" href="<?= route_to('contact') ?>">Hubungi Kami</a>
                </li>

                <?php if (session()->get('isLoggedIn')) : ?>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-brand btn-sm d-flex align-items-center gap-2" href="<?= route_to('dashboard.index') ?>">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard (<?= esc(session()->get('name')) ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item ms-lg-1 mt-2 mt-lg-0">
                        <a class="btn btn-outline-brand btn-sm text-danger" href="<?= route_to('auth.logout') ?>" title="Keluar">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-outline-brand btn-sm" href="<?= route_to('auth.login') ?>">
                            Masuk
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-brand btn-sm" href="<?= route_to('auth.register') ?>">
                            Daftar Akun
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
