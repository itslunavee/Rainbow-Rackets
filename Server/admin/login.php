<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
  header("Location: dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="../../Styles/login.css">
</head>
<body>
<form action="../auth/login_process.php" method="POST">
    <h2>Admin Login</h2>
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</body>
</html>