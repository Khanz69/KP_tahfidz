<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
    $openEditId = $openEditId ?? null;
    $prefillHafalanId = $prefillHafalanId ?? null;
    $errorBag = session('errors') ?? [];
    $lastFormType = old('form_type');
    $editingLaporanId = old('laporan_id');
    $openEditModalId = $editingLaporanId ? $editingLaporanId : $openEditId;
    $shouldOpenCreateModal = $lastFormType === 'create' || !empty($prefillHafalanId);
    $createHasErrors = $lastFormType === 'create';
    $editHasErrors = $lastFormType === 'edit';
    $showErrorAlert = $errorBag && in_array($lastFormType, ['create', 'edit']);
    $createHafalanValue = old('hafalan_id', $prefillHafalanId ?? '');
    $createJenisValue = old('jenis_laporan');
    $createTanggalValue = old('tanggal_laporan');
    $createHafalanInvalid = $createHasErrors && isset($errorBag['hafalan_id']) ? 'is-invalid' : '';
    $createJenisInvalid = $createHasErrors && isset($errorBag['jenis_laporan']) ? 'is-invalid' : '';
    $createTanggalInvalid = $createHasErrors && isset($errorBag['tanggal_laporan']) ? 'is-invalid' : '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="bi bi-file-earmark-text me-2"></i>
        Data Laporan
    </h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateLaporan">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Laporan
    </button>
</div>

<?php if ($showErrorAlert): ?>
<div class="alert alert-danger mb-4">
    <strong>Terjadi kesalahan:</strong>
    <ul class="mb-0">
        <?php foreach ($errorBag as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- Filter by Jenis Laporan -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('/laporan') ?>" 
                       class="btn btn-outline-primary <?= !isset($jenis) ? 'active' : '' ?>">
                        <i class="bi bi-list me-1"></i>
                        Semua Laporan
                    </a>
                    <a href="<?= base_url('/laporan/jenis/mingguan') ?>" 
                       class="btn btn-outline-info <?= (isset($jenis) && $jenis == 'mingguan') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-week me-1"></i>
                        Laporan Mingguan
                    </a>
                    <a href="<?= base_url('/laporan/jenis/bulanan') ?>" 
                       class="btn btn-outline-success <?= (isset($jenis) && $jenis == 'bulanan') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-month me-1"></i>
                        Laporan Bulanan
                    </a>
                    <a href="<?= base_url('/laporan/jenis/semesteran') ?>" 
                       class="btn btn-outline-warning <?= (isset($jenis) && $jenis == 'semesteran') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-range me-1"></i>
                        Laporan Semesteran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="laporanTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Santri</th>
                        <th>Juz</th>
                        <th>Surat</th>
                        <th>Status Hafalan</th>
                        <th>Jenis Laporan</th>
                        <th>Tanggal Laporan</th>
                        <th>Tanggal Setor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($laporan)): ?>
                        <?php foreach ($laporan as $l): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary"><?= $l['laporan_id'] ?></span>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= esc($l['nama_santri']) ?></strong>
                                        <br>
                                        <small class="text-muted"><?= esc($l['kamar']) ?> - <?= esc($l['kelas']) ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">Juz <?= $l['juz'] ?></span>
                                </td>
                                <td><?= esc($l['surat']) ?></td>
                                <td>
                                    <?php if ($l['status'] == 'lulus'): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Lulus
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">
                                            <i class="bi bi-x-circle me-1"></i>Tidak Lulus
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $badgeClass = '';
                                    $icon = '';
                                    switch ($l['jenis_laporan']) {
                                        case 'mingguan':
                                            $badgeClass = 'bg-info';
                                            $icon = 'bi-calendar-week';
                                            break;
                                        case 'bulanan':
                                            $badgeClass = 'bg-success';
                                            $icon = 'bi-calendar-month';
                                            break;
                                        case 'semesteran':
                                            $badgeClass = 'bg-warning';
                                            $icon = 'bi-calendar-range';
                                            break;
                                    }
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <i class="<?= $icon ?> me-1"></i>
                                        <?= ucfirst($l['jenis_laporan']) ?>
                                    </span>
                                </td>
                                <td>
                                    <small><?= date('d M Y', strtotime($l['tanggal_laporan'])) ?></small>
                                </td>
                                <td>
                                    <small><?= date('d M Y', strtotime($l['tanggal_setor'])) ?></small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDetail<?= $l['laporan_id'] ?>"
                                                title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="<?= base_url('/laporan/print/' . $l['laporan_id']) ?>" 
                                           class="btn btn-sm btn-outline-success" 
                                           title="Print"
                                           target="_blank">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary" 
                                                data-edit-open="<?= $l['laporan_id'] ?>" 
                                                title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="<?= base_url('/laporan/delete/' . $l['laporan_id']) ?>" 
                                           class="btn btn-sm btn-outline-danger btn-delete" 
                                           title="Hapus"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-file-earmark-text fs-1 d-block mb-2"></i>
                                Belum ada data laporan
                                <br>
                                <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalCreateLaporan">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Tambah Laporan Pertama
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Laporan -->
<?php foreach ($laporan as $l): ?>
<div class="modal fade" id="modalDetail<?= $l['laporan_id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Detail Laporan [ID: <?= $l['laporan_id'] ?>]
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Informasi Santri -->
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-person me-2"></i>
                                    Informasi Santri
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Nama Santri:</strong></td>
                                        <td><strong><?= esc($l['nama_santri']) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kamar:</strong></td>
                                        <td><?= esc($l['kamar']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kelas:</strong></td>
                                        <td><?= esc($l['kelas']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Hafalan -->
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-book me-2"></i>
                                    Informasi Hafalan
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Juz:</strong></td>
                                        <td><span class="badge bg-primary fs-6">Juz <?= $l['juz'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Halaman:</strong></td>
                                        <td>
                                            <?php if ($l['halaman']): ?>
                                                Halaman <?= $l['halaman'] ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Surat:</strong></td>
                                        <td><?= esc($l['surat']) ?: '-' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status dan Jenis Laporan -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Status Hafalan
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <?php if ($l['status'] == 'lulus'): ?>
                                    <div class="h3 text-success mb-2">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <span class="badge bg-success fs-6">LULUS</span>
                                <?php else: ?>
                                    <div class="h3 text-warning mb-2">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </div>
                                    <span class="badge bg-warning fs-6">TIDAK LULUS</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-file-earmark me-2"></i>
                                    Jenis Laporan
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <?php
                                $badgeClass = '';
                                $icon = '';
                                switch ($l['jenis_laporan']) {
                                    case 'mingguan':
                                        $badgeClass = 'bg-info';
                                        $icon = 'bi-calendar-week';
                                        break;
                                    case 'bulanan':
                                        $badgeClass = 'bg-success';
                                        $icon = 'bi-calendar-month';
                                        break;
                                    case 'semesteran':
                                        $badgeClass = 'bg-warning';
                                        $icon = 'bi-calendar-range';
                                        break;
                                }
                                ?>
                                <div class="h3 text-info mb-2">
                                    <i class="<?= $icon ?>"></i>
                                </div>
                                <span class="badge <?= $badgeClass ?> fs-6">
                                    <?= ucfirst($l['jenis_laporan']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Waktu -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-calendar me-2"></i>
                                    Tanggal Setor
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Tanggal:</strong></td>
                                        <td><?= date('d M Y', strtotime($l['tanggal_setor'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hari:</strong></td>
                                        <td><?= date('l', strtotime($l['tanggal_setor'])) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-dark text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-calendar-check me-2"></i>
                                    Tanggal Laporan
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Tanggal:</strong></td>
                                        <td><?= date('d M Y', strtotime($l['tanggal_laporan'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hari:</strong></td>
                                        <td><?= date('l', strtotime($l['tanggal_laporan'])) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Tutup
                </button>
                <a href="<?= base_url('/laporan/print/' . $l['laporan_id']) ?>" 
                   class="btn btn-success" 
                   target="_blank">
                    <i class="bi bi-printer me-1"></i>
                    Print
                </a>
                <button type="button" class="btn btn-warning" data-edit-open="<?= $l['laporan_id'] ?>">
                    <i class="bi bi-pencil me-1"></i>
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Edit Laporan -->
<?php foreach ($laporan as $l): ?>
    <?php
        $isEditingCurrent = $editHasErrors && $editingLaporanId == $l['laporan_id'];
        $selectedHafalanId = $isEditingCurrent && old('hafalan_id') !== null ? old('hafalan_id') : $l['hafalan_id'];
        $selectedJenis = $isEditingCurrent && old('jenis_laporan') !== null ? old('jenis_laporan') : $l['jenis_laporan'];
        $selectedTanggal = $isEditingCurrent && old('tanggal_laporan') !== null ? old('tanggal_laporan') : $l['tanggal_laporan'];
        $hafalanInvalid = $isEditingCurrent && isset($errorBag['hafalan_id']) ? 'is-invalid' : '';
        $jenisInvalid = $isEditingCurrent && isset($errorBag['jenis_laporan']) ? 'is-invalid' : '';
        $tanggalInvalid = $isEditingCurrent && isset($errorBag['tanggal_laporan']) ? 'is-invalid' : '';
    ?>
    <div class="modal fade" id="modalEdit<?= $l['laporan_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="<?= base_url('/laporan/update/' . $l['laporan_id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="form_type" value="edit">
                    <input type="hidden" name="laporan_id" value="<?= $l['laporan_id'] ?>">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title text-white">
                            <i class="bi bi-file-gear me-2"></i>
                            Edit Laporan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_hafalan_id_<?= $l['laporan_id'] ?>" class="form-label">
                                    Data Hafalan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?= $hafalanInvalid ?>" 
                                        id="edit_hafalan_id_<?= $l['laporan_id'] ?>" 
                                        name="hafalan_id" 
                                        required>
                                    <option value="">Pilih Data Hafalan</option>
                                    <?php foreach ($hafalan as $h): ?>
                                        <option value="<?= $h['hafalan_id'] ?>" <?= $selectedHafalanId == $h['hafalan_id'] ? 'selected' : '' ?>>
                                            <?= esc($h['nama_santri']) ?> - Juz <?= $h['juz'] ?>
                                            <?php if ($h['surat']): ?>(<?= esc($h['surat']) ?>)<?php endif; ?>
                                            - <?= date('d M Y', strtotime($h['tanggal_setor'])) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($hafalanInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['hafalan_id']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_jenis_laporan_<?= $l['laporan_id'] ?>" class="form-label">
                                    Jenis Laporan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?= $jenisInvalid ?>" 
                                        id="edit_jenis_laporan_<?= $l['laporan_id'] ?>" 
                                        name="jenis_laporan" 
                                        required>
                                    <option value="">Pilih Jenis Laporan</option>
                                    <option value="mingguan" <?= $selectedJenis == 'mingguan' ? 'selected' : '' ?>>Laporan Mingguan</option>
                                    <option value="bulanan" <?= $selectedJenis == 'bulanan' ? 'selected' : '' ?>>Laporan Bulanan</option>
                                    <option value="semesteran" <?= $selectedJenis == 'semesteran' ? 'selected' : '' ?>>Laporan Semesteran</option>
                                </select>
                                <?php if ($jenisInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['jenis_laporan']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_tanggal_laporan_<?= $l['laporan_id'] ?>" class="form-label">
                                    Tanggal Laporan <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control <?= $tanggalInvalid ?>" 
                                       id="edit_tanggal_laporan_<?= $l['laporan_id'] ?>" 
                                       name="tanggal_laporan" 
                                       value="<?= esc($selectedTanggal) ?>"
                                       required>
                                <?php if ($tanggalInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['tanggal_laporan']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Create Laporan -->
<div class="modal fade" id="modalCreateLaporan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">
                    <i class="bi bi-file-plus me-2"></i>
                    Tambah Laporan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/laporan/store') ?>" method="post" id="formCreateLaporan">
                <?= csrf_field() ?>
                <input type="hidden" name="form_type" value="create">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hafalan_id" class="form-label">
                                Data Hafalan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= $createHafalanInvalid ?>" id="hafalan_id" name="hafalan_id" required>
                                <option value="">Pilih Data Hafalan</option>
                                <?php foreach ($hafalan as $h): ?>
                                    <option value="<?= $h['hafalan_id'] ?>" <?= $createHafalanValue == $h['hafalan_id'] ? 'selected' : '' ?>>
                                        <?= esc($h['nama_santri']) ?> - Juz <?= $h['juz'] ?> 
                                        <?php if ($h['surat']): ?>
                                            (<?= esc($h['surat']) ?>)
                                        <?php endif; ?>
                                        - <?= date('d M Y', strtotime($h['tanggal_setor'])) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($createHafalanInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['hafalan_id']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jenis_laporan" class="form-label">
                                Jenis Laporan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= $createJenisInvalid ?>" id="jenis_laporan" name="jenis_laporan" required>
                                <option value="">Pilih Jenis Laporan</option>
                                <option value="mingguan" <?= $createJenisValue === 'mingguan' ? 'selected' : '' ?>>
                                    <i class="bi bi-calendar-week me-1"></i>Laporan Mingguan
                                </option>
                                <option value="bulanan" <?= $createJenisValue === 'bulanan' ? 'selected' : '' ?>>
                                    <i class="bi bi-calendar-month me-1"></i>Laporan Bulanan
                                </option>
                                <option value="semesteran" <?= $createJenisValue === 'semesteran' ? 'selected' : '' ?>>
                                    <i class="bi bi-calendar-range me-1"></i>Laporan Semesteran
                                </option>
                            </select>
                            <?php if ($createJenisInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['jenis_laporan']) ?>
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
                                   class="form-control <?= $createTanggalInvalid ?>" 
                                   id="tanggal_laporan" 
                                   name="tanggal_laporan" 
                                   value="<?= esc($createTanggalValue) ?>"
                                   required>
                            <?php if ($createTanggalInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['tanggal_laporan']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Preview Data Hafalan -->
                    <div class="row" id="hafalanPreview" style="display: none;">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="m-0">
                                        <i class="bi bi-eye me-2"></i>
                                        Preview Data Hafalan
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Santri:</strong> <span id="previewSantri">-</span><br>
                                            <strong>Juz:</strong> <span id="previewJuz">-</span><br>
                                            <strong>Surat:</strong> <span id="previewSurat">-</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Halaman:</strong> <span id="previewHalaman">-</span><br>
                                            <strong>Status:</strong> <span id="previewStatus">-</span><br>
                                            <strong>Tanggal Setor:</strong> <span id="previewTanggalSetor">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="bi bi-check-circle me-1"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#laporanTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        },
        "pageLength": 25,
        "order": [[6, "desc"]], // Sort by tanggal laporan
        "columnDefs": [
            { "orderable": false, "targets": 8 }
        ]
    });

    // Set default tanggal laporan to today when modal opens
    $('#modalCreateLaporan').on('show.bs.modal', function () {
        const tanggalLaporanInput = document.getElementById('tanggal_laporan');
        if (!tanggalLaporanInput.value) {
            tanggalLaporanInput.value = new Date().toISOString().split('T')[0];
        }
    });

    // Reset form when modal is hidden
    $('#modalCreateLaporan').on('hidden.bs.modal', function () {
        document.getElementById('formCreateLaporan').reset();
        document.getElementById('hafalanPreview').style.display = 'none';
    });

    // Handle form submission
    $('#formCreateLaporan').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.html('<i class="bi bi-hourglass-split me-1"></i>Menyimpan...').prop('disabled', true);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show success message
                showAlert('success', 'Data laporan berhasil ditambahkan');
                
                // Close modal
                $('#modalCreateLaporan').modal('hide');
                
                // Reload page after a short delay
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = 'Terjadi kesalahan:\n' + Object.values(errors).join('\n');
                }
                
                showAlert('error', errorMessage);
            },
            complete: function() {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Preview hafalan data when selected
    const createHafalanSelect = document.getElementById('hafalan_id');
    const hafalanPreviewElement = document.getElementById('hafalanPreview');

    if (createHafalanSelect) {
        createHafalanSelect.addEventListener('change', function() {
            const hafalanId = this.value;
            const previewDiv = hafalanPreviewElement;
            
            if (!previewDiv) {
                return;
            }

            if (hafalanId) {
                const selectedOption = this.options[this.selectedIndex];
                const optionText = selectedOption.text;
                const parts = optionText.split(' - ');

                if (parts.length >= 3) {
                    document.getElementById('previewSantri').textContent = parts[0];
                    document.getElementById('previewJuz').textContent = parts[1];
                    document.getElementById('previewSurat').textContent = parts[2].split(' - ')[0].replace(/[()]/g, '');
                    document.getElementById('previewTanggalSetor').textContent = parts[parts.length - 1];
                }
                
                previewDiv.style.display = 'block';
            } else {
                previewDiv.style.display = 'none';
            }
        });

        if (createHafalanSelect.value) {
            createHafalanSelect.dispatchEvent(new Event('change'));
        }
    }

    const editModalToOpen = '<?= esc($openEditModalId ?? '') ?>';
    const shouldOpenCreateModalJs = <?= $shouldOpenCreateModal ? 'true' : 'false' ?>;

    if (editModalToOpen) {
        const editModalEl = document.getElementById('modalEdit' + editModalToOpen);
        if (editModalEl) {
            bootstrap.Modal.getOrCreateInstance(editModalEl).show();
        }
    } else if (shouldOpenCreateModalJs) {
        const createModalEl = document.getElementById('modalCreateLaporan');
        if (createModalEl) {
            bootstrap.Modal.getOrCreateInstance(createModalEl).show();
        }
    }

    $(document).on('click', '[data-edit-open]', function () {
        const detailModal = $(this).closest('.modal')[0];
        if (detailModal) {
            const instance = bootstrap.Modal.getInstance(detailModal);
            if (instance) {
                instance.hide();
            }
        }

        const editId = this.getAttribute('data-edit-open');
        const editModalEl = document.getElementById('modalEdit' + editId);
        if (editModalEl) {
            bootstrap.Modal.getOrCreateInstance(editModalEl).show();
        }
    });
});

// Function to show alerts
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.main-content');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 5000);
}
</script>
<?= $this->endSection() ?>
