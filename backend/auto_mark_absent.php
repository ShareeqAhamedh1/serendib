<?php
require 'conn.php';
session_start();

date_default_timezone_set('Asia/Colombo');

$today     = date('Y-m-d');
$todayDay  = date('l');

/* =====================================================
   🔐 DO NOT RUN IF ATTENDANCE NOT STARTED
===================================================== */
$started = $conn->query("
    SELECT 1
    FROM attendance
    WHERE date = '$today'
    LIMIT 1
");

if ($started->num_rows === 0) {
    $_SESSION['attendance_summary'] = [
        'students_marked_absent' => 0,
        'teachers_marked_absent' => 0,
        'skipped_students'       => 0,
        'skipped_teachers'       => 0,
        'message' => 'Attendance not started yet'
    ];

    header("Location: " . BASE_URL . "admin/attendance-scanner.php");
    exit;
}

/* =====================================================
   CONTINUE NORMAL LOGIC
===================================================== */
$response = [
    'students_marked_absent' => 0,
    'teachers_marked_absent' => 0,
    'skipped_students'       => 0,
    'skipped_teachers'       => 0
];

/* =====================================================
   1️⃣ STUDENTS — ONLY GRADE 6–11
===================================================== */
$students = $conn->query("
    SELECT id
    FROM students
    WHERE class_id IN (1,2,3,4,5,6)
");

while ($s = $students->fetch_assoc()) {

    $sid = (int)$s['id'];

    $check = $conn->query("
        SELECT 1
        FROM attendance
        WHERE entity_type='student'
          AND entity_id=$sid
          AND date='$today'
        LIMIT 1
    ");

    if ($check->num_rows > 0) {
        $response['skipped_students']++;
        continue;
    }

    $conn->query("
        INSERT INTO attendance (entity_id, entity_type, date, status)
        VALUES ($sid, 'student', '$today', 'absent')
    ");

    $response['students_marked_absent']++;
}

/* =====================================================
   2️⃣ TEACHERS — ONLY IF THEY HAVE CLASSES TODAY
===================================================== */
$teachers = $conn->query("
    SELECT DISTINCT t.id
    FROM teachers t
    JOIN timetable tt ON tt.teacher_id = t.id
    WHERE tt.day_of_week = '$todayDay'
");

while ($t = $teachers->fetch_assoc()) {

    $tid = (int)$t['id'];

    $check = $conn->query("
        SELECT 1
        FROM attendance
        WHERE entity_type='teacher'
          AND entity_id=$tid
          AND date='$today'
        LIMIT 1
    ");

    if ($check->num_rows > 0) {
        $response['skipped_teachers']++;
        continue;
    }

    $conn->query("
        INSERT INTO attendance (entity_id, entity_type, date, status)
        VALUES ($tid, 'teacher', '$today', 'absent')
    ");

    $response['teachers_marked_absent']++;

    $leaveCheck = $conn->query("
        SELECT id
        FROM teacher_leave_requests
        WHERE teacher_id = $tid
          AND status = 'Approved'
          AND '$today' BETWEEN start_date AND end_date
        LIMIT 1
    ");

    if ($leaveCheck->num_rows === 0) {
        $conn->query("
            INSERT INTO teacher_leave_requests (
                teacher_id, leave_type, start_date, end_date,
                days, reason, status, created_at
            ) VALUES (
                $tid, 'CASUAL', '$today', '$today',
                1, 'Auto marked by attendance scanner',
                'Approved', NOW()
            )
        ");
    }
}

$_SESSION['attendance_summary'] = $response;

header("Location: " . BASE_URL . "admin/attendance-scanner.php");
exit;
