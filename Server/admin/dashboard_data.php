<?php
function getDashboardData($pdo) {
    $data = [];
    
    try {
        // Pending Approvals
        $data['pending_users'] = $pdo->query("
            SELECT user_id, name, email, created_at 
            FROM users 
            WHERE status = 'unverified'
            ORDER BY created_at DESC 
            LIMIT 5
        ")->fetchAll();

        // Events
        $data['next_event'] = $pdo->query("
            SELECT * FROM events 
            WHERE event_date >= CURDATE()
            ORDER BY event_date ASC 
            LIMIT 1
        ")->fetch();

        $data['last_event'] = $pdo->query("
            SELECT e.*, 
                COUNT(p.user_id) AS participant_count,
                IFNULL(SUM(po.points), 0) AS total_points
            FROM events e
            LEFT JOIN participants p ON e.event_id = p.event_id
            LEFT JOIN points po ON e.event_id = po.event_id
            WHERE e.event_date < CURDATE()
            GROUP BY e.event_id
            ORDER BY e.event_date DESC 
            LIMIT 1
        ")->fetch();

        // Statistics
        $data['stats'] = [
            'total_members' => $pdo->query("SELECT COUNT(*) FROM users WHERE status = 'verified'")->fetchColumn() ?: 0,
            'active_events' => $pdo->query("SELECT COUNT(*) FROM events WHERE event_date >= CURDATE()")->fetchColumn() ?: 0,
            'total_points' => $pdo->query("SELECT SUM(points) FROM points")->fetchColumn() ?: 0,
            'recent_signups' => $pdo->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn() ?: 0
        ];

    } catch (PDOException $e) {
        error_log("Dashboard data error: " . $e->getMessage());
        $data['error'] = "Failed to load dashboard data";
    }

    return $data;
}
?>