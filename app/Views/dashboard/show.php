<?= $this->extend('layouts/dashboard') ?>

<?php
$fmt = static fn (float $n): string => number_format($n, 0, ',', '.');
$statusMap = [
    'pending'    => ['badge-pending', 'Menunggu Pembayaran'],
    'processing' => ['badge-processing', 'Sedang Diproses'],
    'done'       => ['badge-done', 'Selesai'],
    'cancelled'  => ['badge-cancelled', 'Dibatalkan'],
];
[$class, $label] = $statusMap[$order['status']] ?? ['badge-pending', $order['status']];
$waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '6281234567890');
$waText = rawurlencode("Halo SaldoKita, saya ingin konfirmasi pembayaran untuk Order #{$order['id']} sebesar Rp " . $fmt((float) $order['total_rupiah']) . ".");
$whatsappUrl = 'https://wa.me/' . $waNumber . '?' . $waText;
?>

<?= $this->section('content') ?>
<div class="row g-4">
    <!-- Order Details Card -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-subtle">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.08em;">Detail Transaksi</span>
                        <h4 class="fw-bold mb-0 text-ink tabular-nums">Order #<?= str_pad((string) $order['id'], 5, '0', STR_PAD_LEFT) ?></h4>
                    </div>
                    <span class="badge-status <?= $class ?>"><?= esc($label) ?></span>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-4">
                        <tbody class="small">
                            <tr class="border-bottom border-subtle">
                                <td class="text-muted py-2" style="width:38%">Jenis Layanan</td>
                                <td class="py-2 fw-semibold text-ink">
                                    <?= $order['type'] === 'topup' ? 'Top Up Saldo PayPal' : 'Jasa Pembayaran Online' ?>
                                </td>
                            </tr>
                            <tr class="border-bottom border-subtle">
                                <td class="text-muted py-2">Nominal Transaksi</td>
                                <td class="py-2 fw-bold text-ink fs-6 tabular-nums">US$ <?= number_format((float) $order['amount'], 2) ?></td>
                            </tr>
                            <tr class="border-bottom border-subtle">
                                <td class="text-muted py-2">Kurs Pertukaran</td>
                                <td class="py-2 text-ink tabular-nums">Rp <?= $fmt((float) $order['rate']) ?> / USD</td>
                            </tr>
                            <?php if ($order['type'] === 'pay') : ?>
                                <tr class="border-bottom border-subtle">
                                    <td class="text-muted py-2">Biaya Admin Jasa</td>
                                    <td class="py-2 text-ink tabular-nums">Rp <?= $fmt((float) $order['admin_fee']) ?></td>
                                </tr>
                                <tr class="border-bottom border-subtle">
                                    <td class="text-muted py-2">Tautan Produk Item</td>
                                    <td class="py-2 text-break"><a href="<?= esc($order['item_url']) ?>" target="_blank" rel="noopener" class="text-brand text-decoration-none fw-semibold"><?= esc($order['item_url']) ?> <i class="bi bi-box-arrow-up-right small"></i></a></td>
                                </tr>
                            <?php else : ?>
                                <tr class="border-bottom border-subtle">
                                    <td class="text-muted py-2">Akun PayPal Penerima</td>
                                    <td class="py-2 fw-bold text-brand"><?= esc($order['paypal_acc']) ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (! empty($order['note'])) : ?>
                                <tr class="border-bottom border-subtle">
                                    <td class="text-muted py-2">Catatan Order</td>
                                    <td class="py-2 text-ink"><?= esc($order['note']) ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr class="border-bottom border-subtle">
                                <td class="text-muted py-2">Waktu Pembuatan</td>
                                <td class="py-2 text-muted tabular-nums"><?= date('d M Y, H:i:s', strtotime($order['created_at'])) ?> WIB</td>
                            </tr>
                            <tr style="background: var(--surface-soft);">
                                <td class="py-3 ps-3"><strong class="text-ink">Total Pembayaran</strong></td>
                                <td class="py-3 pe-3 text-end"><strong class="text-brand fs-4 tabular-nums">Rp <?= $fmt((float) $order['total_rupiah']) ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-outline-brand btn-sm" href="<?= route_to('dashboard.index') ?>">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                    </a>
                    <a class="btn btn-brand btn-sm d-inline-flex align-items-center gap-1" href="<?= route_to('dashboard.invoice', $order['id']) ?>">
                        <i class="bi bi-file-earmark-pdf"></i> Unduh Invoice PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bank Instruction Card -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-bank text-brand"></i> Instruksi Pembayaran Bank
                </h5>

                <div class="p-3 bg-brand-soft rounded-3 mb-3">
                    <div class="small text-muted mb-1">Nominal yang Harus Ditransfer:</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fs-4 fw-bold text-brand tabular-nums">Rp <?= $fmt((float) $order['total_rupiah']) ?></span>
                        <button type="button" class="btn-copy" data-copy="<?= (int) $order['total_rupiah'] ?>">
                            <i class="bi bi-copy me-1"></i>Salin Nominal
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="small text-muted mb-1">Bank Tujuan:</div>
                    <div class="fw-bold text-ink fs-6"><?= esc($settings['bank_name'] ?? 'BCA') ?></div>
                </div>

                <div class="mb-3">
                    <div class="small text-muted mb-1">Nomor Rekening:</div>
                    <div class="d-flex align-items-center justify-content-between p-2 rounded-2 border border-subtle bg-white">
                        <span class="fw-bold fs-6 text-ink tabular-nums"><?= esc($settings['bank_account'] ?? '-') ?></span>
                        <button type="button" class="btn-copy" data-copy="<?= esc($settings['bank_account'] ?? '') ?>">
                            <i class="bi bi-copy me-1"></i>Salin No. Rek
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="small text-muted mb-1">Atas Nama:</div>
                    <div class="fw-bold text-ink"><?= esc($settings['bank_holder'] ?? '-') ?></div>
                </div>

                <ol class="small text-muted ps-3 mb-4" style="line-height: 1.6;">
                    <li>Transfer sesuai nominal tepat hingga digit terakhir.</li>
                    <li>Sertakan pesan transfer dengan kode <strong>#<?= $order['id'] ?></strong>.</li>
                    <li>Setelah transfer, klik tombol konfirmasi WhatsApp di bawah.</li>
                </ol>

                <a class="btn btn-brand w-100 py-2 d-flex align-items-center justify-content-center gap-2 mb-3" href="<?= esc($whatsappUrl) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp"></i>
                    <span>Konfirmasi Pembayaran via WhatsApp</span>
                </a>

                <div class="p-2 px-3 rounded-2 bg-soft border border-subtle small text-muted">
                    <i class="bi bi-shield-check text-brand me-1"></i>
                    Order terlindungi garansi 100%. Saldo akan diproses segera setelah transfer terverifikasi.
                </div>
            </div>
        </div>
    </div>

    <!-- Proof of Delivery Section if completed -->
    <?php if ($order['status'] === 'done' && ! empty($order['proof_path'])) : ?>
        <div class="col-12 mt-3">
            <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold mb-3 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-receipt text-success"></i> Bukti Pengiriman Resmi
                    </h5>
                    <a href="<?= route_to('proof.view', $order['id']) ?>" target="_blank" class="d-inline-block">
                        <img src="<?= route_to('proof.view', $order['id']) ?>"
                             alt="Bukti pengiriman order #<?= $order['id'] ?>"
                             class="img-fluid rounded-3 shadow-sm border border-subtle" style="max-height:420px">
                    </a>
                    <p class="small text-muted mt-3 mb-0">
                        <i class="bi bi-patch-check-fill text-success me-1"></i> Saldo atau pembayaran berhasil dikirimkan ke tujuan dan notifikasi telah dikirimkan ke email Anda.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
