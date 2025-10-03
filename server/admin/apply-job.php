<?php
// server/admin/apply-job.php
require_once __DIR__ . '/../config/cors.php';

header('Content-Type: application/json');

// Database connection
require_once __DIR__ . '/../config/db.php'; // Adjust path as needed

function respond($status, $msg = '') {
    echo json_encode(['status' => $status, 'message' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request.');
}

// Validate fields
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$cover = trim($_POST['cover_letter'] ?? '');
$job_title = trim($_POST['job_title'] ?? '');

if (!$name || !$email || !$phone || !$cover || !$job_title) {
    respond(false, 'All fields are required.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Invalid email.');
}

// Handle file upload
if (!isset($_FILES['resume']) || $_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
    respond(false, 'Resume upload failed.');
}
$resume = $_FILES['resume'];
$allowed = ['pdf', 'doc', 'docx'];
$ext = strtolower(pathinfo($resume['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    respond(false, 'Invalid file type.');
}
if ($resume['size'] > 2 * 1024 * 1024) {
    respond(false, 'File too large (max 2MB).');
}
$uploadDir = __DIR__ . '/../../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
$filename = uniqid('resume_', true) . '.' . $ext;
$dest = $uploadDir . $filename;
if (!move_uploaded_file($resume['tmp_name'], $dest)) {
    respond(false, 'Failed to save resume.');
}
$resumePath = 'uploads/' . $filename;

// Insert into DB
try {
    $stmt = $pdo->prepare('INSERT INTO job_applications (job_title, name, email, phone, cover_letter, resume_path, applied_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
    $stmt->execute([$job_title, $name, $email, $phone, $cover, $resumePath]);
    respond(true, 'Application submitted.');
} catch (Exception $e) {
    respond(false, 'Database error.');
}
