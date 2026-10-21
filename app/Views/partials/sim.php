<?php
/**
 * Kartu simulasi top up / jasa bayar.
 * $type : 'topup'|'pay'
 * $rate, $min, $settings : dikirim dari view utama
 */
$type = $type ?? 'topup';
$isTopup = $type === 'topup';
$uid = 'sim-' . $type;
$fmt = static fn (float $n): string => number_format($n, 0, ',', '.');
$defaultAmount = $isTopup ? 50 : 25;
$presets = $isTopup ? [50, 100, 250, 500] : [15, 30, 75, 150];
?>
<div class="sim-card p-4 h-100" data-type="<?= $type ?>">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="eyebrow-pill mb-1">
                <?= $isTopup ? 'Kalkulator Top Up' : 'Kalkulator Jasa Bayar' ?>
            </span>
            <h5 class="fw-bold mb-0 mt-1">
                Simulasi <?= $isTopup ? 'Beli Saldo' : 'Pembayaran Item' ?>
            </h5>
        </div>
        <div class="badge bg-brand-soft text-brand fw-semibold px-2 py-1 small">
            <span class="pulse-dot d-inline-block me-1"></span> Live Rate
        </div>
    </div>

    <p class="text-muted small mb-3">
        <?= $isTopup
            ? 'Kalkulasi nominal rupiah yang perlu kamu transfer ke rekening lokal kami.'
            : 'Hitung total belanja rupiah termasuk biaya penanganan checkout resmi.' ?>
    </p>

    <!-- Nominal Input -->
    <div class="mb-3">
        <label class="form-label" for="<?= $uid ?>-amount">
            <?= $isTopup ? 'Nominal PayPal yang Ingin Dibeli (USD)' : 'Total Harga Belanja Item (USD)' ?>
        </label>
        <div class="sim-input-box d-flex">
            <div class="sim-input-prefix">$</div>
            <input type="number" class="sim-input-control sim-amount" id="<?= $uid ?>-amount"
                   value="<?= $defaultAmount ?>" min="<?= esc($min) ?>" step="1" inputmode="numeric"
                   placeholder="<?= $defaultAmount ?>">
        </div>
        <!-- Quick Preset Chips -->
        <div class="quick-chips">
            <span class="text-muted small align-self-center me-1" style="font-size: 0.75rem;">Preset:</span>
            <?php foreach ($presets as $p) : ?>
                <button type="button" class="chip-btn" data-val="<?= $p ?>">+$<?= $p ?></button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Live Breakdown Card -->
    <div class="sim-breakdown-card mb-4">
        <div class="sim-breakdown-row">
            <span>Kurs Referensi</span>
            <span class="val sim-rate">Rp <?= $fmt($rate) ?> / USD</span>
        </div>
        <?php if (! $isTopup) : ?>
            <div class="sim-breakdown-row">
                <span>Biaya Admin Checkout</span>
                <span class="val sim-fee">Rp 0</span>
            </div>
        <?php else : ?>
            <div class="sim-breakdown-row">
                <span>Biaya Admin</span>
                <span class="val text-success fw-bold">Gratis (Rp 0)</span>
            </div>
            <div class="sim-breakdown-row">
                <span>Saldo Bersih Masuk</span>
                <span class="val sim-usd">$<?= $defaultAmount ?> USD</span>
            </div>
        <?php endif; ?>
        <div class="sim-breakdown-row total-row">
            <span>Total yang Ditransfer</span>
            <span class="val sim-total text-brand">Rp 0</span>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-grid gap-2">
        <button type="button" class="btn btn-brand sim-btn py-2">
            <span class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
            <span class="btn-text">Hitung Estimasi</span>
        </button>
        <a class="btn btn-outline-brand sim-order py-2 d-flex align-items-center justify-content-center gap-2" href="#" target="_blank" rel="noopener">
            <i class="bi bi-whatsapp text-success"></i>
            <span>Lanjut Order WhatsApp</span>
        </a>
    </div>

    <div class="d-flex align-items-center gap-2 small text-muted mt-3 pt-2 border-top border-subtle" style="font-size: 0.78rem;">
        <i class="bi bi-shield-check text-brand fs-6"></i>
        <span>Minimal <?= $isTopup ? 'top up' : 'order' ?> <strong>US$ <?= $fmt($min) ?></strong>. Rate final terkunci saat order dibuat.</span>
    </div>
</div>
