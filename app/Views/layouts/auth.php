<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Monitoring Tahfidz' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --sundance: #cfbc67;
            --elephant: #163d57;
            --willow-grove: #6a7c5c;
            --wattle: #ddd147;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background-image: url('https://t3.ftcdn.net/jpg/03/35/71/80/360_F_335718092_XvMIfWlpkkPNKXkVUJRRMvIy1R3VsvxF.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: #000000bf;
            z-index: 0;
        }
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 2rem;
        }
        .auth-card {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
        }
        .auth-card .card {
            background: linear-gradient(145deg, var(--elephant), var(--willow-grove));
            border: none;
            color: #f3fff5;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.45);
            overflow: hidden;
        }
        .auth-card .card-body {
            padding: 2rem;
        }
        .card-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .auth-logo-img {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            padding: 0.35rem;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.35);
        }
        .card-title {
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.02em;
        }
        .auth-card .form-label {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }
        .auth-card .form-control {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }
        .auth-card .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(91, 198, 141, 0.35);
            border-color: var(--sundance);
        }
        .auth-card .btn-primary {
            background: linear-gradient(135deg, var(--wattle), var(--sundance));
            border: none;
            font-weight: 600;
            color: var(--elephant);
        }
        .auth-card .btn-primary:hover {
            background: linear-gradient(135deg, var(--elephant), var(--willow-grove));
            color: #ffffff;
        }
    </style>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>