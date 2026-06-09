<?php
require 'conn.php';

header('Content-Type: application/json');

$day        = $_GET['day'] ?? '';
$teacher_id = (int)($_GET['teacher_id'] ?? 0);
$class_id   = (int)($_GET['class_id'] ?? 0);
$section_id = (int)($_GET['section_id'] ?? 0);
$subject_id = (int)($_GET['subject_id'] ?? 0);

$response = [
    'teacher_conflicts' => [],
    'class_conflicts'   => [],
    'basket_conflicts'  => []
];

/* =========================================
   VALIDATION
========================================= */
if(!$day || !$class_id){

    echo json_encode($response);
    exit;
}

/* =========================================
   GET CURRENT SUBJECT INFO
========================================= */
$currentBasket = null;
$currentType   = 'Normal';

if($subject_id){

    $stmt = $conn->prepare("
        SELECT
            subject_type,
            basket_group
        FROM subjects
        WHERE id = ?
    ");

    $stmt->bind_param("i", $subject_id);

    $stmt->execute();

    $sub = $stmt
        ->get_result()
        ->fetch_assoc();

    $currentType =
        $sub['subject_type'] ?? 'Normal';

    $currentBasket =
        $sub['basket_group'] ?? null;
}

/* =========================================
   TEACHER CONFLICTS
========================================= */
if($teacher_id){

    $stmt = $conn->prepare("
        SELECT DISTINCT period_number
        FROM timetable
        WHERE day_of_week = ?
        AND teacher_id = ?
    ");

    $stmt->bind_param(
        "si",
        $day,
        $teacher_id
    );

    $stmt->execute();

    $res = $stmt->get_result();

    while($r = $res->fetch_assoc()){

        $response['teacher_conflicts'][] =
            (int)$r['period_number'];
    }
}

/* =========================================
   CLASS / SUBJECT CONFLICTS
========================================= */
$stmt = $conn->prepare("
    SELECT
        t.period_number,
        s.subject_type,
        s.basket_group

    FROM timetable t

    JOIN subjects s
        ON s.id = t.subject_id

    WHERE t.day_of_week = ?
    AND t.class_id = ?
    AND (t.section_id <=> ?)
");

$stmt->bind_param(
    "sii",
    $day,
    $class_id,
    $section_id
);

$stmt->execute();

$res = $stmt->get_result();

while($r = $res->fetch_assoc()){

    $period =
        (int)$r['period_number'];

    $existingType =
        $r['subject_type'] ?? 'Normal';

    $existingBasket =
        $r['basket_group'] ?? null;

    /* =====================================
       GROUP SUBJECTS
    ===================================== */
    if($currentType === 'Group Subject'){

        /*
           allow ONLY SAME basket
        */

        $sameBasket =
            $existingType === 'Group Subject'
            &&
            $existingBasket
            &&
            $existingBasket === $currentBasket;

        if(!$sameBasket){

            $response['basket_conflicts'][] =
                $period;
        }
    }

    /* =====================================
       FIRST LANGUAGE
    ===================================== */
    elseif($currentType === 'First Language'){

        /*
           allow ONLY First Language
        */

        if($existingType !== 'First Language'){

            $response['basket_conflicts'][] =
                $period;
        }
    }

    /* =====================================
       SECOND LANGUAGE
    ===================================== */
    elseif($currentType === 'Second Language'){

        /*
           allow ONLY Second Language
        */

        if($existingType !== 'Second Language'){

            $response['basket_conflicts'][] =
                $period;
        }
    }

    /* =====================================
       NORMAL SUBJECTS
    ===================================== */
    else{

        /*
           normal subjects
           cannot overlap anything
        */

        $response['class_conflicts'][] =
            $period;
    }
}

echo json_encode($response);