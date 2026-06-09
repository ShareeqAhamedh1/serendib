<?php
require 'conn.php';
header('Content-Type: application/json');

$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
$section_id = isset($_GET['section_id']) ? (int)$_GET['section_id'] : 0;

if (!$class_id || !$section_id) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT id, admission_no, first_name, last_name FROM students WHERE class_id=? AND section_id=? ORDER BY first_name");
$stmt->bind_param("ii", $class_id, $section_id);
$stmt->execute();
$res = $stmt->get_result();
$out = [];
while ($r = $res->fetch_assoc()) {
    $out[] = $r;
}
echo json_encode($out);
