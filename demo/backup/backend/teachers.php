<?php
require 'conn.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
  header('HTTP/1.1 401 Unauthorized');
  exit;
}

$action = $_GET['action'] ?? '';

/* -----------------------------
   FILE UPLOAD
----------------------------- */
function handle_photo_upload($field = 'photo') {
  $dir = __DIR__ . '/../uploads/';
  if (!is_dir($dir)) mkdir($dir, 0755, true);

  if (!isset($_FILES[$field]) || $_FILES[$field]['error'] == UPLOAD_ERR_NO_FILE)
      return null;

  $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
  if (!in_array($ext, ['jpg','jpeg','png','gif']))
      return null;

  $name = uniqid('teacher_', true) . '.' . $ext;
  if (!move_uploaded_file($_FILES[$field]['tmp_name'], $dir.$name)) {
    return null;
  }
  return $name;
}

/* -----------------------------
   ROLE HELPERS
----------------------------- */
function ensure_teacher_role_id(): int {
  global $conn;
  $res = $conn->query("SELECT id FROM roles WHERE name='teacher' LIMIT 1");
  if ($res && $res->num_rows > 0) {
    return (int)$res->fetch_assoc()['id'];
  }
  $conn->query("INSERT INTO roles (name, description) VALUES ('teacher','Teacher role')");
  return (int)$conn->insert_id;
}

/* -----------------------------
   USER HELPERS
----------------------------- */

/**
 * Create a teacher user with username = $teacher_code
 * Returns the user_id (int)
 */
function create_teacher_user(string $teacher_code, string $first, string $last, ?string $email): int {
  global $conn;
  $role_id   = ensure_teacher_role_id();
  $username  = $teacher_code; // ✅ username = teacher_code
  $full_name = trim("$first $last");
  $plain     = 'teacher123';
  $hash      = password_hash($plain, PASSWORD_DEFAULT);

  // Make sure username is unique; if taken, add suffix
  $base = $username;
  $i = 0;
  while (true) {
    $s = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
    if (!$s) break;
    $s->bind_param("s", $username);
    $s->execute();
    $r = $s->get_result();
    if (!$r || $r->num_rows === 0) break;
    $i++;
    $username = $base . $i;
  }

  $stmt = $conn->prepare("
    INSERT INTO users (role_id, username, password, full_name, email, status, created_at)
    VALUES (?, ?, ?, ?, ?, 'active', NOW())
  ");
  if (!$stmt) {
    throw new Exception("Create user failed: " . $conn->error);
  }
  $stmt->bind_param("issss", $role_id, $username, $hash, $full_name, $email);
  $stmt->execute();
  return (int)$stmt->insert_id;
}

/**
 * Update a teacher's linked user account to keep it in sync
 * - username := teacher_code
 * - email, full_name
 * - status: maps teacher status -> users.status
 */
function sync_user_with_teacher(int $user_id, string $teacher_code, string $first, string $last, ?string $email, string $teacher_status): void {
  global $conn;

  // Map teacher status to users.status
  $t = strtolower($teacher_status);
  $user_status = ($t === 'inactive' || $t === 'left') ? 'inactive' : 'active';

  // If another user already uses this username (teacher_code), add a suffix
  $desired_username = $teacher_code;
  $username = $desired_username;
  $base = $username;
  $i = 0;

  // Check if the desired username is used by a different user
  $chk = $conn->prepare("SELECT id FROM users WHERE username=? AND id<>? LIMIT 1");
  if ($chk) {
    while (true) {
      $chk->bind_param("si", $username, $user_id);
      $chk->execute();
      $row = $chk->get_result();
      if (!$row || $row->num_rows === 0) break;
      $i++;
      $username = $base . $i;
    }
  }

  $full_name = trim("$first $last");

  $stmt = $conn->prepare("UPDATE users SET username=?, email=?, full_name=?, status=? WHERE id=?");
  if ($stmt) {
    $stmt->bind_param("ssssi", $username, $email, $full_name, $user_status, $user_id);
    $stmt->execute();
  }
}

/* -----------------------------
   CREATE TEACHER
----------------------------- */
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $teacher_code = trim($_POST['teacher_code'] ?? '');
  $first        = trim($_POST['first_name']);
  $last         = trim($_POST['last_name']);
  $gender       = $_POST['gender'];
  $email        = trim($_POST['email']);
  $phone        = trim($_POST['phone']);
  $subject_id   = !empty($_POST['subject_id']) ? (int)$_POST['subject_id'] : null;
  // normalize to lowercase for consistency in DB (you can switch to Title Case if you prefer)
  $status       = strtolower($_POST['status'] ?? 'active'); // 'active' | 'inactive' | 'left'
  $photo        = handle_photo_upload('photo');

  // Auto-generate teacher code if empty
  if ($teacher_code === '') {
    $row = $conn->query("SELECT MAX(id) AS max_id FROM teachers")->fetch_assoc();
    $next = (int)($row['max_id'] ?? 0) + 1;
    $teacher_code = 'T' . str_pad($next, 3, '0', STR_PAD_LEFT);
  }

  // Create linked user with username=teacher_code
  try {
    $user_id = create_teacher_user($teacher_code, $first, $last, $email);
  } catch (Exception $e) {
    die('Failed to create user: ' . $e->getMessage());
  }

  $stmt = $conn->prepare("
    INSERT INTO teachers 
    (teacher_code, user_id, first_name, last_name, gender, email, phone, subject_id, photo, join_date, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
  ");
  if (!$stmt) {
    die('Prepare failed (create teacher): ' . $conn->error);
  }

  // s i s s s s s i s s
  $stmt->bind_param(
    "sissssssis",
    $teacher_code, $user_id, $first, $last, $gender,
    $email, $phone, $subject_id, $photo, $status
  );
  $stmt->execute();

  // Make sure user status matches teacher status
  sync_user_with_teacher($user_id, $teacher_code, $first, $last, $email, $status);

  header('Location: ' . BASE_URL . 'admin/teachers.php?created=1');
  exit;
}

/* -----------------------------
   UPDATE TEACHER
----------------------------- */
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $id           = (int)$_POST['id'];
  $teacher_code = trim($_POST['teacher_code']);
  $first        = trim($_POST['first_name']);
  $last         = trim($_POST['last_name']);
  $gender       = $_POST['gender'];
  $email        = trim($_POST['email']);
  $phone        = trim($_POST['phone']);
  $subject_id   = !empty($_POST['subject_id']) ? (int)$_POST['subject_id'] : null;
  $status       = strtolower($_POST['status'] ?? 'active'); // 'active' | 'inactive' | 'left'
  $photo        = handle_photo_upload('photo');

  // Get user_id linked to this teacher
  $u = $conn->prepare("SELECT user_id FROM teachers WHERE id=? LIMIT 1");
  $u->bind_param("i", $id);
  $u->execute();
  $resUser = $u->get_result();
  $user_id = 0;
  if ($resUser && $row = $resUser->fetch_assoc()) {
    $user_id = (int)$row['user_id'];
  }

  if ($photo) {
    $stmt = $conn->prepare("
      UPDATE teachers 
      SET teacher_code=?, first_name=?, last_name=?, gender=?, email=?, phone=?, subject_id=?, status=?, photo=?
      WHERE id=?
    ");
    if (!$stmt) die('Prepare failed (update with photo): ' . $conn->error);

    // s s s s s s i s s i
    $stmt->bind_param(
      "ssssssissi",
      $teacher_code, $first, $last, $gender, $email, $phone, $subject_id, $status, $photo, $id
    );
  } else {
    $stmt = $conn->prepare("
      UPDATE teachers 
      SET teacher_code=?, first_name=?, last_name=?, gender=?, email=?, phone=?, subject_id=?, status=?
      WHERE id=?
    ");
    if (!$stmt) die('Prepare failed (update no photo): ' . $conn->error);

    // s s s s s s i s i
    $stmt->bind_param(
      "ssssssisi",
      $teacher_code, $first, $last, $gender, $email, $phone, $subject_id, $status, $id
    );
  }

  $stmt->execute();

  // Keep user record in sync (username/email/full_name/status)
  if ($user_id > 0) {
    sync_user_with_teacher($user_id, $teacher_code, $first, $last, $email, $status);
  }

  header('Location: ' . BASE_URL . 'admin/teachers.php?updated=1');
  exit;
}

/* -----------------------------
   DELETE TEACHER
----------------------------- */
if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];

  // (Optional) also deactivate user on delete to avoid orphaned login
  $u = $conn->prepare("SELECT user_id FROM teachers WHERE id=? LIMIT 1");
  $u->bind_param("i", $id);
  $u->execute();
  $resU = $u->get_result();
  if ($resU && ($row = $resU->fetch_assoc())) {
    $uid = (int)$row['user_id'];
    if ($uid > 0) {
      $uu = $conn->prepare("UPDATE users SET status='inactive' WHERE id=?");
      $uu->bind_param("i", $uid);
      $uu->execute();
    }
  }

  $stmt = $conn->prepare("DELETE FROM teachers WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  header('Location: ' . BASE_URL . 'admin/teachers.php?deleted=1');
  exit;
}
