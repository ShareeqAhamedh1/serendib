<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';


if (!isset($_SESSION['user_id'])) {
  header('Location: ' . BASE_URL . 'login.php');
  exit;
}

$action = $_GET['action'] ?? '';
$who    = $_POST['who'] ?? ''; // 'student' (can extend later for teacher/parent)

function redirect_with($ok = '', $err = '') {
  $dest = BASE_URL . 'student/profile.php';
  $qs = [];
  if ($ok)  $qs[] = 'ok=' . urlencode($ok);
  if ($err) $qs[] = 'err=' . urlencode($err);
  if ($qs) $dest .= '?' . implode('&', $qs);
  header("Location: $dest");
  exit;
}

// Simple photo upload helper (students)
function upload_photo($field = 'photo') {
  $dir = __DIR__ . '/../../uploads/';
  if (!is_dir($dir)) mkdir($dir, 0755, true);

  if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
  if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;

  $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
  $allowed = ['jpg','jpeg','png','gif'];
  if (!in_array($ext, $allowed)) return null;

  // size limit ~ 2MB
  if (!empty($_FILES[$field]['size']) && $_FILES[$field]['size'] > 2 * 1024 * 1024) return null;

  $name = uniqid('student_', true) . '.' . $ext;
  if (!move_uploaded_file($_FILES[$field]['tmp_name'], $dir . $name)) return null;

  return $name;
}

if ($action === 'change_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) redirect_with('', 'Security check failed.');

  $user_id = (int)($_SESSION['user_id'] ?? 0);
  $current = trim($_POST['current_password'] ?? '');
  $new     = trim($_POST['new_password'] ?? '');
  $confirm = trim($_POST['confirm_password'] ?? '');

  if ($new === '' || strlen($new) < 6) redirect_with('', 'New password must be at least 6 characters.');
  if ($new !== $confirm) redirect_with('', 'New password and confirmation do not match.');

  // fetch user hash
  $stmt = $conn->prepare("SELECT password FROM users WHERE id=? LIMIT 1");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $hashRow = $stmt->get_result()->fetch_assoc();
  if (!$hashRow) redirect_with('', 'User not found.');

  if (!password_verify($current, $hashRow['password'])) {
    redirect_with('', 'Current password is incorrect.');
  }

  $newHash = password_hash($new, PASSWORD_DEFAULT);
  $up = $conn->prepare("UPDATE users SET password=? WHERE id=?");
  $up->bind_param("si", $newHash, $user_id);
  $up->execute();

  redirect_with('Password updated successfully.', '');
}

if ($action === 'update_photo' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) redirect_with('', 'Security check failed.');

  $user_id = (int)($_SESSION['user_id'] ?? 0);
  // Only student path for now
  if ($who !== 'student') redirect_with('', 'Invalid request.');

  $newPhoto = upload_photo('photo');
  if (!$newPhoto) redirect_with('', 'Invalid or too large photo. Allowed: jpg, jpeg, png, gif (max ~2MB).');

  // fetch student by user
  $stmt = $conn->prepare("SELECT id, photo FROM students WHERE user_id=? LIMIT 1");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stu = $stmt->get_result()->fetch_assoc();
  if (!$stu) redirect_with('', 'Student record not found.');

  // Optionally delete old photo (skip if you want to keep files)
  // if (!empty($stu['photo'])) {
  //   $old = __DIR__ . '/../uploads/' . $stu['photo'];
  //   if (is_file($old)) @unlink($old);
  // }

  $up = $conn->prepare("UPDATE students SET photo=? WHERE id=?");
  $up->bind_param("si", $newPhoto, $stu['id']);
  $up->execute();

  redirect_with('Profile photo updated.', '');
}

redirect_with('', 'Invalid action.');
