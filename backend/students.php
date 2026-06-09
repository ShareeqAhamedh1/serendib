<?php 
require 'conn.php';
require 'helpers.php';

// Ensure logged in
if (!isset($_SESSION['user_id'])) {
  header('HTTP/1.1 401 Unauthorized');
  exit;
}

$action = $_GET['action'] ?? '';

/* -----------------------------------------------
   Helper: safe file upload
------------------------------------------------*/
function handle_photo_upload($fieldName = 'photo') {
  $uploadDir = __DIR__ . '/../uploads/';
  if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

  if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] == UPLOAD_ERR_NO_FILE) {
    return null;
  }

  $file = $_FILES[$fieldName];
  $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $allowed = ['jpg', 'jpeg', 'png', 'gif'];

  if (!in_array($ext, $allowed)) return null;

  $newName = uniqid('student_', true) . '.' . $ext;
  $dest = $uploadDir . $newName;
  if (!move_uploaded_file($file['tmp_name'], $dest)) return null;

  return $newName;
}

/* -----------------------------------------------
   Helper: Create student user account
------------------------------------------------*/
function create_student_user($admission_no, $first_name, $last_name, $email = null) {
  global $conn;

  // Ensure student role exists
  $r = $conn->query("SELECT id FROM roles WHERE name='student' LIMIT 1");
  if ($r && $r->num_rows) {
    $roleId = $r->fetch_assoc()['id'];
  } else {
    $conn->query("INSERT INTO roles (name, description) VALUES ('student','Student role')");
    $roleId = $conn->insert_id;
  }

  // Unique username
  $username = $admission_no ?: ('student' . time());
  $base = $username;
  $i = 0;
  while (true) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    if (!$stmt) break;
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows == 0) break;
    $i++;
    $username = $base . $i;
  }

  $plainPassword = 'student123';
  $hashed = password_hash($plainPassword, PASSWORD_DEFAULT);
  $fullName = trim("$first_name $last_name");

  $stmt = $conn->prepare("
    INSERT INTO users (role_id, username, password, full_name, email, status, created_at)
    VALUES (?, ?, ?, ?, ?, 'active', NOW())
  ");
  if (!$stmt) {
    throw new Exception("Create user prepare failed: " . $conn->error);
  }
  $stmt->bind_param("issss", $roleId, $username, $hashed, $fullName, $email);
  $stmt->execute();

  return ['user_id' => $stmt->insert_id, 'username' => $username, 'password' => $plainPassword];
}

/* -----------------------------------------------
   ACTION: Create Student
------------------------------------------------*/
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $ad            = trim($_POST['admission_no'] ?? '');
  $fn            = trim($_POST['first_name'] ?? '');
  $ln            = trim($_POST['last_name'] ?? '');
  $gender        = $_POST['gender'] ?? '';
  $dob           = $_POST['dob'] ?? null; // allow null/empty
  $medium        = $_POST['medium'] ?? null;
  $class_id      = !empty($_POST['class_id']) ? (int)$_POST['class_id'] : null;
  $section_id    = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : null;

  // Parent is managed via "Link Parent" page, ignore any posted parent_id here:
  $parent_id     = null;

  $address       = trim($_POST['address'] ?? '');
  $admission_date= $_POST['admission_date'] ?? date('Y-m-d');
  $status        = $_POST['status'] ?? 'active';

  $photoName     = handle_photo_upload('photo');

  // Auto-generate Admission No if empty or duplicate
  $dupCheck = $conn->prepare("SELECT 1 FROM students WHERE admission_no=? LIMIT 1");
  if ($dupCheck) {
    $dupCheck->bind_param("s", $ad);
    $dupCheck->execute();
    $dup = $dupCheck->get_result()->num_rows > 0;
  } else {
    $dup = false;
  }

  if ($ad === '' || $dup) {
    $res = $conn->query("SELECT MAX(id) AS max_id FROM students");
    $next = ($res && ($row=$res->fetch_assoc()) ? (int)$row['max_id'] : 0) + 1;
    $ad = 'S' . str_pad($next, 3, '0', STR_PAD_LEFT);
  }

  // Create linked user account
  try {
    $userInfo = create_student_user($ad, $fn, $ln);
  } catch (Exception $e) {
    die('Failed to create user account: ' . $e->getMessage());
  }
  $user_id = (int)$userInfo['user_id'];

  // Insert student (includes address, admission_date, status)
  $stmt = $conn->prepare("
    INSERT INTO students 
    (user_id, admission_no, first_name, last_name, gender, dob, class_id, section_id, medium, address, parent_id, photo, admission_date, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  ");
  if (!$stmt) {
    die('Prepare failed (create student): ' . $conn->error);
  }

  // Types: i s s s s s i i s s i s s s
  $stmt->bind_param(
    "isssssiississs",
    $user_id,       // i
    $ad,            // s
    $fn,            // s
    $ln,            // s
    $gender,        // s
    $dob,           // s
    $class_id,      // i
    $section_id,    // i
    $medium,        // s
    $address,       // s
    $parent_id,     // i (nullable)
    $photoName,     // s
    $admission_date,// s
    $status         // s
  );
  $stmt->execute();

  header('Location: ' . BASE_URL . 'admin/students.php?created=1');
  exit;
}

/* -----------------------------------------------
   ACTION: Update Student
------------------------------------------------*/
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $id            = (int)($_POST['id'] ?? 0);
  $ad            = trim($_POST['admission_no'] ?? '');
  $fn            = trim($_POST['first_name'] ?? '');
  $ln            = trim($_POST['last_name'] ?? '');
  $gender        = $_POST['gender'] ?? '';
  $dob           = $_POST['dob'] ?? null;
  $medium        = $_POST['medium'] ?? null;
  $class_id      = !empty($_POST['class_id']) ? (int)$_POST['class_id'] : null;
  $section_id    = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : null;
  $address       = trim($_POST['address'] ?? '');
  $admission_date= $_POST['admission_date'] ?? date('Y-m-d');
  $status        = $_POST['status'] ?? 'active';

  $photoName     = handle_photo_upload('photo');

  if ($photoName) {
    $stmt = $conn->prepare("
      UPDATE students 
      SET admission_no=?, first_name=?, last_name=?, gender=?, dob=?, class_id=?, section_id=?, medium=?, address=?, admission_date=?, status=?, photo=?
      WHERE id=?
    ");
    if (!$stmt) die('Prepare failed (update with photo): ' . $conn->error);

    // 5s + 2i + 5s + 1i  => "sssssiisssssi"
    $stmt->bind_param(
      "sssssiisssssi",
      $ad, $fn, $ln, $gender, $dob,
      $class_id, $section_id,
      $medium, $address, $admission_date, $status, $photoName,
      $id
    );
  } else {
    $stmt = $conn->prepare("
      UPDATE students 
      SET admission_no=?, first_name=?, last_name=?, gender=?, dob=?, class_id=?, section_id=?, medium=?, address=?, admission_date=?, status=?
      WHERE id=?
    ");
    if (!$stmt) die('Prepare failed (update no photo): ' . $conn->error);

    // 5s + 2i + 4s + 1i  => "sssssiissssi"
    $stmt->bind_param(
      "sssssiissssi",
      $ad, $fn, $ln, $gender, $dob,
      $class_id, $section_id,
      $medium, $address, $admission_date, $status,
      $id
    );
  }

  $stmt->execute();
  header('Location: ' . BASE_URL . 'admin/students.php?updated=1');
  exit;
}

/* -----------------------------------------------
   ACTION: Delete Student
------------------------------------------------*/
if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
  if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
  }
  header('Location: ' . BASE_URL . 'admin/students.php?deleted=1');
  exit;
}

/* -----------------------------------------------
   ACTION: Get Student (AJAX)
------------------------------------------------*/
if ($action === 'get' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
  if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $conn->error]);
    exit;
  }
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  header('Content-Type: application/json');
  echo json_encode($row);
  exit;
}
