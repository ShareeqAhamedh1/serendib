<?php
require 'conn.php';
require 'helpers.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'CSRF failed']);
    exit;
}

$scan_code = trim($_POST['scan_code'] ?? '');
if ($scan_code === '') {
    echo json_encode(['success' => false, 'message' => 'Please enter or scan an ID']);
    exit;
}

date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d');
$timeNow = date('H:i:s');

/*----------------------------------------------
 ✅ FUNCTION — Process an attendance scan
----------------------------------------------*/
function processScan($conn, $id, $full_name, $code, $role, $date, $timeNow) {

    // Check today row
    $check = $conn->prepare("
        SELECT id, time_in, time_out 
        FROM attendance
        WHERE entity_id=? AND entity_type=? AND date=?
    ");
    $check->bind_param("iss", $id, $role, $date);
    $check->execute();
    $row = $check->get_result()->fetch_assoc();

    // ✅ CASE 1: time_in exists, time_out empty → mark OUT
    if ($row && $row['time_in'] && !$row['time_out']) {
        $upd = $conn->prepare("UPDATE attendance SET time_out=? WHERE id=?");
        $upd->bind_param("si", $timeNow, $row['id']);
        $upd->execute();

        return [
            'success' => true,
            'name' => $full_name,
            'role' => ucfirst($role),
            'code' => $code,
            'action' => 'out',
            'time' => $timeNow
        ];
    }

    // ✅ CASE 2: already completed (has IN + OUT)
    if ($row && $row['time_in'] && $row['time_out']) {
        return [
            'success' => false,
            'message' => "$full_name already marked IN and OUT today."
        ];
    }

    // ✅ CASE 3: first scan → INSERT present record
    if (!$row) {
        $ins = $conn->prepare("
            INSERT INTO attendance (entity_id, entity_type, date, time_in, status)
            VALUES (?, ?, ?, ?, 'Present')
        ");
        $ins->bind_param("isss", $id, $role, $date, $timeNow);
        $ins->execute();

        return [
            'success' => true,
            'name' => $full_name,
            'role' => ucfirst($role),
            'code' => $code,
            'action' => 'in',
            'time' => $timeNow
        ];
    }

    // fallback
    return ['success' => false, 'message' => 'Unable to process attendance'];
}

/*----------------------------------------------
 ✅ STUDENT PROCESSING
----------------------------------------------*/
$stmt = $conn->prepare("SELECT id, first_name, last_name FROM students WHERE admission_no=? LIMIT 1");
$stmt->bind_param("s", $scan_code);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if ($student) {
    $full_name = "{$student['first_name']} {$student['last_name']}";
    $response = processScan(
        $conn,
        $student['id'],
        $full_name,
        $scan_code,
        'student',
        $date,
        $timeNow
    );
    echo json_encode($response);
    exit;
}

/*----------------------------------------------
 ✅ TEACHER PROCESSING
----------------------------------------------*/
$stmt = $conn->prepare("SELECT id, first_name, last_name FROM teachers WHERE teacher_code=? LIMIT 1");
$stmt->bind_param("s", $scan_code);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

if ($teacher) {
    $full_name = "{$teacher['first_name']} {$teacher['last_name']}";
    $response = processScan(
        $conn,
        $teacher['id'],
        $full_name,
        $scan_code,
        'teacher',
        $date,
        $timeNow
    );
    echo json_encode($response);
    exit;
}

/*----------------------------------------------
 ✅ NO MATCH FOUND
----------------------------------------------*/
echo json_encode(['success' => false, 'message' => 'No matching Student or Teacher found for this ID']);
