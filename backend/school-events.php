<?php
require_once __DIR__.'/conn.php';

date_default_timezone_set('Asia/Colombo');

$now = new DateTime();
$time = $now->format('H:i');

$response = [
  'ring' => false,
  'times' => 1,
  'sound' => null,
  'announcement' => null
];

/* ===============================
   FETCH BELL SOUND
================================ */
$bell = $conn->query("
  SELECT audio_file
  FROM smart_audio_events
  WHERE event_type='bell'
  ORDER BY created_at DESC
  LIMIT 1
")->fetch_assoc();

if (!$bell) {
  echo json_encode($response);
  exit;
}

/* ===============================
   TIME BASED RULES
================================ */

// Period starts every 40 mins from 07:40
$start = new DateTime('07:40');
$intervalStart = new DateTime('11:00');
$intervalEnd   = new DateTime('11:20');
$schoolEnd     = new DateTime('14:00');

// Interval start
if ($time === '11:00') {
  $response['ring'] = true;
  $response['times'] = 2;
}

// Interval end
elseif ($time === '11:20') {
  $response['ring'] = true;
  $response['times'] = 2;
}

// School end
elseif ($time === '14:00') {
  $response['ring'] = true;
  $response['times'] = 2;
}

// Period change
else {
  $diff = ($start->diff($now)->i + ($start->diff($now)->h * 60));
  if ($diff >= 0 && $diff % 40 === 0 && $now < $intervalStart) {
    $response['ring'] = true;
    $response['times'] = 1;
  }
}

if ($response['ring']) {
  $response['sound'] = $bell['audio_file'];
}

echo json_encode($response);
exit;
