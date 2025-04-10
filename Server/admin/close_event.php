<?php
session_start();
require_once('../db_connect.php');

// Check admin login
if (!isset($_SESSION['admin_logged_in'])) 

{
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    try {
        // Update event status to 'closed'
        $stmt = $pdo->prepare("UPDATE events SET status = 'closed' WHERE event_id = ?");
        $stmt->execute([$event_id]);
        $_SESSION['message'] = "Event closed!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

header("Location: ../../Pages/admin/manage_events.php");
exit();
?>