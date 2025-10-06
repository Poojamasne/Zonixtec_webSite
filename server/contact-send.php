<?php
// Simple test version - remove all complex code
header('Content-Type: application/json');

// Test if PHP is working
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode([
        'status' => true,
        'message' => 'PHP is working! Server is ready.'
    ]);
    exit;
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Simple response without database for testing
    echo json_encode([
        'status' => true,
        'message' => 'Message received successfully!',
        'data' => [
            'name' => $input['name'] ?? 'Test',
            'email' => $input['email'] ?? 'test@test.com',
            'subject' => $input['subject'] ?? 'Test Subject'
        ]
    ]);
    exit;
}

// If neither GET nor POST
echo json_encode([
    'status' => false,
    'message' => 'Invalid request method'
]);
?>