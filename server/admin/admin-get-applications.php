<?php
// server/admin/admin-get-applications.php
require_once __DIR__ . '/../config/cors.php';

header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

try {
    $stmt = $pdo->query('SELECT id, job_title, name, email, phone, cover_letter, resume_path, applied_at FROM job_applications ORDER BY applied_at DESC');
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => true, 'applications' => $applications]);
} catch (Exception $e) {
    echo json_encode(['status' => false, 'message' => 'Database error']);
}
