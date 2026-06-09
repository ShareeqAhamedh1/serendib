<?php
require 'conn.php';
header('Content-Type: application/json');

$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;

if (!$class_id) {
  echo json_encode([]);
  exit;
}

$stmt = $conn->prepare("SELECT id, section_name FROM sections WHERE class_id = ? ORDER BY section_name");
$stmt->bind_param("i", $class_id);
$stmt->execute();
$res = $stmt->get_result();

$sections = [];
while ($row = $res->fetch_assoc()) {
  $sections[] = $row;
}

echo json_encode($sections);
