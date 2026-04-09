<?php
require_once '../config.php';

header('Content-Type: application/json');

// 1. Total Visits (Today)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE DATE(created_at) = CURDATE()");
$stmt->execute();
$todayVisits = $stmt->fetchColumn();

// 2. Efficiency (Completed / Total this week)
$stmt = $pdo->prepare("SELECT 
        COUNT(*) as total, 
        SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed 
    FROM tasks 
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$stmt->execute();
$weekStats = $stmt->fetch();
$efficiency = $weekStats['total'] > 0 ? round(($weekStats['completed'] / $weekStats['total']) * 100, 1) : 0;

// 3. Last 7 Days Trend
$stmt = $pdo->prepare("SELECT 
        DATE(created_at) as date, 
        COUNT(*) as count 
    FROM tasks 
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
    GROUP BY DATE(created_at) 
    ORDER BY date ASC");
$stmt->execute();
$trend = $stmt->fetchAll();

// 4. Activity Feed (Last 5 actions)
$stmt = $pdo->prepare("SELECT t.title, t.location_name, t.status, u.phone_number, t.updated_at 
    FROM tasks t 
    JOIN users u ON t.user_id = u.id 
    ORDER BY COALESCE(t.completed_at, t.created_at) DESC 
    LIMIT 5");
$stmt->execute();
$feed = $stmt->fetchAll();

// 5. Resource Rings (Breakdown of statuses overall)
$stmt = $pdo->prepare("SELECT status, COUNT(*) as count FROM tasks GROUP BY status");
$stmt->execute();
$statusCounts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

echo json_encode([
    'liveOutput' => $todayVisits,
    'efficiency' => $efficiency,
    'trend' => $trend,
    'feed' => $feed,
    'resources' => [
        'completed' => $statusCounts['completed'] ?? 0,
        'in_progress' => $statusCounts['in_progress'] ?? 0,
        'pending' => $statusCounts['pending'] ?? 0
    ],
    'totalWeek' => $weekStats['total']
]);
