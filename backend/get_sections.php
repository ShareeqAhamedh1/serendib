<?php
require 'conn.php';

$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;

$stmt = $conn->prepare("SELECT id, section_name FROM sections WHERE class_id = ?");
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();

$sections = [];
while ($row = $result->fetch_assoc()) {
    $sections[] = $row;
}

header('Content-Type: application/json');
echo json_encode($sections);
