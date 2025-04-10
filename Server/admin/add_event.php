<?php
// Server/admin/add_event.php
session_start();
require_once('../db_connect.php');

// Check admin login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['user_status'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_date = $_POST['event_date'];
    $event_type = htmlspecialchars($_POST['event_type']);
    $location = htmlspecialchars($_POST['location']);
    $admin_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO events (event_date, event_type, location, created_by) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$event_date, $event_type, $location, $admin_id]);
        $_SESSION['message'] = "Event added successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

header("Location: ../../Pages/admin/manage_events.php");
exit();
?>