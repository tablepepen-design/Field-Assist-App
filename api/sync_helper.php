<?php
function syncSalesData($pdo, $data) {
    if (!$data || !is_array($data)) {
        return ['error' => 'Invalid data format'];
    }

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
            if (empty($row['date'])) continue;

            // Format date for SQL
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
        return ['message' => "Successfully synced $count rows", 'status' => 'success'];

    } catch (\Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        return ['error' => $e->getMessage()];
    }
}
