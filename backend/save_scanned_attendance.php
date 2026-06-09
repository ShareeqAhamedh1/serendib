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
$date    = date('Y-m-d');
$timeNow = date('H:i:s');

/* --------------------------------------------------
   ✅ WHATSAPP SENDER
-------------------------------------------------- */


function sendWhatsAppTemplate($phone, $template, $params = []) {

    $token = "EAANhEMGZC5L0BQQUBtbU4x2zDbCooACcAyIH6NFQAZB8kv83F3LmgL4dTz5vfLbLy8NRziJBuaMPkRn4jXZAmWoqYzJHpAA9R3Ubi10cbCOKUUdGqErfAtQy18UojJDVZBZAeJPmAZC64zsFg16jUAEITvFIf1hrYpTQZBgwYcI5zqludPifMTSS6wLqiOTv9S1e9A786ZCZAdtHzNZCxHQk081ZBYOKKk5zKcGg5HO";
    $phone_number_id = "996968323489287";

    $url = "https://graph.facebook.com/v18.0/{$phone_number_id}/messages";

    $components = [];
    if (!empty($params)) {
        $bodyParams = [];
        foreach ($params as $param) {
            $bodyParams[] = [
                "type" => "text",
                "text" => $param
            ];
        }

        $components[] = [
            "type" => "body",
            "parameters" => $bodyParams
        ];
    }

    $data = [
        "messaging_product" => "whatsapp",
        "to" => $phone,
        "type" => "template",
        "template" => [
            "name" => $template,
            "language" => ["code" => "en"],
            "components" => $components
        ]
    ];

    $headers = [
        "Authorization: Bearer {$token}",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}


/* --------------------------------------------------
   ✅ COMMON ATTENDANCE HANDLER
-------------------------------------------------- */
function processScan(
    $conn,
    $id,
    $full_name,
    $code,
    $role,
    $date,
    $timeNow,
    $parent_phone = null
) {

    $check = $conn->prepare("
        SELECT id, time_in, time_out, status
        FROM attendance
        WHERE entity_id=? AND entity_type=? AND date=?
    ");
    $check->bind_param("iss", $id, $role, $date);
    $check->execute();
    $row = $check->get_result()->fetch_assoc();

    /* 🔒 BLOCK IF ABSENT */
    if ($row && $row['status'] === 'absent') {
        return [
            'success' => false,
            'message' => "{$full_name} is marked ABSENT today. Attendance is locked."
        ];
    }

    /* ---------- TIME OUT ---------- */
    if ($row && $row['time_in'] && !$row['time_out']) {

        $upd = $conn->prepare("UPDATE attendance SET time_out=? WHERE id=?");
        $upd->bind_param("si", $timeNow, $row['id']);
        $upd->execute();

        if ($role === 'student' && $parent_phone) {
            sendWhatsAppTemplate(
                $parent_phone,
                "student_departure",
                [$full_name, $timeNow]
            );
        }

        return [
            'success' => true,
            'name' => $full_name,
            'role' => ucfirst($role),
            'code' => $code,
            'action' => 'out',
            'time' => $timeNow
        ];
    }

    /* ---------- ALREADY COMPLETED ---------- */
    if ($row && $row['time_in'] && $row['time_out']) {
        return [
            'success' => false,
            'message' => "{$full_name} already marked IN and OUT today."
        ];
    }

    /* ---------- TIME IN ---------- */
    if (!$row) {

        $ins = $conn->prepare("
            INSERT INTO attendance (entity_id, entity_type, date, time_in, status)
            VALUES (?, ?, ?, ?, 'Present')
        ");
        $ins->bind_param("isss", $id, $role, $date, $timeNow);
        $ins->execute();

        if ($role === 'student' && $parent_phone) {
            sendWhatsAppTemplate(
                $parent_phone,
                "student_arrival",
                [$full_name, $timeNow]
            );
        }

        return [
            'success' => true,
            'name' => $full_name,
            'role' => ucfirst($role),
            'code' => $code,
            'action' => 'in',
            'time' => $timeNow
        ];
    }

    return ['success' => false, 'message' => 'Unable to process attendance'];
}


/* --------------------------------------------------
   ✅ STUDENT PROCESSING (WITH FEE CHECK)
-------------------------------------------------- */
$stmt = $conn->prepare("
    SELECT 
        s.id,
        s.first_name,
        s.last_name,
        p.phone AS parent_phone
    FROM students s
    LEFT JOIN parents p ON s.parent_id = p.id
    WHERE s.admission_no = ?
    LIMIT 1
");
$stmt->bind_param("s", $scan_code);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if ($student) {

    $student_id = $student['id'];
    $full_name  = "{$student['first_name']} {$student['last_name']}";

    /* 🔴 FEE CHECK HERE (CORRECT PLACE) */
    $fee = $conn->prepare("
        SELECT COUNT(*) AS cnt
        FROM student_fees
        WHERE student_id=? AND status IN ('Pending','Partial')
    ");
    $fee->bind_param("i", $student_id);
    $fee->execute();
    $feeCount = $fee->get_result()->fetch_assoc()['cnt'];

    if ($feeCount > 0 && empty($_POST['force'])) {
        echo json_encode([
            'success' => false,
            'fee_pending' => true,
            'name' => $full_name,
            'message' => 'Pending or partial fee detected. Allow attendance?'
        ]);
        exit;
    }

    $response = processScan(
        $conn,
        $student_id,
        $full_name,
        $scan_code,
        'student',
        $date,
        $timeNow,
        $student['parent_phone']
    );

    echo json_encode($response);
    exit;
}

/* --------------------------------------------------
   ✅ TEACHER PROCESSING
-------------------------------------------------- */
$stmt = $conn->prepare("
    SELECT id, first_name, last_name
    FROM teachers
    WHERE teacher_code = ?
    LIMIT 1
");
$stmt->bind_param("s", $scan_code);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

if ($teacher) {

    $full_name = "{$teacher['first_name']} {$teacher['last_name']}";

    echo json_encode(
        processScan(
            $conn,
            $teacher['id'],
            $full_name,
            $scan_code,
            'teacher',
            $date,
            $timeNow
        )
    );
    exit;
}

/* --------------------------------------------------
   ❌ NO MATCH
-------------------------------------------------- */
echo json_encode(['success' => false, 'message' => 'No matching Student or Teacher found']);
