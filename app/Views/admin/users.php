<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1 text-ink">Daftar Pelanggan Terdaftar</h5>
                <p class="text-muted small mb-0">Total akun pengguna terdaftar di platform SaldoKita</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-luxury align-middle">
                <thead>
                    <tr>
                        <th>No. ID</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat Email</th>
                        <th>Akun PayPal Default</th>
                        <th>Total Order</th>
                        <th>Tanggal Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u) : ?>
                    <tr>
                        <td class="text-muted tabular-nums">#<?= str_pad((string) $u['id'], 4, '0', STR_PAD_LEFT) ?></td>
                        <td>
                            <div class="fw-bold text-ink">
                                <?= esc($u['name']) ?>
                                <?php if ($u['role'] === 'admin') : ?>
                                    <span class="badge bg-brand-soft text-brand ms-1 small">Admin</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="small text-muted"><?= esc($u['email']) ?></td>
                        <td class="small font-monospace"><?= esc($u['paypal_acc'] ?? '-') ?></td>
                        <td>
                            <span class="badge bg-soft border border-subtle text-ink fw-bold px-2 py-1 tabular-nums">
                                <?= (new \App\Models\OrderModel())->where('user_id', $u['id'])->countAllResults() ?> Order
                            </span>
                        </td>
                        <td class="small text-muted tabular-nums"><?= date('d M Y, H:i', strtotime($u['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
