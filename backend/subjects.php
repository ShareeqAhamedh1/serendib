<?php
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/helpers.php';

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

/* ===============================
   CSRF CHECK
================================ */
// if($_SERVER['REQUEST_METHOD'] === 'POST'){

//     if(
//         !isset($_POST['_token']) ||
//         !hash_equals($_SESSION['_token'], $_POST['_token'])
//     ){
//         die("Invalid CSRF Token");
//     }
// }

/* ===============================
   ACTION
================================ */
$action = $_GET['action'] ?? '';

/* =====================================================
   CREATE SUBJECT
===================================================== */
if($action === 'create'){

    $subject_name = trim($_POST['subject_name'] ?? '');
/* AUTO SUBJECT CODE */

$subject_code = '001';

$codeRes = $conn->query("
    SELECT subject_code
    FROM subjects
    ORDER BY id DESC
    LIMIT 1
");

if($codeRes && $codeRes->num_rows){

    $lastCode = $codeRes->fetch_assoc()['subject_code'];

    $subject_code = str_pad(
        ((int)$lastCode + 1),
        3,
        '0',
        STR_PAD_LEFT
    );
}
    $subject_type = trim($_POST['subject_type'] ?? 'Normal');

    $basket_group = null;

    /* basket only for group subjects */
    if($subject_type === 'Group Subject'){

        $basket_group = trim($_POST['basket_group'] ?? '');

        if(!in_array($basket_group, ['G1','G2','G3'])){
            $basket_group = null;
        }
    }

    /* validation */
    if($subject_name === ''){

        header("Location: ../admin/add-subject.php?error=1");
        exit;
    }

    /* duplicate check */
$check = $conn->prepare("
    SELECT id
    FROM subjects
    WHERE subject_name = ?
    AND subject_type = ?
    LIMIT 1
");

$check->bind_param(
    "ss",
    $subject_name,
    $subject_type
);
    $check->execute();

    if($check->get_result()->num_rows > 0){

        header("Location: ../admin/add-subject.php?exists=1");
        exit;
    }

    /* insert */
    $stmt = $conn->prepare("
        INSERT INTO subjects
        (
            subject_name,
            subject_code,
            subject_type,
            basket_group
        )
        VALUES (?,?,?,?)
    ");

    $stmt->bind_param(
        "ssss",
        $subject_name,
        $subject_code,
        $subject_type,
        $basket_group
    );

    $stmt->execute();

    header("Location: ../admin/subjects.php?created=1");
    exit;
}

/* =====================================================
   UPDATE SUBJECT
===================================================== */
if($action === 'update'){

    $id           = (int)($_POST['id'] ?? 0);
    $subject_name = trim($_POST['subject_name'] ?? '');
/* KEEP EXISTING CODE */

$getCode = $conn->prepare("
    SELECT subject_code
    FROM subjects
    WHERE id = ?
");

$getCode->bind_param("i", $id);
$getCode->execute();

$subject_code = $getCode
    ->get_result()
    ->fetch_assoc()['subject_code'] ?? '001';
    $subject_type = trim($_POST['subject_type'] ?? 'Normal');

    $basket_group = null;

    if($subject_type === 'Group Subject'){

        $basket_group = trim($_POST['basket_group'] ?? '');

        if(!in_array($basket_group, ['G1','G2','G3'])){
            $basket_group = null;
        }
    }

    if(!$id || $subject_name === ''){

        header("Location: ../admin/subjects.php?error=1");
        exit;
    }

    /* duplicate check excluding current */
$check = $conn->prepare("
    SELECT id
    FROM subjects
    WHERE subject_name = ?
    AND subject_type = ?
    AND id != ?
    LIMIT 1
");

$check->bind_param(
    "ssi",
    $subject_name,
    $subject_type,
    $id
);
    $check->execute();

    if($check->get_result()->num_rows > 0){

        header("Location: ../admin/add-subject.php?id=$id&exists=1");
        exit;
    }

    /* update */
    $stmt = $conn->prepare("
        UPDATE subjects
        SET
            subject_name = ?,
            subject_code = ?,
            subject_type = ?,
            basket_group = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssssi",
        $subject_name,
        $subject_code,
        $subject_type,
        $basket_group,
        $id
    );

    $stmt->execute();

    header("Location: ../admin/subjects.php?updated=1");
    exit;
}

/* =====================================================
   DELETE SUBJECT
===================================================== */
if($action === 'delete'){

    $id = (int)($_GET['id'] ?? 0);

    if(!$id){

        header("Location: ../admin/subjects.php");
        exit;
    }

    /* =====================================
       CHECK TIMETABLE
    ===================================== */
    $check = $conn->prepare("
        SELECT id
        FROM timetable
        WHERE subject_id = ?
        LIMIT 1
    ");

    $check->bind_param("i", $id);
    $check->execute();

    if($check->get_result()->num_rows > 0){

        header("Location: ../admin/subjects.php?inuse=timetable");
        exit;
    }

    /* =====================================
       CHECK HOMEWORKS
    ===================================== */
    $check = $conn->prepare("
        SELECT id
        FROM homeworks
        WHERE subject_id = ?
        LIMIT 1
    ");

    $check->bind_param("i", $id);
    $check->execute();

    if($check->get_result()->num_rows > 0){

        header("Location: ../admin/subjects.php?inuse=homeworks");
        exit;
    }

    /* =====================================
       CHECK NOTES
    ===================================== */
    $check = $conn->prepare("
        SELECT id
        FROM subject_notes
        WHERE subject_id = ?
        LIMIT 1
    ");

    $check->bind_param("i", $id);
    $check->execute();

    if($check->get_result()->num_rows > 0){

        header("Location: ../admin/subjects.php?inuse=notes");
        exit;
    }

    /* =====================================
       CHECK EXAM SUBJECTS
    ===================================== */
    $check = $conn->prepare("
        SELECT id
        FROM exam_subjects
        WHERE subject_id = ?
        LIMIT 1
    ");

    $check->bind_param("i", $id);
    $check->execute();

    if($check->get_result()->num_rows > 0){

        header("Location: ../admin/subjects.php?inuse=examsubjects");
        exit;
    }

    /* =====================================
       CHECK EXAM MARKS
    ===================================== */
    $check = $conn->prepare("
        SELECT id
        FROM exam_marks
        WHERE subject_id = ?
        LIMIT 1
    ");

    $check->bind_param("i", $id);
    $check->execute();

    if($check->get_result()->num_rows > 0){

        header("Location: ../admin/subjects.php?inuse=exammarks");
        exit;
    }

    /* =====================================
       SAFE DELETE
    ===================================== */
    $stmt = $conn->prepare("
        DELETE FROM subjects
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ../admin/subjects.php?deleted=1");
    exit;
}
/* ===============================
   INVALID ACTION
================================ */
header("Location: ../admin/subjects.php");
exit;
?>