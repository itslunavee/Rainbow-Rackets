<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../server/admin/login.php");
    exit();
}
require_once('../../Server/db_connect.php');
?>

<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="/rainbow-rackets/Styles/admin.css">
</head>

<nav>
  <a href="dashboard.php">Back to Dashboard</a>
</nav>

<h2>All Users</h2>
<table>
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Total Points</th>
    <th>Action</th>
  </tr>
  <?php
  $stmt = $pdo->query("SELECT * FROM users WHERE status = 'verified'");
  while ($user = $stmt->fetch()):
  ?>
    <tr>
      <td><?= htmlspecialchars($user['name']) ?></td>
      <td><?= htmlspecialchars($user['email']) ?></td>
      <td><?= $user['total_points'] ?></td>
      <td>
        <a href="edit_user.php?id=<?= $user['user_id'] ?>">Edit</a>
        <a href="delete_user.php?id=<?= $user['user_id'] ?>">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>