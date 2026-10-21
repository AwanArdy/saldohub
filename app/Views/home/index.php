<?= $this->extend('layouts/main') ?>

<?php
$rate = (int) ($settings['rate'] ?? 18450);
$minTopup = (int) ($settings['min_topup_usd'] ?? 30);
$minPay = (int) ($settings['min_pay_usd'] ?? 5);
$waText = rawurlencode("Halo SaldoKita, saya ingin berkonsultasi mengenai transaksi PayPal. Kurs hari ini: Rp " . number_format($rate, 0, ',', '.') . ".");
$whatsappUrl = 'https://wa.me/' . ($settings['whatsapp'] ?? '6281234567890') . '?' . $waText;
?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="eyebrow-pill mb-3">
                    <span class="pulse-dot"></span>
                    <span>Kurs Terkini: Rp <?= number_format($rate, 0, ',', '.') ?> / USD &bull; Realtime</span>
                </div>
                
                <h1 class="hero-headline mb-3">
                    Beli Saldo PayPal &amp; Checkout Global, <span class="text-brand">Tanpa Kartu Kredit</span>
                </h1>
                
                <p class="hero-lead mb-4">
                    Solusi konversi mata uang digital paling praktis di Indonesia. Nikmati kurs flat transparan, saldo legal 100%, proses instan, serta jaminan garansi sampai tuntas.
                </p>

                <div class="d-flex flex-wrap gap-3 mb-2">
                    <a class="btn btn-brand btn-lg d-inline-flex align-items-center gap-2" href="<?= route_to('service.topup') ?>">
                        <i class="bi bi-cash-coin"></i>
                        <span>Top Up Saldo PayPal</span>
                    </a>
                    <a class="btn btn-outline-brand btn-lg d-inline-flex align-items-center gap-2" href="<?= route_to('service.pay') ?>">
                        <i class="bi bi-credit-card-2-front"></i>
                        <span>Jasa Bayar Belanja</span>
                    </a>
                </div>

                <div class="trust-strip">
                    <div class="trust-item">
                        <i class="bi bi-shield-fill-check"></i>
                        <span>100% Saldo Legal &amp; Bersih</span>
                    </div>
                    <div class="trust-item">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span>Proses Rata-rata &lt; 30 Menit</span>
                    </div>
                    <div class="trust-item">
                        <i class="bi bi-patch-check-fill"></i>
                        <span>Garansi Transaksi Penuh</span>
                    </div>
                </div>
            </div>

            <!-- Financial Terminal Rate Card -->
            <div class="col-lg-5">
                <div class="terminal-card">
                    <div class="terminal-header">
                        <div class="terminal-title">
                            <i class="bi bi-activity text-primary"></i>
                            <span>TERMINAL KURS RESMI</span>
                        </div>
                        <div class="eyebrow-pill pill-dark py-1 px-2" style="font-size: 0.68rem;">
                            <span class="pulse-dot me-1"></span> PASAR AKTIF
                        </div>
                    </div>

                    <div class="terminal-body">
                        <div class="terminal-pair">
                            <span>Pasangan Mata Uang:</span>
                            <span class="terminal-pair-badge">USD / IDR</span>
                        </div>

                        <div class="terminal-rate-val">
                            Rp <?= number_format($rate, 0, ',', '.') ?>
                        </div>

                        <div class="terminal-sub">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Kurs Flat Final &bull; Bebas Biaya Terselubung</span>
                        </div>

                        <div class="terminal-grid">
                            <div class="terminal-metric">
                                <span class="label">Min. Top Up Saldo</span>
                                <span class="val">$<?= $minTopup ?> USD</span>
                            </div>
                            <div class="terminal-metric">
                                <span class="label">Min. Jasa Bayar</span>
                                <span class="val">$<?= $minPay ?> USD</span>
                            </div>
                            <div class="terminal-metric">
                                <span class="label">Metode Bayar</span>
                                <span class="val">Bank Lokal &amp; QRIS</span>
                            </div>
                            <div class="terminal-metric">
                                <span class="label">SLA Pengiriman</span>
                                <span class="val">&lt; 2 Jam Kerja</span>
                            </div>
                        </div>

                        <div class="terminal-actions">
                            <a class="btn btn-brand btn-sm" href="<?= route_to('service.topup') ?>">
                                Order Top Up
                            </a>
                            <a class="btn btn-dark-terminal btn-sm" href="<?= route_to('service.pay') ?>">
                                Order Jasa Bayar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Showcase -->
<section class="py-5" id="services">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="eyebrow-pill mb-2">Pilihan Solusi</span>
            <h2 class="display-6 fw-bold">Layanan Transaksi Digital</h2>
            <p class="text-muted mx-auto" style="max-width: 540px;">
                Dua solusi utama yang dirancang untuk memudahkan transaksi internasional tanpa repot kartu kredit.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-5">
                <a href="<?= route_to('service.topup') ?>" class="service-box">
                    <div class="service-icon-wrap">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <span class="service-badge bg-brand-soft text-brand">Minimal Order $<?= $minTopup ?></span>
                    <h4 class="fw-bold mb-2">Top Up Saldo PayPal</h4>
                    <p class="text-muted small mb-0">
                        Isi saldo langsung masuk ke akun PayPal pribadi milikmu sendiri. Sangat tepat untuk keperluan biaya langganan software, campaign iklan Facebook/Google, atau transaksi antar akun.
                    </p>
                    <ul class="service-feature-list">
                        <li><i class="bi bi-check2-circle"></i> Tanpa perlu verifikasi kartu kredit sendiri</li>
                        <li><i class="bi bi-check2-circle"></i> Saldo legal dari invoice resmi kontrak kerja</li>
                        <li><i class="bi bi-check2-circle"></i> Didukung notifikasi email &amp; bukti pengiriman</li>
                    </ul>
                    <div class="service-action-link">
                        <span>Lakukan Top Up Sekarang</span>
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>

            <!-- Service 2 -->
            <div class="col-md-6 col-lg-5">
                <a href="<?= route_to('service.pay') ?>" class="service-box">
                    <div class="service-icon-wrap" style="background: #fef3c7; color: #b45309; border-color: #fde68a;">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <span class="service-badge" style="background: #fef3c7; color: #b45309;">Minimal Order $<?= $minPay ?></span>
                    <h4 class="fw-bold mb-2">Jasa Pembayaran Online</h4>
                    <p class="text-muted small mb-0">
                        Ingin membeli produk fisik atau digital dari situs luar negeri tapi kamu tidak memiliki akun PayPal? Cukup berikan link produknya, tim kami yang akan melunasi invoice atas nama kamu.
                    </p>
                    <ul class="service-feature-list">
                        <li><i class="bi bi-check2-circle"></i> Tidak wajib memiliki akun PayPal pribadi</li>
                        <li><i class="bi bi-check2-circle"></i> Cocok untuk eBay, Etsy, domain, hosting, Envato</li>
                        <li><i class="bi bi-check2-circle"></i> Biaya admin transparan sejak perhitungan awal</li>
                    </ul>
                    <div class="service-action-link" style="color: #b45309;">
                        <span>Gunakan Jasa Checkout</span>
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Institutional Security & Compliance Showcase -->
<section class="py-4">
    <div class="container">
        <div class="security-banner">
            <div class="row align-items-center mb-5">
                <div class="col-lg-8">
                    <div class="eyebrow-pill pill-dark mb-2">
                        <i class="bi bi-shield-lock-fill text-primary"></i> Standar Perlindungan
                    </div>
                    <h3 class="fw-bold text-white mb-2">Komitmen Keamanan &amp; Integritas Saldo</h3>
                    <p class="text-white-50 mb-0 small" style="max-width: 600px;">
                        Setiap rupiah dan dollar yang berputar di SaldoKita tunduk pada prosedur penjaminan ketat guna melindungi akun para pelanggan dari risiko penangguhan sistem PayPal.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="<?= route_to('page', 'how-to-order') ?>" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-file-earmark-lock me-1"></i> Pelajari Alur Kerja
                    </a>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6 col-lg-3">
                    <div class="security-pillar">
                        <i class="bi bi-patch-check-fill security-pillar-ico"></i>
                        <h5>100% Sumber Legal</h5>
                        <p>Berasal murni dari hasil penarikan remunerasi kontrak freelance resmi. Bebas dari dana ilegal.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="security-pillar">
                        <i class="bi bi-shield-shaded security-pillar-ico"></i>
                        <h5>Garansi Saldo Tuntas</h5>
                        <p>Setiap order dilindungi garansi saldo sukses diterima sampai ke akun tujuan tanpa kompromi.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="security-pillar">
                        <i class="bi bi-receipt security-pillar-ico"></i>
                        <h5>Invoice &amp; Bukti Riil</h5>
                        <p>Dilengkapi bukti tangkapan layar pengiriman resmi serta PDF invoice yang dapat diunduh kapan saja.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="security-pillar">
                        <i class="bi bi-key-fill security-pillar-ico"></i>
                        <h5>Privasi Password 100%</h5>
                        <p>Kami tidak pernah meminta kredensial login atau kata sandi akun PayPal Anda. Transaksi 100% aman.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Channels Bar -->
        <div class="payment-channels-wrap mt-3">
            <span class="fw-bold text-ink small">Didukung Transfer Bank Nasional:</span>
            <div class="d-flex flex-wrap gap-2">
                <span class="bank-tag"><i class="bi bi-bank me-1 text-brand"></i>Bank BCA</span>
                <span class="bank-tag"><i class="bi bi-bank me-1 text-brand"></i>Bank Mandiri</span>
                <span class="bank-tag"><i class="bi bi-bank me-1 text-brand"></i>Bank BNI</span>
                <span class="bank-tag"><i class="bi bi-bank me-1 text-brand"></i>Bank BRI</span>
                <span class="bank-tag"><i class="bi bi-bank me-1 text-brand"></i>Bank Syariah (BSI)</span>
                <span class="bank-tag"><i class="bi bi-qr-code-scan me-1 text-brand"></i>QRIS Nasional</span>
            </div>
        </div>
    </div>
</section>

<!-- Calculator & How to Order Section -->
<section class="py-5" id="simTabs">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="eyebrow-pill mb-2">Simulasi &amp; Tata Cara</span>
            <h2 class="display-6 fw-bold">Hitung Estimasi &amp; Alur Order</h2>
            <p class="text-muted mx-auto" style="max-width: 520px;">
                Kalkulasi nilai transaksi secara transparan dan pelajari empat langkah praktis order di SaldoKita.
            </p>

            <ul class="nav sim-nav-pills mt-4 justify-content-center" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#p-topup" type="button">
                        <i class="bi bi-cash-coin me-1"></i> Top Up Saldo
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#p-pay" type="button">
                        <i class="bi bi-credit-card-2-front me-1"></i> Jasa Pembayaran
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <!-- Tab Top Up -->
            <div class="tab-pane fade show active" id="p-topup">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 p-4 rounded-4">
                            <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <i class="bi bi-diagram-3 text-brand"></i> Alur Transaksi Top Up Saldo
                            </h5>

                            <?php
                            $stepsTopup = [
                                ['Masuk atau Buat Akun', 'Daftarkan akun gratis Anda dalam 30 detik untuk memonitor riwayat order.', 'bi-person-check'],
                                ['Ajukan Order Top Up', 'Masukkan nominal dollar yang diinginkan beserta email PayPal penerima.', 'bi-pencil-square'],
                                ['Transfer ke Rekening Resmi', 'Lakukan pembayaran sesuai nominal rupiah final via bank lokal pilihan Anda.', 'bi-credit-card'],
                                ['Saldo Sukses Masuk', 'Tim kami memproses pengiriman saldo. Saldo tiba bergaransi resmi.', 'bi-check2-all'],
                            ];
                            for ($i = 0; $i < count($stepsTopup); $i++) : [$t, $d, $ico] = $stepsTopup[$i]; ?>
                                <div class="d-flex gap-3 mb-4">
                                    <div class="step-num-badge flex-shrink-0"><?= $i + 1 ?></div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-ink"><?= esc($t) ?></h6>
                                        <p class="text-muted small mb-0"><?= esc($d) ?></p>
                                    </div>
                                </div>
                            <?php endfor; ?>

                            <div class="p-3 bg-brand-soft rounded-3 mt-auto">
                                <div class="d-flex align-items-center gap-2 small">
                                    <i class="bi bi-info-circle-fill text-brand fs-6"></i>
                                    <span>Sudah punya akun? Langsung login untuk order lebih cepat via dashboard.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <?= view('partials/sim', ['type' => 'topup', 'rate' => $rate, 'min' => $minTopup, 'settings' => $settings]) ?>
                    </div>
                </div>
            </div>

            <!-- Tab Jasa Bayar -->
            <div class="tab-pane fade" id="p-pay">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 p-4 rounded-4">
                            <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                <i class="bi bi-diagram-3 text-brand"></i> Alur Jasa Checkout Belanja Online
                            </h5>

                            <?php
                            $stepsPay = [
                                ['Siapkan Tautan Produk', 'Salin tautan atau detail invoice barang/jasa dari website luar negeri yang ingin dibeli.', 'bi-link-45deg'],
                                ['Ajukan Permintaan Order', 'Isi form order jasa bayar dengan link produk serta total nominal dalam USD.', 'bi-file-earmark-plus'],
                                ['Transfer Pembayaran', 'Transfer nilai belanja + ongkos penanganan resmi ke rekening lokal SaldoKita.', 'bi-cash-coin'],
                                ['Order Selesai Dilunasi', 'Kami membayarkan tagihan langsung di merchant luar negeri & mengunggah bukti pelunasan.', 'bi-receipt-cutoff'],
                            ];
                            for ($i = 0; $i < count($stepsPay); $i++) : [$t, $d, $ico] = $stepsPay[$i]; ?>
                                <div class="d-flex gap-3 mb-4">
                                    <div class="step-num-badge flex-shrink-0" style="background: #d97706;"><?= $i + 1 ?></div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-ink"><?= esc($t) ?></h6>
                                        <p class="text-muted small mb-0"><?= esc($d) ?></p>
                                    </div>
                                </div>
                            <?php endfor; ?>

                            <div class="p-3 rounded-3 mt-auto" style="background: #fef3c7; color: #92400e;">
                                <div class="d-flex align-items-center gap-2 small">
                                    <i class="bi bi-exclamation-triangle-fill fs-6"></i>
                                    <span>Kami hanya melayani checkout pada merchant legal yang menerima pembayaran PayPal resmi.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <?= view('partials/sim', ['type' => 'pay', 'rate' => $rate, 'min' => $minPay, 'settings' => $settings]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Us / Value Proposition -->
<section class="py-5 bg-soft">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="eyebrow-pill mb-2">Nilai Tambah</span>
            <h2 class="display-6 fw-bold">Mengapa Pelanggan Memilih Kami</h2>
            <p class="text-muted mx-auto" style="max-width: 520px;">
                Standar layanan yang dirancang untuk menghadirkan rasa tenang dan kemudahan dalam setiap kali bertransaksi.
            </p>
        </div>

        <div class="row g-4">
            <?php
            $features = [
                ['bi-shield-check', 'Garansi Dana Aman', 'Setiap saldo yang ditransaksikan dilindungi jaminan 100% sampai ke tujuan. Tim kami menangani kendala teknis secara sigap dan bertanggung jawab.'],
                ['bi-calculator', 'Rate Flat Tanpa Markup', 'Kurs yang ditampilkan saat simulasi adalah nilai final. Tidak ada biaya tersembunyi atau potongan tak terduga setelah pembayaran.'],
                ['bi-stopwatch', 'Selesai dalam Hitungan Menit', 'Antrean order diverifikasi secara realtime saat jam kerja. Rata-rata saldo diterima pembeli dalam kurun waktu 15 hingga 45 menit.'],
                ['bi-credit-card-2-back', 'Bebas Kartu Kredit', 'Lakukan checkout belanja dan langganan software luar negeri cukup memakai transfer bank lokal, m-banking, atau QRIS.'],
                ['bi-chat-dots', 'Layanan Pelanggan WhatsApp', 'Bantuan cepat dan ramah melalui obrolan WhatsApp oleh customer support kami yang berpengalaman.'],
                ['bi-award', 'Reputasi Teruji & Terpercaya', 'Telah melayani ribuan transaksi kebutuhan freelancer, agency, profesional kreatif, dan pembeli online di seluruh pelosok Indonesia.'],
            ];
            foreach ($features as [$ico, $title, $desc]) : ?>
                <div class="col-md-6 col-lg-4">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="bi <?= $ico ?>"></i>
                        </div>
                        <h5 class="fw-bold mb-2"><?= esc($title) ?></h5>
                        <p class="text-muted small mb-0"><?= esc($desc) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ Accordion -->
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="eyebrow-pill mb-2">Pusat Informasi</span>
            <h2 class="display-6 fw-bold">Pertanyaan Umum (FAQ)</h2>
            <p class="text-muted mx-auto" style="max-width: 500px;">
                Jawaban seputar pengisian saldo, cara kerja jasa pembayaran, serta syarat transaksi.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <?php
                    $faq = [
                        ['Apa itu SaldoKita?', 'SaldoKita adalah platform perantara transaksi PayPal resmi di Indonesia. Kami menyediakan dua fasilitas: pembelian saldo PayPal langsung ke rekening akun Anda, serta jasa pembayaran tagihan/checkout barang dari merchant luar negeri tanpa membutuhkan kartu kredit.'],
                        ['Bagaimana alur pembayaran transaksinya?', 'Sangat mudah. Anda mendaftar akun, melakukan simulasi order, lalu mentransfer nilai rupiah ke rekening bank resmi kami (BCA, Mandiri, BNI, BRI, BSI, atau QRIS). Setelah transfer terverifikasi, order Anda langsung diproses.'],
                        ['Berapa lama estimasi saldo masuk ke akun PayPal saya?', 'Pada jam operasional normal (Senin–Minggu), order Anda umumnya tuntas diproses dalam 15 hingga 45 menit setelah konfirmasi pembayaran diterima. Batas toleransi maksimal adalah 2 jam kerja.'],
                        ['Apakah akun PayPal saya harus berstatus terverifikasi?', 'Akun PayPal yang belum terverifikasi kartu kredit tetap dapat menerima saldo dari SaldoKita. Namun, pastikan email akun Anda telah dikonfirmasi di platform PayPal.'],
                        ['Apakah aman dan apakah ada bukti transaksi resmi?', 'Sangat aman. Setiap transaksi kami sertai dengan Invoice PDF resmi serta screenshot bukti pengiriman langsung dari dashboard admin kami yang dapat Anda unduh kapan saja.'],
                        ['Apakah ada biaya admin terselubung?', 'Sama sekali tidak ada. Untuk Top Up Saldo, biaya admin adalah Rp 0 (gratis). Untuk Jasa Bayar, biaya jasa penanganan telah tercantum transparan pada hasil kalkulator sebelum Anda menyetujui transaksi.'],
                    ];
                    $n = 0;
                    foreach ($faq as [$q, $a]) : $n++; ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?= $n ?>">
                                <button class="accordion-button <?= $n > 1 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faqCol<?= $n ?>" aria-expanded="<?= $n === 1 ? 'true' : 'false' ?>">
                                    <?= esc($q) ?>
                                </button>
                            </h2>
                            <div id="faqCol<?= $n ?>" class="accordion-collapse collapse <?= $n === 1 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <?= esc($a) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEO Article Container -->
<section class="py-5 bg-soft">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <div class="article-container">
                    <span class="eyebrow-pill mb-2">Panduan Finansial</span>
                    <h2>SaldoKita — Solusi Transaksi Digital Tanpa Hambatan</h2>
                    <p>
                        PayPal adalah metode pembayaran paling universal di ekosistem digital saat ini. Bagi para freelancer, desainer, pebisnis online, dan penikmat konten yang berlangganan tools luar negeri seperti Canva Pro, Envato, Zoom, ChatGPT Plus, hingga Midjourney, PayPal merupakan gerbang utama pelunasan tagihan.
                    </p>
                    <p>
                        Kendala utama di Indonesia adalah banyak pengguna belum memiliki kartu kredit internasional atau mengalami penolakan transaksi debit online oleh sistem perbankan. SaldoKita hadir menjembatani kendala tersebut: Anda dapat <strong>mengisi saldo PayPal</strong> atau memanfaatkan <strong>jasa bayar merchant</strong> cukup dengan transfer bank lokal atau QRIS.
                    </p>

                    <h3>Prinsip Keamanan Finansial Kami</h3>
                    <ul>
                        <li><strong>Kurs Transparan</strong> — Angka yang Anda lihat pada simulasi adalah nominal transfer murni tanpa embel-embel markup tersembunyi.</li>
                        <li><strong>Sumber Dana Terverifikasi</strong> — Saldo didistribusikan dari pembayaran invoice pekerjaan resmi, sehingga aman dari risiko sengketa atau pembekuan akun.</li>
                        <li><strong>Proteksi Pelanggan</strong> — Dilengkapi jaminan transaksi tuntas atau uang kembali 100% apabila terjadi kendala teknis pada pihak merchant.</li>
                    </ul>

                    <h3>Mulai Bertransaksi Sekarang</h3>
                    <p class="mb-0">
                        Bebaskan diri dari hambatan pembayaran lintas negara. <a href="<?= route_to('auth.register') ?>" class="text-brand fw-bold">Daftar akun gratis sekarang</a> dan ajukan order pertama Anda dalam hitungan menit.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
