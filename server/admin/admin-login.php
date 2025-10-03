<?php
require_once '../config/cors.php';
require_once '../config/db.php';

// Read JSON payload from request body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (!$username || !$password) {
    echo json_encode(['success' => false, 'message' => 'Missing credentials']);
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && $password === $admin['password']) {
    echo json_encode([
        'status' => true,
        'statuscode' => 200,
        'message' => 'login successful',
        'response' => $admin
    ]);
} else {
    echo json_encode([
        'status' => false,
        'statuscode' => 401,
        'message' => 'Invalid username or password',
        'response' => null
    ]);
}
