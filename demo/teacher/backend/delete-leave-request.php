<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
$request_id = (int)($_POST['request_id'] ?? 0);

if (!$user_id || !$request_id) {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
    exit;
}

/* Verify teacher owns this request AND it is pending */
$stmt = $conn->prepare("
    SELECT r.id
    FROM teacher_leave_requests r
    JOIN teachers t ON t.id = r.teacher_id
    WHERE r.id = ?
      AND r.status = 'Pending'
      AND t.user_id = ?
");
$stmt->bind_param("ii", $request_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo json_encode([
        'status'=>'error',
        'message'=>'You cannot delete this request'
    ]);
    exit;
}

/* Delete */
$del = $conn->prepare("
    DELETE FROM teacher_leave_requests
    WHERE id = ?
");
$del->bind_param("i", $request_id);
$del->execute();

echo json_encode([
    'status'=>'success',
    'message'=>'Leave request deleted'
]);
