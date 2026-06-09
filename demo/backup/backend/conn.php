<?php
// backend/conn.php
date_default_timezone_set('Asia/Dubai');
if (!isset($_SESSION)) {
    session_start();
}

// Base URL of your project (adjust folder name if needed)
// Base URL of your live project
define('BASE_URL', 'https://serendib.edu.lk/');


// $servername = "localhost";
// $username   = "root";
// $password   = "";
// $dbname     = "school_erp";

$servername = "localhost";
$username = "u935688916_serendib";
$password = "*dA^SI:4a";
$dbname = "u935688916_serendib";

// Create MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Common variables
$current_date_time = date('Y-m-d H:i:s');

/* ------------------------------
   🔹 Image upload helper
--------------------------------*/
function uploadImage($fileName, $filePath, $allowedList, $errorLocation)
{
    if (!isset($_FILES[$fileName]) || $_FILES[$fileName]['error'] !== 0) {
        header('Location: ' . $errorLocation . '?uploadError');
        exit();
    }

    $imgName = $_FILES[$fileName]['name'];
    $imgTempName = $_FILES[$fileName]['tmp_name'];
    $fileExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedList)) {
        header('Location: ' . $errorLocation . '?extensionError=' . $fileExt);
        exit();
    }

    $fileNameNew = uniqid('img_', true) . '.' . $fileExt;
    $fileDestination = $filePath . $fileNameNew;

    if (!move_uploaded_file($imgTempName, $fileDestination)) {
        header('Location: ' . $errorLocation . '?moveError');
        exit();
    }

    return $fileNameNew; // return the new file name
}

/* ------------------------------
   🔹 Time difference helpers
--------------------------------*/
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = [
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function formatTimeDifference($date_time)
{
    $now = new DateTime();
    $target = new DateTime($date_time);
    $interval = $target->diff($now);

    if ($interval->days === 0) {
        if ($interval->h > 0) {
            return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
        } elseif ($interval->i > 0) {
            return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
        }
    } else {
        return $target->format('Y-m-d H:i:s');
    }
}
?>
