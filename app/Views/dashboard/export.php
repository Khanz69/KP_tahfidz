<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-download me-2"></i>
                    Export Data Sistem Monitoring Tahfidz
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Pilih data yang ingin diekspor dan format file yang diinginkan.
                </p>

                <div class="row">
                    <!-- Data Santri -->
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-people text-primary fs-1 mb-3"></i>
                                <h5 class="card-title">Data Santri</h5>
                                <p class="card-text text-muted">
                                    <?= count($santri_data) ?> santri terdaftar
                                </p>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="exportData('santri', 'csv')">
                                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="exportData('santri', 'excel')">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Hafalan -->
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-book-half text-success fs-1 mb-3"></i>
                                <h5 class="card-title">Data Hafalan</h5>
                                <p class="card-text text-muted">
                                    <?= count($hafalan_data) ?> record hafalan
                                </p>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="exportData('hafalan', 'csv')">
                                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="exportData('hafalan', 'excel')">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Laporan -->
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-file-earmark-text text-info fs-1 mb-3"></i>
                                <h5 class="card-title">Data Laporan</h5>
                                <p class="card-text text-muted">
                                    <?= count($laporan_data) ?> laporan tersedia
                                </p>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-info btn-sm" onclick="exportData('laporan', 'csv')">
                                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm" onclick="exportData('laporan', 'excel')">
                                        <i class="bi bi-file-earmark-excel me-1"></i>Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export All Data -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <i class="bi bi-archive text-warning fs-1 mb-3"></i>
                                <h5 class="card-title text-warning">Export Semua Data</h5>
                                <p class="card-text text-muted">
                                    Ekspor semua data dalam satu file
                                </p>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-warning" onclick="exportData('all', 'excel')">
                                        <i class="bi bi-file-earmark-excel me-2"></i>Export Semua Data (Excel)
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="exportData('all', 'csv')">
                                        <i class="bi bi-file-earmark-spreadsheet me-2"></i>Export Semua Data (CSV)
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Preview -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="bi bi-eye me-2"></i>
                                    Preview Data
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="previewTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="santri-tab" data-bs-toggle="tab" data-bs-target="#santri-preview" type="button" role="tab">
                                            Data Santri
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="hafalan-tab" data-bs-toggle="tab" data-bs-target="#hafalan-preview" type="button" role="tab">
                                            Data Hafalan
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan-preview" type="button" role="tab">
                                            Data Laporan
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="previewTabsContent">
                                    <div class="tab-pane fade show active" id="santri-preview" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nama Santri</th>
                                                        <th>Kamar</th>
                                                        <th>Kelas</th>
                                                        <th>Angkatan</th>
                                                        <th>Tanggal Masuk</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (array_slice($santri_data, 0, 5) as $santri): ?>
                                                        <tr>
                                                            <td><?= $santri['santri_id'] ?></td>
                                                            <td><?= esc($santri['nama_santri']) ?></td>
                                                            <td><?= esc($santri['kamar']) ?></td>
                                                            <td><?= esc($santri['kelas']) ?></td>
                                                            <td><?= $santri['angkatan'] ?></td>
                                                            <td><?= $santri['tanggal_masuk'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <?php if (count($santri_data) > 5): ?>
                                                <p class="text-muted text-center">
                                                    <small>Menampilkan 5 dari <?= count($santri_data) ?> data</small>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="hafalan-preview" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Santri</th>
                                                        <th>Juz</th>
                                                        <th>Surat</th>
                                                        <th>Status</th>
                                                        <th>Tanggal Setor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (array_slice($hafalan_data, 0, 5) as $hafalan): ?>
                                                        <tr>
                                                            <td><?= $hafalan['hafalan_id'] ?></td>
                                                            <td><?= esc($hafalan['nama_santri']) ?></td>
                                                            <td>Juz <?= $hafalan['juz'] ?></td>
                                                            <td><?= esc($hafalan['surat']) ?></td>
                                                            <td>
                                                                <?php if ($hafalan['status'] == 'lulus'): ?>
                                                                    <span class="badge bg-success">Lulus</span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-warning">Tidak Lulus</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= $hafalan['tanggal_setor'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <?php if (count($hafalan_data) > 5): ?>
                                                <p class="text-muted text-center">
                                                    <small>Menampilkan 5 dari <?= count($hafalan_data) ?> data</small>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="laporan-preview" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Santri</th>
                                                        <th>Jenis Laporan</th>
                                                        <th>Tanggal Laporan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (array_slice($laporan_data, 0, 5) as $laporan): ?>
                                                        <tr>
                                                            <td><?= $laporan['laporan_id'] ?></td>
                                                            <td><?= esc($laporan['nama_santri']) ?></td>
                                                            <td>
                                                                <span class="badge bg-info">
                                                                    <?= ucfirst($laporan['jenis_laporan']) ?>
                                                                </span>
                                                            </td>
                                                            <td><?= $laporan['tanggal_laporan'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <?php if (count($laporan_data) > 5): ?>
                                                <p class="text-muted text-center">
                                                    <small>Menampilkan 5 dari <?= count($laporan_data) ?> data</small>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function exportData(type, format) {
    // Show loading
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Loading...';
    button.disabled = true;

    // Simulate export (in real implementation, this would make an AJAX call)
    setTimeout(() => {
        // Create download link
        const data = {
            santri: <?= json_encode($santri_data) ?>,
            hafalan: <?= json_encode($hafalan_data) ?>,
            laporan: <?= json_encode($laporan_data) ?>
        };

        let content = '';
        let filename = '';

        if (type === 'all') {
            filename = `tahfidz_all_data_${new Date().toISOString().split('T')[0]}.${format}`;
            content = generateAllDataExport(data, format);
        } else {
            filename = `tahfidz_${type}_${new Date().toISOString().split('T')[0]}.${format}`;
            content = generateSingleDataExport(data[type], format);
        }

        downloadFile(content, filename, format);

        // Reset button
        button.innerHTML = originalText;
        button.disabled = false;

        // Show success message
        showAlert('success', `Data ${type} berhasil diekspor dalam format ${format.toUpperCase()}`);
    }, 1000);
}

function generateSingleDataExport(data, format) {
    if (format === 'csv') {
        if (data.length === 0) return '';
        
        const headers = Object.keys(data[0]).join(',');
        const rows = data.map(row => 
            Object.values(row).map(value => 
                typeof value === 'string' && value.includes(',') ? `"${value}"` : value
            ).join(',')
        );
        
        return [headers, ...rows].join('\n');
    } else {
        // For Excel, we'll create a simple CSV that can be opened in Excel
        return generateSingleDataExport(data, 'csv');
    }
}

function generateAllDataExport(data, format) {
    if (format === 'csv') {
        let content = '=== DATA SANTRI ===\n';
        content += generateSingleDataExport(data.santri, 'csv');
        content += '\n\n=== DATA HAFALAN ===\n';
        content += generateSingleDataExport(data.hafalan, 'csv');
        content += '\n\n=== DATA LAPORAN ===\n';
        content += generateSingleDataExport(data.laporan, 'csv');
        return content;
    } else {
        return generateAllDataExport(data, 'csv');
    }
}

function downloadFile(content, filename, format) {
    const blob = new Blob([content], { 
        type: format === 'csv' ? 'text/csv' : 'application/vnd.ms-excel' 
    });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
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
