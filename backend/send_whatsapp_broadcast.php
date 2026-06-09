<?php
require_once 'conn.php';
require_once 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    die('CSRF failed');
}

$target   = $_POST['target']   ?? '';
$template = $_POST['template'] ?? '';

if ($target === '' || $template === '') {
    die('Missing required data');
}

/* -------------------------------------------------
   VALIDATE TEMPLATE vs TARGET
-------------------------------------------------- */

if ($template === 'student_specific_notice' && $target !== 'student') {
    die('Invalid template selection');
}

/* -------------------------------------------------
   FETCH RECIPIENTS
-------------------------------------------------- */

$parents = [];

/* ---------- ALL PARENTS ---------- */
if ($target === 'all') {

    $res = $conn->query("
        SELECT DISTINCT p.phone, p.full_name
        FROM parents p
        JOIN students s ON s.parent_id = p.id
        WHERE p.phone IS NOT NULL AND p.phone <> ''
    ");

    while ($r = $res->fetch_assoc()) {
        $parents[] = $r;
    }
}

/* ---------- CLASS WISE ---------- */
elseif ($target === 'class') {

    $class_id = (int)($_POST['class_id'] ?? 0);
    if ($class_id <= 0) die('Invalid class');

    $stmt = $conn->prepare("
        SELECT DISTINCT p.phone, p.full_name
        FROM parents p
        JOIN students s ON s.parent_id = p.id
        WHERE s.class_id = ?
          AND p.phone IS NOT NULL
          AND p.phone <> ''
    ");
    $stmt->bind_param('i', $class_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($r = $res->fetch_assoc()) {
        $parents[] = $r;
    }
}

/* ---------- SELECTED STUDENT ---------- */
elseif ($target === 'student') {

    $student_id = (int)($_POST['student_id'] ?? 0);
    if ($student_id <= 0) die('Invalid student');

    $stmt = $conn->prepare("
        SELECT 
            p.phone,
            CONCAT(s.first_name, ' ', s.last_name) AS student_name
        FROM students s
        JOIN parents p ON s.parent_id = p.id
        WHERE s.id = ?
        LIMIT 1
    ");
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if (!$row || !$row['phone']) {
        die('Parent phone not found');
    }

    $parents[] = $row; // single parent
}

/* -------------------------------------------------
   BUILD TEMPLATE PARAMETERS
-------------------------------------------------- */

$sent = 0;
$failed = 0;

foreach ($parents as $p) {

    $phone = preg_replace('/\D/', '', $p['phone']);
    if (strlen($phone) < 9) {
        $failed++;
        continue;
    }

    /* ---------- SCHOOL ANNOUNCEMENT ---------- */
    if ($template === 'school_announcement') {

        $announcement = trim($_POST['announcement'] ?? '');
        if ($announcement === '') die('Announcement required');

        $ok = sendWhatsAppTemplate(
            $phone,
            'school_announcement',
            [
                $announcement,
                'Serendib High School'
            ]
        );
    }

    /* ---------- PARENTS MEETING ---------- */
    elseif ($template === 'parents_meeting_notice') {

        $school = trim($_POST['school_name'] ?? '');
        $date   = trim($_POST['meeting_date'] ?? '');
        $time   = trim($_POST['meeting_time'] ?? '');
        $venue  = trim($_POST['venue'] ?? '');

        if ($school === '' || $date === '' || $time === '' || $venue === '') {
            die('Meeting details missing');
        }

        // Class name for template
        $className = 'Selected Class';

        if ($target === 'class') {
            $c = $conn->prepare("SELECT class_name FROM classes WHERE id=?");
            $c->bind_param('i', $class_id);
            $c->execute();
            $className = $c->get_result()->fetch_assoc()['class_name'] ?? 'Class';
        }

        $ok = sendWhatsAppTemplate(
            $phone,
            'parents_meeting_notice',
            [
                
                $className,
                $date,
                $time,
                $venue
            ]
        );
    }

    /* ---------- STUDENT SPECIFIC ---------- */
    elseif ($template === 'student_specific_notice') {

        $message = trim($_POST['student_message'] ?? '');
        if ($message === '') die('Student message required');

        $ok = sendWhatsAppTemplate(
            $phone,
            'student_specific_notice',
            [
                $p['student_name'],
                $message
            ]
        );
    }

    $ok ? $sent++ : $failed++;
}

function sendWhatsAppTemplate($phone, $template, $params = []) {

    $token = "EAANhEMGZC5L0BQQUBtbU4x2zDbCooACcAyIH6NFQAZB8kv83F3LmgL4dTz5vfLbLy8NRziJBuaMPkRn4jXZAmWoqYzJHpAA9R3Ubi10cbCOKUUdGqErfAtQy18UojJDVZBZAeJPmAZC64zsFg16jUAEITvFIf1hrYpTQZBgwYcI5zqludPifMTSS6wLqiOTv9S1e9A786ZCZAdtHzNZCxHQk081ZBYOKKk5zKcGg5HO";
    $phone_number_id = "996968323489287";

    $url = "https://graph.facebook.com/v22.0/{$phone_number_id}/messages";

    $bodyParams = [];
    foreach ($params as $p) {
        $bodyParams[] = ["type" => "text", "text" => $p];
    }

    $payload = [
        "messaging_product" => "whatsapp",
        "to" => $phone,
        "type" => "template",
        "template" => [
            "name" => $template,
            "language" => ["code" => "en"],
            "components" => [
                ["type" => "body", "parameters" => $bodyParams]
            ]
        ]
    ];

    $headers = [
        "Authorization: Bearer {$token}",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_RETURNTRANSFER => true
    ]);

    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($code === 200 || $code === 201);
}

/* -------------------------------------------------
   REDIRECT BACK WITH RESULT
-------------------------------------------------- */

header(
    "Location: " . BASE_URL .
    "admin/whatsapp-broadcast.php?sent={$sent}&failed={$failed}"
);
exit;
