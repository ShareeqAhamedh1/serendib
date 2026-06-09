<?php

session_start();

require_once 'conn.php';
require_once 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/student-of-the-week.php');
    exit;
}

/* ===============================
   FORM DATA
================================ */
$student_id     = (int)$_POST['student_id'];
$title          = trim($_POST['title']);
$description    = trim($_POST['description']);
$week_date      = $_POST['week_date'];
$points_awarded = (int)$_POST['points_awarded'];

$awarded_by = $_SESSION['user_id'] ?? null;

$image = null;

/* ===============================
   IMAGE UPLOAD
================================ */
if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === 0
) {

    $uploadDir = '../uploads/student-of-the-week/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = strtolower(
        pathinfo(
            $_FILES['image']['name'],
            PATHINFO_EXTENSION
        )
    );

    $image = 'sow_' .
             time() .
             '_' .
             uniqid() .
             '.' .
             $ext;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $uploadDir . $image
    );
}

/* ===============================
   ONLY ONE ACTIVE WINNER
================================ */
$conn->query("
    UPDATE student_of_the_week
    SET is_active = 0
");

/* ===============================
   SAVE WINNER
================================ */
$stmt = $conn->prepare("
    INSERT INTO student_of_the_week
    (
        student_id,
        title,
        description,
        image,
        week_date,
        points_awarded,
        awarded_by,
        is_active
    )
    VALUES
    (
        ?,?,?,?,?,?,?,1
    )
");

$stmt->bind_param(
    "issssis",
    $student_id,
    $title,
    $description,
    $image,
    $week_date,
    $points_awarded,
    $awarded_by
);

$stmt->execute();

$winner_id = $conn->insert_id;

/* ===============================
   HOUSE POINTS
================================ */
$house = $conn->query("
    SELECT house_id
    FROM house_members
    WHERE entity_type='student'
    AND entity_id = $student_id
    LIMIT 1
")->fetch_assoc();

if ($house) {

    $house_id = (int)$house['house_id'];

    $year = $conn->query("
        SELECT id
        FROM academic_years
        WHERE is_active = 1
        LIMIT 1
    ")->fetch_assoc();

    $academic_year_id =
        $year['id'] ?? 0;

$reason = "Student of the Week";
$source = "ADMIN";

$stmt = $conn->prepare("
    INSERT INTO house_point_logs
    (
        house_id,
        entity_type,
        entity_id,
        points,
        action,
        reason,
        source,
        academic_year_id
    )
    VALUES
    (
        ?,
        'student',
        ?,
        ?,
        'ADD',
        ?,
        ?,
        ?
    )
");

$stmt->bind_param(
    "iiissi",
    $house_id,
    $student_id,
    $points_awarded,
    $reason,
    $source,
    $academic_year_id
);

    $stmt->execute();
}

/* ===============================
   REDIRECT
================================ */
header(
    "Location: ../admin/student-of-the-week.php?success=1"
);

exit;