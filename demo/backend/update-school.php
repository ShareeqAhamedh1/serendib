<?php
require_once 'conn.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data['student_id']);
$value = intval($data['value']);

$stmt = $conn->prepare("UPDATE students SET isSchool=? WHERE id=?");
$stmt->bind_param("ii",$value,$id);
$stmt->execute();

echo json_encode(["success"=>true]);