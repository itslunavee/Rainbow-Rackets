<?php
require_once('dashboard.php');

// Get user ID from URL
$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    header("Location: manage_users.php");
    exit();
}

// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['error'] = "User not found";
    header("Location: manage_users.php");
    exit();
}
?>

<head>
    <title>Edit Users</title>
    <link rel="stylesheet" href="/rainbow-rackets/Styles/admin.css">
</head>

<nav>
  <a href="manage_users.php">Back to Users</a>
</nav>

<div class="dashboard-container">
    <h2>Edit User: <?= htmlspecialchars($user['name']) ?></h2>
    
    <form method="POST" action="../../server/admin/update_user.php">
        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
        
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Total Points:</label>
            <input type="number" name="total_points" value="<?= $user['total_points'] ?>">
        </div>
        
        <button type="submit" class="btn-save">Save Changes</button>
        <a href="manage_users.php" class="btn-cancel">Cancel</a>
    </form>
</div>