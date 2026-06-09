<?php
require_once __DIR__ . '/conn.php';

header('Content-Type: application/json');

$house_id = isset($_GET['house_id']) ? (int)$_GET['house_id'] : 0;

if (!$house_id) {
    echo json_encode([]);
    exit;
}

/*
  Fetch students who belong to this house
  entity_type = 'student' is IMPORTANT
*/
$stmt = $conn->prepare("
    SELECT 
      s.id,
      CONCAT(s.first_name, ' ', s.last_name) AS name
    FROM house_members hm
    JOIN students s 
      ON hm.entity_id = s.id
    WHERE hm.house_id = ?
      AND hm.entity_type = 'student'
    ORDER BY s.first_name, s.last_name
");

$stmt->bind_param("i", $house_id);
$stmt->execute();

$res = $stmt->get_result();

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = [
        'id'   => $row['id'],
        'name' => $row['name']
    ];
}

echo json_encode($data);
