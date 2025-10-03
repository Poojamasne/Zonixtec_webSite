<?php
require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT id, title, department, location, type, status, salary, tags, description, requirements FROM jobs ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Stats
    $stats = [
        'total' => 0,
        'active' => 0,
        'draft' => 0,
        'closed' => 0
    ];
    foreach ($jobs as $job) {
        $stats['total']++;
        if ($job['status'] === 'active') $stats['active']++;
        elseif ($job['status'] === 'draft') $stats['draft']++;
        elseif ($job['status'] === 'closed') $stats['closed']++;
    }

    echo json_encode([
        'status' => true,
        'statuscode' => 200,
        'message' => 'Jobs fetched successfully',
        'response' => $jobs,
        'stats' => $stats
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'statuscode' => 500,
        'message' => 'Failed to fetch jobs',
        'response' => $e->getMessage()
    ]);
}
