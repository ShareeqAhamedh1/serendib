<?php
require_once __DIR__ . '/conn.php';

header('Content-Type: application/json');

/* =========================================
   FILTERS
========================================= */
$class_id = isset($_GET['class_id'])
    && $_GET['class_id'] !== ''
        ? (int)$_GET['class_id']
        : null;

$section_id = isset($_GET['section_id'])
    && $_GET['section_id'] !== ''
        ? (int)$_GET['section_id']
        : null;

$teacher_id = isset($_GET['teacher_id'])
    && $_GET['teacher_id'] !== ''
        ? (int)$_GET['teacher_id']
        : null;

$where  = [];
$params = [];
$types  = '';

if ($class_id) {

    $where[] = 'tt.class_id = ?';

    $params[] = $class_id;

    $types .= 'i';
}

if ($section_id) {

    $where[] = 'tt.section_id = ?';

    $params[] = $section_id;

    $types .= 'i';
}

if ($teacher_id) {

    $where[] = 'tt.teacher_id = ?';

    $params[] = $teacher_id;

    $types .= 'i';
}

$whereSql =
    $where
        ? 'WHERE ' . implode(' AND ', $where)
        : '';

/* =========================================
   FETCH TIMETABLE
========================================= */
$sql = "

SELECT
    tt.id,
    tt.day_of_week,
    tt.start_time,
    tt.end_time,

    sub.subject_name,
    sub.subject_type,
    sub.basket_group,

    sec.section_name,

    c.class_name AS grade,

    CONCAT(
        t.first_name,
        ' ',
        t.last_name
    ) AS teacher_name

FROM timetable tt

JOIN subjects sub
    ON sub.id = tt.subject_id

JOIN teachers t
    ON t.id = tt.teacher_id

LEFT JOIN sections sec
    ON sec.id = tt.section_id

LEFT JOIN classes c
    ON c.id = tt.class_id

$whereSql

ORDER BY
    FIELD(
        tt.day_of_week,
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    ),

    tt.start_time
";

$stmt = $conn->prepare($sql);

if ($params) {

    $stmt->bind_param(
        $types,
        ...$params
    );
}

$stmt->execute();

$res = $stmt->get_result();

/* =========================================
   RANDOM COLORS
========================================= */
$colors = [
    'color-1',
    'color-2',
    'color-3',
    'color-4',
    'color-5',
    'color-6',
    'color-7',
    'color-8'
];

$data = [];

while ($row = $res->fetch_assoc()) {

    /* =====================================
       SUBJECT LABEL
    ===================================== */
    $subject =
        $row['subject_name'];

    $type =
        $row['subject_type'] ?? 'Normal';

    $basket =
        $row['basket_group'] ?? '';

    if($type === 'Group Subject'){

        $subject .= ' (' . $basket . ')';
    }

    elseif($type === 'First Language'){

        $subject .= ' (1st Lang)';
    }

    elseif($type === 'Second Language'){

        $subject .= ' (2nd Lang)';
    }

    /* =====================================
       RANDOM COLOR
    ===================================== */
    $randomColor =
        $colors[array_rand($colors)];

    $data[] = [

        'id' => $row['id'],

        'day_of_week' =>
            $row['day_of_week'],

        'start_time' =>
            substr(
                $row['start_time'],
                0,
                5
            ),

        'subject' =>
            $subject,

        'teacher' =>
            $row['teacher_name'],

        'section' =>
            $row['section_name'] ?? '',

        'grade' =>
            $row['grade'] ?? '',

        'color' =>
            $randomColor
    ];
}

echo json_encode($data);