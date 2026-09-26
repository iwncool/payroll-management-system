<?php
session_start();
require_once __DIR__ . '/config/db.php';

$pdo = dbConnection();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user = getUserById($pdo, $_SESSION['user_id']);
$employeeCount = (int) $pdo->query('SELECT COUNT(*) FROM employees')->fetchColumn();
$processedCount = (int) $pdo->query("SELECT COUNT(*) FROM employees WHERE is_processed = 1")->fetchColumn();
$pendingCount = $employeeCount - $processedCount;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Payroll</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Payroll System</div>
            <nav>
                <a class="active" href="dashboard.php">Dashboard</a>
                <a href="employees.php">Master Data Karyawan</a>
                <a href="processed_employees.php">Data Diterima</a>
                <a href="profile.php">Password & Keamanan</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>

        <main class="content">
            <header class="topbar">
                <div>
                    <h1>Dashboard</h1>
                    <p>Selamat datang, <?php echo htmlspecialchars($user['username']); ?></p>
                </div>
            </header>

            <section class="stats">
                <div class="stat-card primary">
                    <span>Total Karyawan</span>
                    <strong><?php echo $employeeCount; ?></strong>
                </div>
                <div class="stat-card success">
                    <span>Diterima</span>
                    <strong><?php echo $processedCount; ?></strong>
                </div>
                <div class="stat-card warning">
                    <span>Belum Diproses</span>
                    <strong><?php echo $pendingCount; ?></strong>
                </div>
            </section>

            <section class="panel">
                <h2>Menu Utama</h2>
                <div class="menu-grid">
                    <a class="menu-item" href="employees.php">
                        <h3>Master Data Karyawan</h3>
                        <p>Tambah, ubah, dan hapus data karyawan.</p>
                    </a>
                    <a class="menu-item" href="processed_employees.php">
                        <h3>Data Karyawan Diterima</h3>
                        <p>Daftar karyawan yang sudah diproses oleh perusahaan.</p>
                    </a>
                    <a class="menu-item" href="profile.php">
                        <h3>Password & Keamanan</h3>
                        <p>Tambah password baru, ubah, atau hapus password.</p>
                    </a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
