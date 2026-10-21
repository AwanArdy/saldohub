<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="text-center mb-4">
            <div class="brand-logo-icon mx-auto mb-3" style="width: 2.75rem; height: 2.75rem;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L3 7V12C3 17.5 7 21.5 12 22C17 21.5 21 17.5 21 12V7L12 2Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 12H15M12 9V15" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="fw-bold mb-1">Registrasi Akun</h3>
            <p class="text-muted small mb-0">Buat akun SaldoHub untuk kemudahan bertransaksi</p>
        </div>

        <?= view('partials/flash') ?>

        <form method="post" action="<?= route_to('auth.register') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label" for="name">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" required minlength="3" placeholder="Nama Anda" value="<?= esc(old('name')) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" required placeholder="nama@email.com" value="<?= esc(old('email')) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="paypal_acc">Akun PayPal Utama <span class="text-muted small fw-normal">(Opsional)</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-wallet2"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0" id="paypal_acc" name="paypal_acc" placeholder="email-paypal@domain.com" value="<?= esc(old('paypal_acc')) ?>">
                </div>
                <div class="form-text small" style="font-size: 0.76rem;">Dapat diubah kapan saja di dashboard.</div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" required minlength="8" placeholder="Minimal 8 karakter">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label" for="confirm">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control border-start-0 ps-0" id="confirm" name="confirm" required placeholder="Ulangi kata sandi">
                </div>
            </div>

            <button type="submit" class="btn btn-brand w-100 py-2 fs-6">
                <i class="bi bi-person-check me-1"></i> Buat Akun Baru
            </button>
        </form>

        <p class="text-center small text-muted mt-4 mb-0">
            Sudah memiliki akun? <a href="<?= route_to('auth.login') ?>" class="text-brand fw-bold text-decoration-none">Masuk di sini</a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>
