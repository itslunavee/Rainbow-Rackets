<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../server/admin/login.php");
    exit();
}
require_once('../../Server/db_connect.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve Users</title>
    <link rel="stylesheet" href="/rainbow-rackets/Styles/admin.css">
</head>
<body>
    
    <nav>
        <a href="dashboard.php">Back to Dashboard</a>
    </nav>

    <h2>Pending Approvals</h2>
    <table>
        <?php
        $stmt = $pdo->query("SELECT * FROM users WHERE status = 'unverified'");
        while ($user = $stmt->fetch()):
        ?>
            <tr>
            <td>
            <form method="POST" action="../../Server/admin/approval.php">
            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
            <button type="submit" name="approve" class="btn-approve">Approve</button>
            <button type="submit" name="reject" class="btn-reject">Reject</button>
            </form>
            </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>