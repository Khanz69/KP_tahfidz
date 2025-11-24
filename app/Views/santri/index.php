<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="bi bi-people me-2"></i>
        Data Santri
    </h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSantri">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Santri
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="santriTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama Santri</th>
                        <th>Kamar</th>
                        <th>Kelas</th>
                        <th>Angkatan</th>
                        <th>Tanggal Masuk</th>
                        <th>Statistik Hafalan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($santri)): ?>
                        <?php foreach ($santri as $s): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-secondary"><?= $s['santri_id'] ?></span>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= esc($s['nama_santri']) ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($s['kamar']): ?>
                                        <span class="badge bg-info"><?= esc($s['kamar']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($s['kelas']): ?>
                                        <span class="badge bg-primary"><?= esc($s['kelas']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($s['angkatan']): ?>
                                        <span class="badge bg-success"><?= $s['angkatan'] ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($s['tanggal_masuk']): ?>
                                        <small><?= date('d M Y', strtotime($s['tanggal_masuk'])) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="mb-1">
                                            <small class="text-muted">Total: </small>
                                            <span class="badge bg-secondary"><?= $s['total_hafalan'] ?? 0 ?></span>
                                        </div>
                                        <div class="mb-1">
                                            <small class="text-muted">Lulus: </small>
                                            <span class="badge bg-success"><?= $s['hafalan_lulus'] ?? 0 ?></span>
                                        </div>
                                        <div>
                                            <small class="text-muted">Tidak Lulus: </small>
                                            <span class="badge bg-warning"><?= $s['hafalan_tidak_lulus'] ?? 0 ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDetail<?= $s['santri_id'] ?>"
                                                title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditSantri<?= $s['santri_id'] ?>"
                                                title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDeleteSantri<?= $s['santri_id'] ?>"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data santri
                                <br>
                                <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalTambahSantri">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Tambah Santri Pertama
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Santri -->
<?php foreach ($santri as $s): ?>
<div class="modal fade" id="modalDetail<?= $s['santri_id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <i class="bi bi-person me-2"></i>
                    Detail Santri [ID: <?= $s['santri_id'] ?>]
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Informasi Personal -->
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Informasi Personal
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Nama Santri:</strong></td>
                                        <td><?= esc($s['nama_santri']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>ID Santri:</strong></td>
                                        <td><span class="badge bg-secondary"><?= $s['santri_id'] ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kamar:</strong></td>
                                        <td>
                                            <?php if ($s['kamar']): ?>
                                                <span class="badge bg-info"><?= esc($s['kamar']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ditentukan</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kelas:</strong></td>
                                        <td>
                                            <?php if ($s['kelas']): ?>
                                                <span class="badge bg-primary"><?= esc($s['kelas']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ditentukan</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Akademik -->
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-book me-2"></i>
                                    Informasi Akademik
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="40%"><strong>Angkatan:</strong></td>
                                        <td>
                                            <?php if ($s['angkatan']): ?>
                                                <span class="badge bg-success"><?= $s['angkatan'] ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ditentukan</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Masuk:</strong></td>
                                        <td>
                                            <?php if ($s['tanggal_masuk']): ?>
                                                <?= date('d M Y', strtotime($s['tanggal_masuk'])) ?>
                                            <?php else: ?>
                                                <span class="text-muted">Belum ditentukan</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Terdaftar:</strong></td>
                                        <td><?= date('d M Y H:i', strtotime($s['created_at'])) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Hafalan -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="bi bi-graph-up me-2"></i>
                                    Statistik Hafalan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <div class="h4 text-primary"><?= $s['total_hafalan'] ?? 0 ?></div>
                                        <div class="text-muted">Total Hafalan</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="h4 text-success"><?= $s['hafalan_lulus'] ?? 0 ?></div>
                                        <div class="text-muted">Hafalan Lulus</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="h4 text-warning"><?= $s['hafalan_tidak_lulus'] ?? 0 ?></div>
                                        <div class="text-muted">Tidak Lulus</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="h4 text-info">
                                            <?php 
                                            $total = $s['total_hafalan'] ?? 0;
                                            $lulus = $s['hafalan_lulus'] ?? 0;
                                            echo $total > 0 ? round(($lulus / $total) * 100, 1) : 0;
                                            ?>%
                                        </div>
                                        <div class="text-muted">Success Rate</div>
                                    </div>
                                </div>
                                
                                <?php if ($s['total_hafalan'] > 0): ?>
                                    <div class="progress mt-3" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: <?= $total > 0 ? ($lulus / $total) * 100 : 0 ?>%">
                                            <?= $total > 0 ? round(($lulus / $total) * 100, 1) : 0 ?>% Lulus
                                        </div>
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                             style="width: <?= $total > 0 ? (($s['hafalan_tidak_lulus'] ?? 0) / $total) * 100 : 0 ?>%">
                                            <?= $total > 0 ? round((($s['hafalan_tidak_lulus'] ?? 0) / $total) * 100, 1) : 0 ?>% Tidak Lulus
                                        </div>
                                    </div>
                                <?php endif; ?>
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
                <a href="<?= base_url('/santri/detail/' . $s['santri_id']) ?>" class="btn btn-primary">
                    <i class="bi bi-eye me-1"></i>
                    Lihat Detail Lengkap
                </a>
                <a href="<?= base_url('/santri/edit/' . $s['santri_id']) ?>" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Edit Santri -->
<?php foreach ($santri as $s): ?>
<div class="modal fade" id="modalEditSantri<?= $s['santri_id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-person-gear me-2"></i>
                    Edit Santri: <?= esc($s['nama_santri']) ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/santri/update/' . $s['santri_id']) ?>" method="post" id="formEditSantri<?= $s['santri_id'] ?>">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_nama_santri_<?= $s['santri_id'] ?>" class="form-label">
                                Nama Santri <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                    class="form-control" 
                                    id="edit_nama_santri_<?= $s['santri_id'] ?>" 
                                    name="nama_santri" 
                                    value="<?= esc($s['nama_santri']) ?>"
                                    placeholder="Masukkan nama lengkap santri"
                                    required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_kamar_<?= $s['santri_id'] ?>" class="form-label">Kamar</label>
                            <input type="text" 
                                    class="form-control" 
                                    id="edit_kamar_<?= $s['santri_id'] ?>" 
                                    name="kamar" 
                                    value="<?= esc($s['kamar']) ?>"
                                    placeholder="Contoh: Kamar A1">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_kelas_<?= $s['santri_id'] ?>" class="form-label">Kelas</label>
                            <input type="text" 
                                    class="form-control" 
                                    id="edit_kelas_<?= $s['santri_id'] ?>" 
                                    name="kelas" 
                                    value="<?= esc($s['kelas']) ?>"
                                    placeholder="Contoh: 10 MIPA">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_angkatan_<?= $s['santri_id'] ?>" class="form-label">Angkatan</label>
                            <select class="form-select" id="edit_angkatan_<?= $s['santri_id'] ?>" name="angkatan">
                                <option value="">Pilih Angkatan</option>
                                <?php for ($year = date('Y'); $year >= 2020; $year--): ?>
                                    <option value="<?= $year ?>" <?= $s['angkatan'] == $year ? 'selected' : '' ?>>
                                        <?= $year ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_tanggal_masuk_<?= $s['santri_id'] ?>" class="form-label">Tanggal Masuk</label>
                            <input type="date" 
                                    class="form-control" 
                                    id="edit_tanggal_masuk_<?= $s['santri_id'] ?>" 
                                    name="tanggal_masuk" 
                                    value="<?= $s['tanggal_masuk'] ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal Create Santri -->
<div class="modal fade" id="modalTambahSantri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <i class="bi bi-person-plus me-2"></i>
                    Tambah Santri Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('/santri/store') ?>" method="post" id="formTambahSantri">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama_santri" class="form-label">
                                Nama Santri <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                    class="form-control" 
                                    id="nama_santri" 
                                    name="nama_santri" 
                                    placeholder="Masukkan nama lengkap santri"
                                    required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kamar" class="form-label">Kamar</label>
                            <input type="text" 
                                    class="form-control" 
                                    id="kamar" 
                                    name="kamar" 
                                    placeholder="Contoh: Kamar A1">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" 
                                    class="form-control" 
                                    id="kelas" 
                                    name="kelas" 
                                    placeholder="Contoh: 10 MIPA">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <select class="form-select" id="angkatan" name="angkatan">
                                <option value="">Pilih Angkatan</option>
                                <?php for ($year = date('Y'); $year >= 2020; $year--): ?>
                                    <option value="<?= $year ?>"><?= $year ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" 
                                    class="form-control" 
                                    id="tanggal_masuk" 
                                    name="tanggal_masuk">
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
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Santri -->
<?php foreach ($santri as $s): ?>
<div class="modal fade" id="modalDeleteSantri<?= $s['santri_id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus Santri
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-circle me-2 fs-5"></i>
                    <div>
                        Data santri berikut akan dihapus secara permanen. 
                        Tindakan ini <strong>tidak dapat dibatalkan</strong>.
                    </div>
                </div>

                <div class="card bg-light border-0">
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td width="40%"><strong>ID Santri:</strong></td>
                                <td><span class="badge bg-secondary"><?= $s['santri_id'] ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Santri:</strong></td>
                                <td><?= esc($s['nama_santri']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Kamar:</strong></td>
                                <td><?= $s['kamar'] ? '<span class="badge bg-info">'.esc($s['kamar']).'</span>' : '<span class="text-muted">-</span>' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Kelas:</strong></td>
                                <td><?= $s['kelas'] ? '<span class="badge bg-primary">'.esc($s['kelas']).'</span>' : '<span class="text-muted">-</span>' ?></td>
                            </tr>
                            <tr>
                                <td><strong>Angkatan:</strong></td>
                                <td><?= $s['angkatan'] ? '<span class="badge bg-success">'.$s['angkatan'].'</span>' : '<span class="text-muted">-</span>' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Batal
                </button>

                <form action="<?= base_url('/santri/delete/' . $s['santri_id']) ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#santriTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        },
        "pageLength": 25,
        "order": [[1, "asc"]],
        "columnDefs": [
            { "orderable": false, "targets": 7 }
        ]
    });

    // Set default tanggal masuk to today when modal opens
    $('#modalTambahSantri').on('show.bs.modal', function () {
        const tanggalMasukInput = document.getElementById('tanggal_masuk');
        if (!tanggalMasukInput.value) {
            tanggalMasukInput.value = new Date().toISOString().split('T')[0];
        }
    });

    // Reset form when modal is hidden
    $('#modalTambahSantri').on('hidden.bs.modal', function () {
        document.getElementById('formTambahSantri').reset();
    });

    // Handle form submission
    $('#formTambahSantri').on('submit', function(e) {
        e.preventDefault();
        
        console.log('Form submission started');
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Debug: Log form data
        console.log('Form data being sent:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Show loading state
        submitBtn.html('<i class="bi bi-hourglass-split me-1"></i>Menyimpan...').prop('disabled', true);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                console.log('AJAX request starting...');
            },
            success: function(response) {
                // Show success message
                showAlert('success', 'Data santri berhasil ditambahkan');
                
                // Close modal
                $('#modalTambahSantri').modal('hide');
                
                // Reload page after a short delay
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                console.log('Error response:', xhr);
                let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = 'Terjadi kesalahan:\n' + Object.values(errors).join('\n');
                    } else if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                } else if (xhr.responseText) {
                    // Try to parse HTML response for error messages
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(xhr.responseText, 'text/html');
                    const errorElements = doc.querySelectorAll('.alert-danger, .error, .validation-error');
                    if (errorElements.length > 0) {
                        errorMessage = Array.from(errorElements).map(el => el.textContent.trim()).join('\n');
                    }
                }
                
                showAlert('error', errorMessage);
            },
            complete: function() {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Handle edit form submissions
    $('[id^="formEditSantri"]').on('submit', function(e) {
        e.preventDefault();
        
        console.log('Edit form submission started');
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        // Debug: Log form data
        console.log('Edit form data being sent:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Show loading state
        submitBtn.html('<i class="bi bi-hourglass-split me-1"></i>Menyimpan...').prop('disabled', true);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                console.log('Edit AJAX request starting...');
            },
            success: function(response) {
                // Show success message
                showAlert('success', 'Data santri berhasil diperbarui');
                
                // Close modal
                const modalId = $(e.target).closest('.modal').attr('id');
                $('#' + modalId).modal('hide');
                
                // Reload page after a short delay
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                console.log('Edit error response:', xhr);
                let errorMessage = 'Terjadi kesalahan saat memperbarui data';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMessage = 'Terjadi kesalahan:\n' + Object.values(errors).join('\n');
                    } else if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                } else if (xhr.responseText) {
                    // Try to parse HTML response for error messages
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(xhr.responseText, 'text/html');
                    const errorElements = doc.querySelectorAll('.alert-danger, .error, .validation-error');
                    if (errorElements.length > 0) {
                        errorMessage = Array.from(errorElements).map(el => el.textContent.trim()).join('\n');
                    }
                }
                
                showAlert('error', errorMessage);
            },
            complete: function() {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
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


