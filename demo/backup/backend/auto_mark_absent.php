<?php
require 'conn.php';

date_default_timezone_set('Asia/Colombo');
$today = date('Y-m-d');

$response = [
    'students_marked_absent' => 0,
    'teachers_marked_absent' => 0
];

/* --------------------------------------------
   ✅ 1. MARK STUDENTS AS ABSENT IF NOT MARKED
---------------------------------------------- */
$students = $conn->query("SELECT id FROM students");

while ($s = $students->fetch_assoc()) {
    $sid = $s['id'];

    // Check if already marked today
    $check = $conn->query("
        SELECT id FROM attendance 
        WHERE entity_type='student' AND entity_id=$sid AND date='$today'
    ");

    // If no attendance record → mark Absent
    if ($check->num_rows == 0) {
        $conn->query("
            INSERT INTO attendance (entity_id, entity_type, date, status)
            VALUES ($sid, 'student', '$today', 'Absent')
        ");
        $response['students_marked_absent']++;
    }
}


/* --------------------------------------------
   ✅ 2. MARK TEACHERS AS ABSENT IF NOT MARKED
---------------------------------------------- */
$teachers = $conn->query("SELECT id FROM teachers");

while ($t = $teachers->fetch_assoc()) {
    $tid = $t['id'];

    // Check if already marked today
    $check = $conn->query("
        SELECT id FROM attendance 
        WHERE entity_type='teacher' AND entity_id=$tid AND date='$today'
    ");

    if ($check->num_rows == 0) {
        $conn->query("
            INSERT INTO attendance (entity_id, entity_type, date, status)
            VALUES ($tid, 'teacher', '$today', 'Absent')
        ");
        $response['teachers_marked_absent']++;
    }
}

echo json_encode([
    'success' => true,
    'message' => 'Absent marking completed.',
    'summary' => $response
]);
