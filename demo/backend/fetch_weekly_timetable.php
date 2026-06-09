<?php
require_once __DIR__ . '/conn.php';

header('Content-Type: application/json');

$class_id   = isset($_GET['class_id']) && $_GET['class_id'] !== '' ? (int)$_GET['class_id'] : null;
$section_id = isset($_GET['section_id']) && $_GET['section_id'] !== '' ? (int)$_GET['section_id'] : null;
$teacher_id = isset($_GET['teacher_id']) && $_GET['teacher_id'] !== '' ? (int)$_GET['teacher_id'] : null;

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

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "
    SELECT
        tt.id,
        tt.day_of_week,
        tt.start_time,
        tt.end_time,
        sub.subject_name,
        sec.section_name,
        c.class_name AS grade,
        CONCAT(t.first_name,' ',t.last_name) AS teacher_name
    FROM timetable tt
    JOIN subjects sub ON sub.id = tt.subject_id
    JOIN teachers t  ON t.id  = tt.teacher_id
    LEFT JOIN sections sec ON sec.id = tt.section_id
    LEFT JOIN classes c   ON c.id   = tt.class_id
    $whereSql
    ORDER BY 
        FIELD(tt.day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),
        tt.start_time
";

$stmt = $conn->prepare($sql);

if ($params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$res = $stmt->get_result();

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = [
        'id'          => $row['id'],
        'day_of_week' => $row['day_of_week'],
        'start_time'  => substr($row['start_time'], 0, 5),
        'subject'     => $row['subject_name'],
        'teacher'     => $row['teacher_name'],
        'section'     => $row['section_name'] ?? '',
        'grade'       => $row['grade'] ?? ''
    ];
}

echo json_encode($data);
