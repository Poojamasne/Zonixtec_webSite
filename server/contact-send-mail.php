<?php
// server/contact-send-mail.php
require_once '../config/cors.php';

header('Content-Type: application/json');

// Allow CORS if needed (uncomment if you want to allow cross-origin requests)
// header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = 'zonixtecitservices@gmail.com';
    $name = isset($_POST['name']) ? strip_tags($_POST['name']) : '';
    $email = isset($_POST['email']) ? strip_tags($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? strip_tags($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? strip_tags($_POST['subject']) : 'Contact Form Submission';
    $message = isset($_POST['message']) ? strip_tags($_POST['message']) : '';

    if (!$name || !$email || !$subject || !$message) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
        exit;
    }

    $email_subject = "[Contact Form] $subject";
    $email_body = "You have received a new message from the contact form on your website.\n\n" .
        "Name: $name\n" .
        "Email: $email\n" .
        "Phone: $phone\n" .
        "Subject: $subject\n" .
        "Message:\n$message\n";

    $headers = "From: $name <$email>\r\n" .
               "Reply-To: $email\r\n" .
               "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $email_subject, $email_body, $headers)) {
        // Redirect to thank you page if not AJAX
        if (!empty($_POST['redirect'])) {
            header('Location: ' . $_POST['redirect']);
            exit;
        }
        echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to send message.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
