<?php
require_once __DIR__.'/conn.php';

$a = $conn->query("
  SELECT *
  FROM smart_announcements
  WHERE (expires_at IS NULL OR expires_at > NOW())
  ORDER BY created_at DESC
  LIMIT 1
")->fetch_assoc();

echo json_encode($a ?: []);
exit;
