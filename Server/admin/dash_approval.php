<?php
// Server/admin/handle_approval.php
session_start();
require_once('../db_connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    try {
        if ($action === 'approve') {
            $stmt = $pdo->prepare("UPDATE users SET status = 'verified' WHERE user_id = ?");
            $message = "User approved successfully";
        } else {
            $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
            $message = "User rejected successfully";
        }

        $stmt->execute([$user_id]);
        echo json_encode(['success' => true, 'message' => $message]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>