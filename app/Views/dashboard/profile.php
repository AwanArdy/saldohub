<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--border-subtle) !important;">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-subtle">
                    <div class="stat-ico-wrap stat-ico-blue">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0 text-ink">Pengaturan Profil Akun</h4>
                        <p class="text-muted small mb-0">Kelola identitas akun dan preferensi rekening PayPal default Anda</p>
                    </div>
                </div>

                <form method="post" action="<?= route_to('dashboard.profile.save') ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" required minlength="3"
                                   value="<?= esc($user['name'] ?? '') ?>" placeholder="Nama lengkap Anda">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Email Terdaftar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 bg-light" value="<?= esc($user['email'] ?? '') ?>" disabled>
                        </div>
                        <div class="form-text small" style="font-size: 0.76rem;">Alamat email merupakan identitas akun unik dan tidak dapat diubah.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="paypal_acc">Akun PayPal Default</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-wallet2"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0" id="paypal_acc" name="paypal_acc"
                                   placeholder="email-paypal@domain.com"
                                   value="<?= esc($user['paypal_acc'] ?? '') ?>">
                        </div>
                        <div class="form-text small" style="font-size: 0.76rem;">Otomatis terisi saat Anda membuat order top up saldo baru.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="password">Kata Sandi Baru <span class="text-muted small fw-normal">(Kosongkan jika tidak ingin mengganti)</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" minlength="8" placeholder="Minimal 8 karakter">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-brand">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan Profil
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
