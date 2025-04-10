<?php
require_once('../Server/db_connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rainbow Rackets - Events</title>
    <link rel="stylesheet" href="../Styles/fonts.css">
    <link rel="stylesheet" href="../Styles/main.css">
</head>

<body>
<header class="header">
        <nav class="nav-container">
            <a href="home.php" class="logo">Rainbow Rackets</a>
            <button class="hamburger">☰</button>
            <ul class="nav-menu">
                <li><a href="home.php" class="nav-link">Home</a></li>
                <li><a href="events.php" class="nav-link">Events</a></li>
                <li><a href="signup.php" class="nav-link">Join</a></li>
                <li><a href="about.php" class="nav-link">About</a></li>
            </ul>
        </nav>
</header>

    <section class="calendar">
        <h2>Upcoming Events</h2>
        <div class="calendar-grid">
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM events WHERE status = 'active' ORDER BY event_date ASC");
                while ($event = $stmt->fetch()):
            ?>
                <div class="event-card">
                    <h3><?= htmlspecialchars($event['event_type']) ?></h3>
                    <p class="event-date">
                        <?= date('M j, Y', strtotime($event['event_date'])) ?>
                    </p>
                    <p class="event-location">
                        <?= htmlspecialchars($event['location']) ?>
                    </p>
                </div>
            <?php
                endwhile;
            } catch (PDOException $e) {
                echo '<div class="error">Error loading events: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
            ?>
        </div>
    </section>

    <script src="../Scripts/main.js"></script>
</body>
</html>