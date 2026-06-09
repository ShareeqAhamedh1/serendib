<?php
require_once __DIR__ . '/conn.php';
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Unknown error'];

try {
    $teacher_id = (int)($_POST['teacher_id'] ?? 0);
    $year       = (int)($_POST['year'] ?? date('Y'));
    $sick       = (int)($_POST['SICK'] ?? 0);
    $casual     = (int)($_POST['CASUAL'] ?? 0);
    $annual     = (int)($_POST['ANNUAL'] ?? 0);

    if (!$teacher_id) {
        throw new Exception('Invalid teacher');
    }

    // Upsert leave quota
    $stmt = $conn->prepare("
        INSERT INTO teacher_leave_quota
            (teacher_id, year, sick_leave, casual_leave, annual_leave)
        VALUES (?,?,?,?,?)
        ON DUPLICATE KEY UPDATE
            sick_leave = VALUES(sick_leave),
            casual_leave = VALUES(casual_leave),
            annual_leave = VALUES(annual_leave)
    ");
    $stmt->bind_param(
        "iiiii",
        $teacher_id,
        $year,
        $sick,
        $casual,
        $annual
    );
    $stmt->execute();

    $response = [
        'status' => 'success',
        'message' => 'Leave quota saved successfully'
    ];

} catch (Throwable $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;
