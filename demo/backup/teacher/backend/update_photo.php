<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['csrf_token'] ?? '')){
  header('Location: ../teacher/profile.php?photo=fail'); exit;
}

$teacher_id = (int)($_POST['teacher_id'] ?? 0);
if($teacher_id <= 0){ header('Location: ../teacher/profile.php?photo=fail'); exit; }

function upload_photo($field='photo'){
  if(!isset($_FILES[$field]) || $_FILES[$field]['error'] == UPLOAD_ERR_NO_FILE) return null;
  if($_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;

  $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
  $allowed = ['jpg','jpeg','png','gif'];
  if(!in_array($ext, $allowed)) return null;

  $dir = __DIR__ . '/../../uploads/';
  if(!is_dir($dir)) mkdir($dir,0755,true);

  $name = uniqid('teacher_', true).'.'.$ext;
  $ok = move_uploaded_file($_FILES[$field]['tmp_name'], $dir.$name);
  return $ok ? $name : null;
}

$photo = upload_photo('photo');
if(!$photo){ header('Location: ../profile.php?photo=fail'); exit; }

$upd = $conn->prepare("UPDATE teachers SET photo=? WHERE id=?");
$upd->bind_param("si", $photo, $teacher_id);
$upd->execute();

header('Location: ../profile.php?photo=ok'); exit;
