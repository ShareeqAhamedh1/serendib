<?php

session_start();

require_once 'conn.php';

$id = (int)($_GET['id'] ?? 0);

if(!$id){
    header('Location: ../admin/student-of-the-week.php');
    exit;
}

/* Get image */
$stmt = $conn->prepare("
    SELECT image
    FROM student_of_the_week
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$row = $stmt->get_result()->fetch_assoc();

if($row){

    if(
        !empty($row['image']) &&
        file_exists(
            "../uploads/student-of-the-week/" .
            $row['image']
        )
    ){
        unlink(
            "../uploads/student-of-the-week/" .
            $row['image']
        );
    }
}

/* Delete record */
$stmt = $conn->prepare("
    DELETE FROM student_of_the_week
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

header(
    'Location: ../admin/student-of-the-week.php?deleted=1'
);
exit;