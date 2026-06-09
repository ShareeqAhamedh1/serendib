<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../marks.php?error=Invalid+Request");
    exit;
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    header("Location: ../marks.php?error=CSRF+Failed");
    exit;
}

$exam_id    = (int)$_POST['exam_id'];
$class_id   = (int)$_POST['class_id'];
$section_id = (int)$_POST['section_id'];
$marks      = $_POST['marks'] ?? [];

if (empty($marks)) {
    header("Location: ../enter-marks.php?exam_id=$exam_id&error=No+Marks");
    exit;
}

// For a single subject only
$subject_id = (int)$_POST['subject_id'] ?? (int)$_GET['subject_id'] ?? 0;

// Load max and pass marks
$sq = $conn->query("
    SELECT max_marks, pass_marks
    FROM exam_subjects
    WHERE exam_id=$exam_id AND class_id=$class_id AND subject_id=$subject_id
");
$ss = $sq->fetch_assoc();

$max  = $ss['max_marks'];
$pass = $ss['pass_marks'];

// Helper: grade calculator
function calcGrade($m, $max) {
    if ($m >= 0.85*$max) return "A";
    if ($m >= 0.70*$max) return "B";
    if ($m >= 0.55*$max) return "C";
    if ($m >= 0.40*$max) return "D";
    return "E";
}

$conn->begin_transaction();

try {

    foreach ($marks as $stu_id => $value) {

        $stu_id = (int)$stu_id;
        $value  = trim($value);

        if ($value === "" || !is_numeric($value)) continue;

        $value = (int)$value;
        if ($value < 0) $value = 0;
        if ($value > $max) $value = $max;

        $grade  = calcGrade($value, $max);
        $status = $value >= $pass ? "pass" : "fail";

        // Check if mark exists
        $chk = $conn->query("
            SELECT id FROM exam_marks
            WHERE exam_id=$exam_id 
            AND subject_id=$subject_id
            AND student_id=$stu_id
        ");

        if ($chk->num_rows > 0) {
            // UPDATE
            $id = $chk->fetch_assoc()['id'];
            $conn->query("
                UPDATE exam_marks
                SET marks_obtained=$value,
                    grade='$grade',
                    status='$status',
                    updated_at=NOW()
                WHERE id=$id
            ");
        } else {
            // INSERT
            $conn->query("
                INSERT INTO exam_marks
                (exam_id, class_id, section_id, student_id, subject_id, marks_obtained, grade, status, created_at)
                VALUES
                ($exam_id, $class_id, $section_id, $stu_id, $subject_id, $value, '$grade', '$status', NOW())
            ");
        }
    }

    $conn->commit();
    header("Location: ../enter-marks.php?exam_id=$exam_id&success=1");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    header("Location: ../enter-marks.php?exam_id=$exam_id&error=Save+Failed");
    exit;
}
