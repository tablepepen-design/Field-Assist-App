<?php
require_once '../config.php';

header('Content-Type: application/json');

// Get the POST data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data format']);
    exit;
}

// Optional: Simple API Key check
$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
$expectedKey = 'MORARKA_SYNC_2026'; // You can change this and update in script.gs

/* 
if ($apiKey !== $expectedKey) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
*/

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO sales_data 
        (sale_date, salesman, item_number, shop_name, product, units, unit_price, sales_amount, totals) 
        VALUES (:sale_date, :salesman, :item_number, :shop_name, :product, :units, :unit_price, :sales_amount, :totals)
        ON DUPLICATE KEY UPDATE 
        units = VALUES(units), 
        unit_price = VALUES(unit_price), 
        sales_amount = VALUES(sales_amount), 
        totals = VALUES(totals)");

    $count = 0;
    foreach ($data as $row) {
        // Basic validation of fields
        if (empty($row['date'])) continue;

        // Format date for SQL (Assuming DD-MM-YYYY or YYYY-MM-DD)
        $date = date('Y-m-d', strtotime($row['date']));

        $stmt->execute([
            ':sale_date' => $date,
            ':salesman' => $row['salesman'] ?? '',
            ':item_number' => $row['item_number'] ?? '',
            ':shop_name' => $row['shop_name'] ?? '',
            ':product' => $row['product'] ?? '',
            ':units' => intval($row['units'] ?? 0),
            ':unit_price' => floatval($row['unit_price'] ?? 0),
            ':sales_amount' => floatval($row['sales_amount'] ?? 0),
            ':totals' => floatval($row['totals'] ?? 0)
        ]);
        $count++;
    }

    $pdo->commit();
    echo json_encode(['message' => "Successfully synced $count rows", 'status' => 'success']);

} catch (\Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
