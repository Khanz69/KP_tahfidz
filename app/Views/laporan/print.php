<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hafalan - <?= esc($laporan['nama_santri']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; }
            .card { border: 1px solid #000 !important; }
        }
        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .footer {
            border-top: 1px solid #000;
            padding-top: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="header text-center">
            <h2 class="mb-2">LAPORAN HAFALAN SANTRI</h2>
            <h4 class="mb-0">Pondok Pesantren Tahfidz</h4>
            <p class="mb-0">Jl. Pesantren No. 123, Kota Pesantren</p>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Detail Laporan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>ID Laporan:</strong></td>
                                        <td><?= $laporan['laporan_id'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Santri:</strong></td>
                                        <td><?= esc($laporan['nama_santri']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kamar:</strong></td>
                                        <td><?= esc($laporan['kamar']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kelas:</strong></td>
                                        <td><?= esc($laporan['kelas']) ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Juz:</strong></td>
                                        <td>Juz <?= $laporan['juz'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Halaman:</strong></td>
                                        <td><?= $laporan['halaman'] ? 'Halaman ' . $laporan['halaman'] : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Surat:</strong></td>
                                        <td><?= esc($laporan['surat']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <?php if ($laporan['status'] == 'lulus'): ?>
                                                <span class="badge bg-success">Lulus</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Tidak Lulus</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar me-2"></i>
                            Informasi Waktu
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Tanggal Setor:</strong></td>
                                        <td><?= date('d M Y', strtotime($laporan['tanggal_setor'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Laporan:</strong></td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <?= ucfirst($laporan['jenis_laporan']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%"><strong>Tanggal Laporan:</strong></td>
                                        <td><?= date('d M Y', strtotime($laporan['tanggal_laporan'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td><?= date('d M Y H:i', strtotime($laporan['created_at'])) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($laporan['keterangan']): ?>
                <div class="card mt-3">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-text me-2"></i>
                            Keterangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?= esc($laporan['keterangan']) ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0"><strong>Dicetak pada:</strong> <?= date('d M Y H:i:s') ?></p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">Sistem Monitoring Tahfidz</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div class="no-print text-center mt-4">
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="bi bi-printer me-1"></i>
            Print
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="bi bi-x-circle me-1"></i>
            Tutup
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
