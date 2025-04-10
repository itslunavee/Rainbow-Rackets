<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../server/admin/login.php");
    exit();
}

require_once('../../Server/db_connect.php');
require_once('../../Server/admin/dashboard_data.php');

$dashboard = getDashboardData($pdo);
?>

<!DOCTYPE html>
<html>
<head>
    <title>System Management Dashboard</title>
    <link rel="stylesheet" href="/rainbow-rackets/Styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="admin-nav-wrapper">
        <button id="mobile-menu-btn">☰</button>
        <ul id="admin-nav">
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="approve_users.php">Approve Users</a></li>
            <li><a href="manage_events.php">Manage Events</a></li>
            <li><a href="logout.php" class="admin-logout">Logout</a></li>
        </ul>
    </nav>

    <div class="dashboard-container">
        <?php if(isset($dashboard['error'])): ?>
            <div class="alert error"><?= htmlspecialchars($dashboard['error']) ?></div>
        <?php endif; ?>

        <!-- Quick Stats Row -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3><i class="fas fa-users"></i> Total Members</h3>
                <p><?= $dashboard['stats']['total_members'] ?? 0 ?></p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-calendar-alt"></i> Active Events</h3>
                <p><?= $dashboard['stats']['active_events'] ?? 0 ?></p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-trophy"></i> Total Points Awarded</h3>
                <p><?= $dashboard['stats']['total_points'] ?? 0 ?></p>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="dashboard-card">
            <h2><i class="fas fa-user-clock"></i> Pending Approvals</h2>
            <?php if(!empty($dashboard['pending_users'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dashboard['pending_users'] as $user): ?>
                        <tr data-user-id="<?= $user['user_id'] ?>">
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                            <td>
                                <button class="btn-approve" onclick="handleApproval(<?= $user['user_id'] ?>, 'approve')">Approve</button>
                                <button class="btn-reject" onclick="handleApproval(<?= $user['user_id'] ?>, 'reject')">Reject</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="approve_users.php" class="view-all">View All Pending →</a>
            <?php else: ?>
                <p class="no-results">No pending approvals!</p>
            <?php endif; ?>
        </div>

        <!-- Events Section -->
        <div class="dashboard-columns">
            <div class="dashboard-card">
                <h2><i class="fas fa-calendar-check"></i> Next Event</h2>
                <?php if(!empty($dashboard['next_event'])): ?>
                    <div class="event-highlight">
                        <h3><?= htmlspecialchars($dashboard['next_event']['event_type']) ?></h3>
                        <p class="event-date">
                            <i class="fas fa-clock"></i>
                            <?= date('D, M j, Y', strtotime($dashboard['next_event']['event_date'])) ?>
                        </p>
                        <p class="event-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?= htmlspecialchars($dashboard['next_event']['location']) ?>
                        </p>
                        <a href="manage_events.php" class="btn-edit">Manage Events</a>
                    </div>
                <?php else: ?>
                    <p class="no-events">No upcoming events scheduled</p>
                <?php endif; ?>
            </div>

            <div class="dashboard-card">
                <h2><i class="fas fa-history"></i> Last Event</h2>
                <?php if(!empty($dashboard['last_event'])): ?>
                    <div class="event-highlight">
                        <h3><?= htmlspecialchars($dashboard['last_event']['event_type']) ?></h3>
                        <p class="event-date">
                            <?= date('D, M j, Y', strtotime($dashboard['last_event']['event_date'])) ?>
                        </p>
                        <div class="event-stats">
                            <div class="stat-item">
                                <i class="fas fa-users"></i>
                                <span><?= $dashboard['last_event']['participant_count'] ?> Participants</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-star"></i>
                                <span><?= $dashboard['last_event']['total_points'] ?> Points Awarded</span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="no-events">No past events recorded</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Activity Overview -->
        <div class="dashboard-card">
            <h2><i class="fas fa-chart-line"></i> Activity Overview</h2>
            <div class="metrics-grid">
                <div class="metric-item">
                    <span>New Members (7d)</span>
                    <div class="metric-value"><?= $dashboard['stats']['recent_signups'] ?? 0 ?></div>
                </div>
                <div class="metric-item">
                    <span>Avg. Event Attendance</span>
                    <div class="metric-value"><?= $dashboard['stats']['avg_attendance'] ?? 0 ?>%</div>
                </div>
                <div class="metric-item">
                    <span>Pending RSVPs</span>
                    <div class="metric-value"><?= $dashboard['stats']['pending_rsvps'] ?? 0 ?></div>
                </div>
            </div>
        </div>
    </div>

    <script src="/rainbow-rackets/Scripts/admin.js"></script>
</body>
</html>