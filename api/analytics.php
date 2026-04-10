<?php
require_once '../config.php';

header('Content-Type: application/json');

// 1. Total Visits (Today) - Tasks
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE DATE(created_at) = CURDATE()");
$stmt->execute();
$todayVisits = $stmt->fetchColumn();

// 2. Sales Metrics (All time from Sheet sync)
$stmt = $pdo->prepare("SELECT 
        COUNT(*) as total_orders, 
        SUM(sales_amount) as total_revenue,
        SUM(units) as total_units
    FROM sales_data");
$stmt->execute();
$salesStats = $stmt->fetch();

// 3. Last 7 Days Trend (Sales Revenue)
$stmt = $pdo->prepare("SELECT 
        sale_date as date, 
        SUM(sales_amount) as revenue,
        COUNT(*) as order_count
    FROM sales_data 
    WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
    GROUP BY sale_date 
    ORDER BY sale_date ASC");
$stmt->execute();
$salesTrend = $stmt->fetchAll();

// 4. Activity Feed (Last 10 Sales Entries)
$stmt = $pdo->prepare("SELECT salesman, shop_name, product, sales_amount as amount, sale_date as date
    FROM sales_data 
    ORDER BY sale_date DESC, created_at DESC 
    LIMIT 10");
$stmt->execute();
$salesFeed = $stmt->fetchAll();

// 5. Salesman Performance (Person-wise revenue)
$stmt = $pdo->prepare("SELECT salesman, SUM(sales_amount) as revenue 
    FROM sales_data 
    GROUP BY salesman 
    ORDER BY revenue DESC");
$stmt->execute();
$salesmanPerformance = $stmt->fetchAll();

// 6. Existing Task Statuses (Resource Rings)
$stmt = $pdo->prepare("SELECT status, COUNT(*) as count FROM tasks GROUP BY status");
$stmt->execute();
$statusCounts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

echo json_encode([
    'liveOutput' => $todayVisits,
    'salesStats' => [
        'orders' => $salesStats['total_orders'] ?? 0,
        'revenue' => $salesStats['total_revenue'] ?? 0,
        'units' => $salesStats['total_units'] ?? 0
    ],
    'salesTrend' => $salesTrend,
    'salesFeed' => $salesFeed,
    'salesmanPerformance' => $salesmanPerformance,
    'resources' => [
        'completed' => $statusCounts['completed'] ?? 0,
        'in_progress' => $statusCounts['in_progress'] ?? 0,
        'pending' => $statusCounts['pending'] ?? 0
    ]
]);
