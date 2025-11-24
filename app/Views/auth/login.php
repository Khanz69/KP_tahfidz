<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('login_fail')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('login_fail') ?></div>
<?php endif; ?>

<?= form_open('/login') ?>
    <?= csrf_field() ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="card-brand">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='30' fill='%23fdf2e9'/%3E%3Ctext x='32' y='37' font-family='Segoe UI' font-size='24' text-anchor='middle' fill='%23033a16'%3EDT%3C/text%3E%3C/svg%3E" alt="Data Monitoring Thafidz logo" class="auth-logo-img">
                <div>
                    <p class="card-title mb-0">Data Monitoring Thafidz</p>
                    <small class="text-white-50">Memantau Hafalan Santri</small>
                </div>
            </div>
            <h5 class="text-white fw-semibold mb-3">Masuk</h5>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="<?= esc(old('username')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= $err ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="d-grid">
                <button class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
