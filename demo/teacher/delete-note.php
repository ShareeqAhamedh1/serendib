<?php
require_once __DIR__.'/../backend/conn.php';
require_once __DIR__.'/../vendor/autoload.php';

$id = (int)$_GET['id'];

$files = $conn->query("
    SELECT drive_file_id FROM subject_note_files WHERE note_id=$id
");

/* GOOGLE CLIENT */
$client = new Google_Client();
$client->setAuthConfig(__DIR__.'/../backend/google/credentials.json');
$client->setAccessToken(json_decode(
    file_get_contents(__DIR__.'/../backend/google/token.json'), true
));
$client->setScopes([Google_Service_Drive::DRIVE_FILE]);
$drive = new Google_Service_Drive($client);

// Delete files from Drive
while($f=$files->fetch_assoc()) {
    $drive->files->delete($f['drive_file_id']);
}

// Delete DB
$conn->query("DELETE FROM subject_note_files WHERE note_id=$id");
$conn->query("DELETE FROM subject_notes WHERE id=$id");

header("Location: view-notes.php");
exit;
