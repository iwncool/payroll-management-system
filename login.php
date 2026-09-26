<?php
session_start();
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
    header('Location: dashboard.php');
    exit;
}

header('Location: index.php');
