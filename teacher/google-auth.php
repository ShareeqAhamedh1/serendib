<?php
require_once __DIR__ . '/../vendor/autoload.php';

$client = new Google_Client();

$client->setAuthConfig(__DIR__ . '/../backend/google/credentials.json');

if ($_SERVER['HTTP_HOST'] == 'localhost') {

    $client->setRedirectUri(
        'http://localhost/ser/teacher/google-auth.php'
    );

} else {

    $client->setRedirectUri(
        'https://serendib.edu.lk/teacher/google-auth.php'
    );
}

$client->addScope(Google_Service_Drive::DRIVE_FILE);

$client->setAccessType('offline');
$client->setPrompt('select_account consent');

if (!isset($_GET['code'])) {

    $authUrl = $client->createAuthUrl();

    header("Location: $authUrl");
    exit;

} else {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    file_put_contents(
        __DIR__ . '/../backend/google/token.json',
        json_encode($token)
    );

    // REDIRECT BACK
    header("Location: upload-notes.php?connected=1");
    exit;
}