<?php
require 'conn.php';
require 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    die("CSRF failed");
}

$teacher_id = (int)($_POST['teacher_id'] ?? 0);
$assign = $_POST['assign'] ?? [];

if ($teacher_id <= 0) {
    die("Invalid teacher ID");
}

// Delete old assignments
$conn->query("DELETE FROM teacher_classes WHERE teacher_id = $teacher_id");

// Insert new ones
$stmt = $conn->prepare("
    INSERT INTO teacher_classes (teacher_id, class_id, section_id)
    VALUES (?, ?, ?)
");

foreach ($assign as $a) {
    list($class_id, $section_id) = explode('_', $a);
    $class_id = (int)$class_id;
    $section_id = (int)$section_id;

    $stmt->bind_param("iii", $teacher_id, $class_id, $section_id);
    $stmt->execute();
}

header("Location: ../admin/assign-teacher-classes.php?id=$teacher_id&saved=1");
exit;
