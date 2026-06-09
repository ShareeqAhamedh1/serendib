<?php
require_once 'conn.php';

header('Content-Type: application/json');

$id     = (int)($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';

if (!in_array($status, ['Approved', 'Rejected'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid status'
    ]);
    exit;
}

/* ===============================
   FETCH LEAVE REQUEST (PENDING)
================================ */
$stmt = $conn->prepare("
    SELECT teacher_id, start_date, end_date
    FROM teacher_leave_requests
    WHERE id = ? AND status = 'Pending'
    LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$leave = $res->fetch_assoc();

if (!$leave) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Leave request not found or already processed'
    ]);
    exit;
}

/* ===============================
   UPDATE LEAVE STATUS
================================ */
$upd = $conn->prepare("
    UPDATE teacher_leave_requests
    SET status = ?
    WHERE id = ?
");
$upd->bind_param("si", $status, $id);
$upd->execute();

/* ===============================
   IF APPROVED → MARK ATTENDANCE
================================ */
if ($status === 'Approved') {

    $teacher_id = (int)$leave['teacher_id'];
    $start      = new DateTime($leave['start_date']);
    $end        = new DateTime($leave['end_date']);
    $end->modify('+1 day'); // include last date

    $period = new DatePeriod($start, new DateInterval('P1D'), $end);

    foreach ($period as $date) {

        $day = $date->format('Y-m-d');

        // Check if attendance already exists
        $check = $conn->prepare("
            SELECT id
            FROM attendance
            WHERE entity_type = 'teacher'
              AND entity_id = ?
              AND date = ?
            LIMIT 1
        ");
        $check->bind_param("is", $teacher_id, $day);
        $check->execute();
        $exists = $check->get_result()->fetch_assoc();

        if ($exists) {
            // Update existing attendance
            $updAtt = $conn->prepare("
                UPDATE attendance
                SET status = 'absent'
                WHERE id = ?
            ");
            $updAtt->bind_param("i", $exists['id']);
            $updAtt->execute();
        } else {
            // Insert new attendance record
            $ins = $conn->prepare("
                INSERT INTO attendance (entity_id, entity_type, date, status)
                VALUES (?, 'teacher', ?, 'absent')
            ");
            $ins->bind_param("is", $teacher_id, $day);
            $ins->execute();
        }
    }
}

echo json_encode([
    'status' => 'success',
    'message' => "Request {$status} successfully"
]);
