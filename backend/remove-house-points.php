<?php
require_once 'conn.php';

$data = json_decode(file_get_contents("php://input"), true);

$log_id = (int)($data['log_id'] ?? 0);

if (!$log_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request'
    ]);
    exit;
}

/* GET LOG */
$log = $conn->query("
    SELECT *
    FROM house_point_logs
    WHERE id = $log_id
    LIMIT 1
")->fetch_assoc();

if (!$log) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Record not found'
    ]);
    exit;
}

/* OPTIONAL:
   delete homework submission also
*/
if (
    $log['source'] === 'HOMEWORK' &&
    !empty($log['homework_id']) &&
    !empty($log['entity_id'])
) {

    $student_id = (int)$log['entity_id'];
    $homework_id = (int)$log['homework_id'];

    $conn->query("
        DELETE FROM homework_submissions
        WHERE student_id = $student_id
        AND homework_id = $homework_id
    ");
}

/* DELETE POINT LOG */
$conn->query("
    DELETE FROM house_point_logs
    WHERE id = $log_id
");

echo json_encode([
    'status' => 'success',
    'message' => 'Points removed successfully'
]);