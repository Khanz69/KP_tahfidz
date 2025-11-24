<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Monitoring Tahfidz' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <style>
        :root {
            --sundance: #cfbc67;
            --elephant: #163d57;
            --willow-grove: #6a7c5c;
            --wattle: #ddd147;
            --background-sand: #f4f1e0;
            --text-dark: #0d1f2b;
        }
        body {
            background-color: var(--background-sand);
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(160deg, var(--elephant), var(--willow-grove));
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            border-radius: 0.5rem;
            margin: 0.2rem 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: var(--wattle);
            background-color: rgba(255, 255, 255, 0.12);
            transform: translateX(5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.25);
        }
        .sidebar-user-card {
            color: var(--wattle);
            background-color: #163d575f;
            border-radius: 0.5rem;
            padding: 0rem 1rem;
            transform: translateX(5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.25);
        }
        .main-content {
            background-color: transparent;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            background: #ffffff;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(22, 61, 87, 0.15);
        }
        .stat-card {
            background: linear-gradient(145deg, var(--elephant), var(--willow-grove));
            color: #f7f7f7;
        }
        .stat-card-success {
            background: linear-gradient(165deg, #6a7c5c, #998b4cff);
            color: #f7f7f7;
        }
        .stat-card-warning {
            background: linear-gradient(35deg, #998b4cff, #6a7c5c);
            color: #f7f7f7;
        }
        .stat-card-info {
            background: linear-gradient(35deg, var(--willow-grove), var(--elephant));
            color: #f7f7f7;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--wattle);
        }
        .table {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table thead {
            background: linear-gradient(145deg, var(--elephant), var(--willow-grove));
            color: #fff;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: rgba(207, 188, 103, 0.1);
        }
        .btn {
            border-radius: 0.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--sundance), var(--wattle));
            border: none;
            color: var(--elephant);
            font-weight: 600;
        }
        .btn-outline-secondary {
            border-radius: 0.5rem;
            border-color: rgba(0, 0, 0, 0.25);
            color: var(--text-dark);
        }
        .badge {
            border-radius: 0.5rem;
            background: var(--willow-grove);
        }
        .form-control,
        .form-select {
            border-radius: 0.5rem;
            border-color: rgba(0, 0, 0, 0.15);
        }
        .alert {
            border-radius: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3 d-flex flex-column" style="min-height: 100vh;">
                    <div class="text-center mb-4">
                        <h4 class="text-white">
                            <i class="bi bi-book"></i>
                            Tahfidz Monitor
                        </h4>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= (uri_string() == '' || uri_string() == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('/') ?>">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(uri_string(), 'santri') !== false) ? 'active' : '' ?>" href="<?= base_url('/santri') ?>">
                                <i class="bi bi-people me-2"></i>
                                Data Santri
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(uri_string(), 'hafalan') !== false) ? 'active' : '' ?>" href="<?= base_url('/hafalan') ?>">
                                <i class="bi bi-book-half me-2"></i>
                                Data Hafalan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (strpos(uri_string(), 'laporan') !== false) ? 'active' : '' ?>" href="<?= base_url('/laporan') ?>">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                Laporan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/dashboard/export') ?>">
                                <i class="bi bi-download me-2"></i>
                                Export Data
                            </a>
                        </li>
                    </ul>

                    <?php if (session()->get('userSession')): ?>
                        <div class="mt-auto px-0">
                            <div class="sidebar-user-card d-flex align-items-center gap-2">
                                <span class="bi bi-person-circle fs-3 text-white"></span>
                                <div>
                                    <div class="text-white fw-semibold">
                                        <?= esc(session()->get('userData')->nama ?? session()->get('userData')->username ?? 'Pengguna') ?>
                                    </div>
                                    <?php if (session()->get('userData')->email ?? false): ?>
                                        <small class="text-white-50 d-block">
                                            <?= esc(session()->get('userData')->email) ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <a href="<?= base_url('/logout') ?>" class="btn btn-sm btn-outline-light w-100 mt-1">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                Keluar
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Navigation -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $title ?? 'Dashboard' ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-calendar3"></i>
                                <?= date('d M Y') ?>
                            </button>
                        </div>
                        <?php if (!session()->get('userSession')): ?>
                            <a class="btn btn-sm btn-primary ms-2" href="<?= base_url('/login') ?>">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Login
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Page Content -->
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Confirm delete actions
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-delete') || e.target.closest('.btn-delete')) {
                if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                }
            }
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
