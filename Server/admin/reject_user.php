<?php
// Server/admin/reject_user.php
session_start();
require_once('../db_connect.php');

// Check admin login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $_SESSION['message'] = "User rejected successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error rejecting user: " . $e->getMessage();
    }
}

header("Location: ../../Pages/admin/approve_users.php");
exit();
?>