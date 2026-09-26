<?php
session_start();
require_once __DIR__ . '/config/db.php';

$pdo = dbConnection();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_password') {
        $newPassword = trim($_POST['new_password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        if ($newPassword === '' || $confirmPassword === '') {
            $_SESSION['error'] = 'Password baru dan konfirmasi wajib diisi.';
        } elseif ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Password baru dan konfirmasi password tidak sama.';
        } else {
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
            $stmt->execute([$hash, $_SESSION['user_id']]);
            $_SESSION['success'] = 'Password berhasil diperbarui.';
        }
        header('Location: profile.php');
        exit;
    }

    if ($action === 'delete_password') {
        $stmt = $pdo->prepare('UPDATE users SET password_hash = NULL WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $_SESSION['success'] = 'Password berhasil dihapus. Anda bisa membuat password baru saat login berikutnya.';
        header('Location: profile.php');
        exit;
    }
}

$user = getUserById($pdo, $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Password</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Payroll System</div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="employees.php">Master Data Karyawan</a>
                <a href="processed_employees.php">Data Diterima</a>
                <a class="active" href="profile.php">Password & Keamanan</a>
                <a href="logout.php">Logout</a>
            </nav>
        </aside>

        <main class="content">
            <header class="topbar">
                <div>
                    <h1>Pengaturan Password</h1>
                    <p>Kelola password akun Anda untuk keamanan aplikasi.</p>
                </div>
            </header>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <section class="panel form-panel">
                <h2>Update Password</h2>
                <form method="POST" action="profile.php">
                    <input type="hidden" name="action" value="update_password">
                    <div class="form-grid single">
                        <div>
                            <label>Username</label>
                            <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                        </div>
                        <div>
                            <label>Password Baru</label>
                            <input type="password" name="new_password" placeholder="Masukkan password baru" required>
                        </div>
                        <div>
                            <label>Konfirmasi Password</label>
                            <input type="password" name="confirm_password" placeholder="Ulangi password baru" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Simpan Password</button>
                    </div>
                </form>
            </section>

            <section class="panel form-panel">
                <h2>Hapus Password</h2>
                <p>Fitur ini akan menghapus password aktif. Setelah itu, Anda bisa membuat password baru pada proses login berikutnya.</p>
                <form method="POST" action="profile.php" onsubmit="return confirm('Apakah Anda yakin ingin menghapus password saat ini?');">
                    <input type="hidden" name="action" value="delete_password">
                    <button class="btn btn-danger" type="submit">Hapus Password</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
