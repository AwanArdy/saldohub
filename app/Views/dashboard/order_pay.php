<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-subtle">
                    <div class="stat-ico-wrap stat-ico-amber">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-ink">Order Jasa Pembayaran Online</h4>
                        <p class="text-muted small mb-0">
                            Kurs Rp <?= number_format($rate, 0, ',', '.') ?> &bull; Biaya jasa <?= esc($feePct) ?>% (min. Rp <?= number_format($feeMin, 0, ',', '.') ?>)
                        </p>
                    </div>
                </div>

                <form id="orderForm" method="post" action="<?= route_to('dashboard.pay.store') ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label" for="amount">Harga Item / Tagihan Belanja (USD)</label>
                        <div class="sim-input-box d-flex">
                            <div class="sim-input-prefix">$</div>
                            <input type="number" class="sim-input-control sim-amount" id="amount" name="amount"
                                   value="<?= esc(old('amount', 10)) ?>" min="<?= esc($minUsd) ?>" step="1" required>
                        </div>
                        <div class="form-text small" id="simHint">Masukkan total harga produk/invoice dalam USD.</div>
                    </div>

                    <!-- Live Breakdown Box -->
                    <div class="sim-breakdown-card mb-4 d-none" id="simBox">
                        <div class="sim-breakdown-row">
                            <span>Kurs Per 1 USD</span>
                            <span class="val sim-rate">Rp <?= number_format($rate, 0, ',', '.') ?></span>
                        </div>
                        <div class="sim-breakdown-row">
                            <span>Biaya Jasa Admin</span>
                            <span class="val sim-fee">Rp 0</span>
                        </div>
                        <div class="sim-breakdown-row total-row">
                            <span>Total yang Harus Ditransfer</span>
                            <span class="val text-brand sim-total">Rp 0</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="item_url">Tautan Produk atau Invoice Merchant</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-link-45deg"></i></span>
                            <input type="url" class="form-control border-start-0 ps-0" id="item_url" name="item_url" required
                                   placeholder="https://toko-online.com/checkout/..." value="<?= esc(old('item_url')) ?>">
                        </div>
                        <div class="form-text small">Tautan website toko atau link invoice pembayaran yang perlu kami lunasi.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="note">Keterangan / Opsi Pembelian <span class="text-muted small fw-normal">(Opsional)</span></label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Contoh: Pilih varian warna hitam, size L, dll..."><?= esc(old('note')) ?></textarea>
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
