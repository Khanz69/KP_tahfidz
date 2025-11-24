<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="bi bi-file-gear me-2"></i>
        Edit Laporan
    </h2>
    <a href="<?= base_url('/laporan') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-info-circle me-2"></i>
                    Form Edit Laporan
                </h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/laporan/update/' . $laporan['laporan_id']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hafalan_id" class="form-label">
                                Data Hafalan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= session('errors.hafalan_id') ? 'is-invalid' : '' ?>" 
                                    id="hafalan_id" 
                                    name="hafalan_id" 
                                    required>
                                <option value="">Pilih Data Hafalan</option>
                                <?php foreach ($hafalan as $h): ?>
                                    <option value="<?= $h['hafalan_id'] ?>" 
                                            <?= old('hafalan_id', $laporan['hafalan_id']) == $h['hafalan_id'] ? 'selected' : '' ?>>
                                        <?= esc($h['nama_santri']) ?> - Juz <?= $h['juz'] ?> 
                                        <?php if ($h['surat']): ?>
                                            (<?= esc($h['surat']) ?>)
                                        <?php endif; ?>
                                        - <?= date('d M Y', strtotime($h['tanggal_setor'])) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.hafalan_id')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.hafalan_id') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jenis_laporan" class="form-label">
                                Jenis Laporan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= session('errors.jenis_laporan') ? 'is-invalid' : '' ?>" 
                                    id="jenis_laporan" 
                                    name="jenis_laporan" 
                                    required>
                                <option value="">Pilih Jenis Laporan</option>
                                <option value="mingguan" <?= old('jenis_laporan', $laporan['jenis_laporan']) == 'mingguan' ? 'selected' : '' ?>>
                                    Laporan Mingguan
                                </option>
                                <option value="bulanan" <?= old('jenis_laporan', $laporan['jenis_laporan']) == 'bulanan' ? 'selected' : '' ?>>
                                    Laporan Bulanan
                                </option>
                                <option value="semesteran" <?= old('jenis_laporan', $laporan['jenis_laporan']) == 'semesteran' ? 'selected' : '' ?>>
                                    Laporan Semesteran
                                </option>
                            </select>
                            <?php if (session('errors.jenis_laporan')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.jenis_laporan') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="tanggal_laporan" class="form-label">
                                Tanggal Laporan <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control <?= session('errors.tanggal_laporan') ? 'is-invalid' : '' ?>" 
                                   id="tanggal_laporan" 
                                   name="tanggal_laporan" 
                                   value="<?= old('tanggal_laporan', $laporan['tanggal_laporan']) ?>"
                                   required>
                            <?php if (session('errors.tanggal_laporan')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.tanggal_laporan') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('/laporan') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
