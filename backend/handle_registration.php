<?php
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 0);
error_reporting(E_ALL);

/* =========================
   REQUEST CHECK
========================= */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'register.php');
    exit;
}

/* =========================
   CSRF VALIDATION
========================= */
if (function_exists('verify_csrf') && 
    !verify_csrf($_POST['csrf_token'] ?? '')
) {
    header('Location: ' . BASE_URL . 'register.php?ok=0');
    exit;
}

/* =========================
   SANITIZE INPUT
========================= */

$full_name       = trim($_POST['full_name'] ?? '');
$dob             = $_POST['dob'] ?? null;
$gender          = $_POST['gender'] ?? '';
$joining_grade   = trim($_POST['joining_grade'] ?? '');
$medium          = trim($_POST['medium'] ?? '');
$parent_name     = trim($_POST['parent_name'] ?? '');
$parent_email    = trim($_POST['parent_email'] ?? '');
$parent_phone    = trim($_POST['parent_phone'] ?? '');
$previous_school = trim($_POST['previous_school'] ?? '');
$address         = trim($_POST['address'] ?? '');
$remarks         = trim($_POST['remarks'] ?? '');

/* =========================
   VALIDATION
========================= */

// Allowed grades / streams
$allowed_grades = [
    '6','7','8','9','10','11',
    '2028_physical_science',
    '2028_biological_science',
    '2028_commerce',
    '2028_arts'
];

if (
    empty($full_name) ||
    empty($dob) ||
    empty($gender) ||
    empty($joining_grade) ||
    empty($medium) ||
    empty($parent_name) ||
    empty($parent_phone) ||
    empty($address) ||
    !in_array($joining_grade, $allowed_grades)
) {
    header('Location: ' . BASE_URL . 'register.php?ok=0');
    exit;
}

// Validate email if provided
if (!empty($parent_email) && 
    !filter_var($parent_email, FILTER_VALIDATE_EMAIL)
) {
    header('Location: ' . BASE_URL . 'register.php?ok=0');
    exit;
}

/* =========================
   INSERT INTO DATABASE
========================= */

$stmt = $conn->prepare("
    INSERT INTO registrations 
    (full_name, dob, gender, joining_grade, medium, parent_name, parent_email, parent_phone, previous_school, address, remarks, status, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', NOW())
");

$stmt->bind_param(
    'sssssssssss',
    $full_name,
    $dob,
    $gender,
    $joining_grade,
    $medium,
    $parent_name,
    $parent_email,
    $parent_phone,
    $previous_school,
    $address,
    $remarks
);

$ok = $stmt->execute();

if (!$ok) {
    header('Location: ' . BASE_URL . 'register.php?ok=0');
    exit;
}

/* =========================
   EMAIL FUNCTION
========================= */

function sendMail($to, $toName, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact@serendib.edu.lk';
        $mail->Password   = 'u@PP7j@is65'; // move to .env later
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('contact@serendib.edu.lk', 'Serendib High School');
        $mail->addAddress($to, $toName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Mail failed ({$to}): " . $mail->ErrorInfo);
        return false;
    }
}

/* =========================
   EMAIL CONTENT
========================= */

$emailBody = "
<p>A new student registration has been received.</p>

<ul>
  <li><b>Student Name:</b> {$full_name}</li>
  <li><b>Grade / Stream:</b> {$joining_grade}</li>
  <li><b>Medium:</b> {$medium}</li>
  <li><b>Parent Name:</b> {$parent_name}</li>
  <li><b>Parent Phone:</b> {$parent_phone}</li>
</ul>

<p>Please login to the admin panel to review.</p>
";

/* =========================
   SEND EMAILS
========================= */

// Always notify school
sendMail(
    'contact@serendib.edu.lk',
    'Admissions Team',
    'New Student Registration Received',
    $emailBody
);

// Notify parent if email valid
if (!empty($parent_email)) {

    sendMail(
        $parent_email,
        $parent_name ?: 'Parent',
        'Registration Received – Serendib High School',
        "
        <p>Dear {$parent_name},</p>
        <p>Thank you for registering <b>{$full_name}</b>.</p>
        <p>We have received your application and will contact you soon.</p>
        <br>
        <p>Regards,<br>Admissions Team</p>
        "
    );
}

/* =========================
   SUCCESS REDIRECT
========================= */

header('Location: ' . BASE_URL . 'register.php?ok=1');
exit;