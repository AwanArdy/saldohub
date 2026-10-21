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
            <h3 class="fw-bold mb-1">Masuk ke Akun</h3>
            <p class="text-muted small mb-0">Akses dashboard transaksi dan pantau riwayat order Anda</p>
        </div>

        <?= view('partials/flash') ?>

        <form method="post" action="<?= route_to('auth.login') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label" for="email">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0 ps-0 <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                           id="email" name="email" required value="<?= esc(old('email')) ?>" placeholder="nama@email.com">
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0" for="password">Kata Sandi</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" required placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn btn-brand w-100 py-2 fs-6">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
            </button>
        </form>

        <!-- Demo Account Banner -->
        <div class="p-3 bg-brand-soft rounded-3 mt-4 border border-subtle">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="small fw-bold text-brand"><i class="bi bi-person-badge me-1"></i> Akun Demo:</span>
                <button type="button" class="btn-copy" id="fillDemoBtn" style="font-size: 0.72rem;">
                    Isi Otomatis
                </button>
            </div>
            <div class="small text-muted font-monospace" style="font-size: 0.8rem;">
                user@saldohub.test &bull; user12345
            </div>
        </div>

        <p class="text-center small text-muted mt-4 mb-0">
            Belum memiliki akun? <a href="<?= route_to('auth.register') ?>" class="text-brand fw-bold text-decoration-none">Daftar Akun Baru</a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('page_scripts') ?>
<script>
$('#fillDemoBtn').on('click', function(e) {
    e.preventDefault();
    $('#email').val('user@saldohub.test');
    $('#password').val('user12345');
    $(this).html('<i class="bi bi-check2 text-success me-1"></i>Terisi');
});
</script>
<?= $this->endSection() ?>
