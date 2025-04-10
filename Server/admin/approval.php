<?php
require_once('../db_connect.php');
session_start();

// Check if admin is logged in (security)
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../../Server/admin/login.php");
    exit();
}

// Process approval/rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;

    if ($user_id) {
        if (isset($_POST['approve'])) {
            // Approve the user (sets status to 'verified')
            $stmt = $pdo->prepare("UPDATE users SET status = 'verified' WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $_SESSION['message'] = "User approved successfully!";
        } 
        elseif (isset($_POST['reject'])) {
            // Reject the user (deletes from database)
            $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $_SESSION['message'] = "User rejected and removed.";
        }
    }

    // Redirect back to the approvals page
    header("Location: ../../Pages/admin/approve_users.php");
    exit();
}
?>