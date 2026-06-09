<?php
require 'conn.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {

    header('HTTP/1.1 401 Unauthorized');

    exit;
}

$action = $_GET['action'] ?? '';

/* ============================================================
   CREATE NEW TIMETABLE ENTRY
============================================================ */
if (
    $action === 'create'
    &&
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    if (!verify_csrf($_POST['csrf_token'] ?? '')) {

        die('CSRF failed');
    }

    $class_id =
        (int)$_POST['class_id'];

    $section_id =
        !empty($_POST['section_id'])
        ? (int)$_POST['section_id']
        : null;

    $day_of_week =
        $_POST['day_of_week'];

    $subject_id =
        (int)$_POST['subject_id'];

    $teacher_id =
        (int)$_POST['teacher_id'];

    /* ======================================
       SUBJECT INFO
    ====================================== */
    $subStmt = $conn->prepare("
        SELECT
            subject_type,
            basket_group
        FROM subjects
        WHERE id = ?
    ");

    $subStmt->bind_param(
        "i",
        $subject_id
    );

    $subStmt->execute();

    $subject =
        $subStmt
        ->get_result()
        ->fetch_assoc();

    $subject_type =
        $subject['subject_type'] ?? 'Normal';

    $basket_group =
        $subject['basket_group'] ?? null;

    $periods =
        $_POST['period_number'] ?? [];

    $starts =
        $_POST['start_time'] ?? [];

    $ends =
        $_POST['end_time'] ?? [];

    if(empty($periods)){

        header(
            'Location: '
            . BASE_URL .
            'admin/timetable.php?error=noperiod'
        );

        exit;
    }

    foreach($periods as $i => $pnum){

        $pnum = (int)$pnum;

        if($pnum <= 0){
            continue;
        }

        $start =
            $starts[$i] ?? null;

        $end =
            $ends[$i] ?? null;

        /* ======================================
           TEACHER BUSY
        ====================================== */
        $tchk = $conn->prepare("
            SELECT id
            FROM timetable
            WHERE
                day_of_week = ?
                AND period_number = ?
                AND teacher_id = ?
        ");

        $tchk->bind_param(
            "sii",
            $day_of_week,
            $pnum,
            $teacher_id
        );

        $tchk->execute();

        if(
            $tchk
            ->get_result()
            ->num_rows > 0
        ){

            $_SESSION['flash'] = [

                'type'  => 'error',

                'title' => 'Teacher Busy!',

                'text'  =>
                    'Teacher already assigned for this period.'
            ];

            header(
                'Location: '
                . BASE_URL .
                'admin/timetable.php'
            );

            exit;
        }

        /* ======================================
           GET EXISTING ENTRIES
        ====================================== */
        $existing = $conn->prepare("
            SELECT
                t.id,
                s.subject_type,
                s.basket_group

            FROM timetable t

            JOIN subjects s
                ON s.id = t.subject_id

            WHERE
                t.class_id = ?
                AND (t.section_id <=> ?)
                AND t.day_of_week = ?
                AND t.period_number = ?
        ");

        $existing->bind_param(
            "iisi",
            $class_id,
            $section_id,
            $day_of_week,
            $pnum
        );

        $existing->execute();

        $rows =
            $existing
            ->get_result();

        $blocked = false;

        while($r = $rows->fetch_assoc()){

            /* ======================================
               EXISTING ENTRY INFO
            ====================================== */
            $existingType =
                $r['subject_type'] ?? 'Normal';

            $existingBasket =
                $r['basket_group'] ?? null;

            /* ======================================
               GROUP SUBJECTS
            ====================================== */
            if($subject_type === 'Group Subject'){

                /*
                   allow ONLY same basket
                */

                $sameBasket =
                    $existingType === 'Group Subject'
                    &&
                    $existingBasket
                    &&
                    $existingBasket === $basket_group;

                if(!$sameBasket){

                    $blocked = true;

                    $_SESSION['flash'] = [

                        'type'  => 'error',

                        'title' => 'Basket Busy!',

                        'text'  =>
                            'Another subject/group already exists in this period.'
                    ];

                    break;
                }
            }

            /* ======================================
               FIRST LANGUAGE
            ====================================== */
            elseif($subject_type === 'First Language'){

                /*
                   allow ONLY First Language
                */

                if($existingType !== 'First Language'){

                    $blocked = true;

                    $_SESSION['flash'] = [

                        'type'  => 'error',

                        'title' => 'Class Busy!',

                        'text'  =>
                            'Cannot mix 1st Language with other subjects.'
                    ];

                    break;
                }
            }

            /* ======================================
               SECOND LANGUAGE
            ====================================== */
            elseif($subject_type === 'Second Language'){

                /*
                   allow ONLY Second Language
                */

                if($existingType !== 'Second Language'){

                    $blocked = true;

                    $_SESSION['flash'] = [

                        'type'  => 'error',

                        'title' => 'Class Busy!',

                        'text'  =>
                            'Cannot mix 2nd Language with other subjects.'
                    ];

                    break;
                }
            }

            /* ======================================
               NORMAL SUBJECTS
            ====================================== */
            else{

                /*
                   normal subjects
                   cannot overlap anything
                */

                $blocked = true;

                $_SESSION['flash'] = [

                    'type'  => 'error',

                    'title' => 'Class Busy!',

                    'text'  =>
                        'Class already has a subject in this period.'
                ];

                break;
            }
        }

        if($blocked){

            header(
                'Location: '
                . BASE_URL .
                'admin/timetable.php'
            );

            exit;
        }

        /* ======================================
           INSERT
        ====================================== */
        $stmt = $conn->prepare("
            INSERT INTO timetable
            (
                class_id,
                section_id,
                day_of_week,
                period_number,
                subject_id,
                basket_group,
                teacher_id,
                start_time,
                end_time
            )

            VALUES (?,?,?,?,?,?,?,?,?)
        ");

        $stmt->bind_param(
            "iisiisiss",
            $class_id,
            $section_id,
            $day_of_week,
            $pnum,
            $subject_id,
            $basket_group,
            $teacher_id,
            $start,
            $end
        );

        $stmt->execute();
    }

    $_SESSION['flash'] = [

        'type'  => 'success',

        'title' => 'Timetable Created!',

        'text'  =>
            'Periods added successfully.'
    ];

    header(
        'Location: '
        . BASE_URL .
        'admin/timetable.php'
    );

    exit;
}

/* ============================================================
   DELETE TIMETABLE ENTRY
============================================================ */
if($action === 'delete'){

    $id = (int)($_GET['id'] ?? 0);

    if(!$id){

        header(
            'Location: '
            . BASE_URL .
            'admin/timetable.php'
        );

        exit;
    }

    $stmt = $conn->prepare("
        DELETE FROM timetable
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $_SESSION['flash'] = [

        'type'  => 'success',

        'title' => 'Deleted!',

        'text'  =>
            'Timetable entry deleted successfully.'
    ];

    header(
        'Location: '
        . BASE_URL .
        'admin/timetable.php'
    );

    exit;
}