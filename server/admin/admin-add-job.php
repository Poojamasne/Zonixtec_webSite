<?php
require_once '../config/cors.php';
require_once '../config/db.php';

// Read JSON payload from request body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$title = $data['title'] ?? '';
$department = $data['department'] ?? '';
$location = $data['location'] ?? '';
$type = $data['type'] ?? '';
$status = $data['status'] ?? '';
$salary = $data['salary'] ?? '';
$tags = $data['tags'] ?? '';
$description = $data['description'] ?? '';
$requirements = $data['requirements'] ?? '';

if (!$title || !$department || !$location || !$type || !$status || !$salary || !$tags || !$description || !$requirements) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO jobs (title, department, location, type, status, salary, tags, description, requirements) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $success = $stmt->execute([$title, $department, $location, $type, $status, $salary, $tags, $description, $requirements]);
    if ($success) {
        echo json_encode([
            'status' => true,
            'statuscode' => 200,
            'message' => 'Job added successfully',
            'response' => [
                'title' => $title,
                'department' => $department,
                'location' => $location,
                'type' => $type,
                'status' => $status,
                'salary' => $salary,
                'tags' => $tags,
                'description' => $description,
                'requirements' => $requirements
            ]
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'statuscode' => 500,
            'message' => 'Failed to add job',
            'response' => null
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => false,
        'statuscode' => 500,
        'message' => 'Database error: ' . $e->getMessage(),
        'response' => null
    ]);
}
