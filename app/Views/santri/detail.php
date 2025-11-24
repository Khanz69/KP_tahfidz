<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="bi bi-person me-2"></i>
        Detail Santri: <?= esc($santri['nama_santri']) ?>
    </h2>
    <div class="btn-group">
        <a href="<?= base_url('/santri') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
        <a href="<?= base_url('/santri/edit/' . $santri['santri_id']) ?>" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>
            Edit
        </a>
    </div>
</div>

<div class="row">
    <!-- Informasi Santri -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-info-circle me-2"></i>
                    Informasi Santri
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill text-white fs-2"></i>
                    </div>
                </div>
                
                <table class="table table-borderless table-sm">
                    <tr>
                        <td><strong>ID Santri:</strong></td>
                        <td><span class="badge bg-secondary"><?= $santri['santri_id'] ?></span></td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td><?= esc($santri['nama_santri']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Kamar:</strong></td>
                        <td>
                            <?php if ($santri['kamar']): ?>
                                <span class="badge bg-info"><?= esc($santri['kamar']) ?></span>
                            <?php else: ?>
                                <span class="text-muted">Belum ditentukan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Kelas:</strong></td>
                        <td>
                            <?php if ($santri['kelas']): ?>
                                <span class="badge bg-primary"><?= esc($santri['kelas']) ?></span>
                            <?php else: ?>
                                <span class="text-muted">Belum ditentukan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Angkatan:</strong></td>
                        <td>
                            <?php if ($santri['angkatan']): ?>
                                <span class="badge bg-success"><?= $santri['angkatan'] ?></span>
                            <?php else: ?>
                                <span class="text-muted">Belum ditentukan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Masuk:</strong></td>
                        <td>
                            <?php if ($santri['tanggal_masuk']): ?>
                                <?= date('d M Y', strtotime($santri['tanggal_masuk'])) ?>
                            <?php else: ?>
                                <span class="text-muted">Belum ditentukan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Terdaftar:</strong></td>
                        <td><?= date('d M Y H:i', strtotime($santri['created_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik Hafalan -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-graph-up me-2"></i>
                    Statistik Hafalan
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h3 text-primary"><?= $hafalan_stats['total_hafalan'] ?? 0 ?></div>
                            <div class="text-muted">Total Hafalan</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h3 text-success"><?= $hafalan_stats['hafalan_lulus'] ?? 0 ?></div>
                            <div class="text-muted">Hafalan Lulus</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h3 text-warning"><?= $hafalan_stats['hafalan_tidak_lulus'] ?? 0 ?></div>
                            <div class="text-muted">Tidak Lulus</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h3 text-info">
                                <?php 
                                $total = $hafalan_stats['total_hafalan'] ?? 0;
                                $lulus = $hafalan_stats['hafalan_lulus'] ?? 0;
                                echo $total > 0 ? round(($lulus / $total) * 100, 1) : 0;
                                ?>%
                            </div>
                            <div class="text-muted">Success Rate</div>
                        </div>
                    </div>
                </div>

                <?php if ($hafalan_stats['total_hafalan'] > 0): ?>
                    <div class="progress mb-3" style="height: 20px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: <?= $total > 0 ? ($lulus / $total) * 100 : 0 ?>%">
                            <?= $total > 0 ? round(($lulus / $total) * 100, 1) : 0 ?>% Lulus
                        </div>
                        <div class="progress-bar bg-warning" role="progressbar" 
                             style="width: <?= $total > 0 ? (($hafalan_stats['hafalan_tidak_lulus'] ?? 0) / $total) * 100 : 0 ?>%">
                            <?= $total > 0 ? round((($hafalan_stats['hafalan_tidak_lulus'] ?? 0) / $total) * 100, 1) : 0 ?>% Tidak Lulus
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="bi bi-calendar-check me-1"></i>
                            Terakhir Setor: 
                            <?php if ($hafalan_stats['terakhir_setor']): ?>
                                <?= date('d M Y', strtotime($hafalan_stats['terakhir_setor'])) ?>
                            <?php else: ?>
                                Belum ada
                            <?php endif; ?>
                        </small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="bi bi-calendar-event me-1"></i>
                            Pertama Setor: 
                            <?php if ($hafalan_stats['pertama_setor']): ?>
                                <?= date('d M Y', strtotime($hafalan_stats['pertama_setor'])) ?>
                            <?php else: ?>
                                Belum ada
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Hafalan -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-clock-history me-2"></i>
                    Riwayat Hafalan
                </h6>
                <a href="<?= base_url('/hafalan?santri_id=' . $santri['santri_id']) ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Hafalan
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal Setor</th>
                                <th>Juz</th>
                                <th>Halaman</th>
                                <th>Surat</th>
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
                                            <small><?= date('d M Y', strtotime($h['tanggal_setor'])) ?></small>
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
                                                <a href="<?= base_url('/hafalan?edit_id=' . $h['hafalan_id']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
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
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-book fs-1 d-block mb-2"></i>
                                        Belum ada riwayat hafalan
                                        <br>
                                        <a href="<?= base_url('/hafalan?santri_id=' . $santri['santri_id']) ?>" class="btn btn-primary btn-sm mt-2">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Tambah Hafalan Pertama
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
