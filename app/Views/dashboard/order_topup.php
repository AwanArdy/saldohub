<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-subtle">
                    <div class="stat-ico-wrap stat-ico-blue">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-ink">Order Top Up Saldo PayPal</h4>
                        <p class="text-muted small mb-0">Kurs hari ini Rp <?= number_format($rate, 0, ',', '.') ?> &bull; Minimal US$ <?= number_format($minUsd) ?></p>
                    </div>
                </div>

                <form id="orderForm" method="post" action="<?= route_to('dashboard.topup.store') ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label" for="amount">Nominal Pembelian (USD)</label>
                        <div class="sim-input-box d-flex">
                            <div class="sim-input-prefix">$</div>
                            <input type="number" class="sim-input-control sim-amount" id="amount" name="amount"
                                   value="<?= esc(old('amount', 50)) ?>" min="<?= esc($minUsd) ?>" step="1" required>
                        </div>
                        <div class="form-text small" id="simHint">Masukkan nominal dalam USD untuk melihat estimasi rupiah.</div>
                    </div>

                    <!-- Live Breakdown Box -->
                    <div class="sim-breakdown-card mb-4 d-none" id="simBox">
                        <div class="sim-breakdown-row">
                            <span>Kurs Per 1 USD</span>
                            <span class="val sim-rate">Rp <?= number_format($rate, 0, ',', '.') ?></span>
                        </div>
                        <div class="sim-breakdown-row">
                            <span>Biaya Admin</span>
                            <span class="val text-success fw-bold">Gratis (Rp 0)</span>
                        </div>
                        <div class="sim-breakdown-row total-row">
                            <span>Total yang Harus Ditransfer</span>
                            <span class="val text-brand sim-total">Rp 0</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="paypal_acc">Alamat Email PayPal Penerima</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0" id="paypal_acc" name="paypal_acc"
                                   placeholder="email-paypal@domain.com" required
                                   value="<?= esc(old('paypal_acc', $settings['paypal_acc_default'] ?? '')) ?>">
                        </div>
                        <div class="form-text small">Pastikan email PayPal valid dan aktif untuk menerima transfer dana.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="note">Catatan Tambahan <span class="text-muted small fw-normal">(Opsional)</span></label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Tuliskan catatan khusus bila ada..."><?= esc(old('note')) ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-brand btn-lg w-100">
                        <i class="bi bi-check2-circle me-1"></i> Buat Order &amp; Dapatkan Rekening Transfer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
