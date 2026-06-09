<?php
require 'conn.php';
header('Content-Type: application/json');

$res = $conn->query("
  SELECT audio_file, event_type,
         CASE event_type
           WHEN 'bell'  THEN 'Bell Sound'
           WHEN 'alert' THEN 'Alert Sound'
           WHEN 'music' THEN 'Music Track'
           ELSE 'Audio'
         END AS label
  FROM smart_audio_events
  ORDER BY created_at DESC
");

$data = [];
while ($r = $res->fetch_assoc()) {
  $data[] = $r;
}

echo json_encode($data);
exit;
