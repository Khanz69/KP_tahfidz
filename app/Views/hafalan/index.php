<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
    $openEditId = $openEditId ?? null;
    $prefillSantriId = $prefillSantriId ?? null;
    $errorBag = session('errors') ?? [];
    $lastFormType = old('form_type');
    $editingHafalanId = old('hafalan_id');
    $openEditModalId = $editingHafalanId ?? $openEditId;
    $shouldOpenCreateModal = $lastFormType === 'create' || !empty($prefillSantriId);
    $showErrorAlert = $errorBag && in_array($lastFormType, ['create', 'edit']);
    $createHasErrors = $lastFormType === 'create';
    $editHasErrors = $lastFormType === 'edit';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="bi bi-book-half me-2"></i>
        Data Hafalan
    </h2>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="bi bi-funnel me-1"></i>
            Filter
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateHafalan">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Hafalan
        </button>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-funnel me-2"></i>
                    Filter Data Hafalan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/hafalan/filter') ?>" method="get">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $filters['start_date'] ?? '' ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $filters['end_date'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="lulus" <?= ($filters['status'] ?? '') == 'lulus' ? 'selected' : '' ?>>Lulus</option>
                                <option value="tidak_lulus" <?= ($filters['status'] ?? '') == 'tidak_lulus' ? 'selected' : '' ?>>Tidak Lulus</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="santri_id" class="form-label">Santri</label>
                            <select class="form-select" id="santri_id" name="santri_id">
                                <option value="">Semua Santri</option>
                                <?php if (isset($santri)): ?>
                                    <?php foreach ($santri as $s): ?>
                                        <option value="<?= $s['santri_id'] ?>" <?= ($filters['santri_id'] ?? '') == $s['santri_id'] ? 'selected' : '' ?>>
                                            <?= esc($s['nama_santri']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="hafalanTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Santri</th>
                        <th>Juz</th>
                        <th>Halaman</th>
                        <th>Surat</th>
                        <th>Tanggal Setor</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($hafalan)): ?>
                        <?php foreach ($hafalan as $h): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary"><?= $h['hafalan_id'] ?></span>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= esc($h['nama_santri']) ?></strong>
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

                                        <br>
                                        <small class="text-muted"><?= esc($h['kamar']) ?> - <?= esc($h['kelas']) ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">Juz <?= $h['juz'] ?></span>
                                </td>
                                <td>
                                    <?php if ($h['halaman']): ?>
                                        Halaman <?= $h['halaman'] ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($h['surat']) ?></td>
                                <td>
                                    <small><?= date('d M Y', strtotime($h['tanggal_setor'])) ?></small>
                                </td>
                                <td>
                                    <?php if ($h['status'] == 'lulus'): ?>
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
                                    <?php if ($h['keterangan']): ?>
                                        <small><?= esc($h['keterangan']) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDetail<?= $h['hafalan_id'] ?>"
                                                title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEdit<?= $h['hafalan_id'] ?>"
                                                title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="<?= base_url('/hafalan/delete/' . $h['hafalan_id']) ?>" 
                                           class="btn btn-sm btn-outline-danger btn-delete" 
                                           title="Hapus"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus hafalan ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-book fs-1 d-block mb-2"></i>
                                Belum ada data hafalan
                                <br>
                                <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalCreateHafalan">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Tambah Hafalan Pertama
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Hafalan -->
<?php foreach ($hafalan as $h): ?>
<div class="modal fade" id="modalDetail<?= $h['hafalan_id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">
                    <i class="bi bi-book-half me-2"></i>
                    Detail Hafalan [ID: <?= $h['hafalan_id'] ?>]
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
                                        <td><strong><?= esc($h['nama_santri']) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kamar:</strong></td>
                                        <td><?= esc($h['kamar']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kelas:</strong></td>
                                        <td><?= esc($h['kelas']) ?></td>
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
                                        <td><span class="badge bg-primary fs-6">Juz <?= $h['juz'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Halaman:</strong></td>
                                        <td>
                                            <?php if ($h['halaman']): ?>
                                                Halaman <?= $h['halaman'] ?>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Surat:</strong></td>
                                        <td><?= esc($h['surat']) ?: '-' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status dan Tanggal -->
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
                                <?php if ($h['status'] == 'lulus'): ?>
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
                                    <i class="bi bi-calendar me-2"></i>
                                    Informasi Waktu
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Tanggal Setor:</strong></td>
                                        <td><?= date('d M Y', strtotime($h['tanggal_setor'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Hari:</strong></td>
                                        <td><?= date('l', strtotime($h['tanggal_setor'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td><?= date('d M Y H:i', strtotime($h['created_at'])) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                <?php if ($h['keterangan']): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-chat-text me-2"></i>
                                    Keterangan
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0"><?= esc($h['keterangan']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Tutup
                </button>
                <button type="button" class="btn btn-warning" data-edit-open="<?= $h['hafalan_id'] ?>">
                    <i class="bi bi-pencil me-1"></i>
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Edit Hafalan -->
<?php foreach ($hafalan as $h): ?>
    <?php
        $isEditingCurrent = $editHasErrors && $editingHafalanId == $h['hafalan_id'];
        $selectedSantriId = $isEditingCurrent && old('santri_id') !== null ? old('santri_id') : $h['santri_id'];
        $selectedJuz = $isEditingCurrent && old('juz') !== null ? old('juz') : $h['juz'];
        $selectedHalaman = $isEditingCurrent && old('halaman') !== null ? old('halaman') : $h['halaman'];
        $selectedSurat = $isEditingCurrent && old('surat') !== null ? old('surat') : $h['surat'];
        $selectedTanggalSetor = $isEditingCurrent && old('tanggal_setor') !== null ? old('tanggal_setor') : $h['tanggal_setor'];
        $selectedStatus = $isEditingCurrent && old('status') !== null ? old('status') : $h['status'];
        $selectedKeterangan = $isEditingCurrent && old('keterangan') !== null ? old('keterangan') : $h['keterangan'];
        $santriInvalid = $isEditingCurrent && isset($errorBag['santri_id']) ? 'is-invalid' : '';
        $juzInvalid = $isEditingCurrent && isset($errorBag['juz']) ? 'is-invalid' : '';
        $halamanInvalid = $isEditingCurrent && isset($errorBag['halaman']) ? 'is-invalid' : '';
        $suratInvalid = $isEditingCurrent && isset($errorBag['surat']) ? 'is-invalid' : '';
        $tanggalInvalid = $isEditingCurrent && isset($errorBag['tanggal_setor']) ? 'is-invalid' : '';
        $statusInvalid = $isEditingCurrent && isset($errorBag['status']) ? 'is-invalid' : '';
    ?>
    <div class="modal fade" id="modalEdit<?= $h['hafalan_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="<?= base_url('/hafalan/update/' . $h['hafalan_id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="form_type" value="edit">
                    <input type="hidden" name="hafalan_id" value="<?= $h['hafalan_id'] ?>">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white">
                            <i class="bi bi-book-gear me-2"></i>
                            Edit Hafalan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_santri_id_<?= $h['hafalan_id'] ?>" class="form-label">
                                    Santri <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?= $santriInvalid ?>" 
                                        id="edit_santri_id_<?= $h['hafalan_id'] ?>" 
                                        name="santri_id" 
                                        required>
                                    <option value="">Pilih Santri</option>
                                    <?php foreach ($santri as $s): ?>
                                        <option value="<?= $s['santri_id'] ?>" <?= $selectedSantriId == $s['santri_id'] ? 'selected' : '' ?>>
                                            <?= esc($s['nama_santri']) ?>
                                            <?php if ($s['kamar']): ?>
                                                (<?= esc($s['kamar']) ?>)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($santriInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['santri_id']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_juz_<?= $h['hafalan_id'] ?>" class="form-label">
                                    Juz <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?= $juzInvalid ?>" 
                                        id="edit_juz_<?= $h['hafalan_id'] ?>" 
                                        name="juz" 
                                        required>
                                    <option value="">Pilih Juz</option>
                                    <?php for ($i = 1; $i <= 30; $i++): ?>
                                        <option value="<?= $i ?>" <?= $selectedJuz == $i ? 'selected' : '' ?>>
                                            Juz <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <?php if ($juzInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['juz']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_halaman_<?= $h['hafalan_id'] ?>" class="form-label">Halaman</label>
                                <input type="number" 
                                       class="form-control <?= $halamanInvalid ?>" 
                                       id="edit_halaman_<?= $h['hafalan_id'] ?>" 
                                       name="halaman" 
                                       value="<?= esc($selectedHalaman) ?>"
                                       placeholder="Contoh: 10"
                                       min="1">
                                <?php if ($halamanInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['halaman']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_surat_<?= $h['hafalan_id'] ?>" class="form-label">Surat</label>
                                <input type="text" 
                                       class="form-control <?= $suratInvalid ?>" 
                                       id="edit_surat_<?= $h['hafalan_id'] ?>" 
                                       name="surat" 
                                       value="<?= esc($selectedSurat) ?>"
                                       placeholder="Contoh: Al-Baqarah">
                                <?php if ($suratInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['surat']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_setor_<?= $h['hafalan_id'] ?>" class="form-label">
                                    Tanggal Setor <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control <?= $tanggalInvalid ?>" 
                                       id="edit_tanggal_setor_<?= $h['hafalan_id'] ?>" 
                                       name="tanggal_setor" 
                                       value="<?= esc($selectedTanggalSetor) ?>"
                                       required>
                                <?php if ($tanggalInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['tanggal_setor']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_status_<?= $h['hafalan_id'] ?>" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select <?= $statusInvalid ?>" 
                                        id="edit_status_<?= $h['hafalan_id'] ?>" 
                                        name="status" 
                                        required>
                                    <option value="">Pilih Status</option>
                                    <option value="lulus" <?= $selectedStatus == 'lulus' ? 'selected' : '' ?>>Lulus</option>
                                    <option value="tidak_lulus" <?= $selectedStatus == 'tidak_lulus' ? 'selected' : '' ?>>Tidak Lulus</option>
                                </select>
                                <?php if ($statusInvalid): ?>
                                    <div class="invalid-feedback">
                                        <?= esc($errorBag['status']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_keterangan_<?= $h['hafalan_id'] ?>" class="form-label">Keterangan</label>
                                <textarea class="form-control" 
                                          id="edit_keterangan_<?= $h['hafalan_id'] ?>" 
                                          name="keterangan" 
                                          rows="3"
                                          placeholder="Masukkan keterangan tambahan (opsional)"><?= esc($selectedKeterangan) ?></textarea>
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

<!-- Modal Create Hafalan -->
<?php
    $createSantriValue = $createHasErrors && old('santri_id') !== null ? old('santri_id') : ($prefillSantriId ?? '');
    $createJuzValue = $createHasErrors ? old('juz') : '';
    $createHalamanValue = $createHasErrors ? old('halaman') : '';
    $createSuratValue = $createHasErrors ? old('surat') : '';
    $createTanggalValue = $createHasErrors ? old('tanggal_setor') : '';
    $createStatusValue = $createHasErrors ? old('status') : '';
    $createKeteranganValue = $createHasErrors ? old('keterangan') : '';
    $createSantriInvalid = $createHasErrors && isset($errorBag['santri_id']) ? 'is-invalid' : '';
    $createJuzInvalid = $createHasErrors && isset($errorBag['juz']) ? 'is-invalid' : '';
    $createHalamanInvalid = $createHasErrors && isset($errorBag['halaman']) ? 'is-invalid' : '';
    $createSuratInvalid = $createHasErrors && isset($errorBag['surat']) ? 'is-invalid' : '';
    $createTanggalInvalid = $createHasErrors && isset($errorBag['tanggal_setor']) ? 'is-invalid' : '';
    $createStatusInvalid = $createHasErrors && isset($errorBag['status']) ? 'is-invalid' : '';
?>
<div class="modal fade" id="modalCreateHafalan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">
                    <i class="bi bi-book-plus me-2"></i>
                    Tambah Hafalan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/hafalan/store') ?>" method="post" id="formCreateHafalan">
                <?= csrf_field() ?>
                <input type="hidden" name="form_type" value="create">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="santri_id" class="form-label">
                                Santri <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= $createSantriInvalid ?>" id="santri_id" name="santri_id" required>
                                <option value="">Pilih Santri</option>
                                <?php foreach ($santri as $s): ?>
                                    <option value="<?= $s['santri_id'] ?>" <?= $createSantriValue == $s['santri_id'] ? 'selected' : '' ?> >
                                        <?= esc($s['nama_santri']) ?> 
                                        <?php if ($s['kamar']): ?>
                                            (<?= esc($s['kamar']) ?>)
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($createSantriInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['santri_id']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="juz" class="form-label">
                                Juz <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= $createJuzInvalid ?>" id="juz" name="juz" required>
                                <option value="">Pilih Juz</option>
                                <?php for ($i = 1; $i <= 30; $i++): ?>
                                    <option value="<?= $i ?>" <?= $createJuzValue == $i ? 'selected' : '' ?>>Juz <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <?php if ($createJuzInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['juz']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="halaman" class="form-label">Halaman</label>
                            <input type="number" 
                                   class="form-control <?= $createHalamanInvalid ?>" 
                                   id="halaman" 
                                   name="halaman" 
                                   value="<?= esc($createHalamanValue) ?>"
                                   placeholder="Contoh: 10"
                                   min="1">
                            <?php if ($createHalamanInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['halaman']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="surat" class="form-label">Surat</label>
                            <input type="text" 
                                   class="form-control <?= $createSuratInvalid ?>" 
                                   id="surat" 
                                   name="surat" 
                                   value="<?= esc($createSuratValue) ?>"
                                   placeholder="Contoh: Al-Baqarah">
                            <?php if ($createSuratInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['surat']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_setor" class="form-label">
                                Tanggal Setor <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control <?= $createTanggalInvalid ?>" 
                                   id="tanggal_setor" 
                                   name="tanggal_setor" 
                                   value="<?= esc($createTanggalValue) ?>"
                                   required>
                            <?php if ($createTanggalInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['tanggal_setor']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select <?= $createStatusInvalid ?>" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="lulus" <?= $createStatusValue == 'lulus' ? 'selected' : '' ?>>Lulus</option>
                                <option value="tidak_lulus" <?= $createStatusValue == 'tidak_lulus' ? 'selected' : '' ?>>Tidak Lulus</option>
                            </select>
                            <?php if ($createStatusInvalid): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorBag['status']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" 
                                      id="keterangan" 
                                      name="keterangan" 
                                      rows="3"
                                      placeholder="Masukkan keterangan tambahan (opsional)"><?= esc($createKeteranganValue) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-success">
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
    $('#hafalanTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        },
        "pageLength": 25,
        "order": [[5, "desc"]], // Sort by tanggal setor
        "columnDefs": [
            { "orderable": false, "targets": 8 }
        ]
    });

    // Set default tanggal setor to today when modal opens
    $('#modalCreateHafalan').on('show.bs.modal', function () {
        const tanggalSetorInput = document.getElementById('tanggal_setor');
        if (!tanggalSetorInput.value) {
            tanggalSetorInput.value = new Date().toISOString().split('T')[0];
        }
    });

    // Reset form when modal is hidden
    $('#modalCreateHafalan').on('hidden.bs.modal', function () {
        document.getElementById('formCreateHafalan').reset();
    });

    // Handle form submission
    $('#formCreateHafalan').on('submit', function(e) {
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
                showAlert('success', 'Data hafalan berhasil ditambahkan');
                
                // Close modal
                $('#modalCreateHafalan').modal('hide');
                
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

        const editModalToOpen = '<?= esc($openEditModalId ?? '') ?>';
        const shouldOpenCreateModalJs = <?= $shouldOpenCreateModal ? 'true' : 'false' ?>;

        if (editModalToOpen) {
            const editModalEl = document.getElementById('modalEdit' + editModalToOpen);
            if (editModalEl) {
                bootstrap.Modal.getOrCreateInstance(editModalEl).show();
            }
        } else if (shouldOpenCreateModalJs) {
            const createModalEl = document.getElementById('modalCreateHafalan');
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
