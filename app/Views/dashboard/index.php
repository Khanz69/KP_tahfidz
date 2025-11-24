<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Total Santri
                        </div>
                        <div class="h5 mb-0 font-weight-bold">
                            <?= $santri_stats['total_santri'] ?? 0 ?>
                        </div>
                        <div class="text-xs">
                            <i class="bi bi-people me-1"></i>
                            <?= $santri_stats['total_angkatan'] ?? 0 ?> Angkatan
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card-success h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Hafalan Lulus
                        </div>
                        <div class="h5 mb-0 font-weight-bold">
                            <?= $hafalan_stats['hafalan_lulus'] ?? 0 ?>
                        </div>
                        <div class="text-xs">
                            <i class="bi bi-check-circle me-1"></i>
                            <?= $hafalan_stats['total_hafalan'] > 0 ? round(($hafalan_stats['hafalan_lulus'] / $hafalan_stats['total_hafalan']) * 100, 1) : 0 ?>% Success Rate
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card-warning h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Hafalan Tidak Lulus
                        </div>
                        <div class="h5 mb-0 font-weight-bold">
                            <?= $hafalan_stats['hafalan_tidak_lulus'] ?? 0 ?>
                        </div>
                        <div class="text-xs">
                            <i class="bi bi-x-circle me-1"></i>
                            Perlu Perbaikan
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-x-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card-info h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                            Total Laporan
                        </div>
                        <div class="h5 mb-0 font-weight-bold">
                            <?= $laporan_stats['total_laporan'] ?? 0 ?>
                        </div>
                        <div class="text-xs">
                            <i class="bi bi-file-earmark-text me-1"></i>
                            <?= $laporan_stats['laporan_mingguan'] ?? 0 ?> Mingguan
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-file-earmark-text fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-graph-up me-2"></i>
                    Grafik Hafalan 6 Bulan Terakhir
                </h6>
            </div>
            <div class="card-body">
                <canvas id="hafalanChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-pie-chart me-2"></i>
                    Distribusi Laporan
                </h6>
            </div>
            <div class="card-body">
                <canvas id="laporanChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-clock-history me-2"></i>
                    Hafalan Terbaru
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Santri</th>
                                <th>Juz</th>
                                <th>Surat</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_hafalan)): ?>
                                <?php foreach ($recent_hafalan as $hafalan): ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <strong><?= esc($hafalan['nama_santri']) ?></strong>
                                                <br>
                                                <small class="text-muted"><?= esc($hafalan['kamar']) ?> - <?= esc($hafalan['kelas']) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Juz <?= $hafalan['juz'] ?></span>
                                        </td>
                                        <td><?= esc($hafalan['surat']) ?></td>
                                        <td>
                                            <?php if ($hafalan['status'] == 'lulus'): ?>
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
                                            <small><?= date('d M Y', strtotime($hafalan['tanggal_setor'])) ?></small>
                                        </td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDetailHafalan<?= $hafalan['hafalan_id'] ?>"
                                                    title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Belum ada data hafalan
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-upload me-2"></i>
                    Import Terbaru
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_imports)): ?>
                    <?php foreach ($recent_imports as $import): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-file-earmark-excel text-success fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold"><?= esc($import['sumber_file']) ?></div>
                                <small class="text-muted">
                                    <?= $import['jumlah_data'] ?> data oleh <?= esc($import['nama']) ?>
                                    <br>
                                    <?= date('d M Y H:i', strtotime($import['tanggal_import'])) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada data import
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Hafalan dari Dashboard -->
<?php if (!empty($recent_hafalan)): ?>
    <?php foreach ($recent_hafalan as $hafalan): ?>
    <div class="modal fade" id="modalDetailHafalan<?= $hafalan['hafalan_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-book-half me-2"></i>
                        Detail Hafalan [ID: <?= $hafalan['hafalan_id'] ?>]
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
                                            <td><strong><?= esc($hafalan['nama_santri']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kamar:</strong></td>
                                            <td><?= esc($hafalan['kamar']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kelas:</strong></td>
                                            <td><?= esc($hafalan['kelas']) ?></td>
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
                                            <td><span class="badge bg-primary fs-6">Juz <?= $hafalan['juz'] ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Halaman:</strong></td>
                                            <td>
                                                <?php if ($hafalan['halaman']): ?>
                                                    Halaman <?= $hafalan['halaman'] ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Surat:</strong></td>
                                            <td><?= esc($hafalan['surat']) ?: '-' ?></td>
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
                                    <?php if ($hafalan['status'] == 'lulus'): ?>
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
                                            <td><?= date('d M Y', strtotime($hafalan['tanggal_setor'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hari:</strong></td>
                                            <td><?= date('l', strtotime($hafalan['tanggal_setor'])) ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat:</strong></td>
                                            <td><?= date('d M Y H:i', strtotime($hafalan['created_at'])) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <?php if ($hafalan['keterangan']): ?>
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
                                    <p class="mb-0"><?= esc($hafalan['keterangan']) ?></p>
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
                    <a href="<?= base_url('/hafalan?edit_id=' . $hafalan['hafalan_id']) ?>" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Hafalan Chart
const hafalanCtx = document.getElementById('hafalanChart').getContext('2d');
const hafalanChart = new Chart(hafalanCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($chart_data, 'bulan')) ?>,
        datasets: [{
            label: 'Hafalan Lulus',
            data: <?= json_encode(array_column($chart_data, 'hafalan_lulus')) ?>,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }, {
            label: 'Hafalan Tidak Lulus',
            data: <?= json_encode(array_column($chart_data, 'hafalan_tidak_lulus')) ?>,
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Laporan Chart
const laporanCtx = document.getElementById('laporanChart').getContext('2d');
const laporanChart = new Chart(laporanCtx, {
    type: 'doughnut',
    data: {
        labels: ['Mingguan', 'Bulanan', 'Semesteran'],
        datasets: [{
            data: [
                <?= $laporan_stats['laporan_mingguan'] ?? 0 ?>,
                <?= $laporan_stats['laporan_bulanan'] ?? 0 ?>,
                <?= $laporan_stats['laporan_semesteran'] ?? 0 ?>
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
