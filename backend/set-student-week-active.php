<?php

session_start();

require_once 'conn.php';

$id = (int)($_GET['id'] ?? 0);

if(!$id){
    header('Location: ../admin/student-of-the-week.php');
    exit;
}

/* Deactivate all */
$conn->query("
    UPDATE student_of_the_week
    SET is_active = 0
");

/* Activate selected */
$stmt = $conn->prepare("
    UPDATE student_of_the_week
    SET is_active = 1
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

header(
    'Location: ../admin/student-of-the-week.php?activated=1'
);
exit;