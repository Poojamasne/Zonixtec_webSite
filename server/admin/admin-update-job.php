<?php
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/db.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => false,
        'statuscode' => 405,
        'message' => 'Method Not Allowed',
        'response' => null
    ]);
    exit;
}

// Get the input data (support both JSON and form-encoded)
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

// Validate required fields
$required = ['id', 'title', 'description', 'location', 'type'];
$missing = [];
foreach ($required as $field) {
    if (empty($input[$field])) {
        $missing[] = $field;
    }
}
if (!empty($missing)) {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'statuscode' => 400,
        'message' => 'Missing required fields: ' . implode(', ', $missing),
        'response' => null
    ]);
    exit;
}

$id = intval($input['id']);
$title = trim($input['title']);
$description = trim($input['description']);
$location = trim($input['location']);
$type = trim($input['type']);

try {
    // Check if job exists
    $stmt = $pdo->prepare('SELECT id FROM jobs WHERE id = ?');
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode([
            'status' => false,
            'statuscode' => 404,
            'message' => 'Job not found',
            'response' => null
        ]);
        exit;
    }

    // Update the job
    $stmt = $pdo->prepare('UPDATE jobs SET title = ?, description = ?, location = ?, type = ? WHERE id = ?');
    $success = $stmt->execute([$title, $description, $location, $type, $id]);

    if ($success) {
        echo json_encode([
            'status' => true,
            'statuscode' => 200,
            'message' => 'Job updated successfully',
            'response' => null
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => false,
            'statuscode' => 500,
            'message' => 'Failed to update job',
            'response' => null
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'statuscode' => 500,
        'message' => 'Server error',
        'response' => $e->getMessage()
    ]);
}
