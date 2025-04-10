<?php
session_start();
require_once('../db_connect.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $_SESSION['message'] = "User deleted successfully";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting user: " . $e->getMessage();
    }
}

header("Location: ../../Pages/admin/manage_users.php");
exit();
?>