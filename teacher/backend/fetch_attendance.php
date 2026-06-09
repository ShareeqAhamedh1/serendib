<?php
require '../../backend/conn.php';

$user_id = $_SESSION['user_id'];

// Get assigned class
$assign = $conn->query("
    SELECT class_id, section_id 
    FROM teacher_classes 
    WHERE teacher_id = (SELECT id FROM teachers WHERE user_id=$user_id)
")->fetch_assoc();

$class_id = $assign['class_id'];
$section_id = $assign['section_id'];

$date = $_GET['date'];

$q = $conn->query("
    SELECT student_id
    FROM attendance
    WHERE entity_type='student'
      AND date='$date'
      AND student_id IN (
          SELECT id FROM students 
          WHERE class_id=$class_id AND section_id=$section_id
      )
");

$data = [];
while($r = $q->fetch_assoc()){
    $data[] = $r;
}

echo json_encode($data);
