<?php
require 'conn.php';
header('Content-Type: application/json');

$data=json_decode(file_get_contents('php://input'),true);
$file=$data['audio_file'] ?? '';

if(!$file){
  echo json_encode(['status'=>'error','message'=>'Invalid request']);
  exit;
}

@unlink(__DIR__."/../uploads/announcements/$file");

$stmt=$conn->prepare("
  DELETE FROM smart_audio_events WHERE audio_file=?
");
$stmt->bind_param("s",$file);
$stmt->execute();

echo json_encode(['status'=>'success','message'=>'Audio deleted']);
