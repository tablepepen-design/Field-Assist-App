<?php
require_once '../config.php';

header('Content-Type: application/json');

// Hardcode user_id for open access demonstration
$user_id = 2;
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Fetch user's tasks
    $stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = ? ORDER BY status ASC, created_at DESC');
    $stmt->execute([$user_id]);
    $tasks = $stmt->fetchAll();
    echo json_encode($tasks);

} elseif ($method === 'POST') {
    // Create new task or update status
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? 'create';

    if ($action === 'create') {
        $title = $data['title'] ?? 'New Visit';
        $location_name = $data['location'] ?? '';
        
        $stmt = $pdo->prepare('INSERT INTO tasks (user_id, title, location_name) VALUES (?, ?, ?)');
        $stmt->execute([$user_id, $title, $location_name]);
        
        echo json_encode(['message' => 'Task created successfully', 'id' => $pdo->lastInsertId()]);
        
    } elseif ($action === 'update_status') {
        $task_id = $data['task_id'] ?? 0;
        $status = $data['status'] ?? 'completed';
        $lat = $data['latitude'] ?? null;
        $lng = $data['longitude'] ?? null;
        
        // Ensure the task belongs to the user
        $stmt = $pdo->prepare('UPDATE tasks SET status = ?, latitude = ?, longitude = ?, completed_at = NOW() WHERE id = ? AND user_id = ?');
        $stmt->execute([$status, $lat, $lng, $task_id, $user_id]);
        
        echo json_encode(['message' => 'Task updated successfully']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
