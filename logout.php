<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/config/db.php';

$pdo = dbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '') {
        $_SESSION['login_error'] = 'Username wajib diisi.';
        header('Location: index.php');
        exit;
    }

    $user = getUserByUsername($pdo, $username);
    if (!$user) {
        $_SESSION['login_error'] = 'Username tidak ditemukan.';
        header('Location: index.php');
        exit;
    }

    if ($user['password_hash'] === null) {
        if ($password === '') {
            $_SESSION['login_error'] = 'Silakan buat password baru untuk akun ini.';
            header('Location: index.php');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
        $stmt->execute([$hash, $user['id']]);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['success'] = 'Password baru berhasil dibuat. Login berhasil.';
        header('Location: dashboard.php');
        exit;
    }

    if (!password_verify($password, $user['password_hash'])) {
        $_SESSION['login_error'] = 'Password salah.';
        header('Location: index.php');
        exit;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['success'] = 'Login berhasil.';
    header('Location: dashboard.php');
    exit;
}

$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Payroll System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-body">
    <div class="login-box">
        <h1>Login Aplikasi</h1>
        <p class="subtitle">Payroll Management System</p>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <div class="login-hint">
            <strong>Info:</strong> Username default adalah <b>admin</b>. Jika password masih kosong, Anda bisa membuat password baru saat login pertama.
        </div>
    </div>
</body>
</html>
