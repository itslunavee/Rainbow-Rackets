<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../server/admin/login.php");
    exit();
}
require_once('../../Server/db_connect.php');

if (isset($_SESSION['message'])) {
  echo '<div class="alert success">' . htmlspecialchars($_SESSION['message']) . '</div>';
  unset($_SESSION['message']);
}
if (isset($_SESSION['error'])) {
  echo '<div class="alert error">' . htmlspecialchars($_SESSION['error']) . '</div>';
  unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
    <link rel="stylesheet" href="/rainbow-rackets/Styles/admin.css">
</head>
<body>

<nav>
  <a href="dashboard.php">Back to Dashboard</a>
</nav>

<h2>Events</h2>
<!-- Add New Event -->
<form method="POST" action="../../Server/admin/add_event.php">
  <input type="date" name="event_date" required>
  <input type="text" name="event_type" placeholder="Event Type" required>
  <input type="text" name="location" placeholder="Location" required>
  <button type="submit">Add Event</button>
</form>

<!-- List of Events -->
<table>
  <tr>
    <th>Date</th>
    <th>Type</th>
    <th>Action</th>
  </tr>
  <?php
  $stmt = $pdo->query("SELECT * FROM events");
  while ($event = $stmt->fetch()):
  ?>
    <tr>
      <td><?= $event['event_date'] ?></td>
      <td><?= htmlspecialchars($event['event_type']) ?></td>
      <td>
        <a href="../../Server/admin/close_event.php?id=<?= $event['event_id'] ?>">Close Event</a>
        <a href="../../Server/admin/award_points.php?id=<?= $event['event_id'] ?>">Award Points</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
