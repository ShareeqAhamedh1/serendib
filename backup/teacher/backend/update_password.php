<?php
require_once '../../backend/conn.php';   // ✅ goes OUT of teacher/ then into backend/
require_once '../../backend/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../profile.php?pwd=fail");
    exit;
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    header("Location: ../profile.php?pwd=fail");
    exit;
}

$user_id = (int)($_POST['user_id'] ?? 0);
$current = $_POST['current_password'] ?? '';
$new      = $_POST['new_password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

if ($new !== $confirm) {
    header("Location: ../profile.php?pwd=fail");
    exit;
}

// ✅ Fetch user password
$stmt = $conn->prepare("SELECT password FROM users WHERE id=? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || !password_verify($current, $user['password'])) {
    header("Location: ../profile.php?pwd=fail");
    exit;
}

// ✅ Update password
$newHash = password_hash($new, PASSWORD_DEFAULT);
$up = $conn->prepare("UPDATE users SET password=? WHERE id=?");
$up->bind_param("si", $newHash, $user_id);
$up->execute();

// ✅ Logout immediately
session_destroy();

header("Location: ../../login.php?password_changed=1");
exit;
