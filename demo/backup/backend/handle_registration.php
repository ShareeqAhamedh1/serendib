<?php
// backend/handle_registration.php
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'serendib_highschool/Register.php');
    exit;
}

// optional CSRF check
if (function_exists('verify_csrf') && !verify_csrf($_POST['csrf_token'] ?? '')) {
    header('Location: ' . BASE_URL . 'serendib_highschool/Register.php?ok=0');
    exit;
}

// sanitize + fetch
$full_name = trim($_POST['full_name'] ?? '');
$dob = $_POST['dob'] ?? null;
$gender = in_array($_POST['gender'] ?? 'male',['male','female','other']) ? $_POST['gender'] : 'male';
$joining_grade = (int)($_POST['joining_grade'] ?? 0);
$medium = trim($_POST['medium'] ?? '');
$parent_name = trim($_POST['parent_name'] ?? '');
$parent_email = trim($_POST['parent_email'] ?? '');
$parent_phone = trim($_POST['parent_phone'] ?? '');
$previous_school = trim($_POST['previous_school'] ?? '');
$address = trim($_POST['address'] ?? '');
$remarks = trim($_POST['remarks'] ?? '');

if ($full_name === '' || $joining_grade < 6 || $joining_grade > 11) {
    header('Location: ' . BASE_URL . 'serendib_highschool/Register.php?ok=0');
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO registrations 
    (full_name, dob, gender, joining_grade, medium, parent_name, parent_email, parent_phone, previous_school, address, remarks, status, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', NOW())
");
$stmt->bind_param(
    'sssiissssss',
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

header('Location: ' . BASE_URL . 'Register.php?ok=' . ($ok ? '1' : '0'));
exit;
