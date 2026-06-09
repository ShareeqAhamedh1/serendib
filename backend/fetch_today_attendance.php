<?php
require 'conn.php';
require 'helpers.php';
header('Content-Type: application/json');

date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d');

// Fetch today's attendance
$q = "
  SELECT 
    a.entity_type,
    a.status,
    COALESCE(s.first_name, t.first_name) AS first_name,
    COALESCE(s.last_name, t.last_name) AS last_name,
    COALESCE(s.admission_no, t.teacher_code) AS code,
    a.time_in,
    a.time_out
  FROM attendance a
  LEFT JOIN students s ON a.entity_type='student' AND a.entity_id=s.id
  LEFT JOIN teachers t ON a.entity_type='teacher' AND a.entity_id=t.id
  WHERE a.date = '$date'
  ORDER BY a.time_in DESC
";

$res = $conn->query($q);
$data = [];

if ($res && $res->num_rows > 0) {
    while ($r = $res->fetch_assoc()) {

        // ✅ Determine status
        if ($r['status'] === 'absent') {
            $status = 'Absent';
        } else {
            if (!empty($r['time_out'])) {
                $status = 'Completed';   // Present + Time Out
            } else {
                $status = 'Present';     // Present + No Time Out
            }
        }

        $data[] = [
            'type' => ucfirst($r['entity_type']),
            'name' => $r['first_name'] . ' ' . $r['last_name'],
            'code' => $r['code'],
            'time_in' => $r['time_in'] ?: '-',
            'time_out' => $r['time_out'] ?: '-',
            'status' => $status
        ];
    }
}

echo json_encode($data);
