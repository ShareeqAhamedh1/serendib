<?php
require_once __DIR__ . '/conn.php';
header('Content-Type: application/json');

date_default_timezone_set('Asia/Colombo');

/* ===============================
   INPUT
================================ */
$class_id   = (int)($_GET['class_id'] ?? 0);
$section_id = (int)($_GET['section_id'] ?? 0);

$day = date('l');
$now = date('H:i:s');

/* ===============================
   TIME RULES
================================ */
$SCHOOL_START   = '07:40:00';
$INTERVAL_START = '11:00:00';
$INTERVAL_END   = '11:20:00';
$SCHOOL_END     = '14:00:00';

/* ===============================
   DEFAULT RESPONSE
================================ */
$response = [
    'status'   => 'normal',
    'current'  => ['subject' => '-', 'teacher' => '-'],
    'next'     => ['subject' => '-', 'teacher' => '-'],
    'messages' => [],
    'sound'    => null
];

/* ===============================
   BEFORE SCHOOL
================================ */
if ($now < $SCHOOL_START) {
    $response['status'] = 'not_started';
    echo json_encode($response);
    exit;
}

/* ===============================
   INTERVAL
================================ */
if ($now >= $INTERVAL_START && $now < $INTERVAL_END) {
    $response['status']  = 'interval';
    $response['current'] = [
        'subject' => 'INTERVAL',
        'teacher' => ''
    ];
    echo json_encode($response);
    exit;
}

/* ===============================
   SCHOOL OVER
================================ */
if ($now >= $SCHOOL_END) {
    $response['status']  = 'ended';
    $response['current'] = [
        'subject' => 'School Over',
        'teacher' => ''
    ];
    echo json_encode($response);
    exit;
}

/* ===============================
   COMMON WHERE CLAUSE
================================ */
$where = "tt.class_id = ? AND tt.day_of_week = ?";
$params = [$class_id, $day];
$types  = "is";

if ($section_id > 0) {
    $where .= " AND tt.section_id = ?";
    $params[] = $section_id;
    $types   .= "i";
}

/* ===============================
   CURRENT PERIOD
================================ */
$sqlCurrent = "
    SELECT 
        s.subject_name AS subject,
        CONCAT(t.first_name,' ',t.last_name) AS teacher
    FROM timetable tt
    JOIN subjects s ON s.id = tt.subject_id
    JOIN teachers t ON t.id = tt.teacher_id
    WHERE $where
      AND TIME(tt.start_time) <= TIME(?)
      AND TIME(tt.end_time)   >  TIME(?)
    LIMIT 1
";

$paramsCurrent = array_merge($params, [$now, $now]);
$typesCurrent  = $types . "ss";

$stmt = $conn->prepare($sqlCurrent);
$stmt->bind_param($typesCurrent, ...$paramsCurrent);
$stmt->execute();
$current = $stmt->get_result()->fetch_assoc();

if ($current) {
    $response['current'] = $current;
}

/* ===============================
   NEXT PERIOD
================================ */
$sqlNext = "
    SELECT 
        s.subject_name AS subject,
        CONCAT(t.first_name,' ',t.last_name) AS teacher
    FROM timetable tt
    JOIN subjects s ON s.id = tt.subject_id
    JOIN teachers t ON t.id = tt.teacher_id
    WHERE $where
      AND TIME(tt.start_time) > TIME(?)
    ORDER BY tt.start_time
    LIMIT 1
";

$paramsNext = array_merge($params, [$now]);
$typesNext  = $types . "s";

$stmt = $conn->prepare($sqlNext);
$stmt->bind_param($typesNext, ...$paramsNext);
$stmt->execute();
$next = $stmt->get_result()->fetch_assoc();

if ($next) {
    $response['next'] = $next;
}

/* ===============================
   ANNOUNCEMENTS
================================ */
$ann = $conn->prepare("
    SELECT title, message, priority, sound_file
    FROM smart_announcements
    WHERE
      (
        target_type = 'ALL'
        OR (target_type = 'CLASS' AND class_id = ?)
        OR (target_type = 'SECTION' AND section_id = ?)
      )
      AND (expires_at IS NULL OR expires_at > NOW())
    ORDER BY priority DESC, created_at DESC
");

$ann->bind_param("ii", $class_id, $section_id);
$ann->execute();
$res = $ann->get_result();

while ($m = $res->fetch_assoc()) {
    $response['messages'][] = [
        'title'    => $m['title'],
        'message'  => $m['message'],
        'priority' => $m['priority']
    ];

    if (!$response['sound'] && $m['sound_file']) {
        $response['sound'] = $m['sound_file'];
    }
}

echo json_encode($response);
