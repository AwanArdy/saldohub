<?= $this->extend('layouts/dashboard') ?>

<?php
$statusMap = [
    'pending'    => ['badge-pending', 'Pending'],
    'processing' => ['badge-processing', 'Diproses'],
    'done'       => ['badge-done', 'Selesai'],
    'cancelled'  => ['badge-cancelled', 'Batal'],
];
?>

<?= $this->section('content') ?>
<!-- Stat Cards Row -->
<div class="row g-3 mb-4">
    <?php
    $cards = [
        ['Total Seluruh Order', $stats['total'], 'bi-layers-fill', 'stat-ico-blue'],
        ['Menunggu Diproses', $stats['pending'], 'bi-hourglass-split', 'stat-ico-amber'],
        ['Order Selesai', $stats['done'], 'bi-check2-circle', 'stat-ico-green'],
    ];
    foreach ($cards as [$label, $val, $ico, $cls]) : ?>
        <div class="col-4">
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

<div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1 text-ink">Kelola Semua Transaksi</h5>
                <p class="text-muted small mb-0">Perbarui status order dan unggah bukti pengiriman resmi untuk pelanggan</p>
            </div>
        </div>

        <?php if ($orders === []) : ?>
            <p class="text-muted small mb-0">Belum ada order masuk.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-luxury align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th style="min-width:240px">Tindakan Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $o) : [$c, $lbl] = $statusMap[$o['status']] ?? ['badge-pending', $o['status']]; ?>
                        <tr>
                            <td class="fw-bold text-brand tabular-nums">#<?= str_pad((string) $o['id'], 5, '0', STR_PAD_LEFT) ?></td>
                            <td>
                                <div class="fw-bold text-ink small"><?= esc($o['user_name']) ?></div>
                                <div class="text-muted" style="font-size:0.75rem"><?= esc($o['user_email']) ?></div>
                            </td>
                            <td>
                                <?php if ($o['type'] === 'topup') : ?>
                                    <span class="badge-type-topup">Top Up</span>
                                <?php else : ?>
                                    <span class="badge-type-pay">Jasa Bayar</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold tabular-nums">$<?= number_format((float) $o['amount'], 2) ?></td>
                            <td><span class="badge-status <?= $c ?>"><?= esc($lbl) ?></span></td>
                            <td>
                                <?php if (! empty($o['proof_path'])) : ?>
                                    <a href="<?= route_to('proof.view', $o['id']) ?>" target="_blank">
                                        <img src="<?= route_to('proof.view', $o['id']) ?>" alt="bukti" style="width:40px;height:40px;object-fit:cover" class="rounded-2 border border-subtle">
                                    </a>
                                <?php else : ?>
                                    <span class="text-muted small">&mdash;</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <!-- Form ganti status -->
                                    <form class="d-inline-flex gap-1 align-items-center" method="post" action="<?= route_to('admin.status', $o['id']) ?>">
                                        <?= csrf_field() ?>
                                        <select name="status" class="form-select form-select-sm" style="width:115px; font-size: 0.82rem;">
                                            <?php foreach (['processing' => 'Diproses', 'done' => 'Selesai', 'cancelled' => 'Batal'] as $v => $t) : ?>
                                                <option value="<?= $v ?>" <?= $o['status'] === $v ? 'selected' : '' ?>><?= $t ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="btn btn-sm btn-outline-brand" type="submit" style="padding: 0.35rem 0.6rem;">Update</button>
                                    </form>

                                    <!-- Upload bukti -->
                                    <button class="btn btn-sm btn-brand d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#up-<?= $o['id'] ?>" <?= $o['status'] === 'done' ? 'disabled' : '' ?> style="padding: 0.35rem 0.65rem;">
                                        <i class="bi bi-upload"></i> Bukti
                                    </button>
                                </div>
                                <div class="collapse mt-2" id="up-<?= $o['id'] ?>">
                                    <form method="post" action="<?= route_to('admin.proof', $o['id']) ?>" enctype="multipart/form-data" class="d-flex gap-2 align-items-center p-2 rounded-2 bg-soft border border-subtle">
                                        <?= csrf_field() ?>
                                        <input type="file" name="proof" class="form-control form-control-sm" accept="image/*" required>
                                        <button class="btn btn-sm btn-brand flex-shrink-0" type="submit">Upload</button>
                                    </form>
                                    <div class="form-text small" style="font-size: 0.72rem;">Gambar otomatis di-resize &amp; kompres &rarr; status otomatis "Selesai" &rarr; email notifikasi dikirimkan.</div>
                                </div>
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
