<?php
require_once '../config.php';
require_once 'sync_helper.php';

header('Content-Type: application/json');

if (!defined('GOOGLE_SCRIPT_URL') || empty(GOOGLE_SCRIPT_URL)) {
    http_response_code(500);
    echo json_encode(['error' => 'Google Script URL not configured in config.php']);
    exit;
}

try {
    // Fetch data from Google Apps Script Web App
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, GOOGLE_SCRIPT_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Google Scripts use redirects
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("Google Script returned HTTP code $httpCode. Response: $response");
    }

    $data = json_decode($response, true);
    if (!$data) {
        throw new Exception('Failed to parse JSON from Google Script. Response: ' . substr($response, 0, 100));
    }

    // Use the helper to sync the data
    $result = syncSalesData($pdo, $data);
    echo json_encode($result);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
