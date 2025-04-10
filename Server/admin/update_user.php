<?php
// Server/admin/update_user.php
session_start();
require_once('../db_connect.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $total_points = (int)$_POST['total_points'];

    try {
        // Check if email exists for another user
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
        $stmt->execute([$email, $user_id]);
        
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Email already exists for another user";
        } else {
            $stmt = $pdo->prepare("
                UPDATE users 
                SET name = ?, email = ?, total_points = ?
                WHERE user_id = ?
            ");
            $stmt->execute([$name, $email, $total_points, $user_id]);
            $_SESSION['message'] = "User updated successfully";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating user: " . $e->getMessage();
    }
}

header("Location: ../../Pages/admin/manage_users.php");
exit();
?>