<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';


header('Content-Type: application/json');

/* ===============================
   AUTH CHECK
================================ */
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized access'
    ]);
    exit;
}

/* ===============================
   FETCH TEACHER
================================ */
$user_id = (int)$_SESSION['user_id'];

$tq = $conn->prepare("
    SELECT id 
    FROM teachers 
    WHERE user_id = ?
    LIMIT 1
");
$tq->bind_param("i", $user_id);
$tq->execute();
$teacher = $tq->get_result()->fetch_assoc();

if (!$teacher) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Teacher record not found'
    ]);
    exit;
}

$teacher_id = (int)$teacher['id'];

/* ===============================
   INPUT VALIDATION
================================ */
$leave_type = $_POST['leave_type'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$end_date   = $_POST['end_date'] ?? '';
$reason     = trim($_POST['reason'] ?? '');

$validTypes = ['SICK', 'CASUAL', 'ANNUAL'];

if (
    !in_array($leave_type, $validTypes) ||
    !$start_date ||
    !$end_date ||
    !$reason
) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid or missing data'
    ]);
    exit;
}

/* ===============================
   DATE CHECK
================================ */
if (strtotime($end_date) < strtotime($start_date)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'End date cannot be before start date'
    ]);
    exit;
}

/* ===============================
   CALCULATE DAYS (INCLUSIVE)
================================ */
$days = (strtotime($end_date) - strtotime($start_date)) / 86400 + 1;
$days = (int)$days;

if ($days <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid leave duration'
    ]);
    exit;
}

/* ===============================
   FETCH QUOTA (COLUMN BASED)
================================ */
$year = date('Y');

$q = $conn->prepare("
    SELECT sick_leave, casual_leave, annual_leave
    FROM teacher_leave_quota
    WHERE teacher_id = ?
      AND year = ?
    LIMIT 1
");
$q->bind_param("ii", $teacher_id, $year);
$q->execute();
$quota = $q->get_result()->fetch_assoc();

if (!$quota) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Leave quota not assigned for this year'
    ]);
    exit;
}

/* ===============================
   MAP LEAVE TYPE → COLUMN
================================ */
$quotaMap = [
    'SICK'   => (int)$quota['sick_leave'],
    'CASUAL' => (int)$quota['casual_leave'],
    'ANNUAL' => (int)$quota['annual_leave']
];

$totalAllowed = $quotaMap[$leave_type];

/* ===============================
   USED LEAVES (APPROVED ONLY)
================================ */
$usedQ = $conn->prepare("
    SELECT SUM(days) AS used_days
    FROM teacher_leave_requests
    WHERE teacher_id = ?
      AND leave_type = ?
      AND status = 'Approved'
      AND YEAR(start_date) = ?
");
$usedQ->bind_param("isi", $teacher_id, $leave_type, $year);
$usedQ->execute();
$used = (int)($usedQ->get_result()->fetch_assoc()['used_days'] ?? 0);

$remaining = $totalAllowed - $used;

if ($days > $remaining) {
    echo json_encode([
        'status' => 'error',
        'message' => "Not enough {$leave_type} leave remaining ({$remaining} days left)"
    ]);
    exit;
}

/* ===============================
   SAVE REQUEST
================================ */
$insert = $conn->prepare("
    INSERT INTO teacher_leave_requests
    (teacher_id, leave_type, start_date, end_date, days, reason, status, created_at)
    VALUES (?,?,?,?,?,?,'Pending',NOW())
");
$insert->bind_param(
    "isssis",
    $teacher_id,
    $leave_type,
    $start_date,
    $end_date,
    $days,
    $reason
);
$insert->execute();

/* ===============================
   SUCCESS
================================ */
echo json_encode([
    'status' => 'success',
    'message' => 'Leave request submitted successfully'
]);
