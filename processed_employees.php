<?php
session_start();
require_once __DIR__ . '/config/db.php';

$pdo = dbConnection();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$processedEmployees = $pdo->query("SELECT * FROM employees WHERE is_processed = 1 ORDER BY tanggal_bergabung DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan Diterima</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Payroll System</div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="employees.php">Master Data Karyawan</a>
                <a class="active" href="processed_employees.php">Data Diterima</a>
                <a href="profile.php">Password & Keamanan</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>

        <main class="content">
            <header class="topbar">
                <div>
                    <h1>Data Karyawan yang Sudah Diproses</h1>
                    <p>Daftar karyawan yang telah diterima dan diproses oleh perusahaan.</p>
                </div>
            </header>

            <section class="panel table-panel">
                <table>
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Tanggal Bergabung</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Tunjangan</th>
                            <th>Fasilitas</th>
                            <th>Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($processedEmployees)): ?>
                            <tr>
                                <td colspan="8">Belum ada karyawan yang diterima.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($processedEmployees as $employee): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($employee['nip']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['tanggal_bergabung']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['departemen']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['jabatan']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['tunjangan']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['fasilitas']); ?></td>
                                    <td>Rp <?php echo number_format((float) $employee['gaji'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
