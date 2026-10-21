<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<!-- Stat Cards Row -->
<div class="row g-3 mb-4">
    <?php
    $cards = [
        ['Total Order', $stats['total'], 'bi-layers-fill', 'stat-ico-blue'],
        ['Menunggu Proses', $stats['pending'], 'bi-hourglass-split', 'stat-ico-amber'],
        ['Order Selesai', $stats['done'], 'bi-check2-circle', 'stat-ico-green'],
        ['Rate Aktif Hari Ini', 'Rp ' . number_format($rate, 0, ',', '.'), 'bi-activity', 'stat-ico-blue'],
    ];
    foreach ($cards as [$label, $val, $ico, $cls]) : ?>
        <div class="col-6 col-lg-3">
            <div class="stat-card-luxury">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-ico-wrap <?= $cls ?>">
                        <i class="bi <?= $ico ?>"></i>
                    </div>
                    <div>
                        <div class="small text-muted" style="font-size: 0.78rem;"><?= esc($label) ?></div>
                        <div class="fw-bold fs-5 text-ink tabular-nums"><?= $val ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Quick Actions -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <a class="action-box" href="<?= route_to('dashboard.topup') ?>">
            <div class="d-flex align-items-start gap-3">
                <div class="stat-ico-wrap stat-ico-blue flex-shrink-0">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <h5 class="fw-bold mb-0 text-ink">Buat Order Top Up Saldo</h5>
                        <i class="bi bi-arrow-right text-brand"></i>
                    </div>
                    <p class="text-muted small mb-0">Isi saldo langsung ke akun PayPal tujuan. Minimal order US$ <?= number_format($minTopup) ?>.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a class="action-box" href="<?= route_to('dashboard.pay') ?>">
            <div class="d-flex align-items-start gap-3">
                <div class="stat-ico-wrap stat-ico-amber flex-shrink-0">
                    <i class="bi bi-credit-card-2-front"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <h5 class="fw-bold mb-0 text-ink">Buat Order Jasa Bayar</h5>
                        <i class="bi bi-arrow-right text-warning"></i>
                    </div>
                    <p class="text-muted small mb-0">Kami bayarkan produk belanja luar negeri atas nama Anda. Minimal order US$ <?= number_format($minPay) ?>.</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Orders History Table -->
<div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1 text-ink">Riwayat Transaksi</h5>
                <p class="text-muted small mb-0">Daftar seluruh pesanan top up dan jasa bayar yang pernah dibuat</p>
            </div>
        </div>

        <?php if ($orders === []) : ?>
            <div class="text-center py-5">
                <div class="service-icon-wrap mx-auto mb-3" style="width: 3.5rem; height: 3.5rem; font-size: 1.5rem;">
                    <i class="bi bi-inbox text-muted"></i>
                </div>
                <h6 class="fw-bold text-ink mb-1">Belum Ada Riwayat Order</h6>
                <p class="text-muted small mb-3">Silakan pilih menu top up atau jasa bayar di atas untuk memulai transaksi pertama Anda.</p>
                <a href="<?= route_to('dashboard.topup') ?>" class="btn btn-brand btn-sm">Mulai Order Sekarang</a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-luxury align-middle">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Layanan</th>
                            <th>Nominal (USD)</th>
                            <th>Total (IDR)</th>
                            <th>Status Transaksi</th>
                            <th>Tanggal &amp; Waktu</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o) : ?>
                            <tr>
                                <td class="fw-bold text-brand tabular-nums">#<?= str_pad((string) $o['id'], 5, '0', STR_PAD_LEFT) ?></td>
                                <td>
                                    <?php if ($o['type'] === 'topup') : ?>
                                        <span class="badge-type-topup"><i class="bi bi-wallet2 me-1"></i>Top Up</span>
                                    <?php else : ?>
                                        <span class="badge-type-pay"><i class="bi bi-cart-check me-1"></i>Jasa Bayar</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold tabular-nums">$<?= number_format((float) $o['amount'], 2) ?></td>
                                <td class="fw-bold tabular-nums text-ink">Rp <?= number_format((float) $o['total_rupiah'], 0, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $map = [
                                        'pending'    => ['badge-pending', 'Menunggu Pembayaran'],
                                        'processing' => ['badge-processing', 'Sedang Diproses'],
                                        'done'       => ['badge-done', 'Selesai'],
                                        'cancelled'  => ['badge-cancelled', 'Dibatalkan'],
                                    ];
                                    [$class, $label] = $map[$o['status']] ?? ['badge-pending', $o['status']];
                                    ?>
                                    <span class="badge-status <?= $class ?>"><?= esc($label) ?></span>
                                </td>
                                <td class="small text-muted tabular-nums"><?= date('d M Y, H:i', strtotime($o['created_at'])) ?></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-brand" href="<?= route_to('dashboard.show', $o['id']) ?>">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
