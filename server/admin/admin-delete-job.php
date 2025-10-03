<?php
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

try {
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

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id']) || !is_numeric($data['id'])) {
        echo json_encode([
            'status' => false,
            'statuscode' => 400,
            'message' => 'Job ID is required and must be numeric',
            'response' => null
        ]);
        exit;
    }

    $id = intval($data['id']);

    // Check if job exists
    $check = $pdo->prepare('SELECT id FROM jobs WHERE id = ?');
    $check->execute([$id]);
    if ($check->rowCount() === 0) {
        echo json_encode([
            'status' => false,
            'statuscode' => 404,
            'message' => 'Job not found',
            'response' => null
        ]);
        exit;
    }

    // Delete the job
    $stmt = $pdo->prepare('DELETE FROM jobs WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'status' => true,
            'statuscode' => 200,
            'message' => 'Job deleted successfully',
            'response' => null
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'statuscode' => 500,
            'message' => 'Failed to delete job',
            'response' => null
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'statuscode' => 500,
        'message' => 'Server error',
        'response' => $e->getMessage()
    ]);
}
