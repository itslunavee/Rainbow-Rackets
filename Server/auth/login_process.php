<?php
require_once('../db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $raw_password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($raw_password, $admin['password'])) {
        session_start();
        $_SESSION['user_status'] = 'admin';
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['user_id'];
        header("Location: ../../pages/admin/dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=invalid");
        exit();
    }
}
?>