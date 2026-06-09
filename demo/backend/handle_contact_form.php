<?php
// ALWAYS JSON
header('Content-Type: application/json');

// TEMP DEBUG (remove after success)
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/helpers.php';

// ✅ IMPORTANT: correct path to vendor
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {

    // Only POST allowed
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Sanitize
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $subject   = trim($_POST['subject'] ?? '');
    $message   = trim($_POST['message'] ?? '');

    // Validate
    if (
        $firstName === '' ||
        $lastName === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        $subject === '' ||
        $message === ''
    ) {
        throw new Exception('Please fill all required fields');
    }

    // ------------------------
    // SEND EMAIL TO SCHOOL
    // ------------------------
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contact@serendib.edu.lk';
    $mail->Password   = 'u@PP7j@is65'; // 🔐 move to config later
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('contact@serendib.edu.lk', 'Serendib International School');
    $mail->addAddress('contact@serendib.edu.lk', 'School Office');

    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Message';

    $mail->Body = "
        <h3>New Contact Message</h3>
        <table cellpadding='6' cellspacing='0' border='1' width='100%'>
            <tr><td><b>Name</b></td><td>{$firstName} {$lastName}</td></tr>
            <tr><td><b>Email</b></td><td>{$email}</td></tr>
            <tr><td><b>Phone</b></td><td>" . ($phone ?: 'N/A') . "</td></tr>
            <tr><td><b>Subject</b></td><td>{$subject}</td></tr>
            <tr><td><b>Message</b></td><td>{$message}</td></tr>
        </table>
    ";

    $mail->send();

    // ------------------------
    // AUTO-REPLY TO USER
    // ------------------------
    $reply = new PHPMailer(true);
    $reply->isSMTP();
    $reply->Host       = 'smtp.hostinger.com';
    $reply->SMTPAuth   = true;
    $reply->Username   = 'contact@serendib.edu.lk';
    $reply->Password   = 'u@PP7j@is65';
    $reply->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $reply->Port       = 465;

    $reply->setFrom('contact@serendib.edu.lk', 'Serendib International School');
    $reply->addAddress($email, $firstName);

    $reply->isHTML(true);
    $reply->Subject = 'We received your message';

    $reply->Body = "
        <p>Dear {$firstName},</p>
        <p>Thank you for contacting <b>Serendib International School</b>.</p>
        <p>We have received your message and our team will respond shortly.</p>
        <br>
        <p>Warm regards,<br>
        Serendib International School</p>
    ";

    $reply->send();

    // ✅ SUCCESS RESPONSE
    echo json_encode([
        'ok' => true,
        'msg' => 'Message sent successfully'
    ]);
    exit;

} catch (Throwable $e) {

    // 🔴 LOG SERVER ERROR
    error_log('Contact form error: ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'msg' => 'Server error: ' . $e->getMessage()
    ]);
    exit;
}
