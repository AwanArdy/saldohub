<footer class="site-footer">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-4">
                <a class="brand-wrapper mb-3" href="<?= route_to('home') ?>">
                    <div class="brand-logo-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L3 7V12C3 17.5 7 21.5 12 22C17 21.5 21 17.5 21 12V7L12 2Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 12H15M12 9V15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="brand-text text-white">Saldo<span>Kita</span></div>
                        <span class="brand-submark" style="color: #64748b;">Digital FX &amp; Escrow</span>
                    </div>
                </a>
                <p class="small text-muted mb-3" style="line-height: 1.65; max-width: 320px;">
                    Platform perantara transaksi saldo PayPal dan jasa checkout online terpercaya untuk pengguna di Indonesia. Aman, legal, bergaransi, dan tanpa kartu kredit.
                </p>
                <div class="d-flex align-items-center gap-2 small text-muted">
                    <span class="pulse-dot"></span>
                    <span>Sistem Aktif &amp; Siap Melayani Transaksi</span>
                </div>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h6>Layanan</h6>
                <ul class="footer-links small">
                    <li><a href="<?= route_to('service.topup') ?>">Top Up PayPal</a></li>
                    <li><a href="<?= route_to('service.pay') ?>">Jasa Pembayaran Online</a></li>
                    <li><a href="<?= route_to('home') ?>#simTabs">Kalkulator Kurs</a></li>
                    <li><a href="<?= route_to('blog') ?>">Artikel &amp; Panduan</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <h6>Legal &amp; Panduan</h6>
                <ul class="footer-links small">
                    <li><a href="<?= route_to('page', 'how-to-order') ?>">Tata Cara Order</a></li>
                    <li><a href="<?= route_to('page', 'terms-of-service') ?>">Syarat &amp; Ketentuan</a></li>
                    <li><a href="<?= route_to('page', 'privacy-policy') ?>">Kebijakan Privasi</a></li>
                    <li><a href="<?= route_to('contact') ?>">Bantuan Pelanggan</a></li>
                </ul>
            </div>

            <div class="col-md-6 col-lg-3">
                <h6>Hubungi Layanan</h6>
                <ul class="footer-links small">
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-whatsapp text-success"></i>
                        <a href="<?= esc($whatsappUrl ?? 'https://wa.me/6281234567890') ?>" target="_blank" class="fw-semibold text-white">WhatsApp Resmi</a>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-envelope text-brand"></i>
                        <span>halo@saldokita.test</span>
                    </li>
                    <li class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-clock text-warning mt-1"></i>
                        <div>
                            <div>Senin – Jumat: 08.00 – 21.00 WIB</div>
                            <div>Sabtu – Minggu: 08.00 – 17.00 WIB</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 small text-muted">
            <div>
                &copy; <?= date('Y') ?> SaldoKita. Seluruh hak cipta dilindungi. Transaksi aman terlindungi garansi.
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-white-50 small">Metode Transfer:</span>
                <span class="badge bg-dark border border-secondary text-light fw-medium">BCA</span>
                <span class="badge bg-dark border border-secondary text-light fw-medium">MANDIRI</span>
                <span class="badge bg-dark border border-secondary text-light fw-medium">BNI</span>
                <span class="badge bg-dark border border-secondary text-light fw-medium">BRI</span>
                <span class="badge bg-dark border border-secondary text-light fw-medium">QRIS</span>
            </div>
        </div>
    </div>
</footer>
