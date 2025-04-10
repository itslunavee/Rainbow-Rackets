<?php
require_once('../db_connect.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../../Server/admin/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $user_id = $_POST['user_id'];
    $points = $_POST['points'];

    try {
        $stmt = $pdo->prepare("INSERT INTO points (user_id, event_id, points) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $event_id, $points]);
        $_SESSION['message'] = "Points awarded successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    header("Location: ../../Pages/admin/manage_events.php");
    exit();
}

// GET request - show award points form
$event_id = $_GET['id'] ?? null;
if (!$event_id) {
    $_SESSION['error'] = "No event specified";
    header("Location: ../../Pages/admin/manage_events.php");
    exit();
}

// Get event details and participants
try {
    // Get event info
    $stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    // Get participants
    $stmt = $pdo->prepare("
        SELECT users.user_id, users.name 
        FROM participants
        JOIN users ON participants.user_id = users.user_id
        WHERE participants.event_id = ?
    ");
    $stmt->execute([$event_id]);
    $participants = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Award Points</title>
    <link rel="stylesheet" href="/rainbow-rackets/Styles/admin.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Award Points for <?= htmlspecialchars($event['event_type']) ?></h2>
        
        <?php if(empty($participants)): ?>
            <div class="alert error">No participants found for this event</div>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="event_id" value="<?= $event_id ?>">
                
                <div class="form-group">
                    <label>Select Participant:</label>
                    <select name="user_id" required>
                        <?php foreach($participants as $p): ?>
                            <option value="<?= $p['user_id'] ?>">
                                <?= htmlspecialchars($p['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Points to Award:</label>
                    <input type="number" name="points" min="1" required>
                </div>

                <button type="submit" class="btn-save">Award Points</button>
                <a href="../../Pages/admin/manage_events.php" class="btn-cancel">Cancel</a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>