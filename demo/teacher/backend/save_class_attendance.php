<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../attendance.php");
    exit;
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    header("Location: ../attendance.php?ok=0");
    exit;
}

date_default_timezone_set('Asia/Colombo');

$date       = $_POST['date'];
$class_id   = (int)$_POST['class_id'];
$section_id  = (int)$_POST['section_id'];

$all_ids = $_POST['all_ids'] ?? [];
$present = $_POST['present'] ?? [];

$now = date("H:i:s");

$conn->begin_transaction();

try {

    // ✅ SELECT existing row WITH status + time_in
    $sel = $conn->prepare("
        SELECT id, status, time_in 
        FROM attendance
        WHERE entity_type='student' AND entity_id=? AND date=?
        LIMIT 1
    ");

    // ✅ INSERT
    $insert = $conn->prepare("
        INSERT INTO attendance (entity_id, entity_type, date, time_in, status)
        VALUES (?, 'student', ?, ?, ?)
    ");

    // ✅ UPDATE
    $update = $conn->prepare("
        UPDATE attendance
        SET time_in=?, status=?
        WHERE id=?
    ");

    foreach ($all_ids as $sid) {

        $sid = (int)$sid;
        $isPresent = isset($present[$sid]);

        // ✅ Load existing row
        $sel->bind_param("is", $sid, $date);
        $sel->execute();
        $existing = $sel->get_result()->fetch_assoc();

        $oldStatus = $existing ? strtolower($existing['status']) : null;
        $oldTime   = $existing['time_in'] ?? null;

        /* ----------------------------------------------
           ✅ CASE 1: PRESENT SELECTED
        ------------------------------------------------ */
        if ($isPresent) {

            // ✅ If already present → do not update anything
            if ($oldStatus === "present") {
                continue;
            }

            // ✅ If changing from absent → present
            $timeToSet = $oldStatus ? $now : $now; // new present
            $status = "present";

            if ($existing) {
                $update->bind_param("ssi", $timeToSet, $status, $existing['id']);
                $update->execute();
            } else {
                $insert->bind_param("isss", $sid, $date, $timeToSet, $status);
                $insert->execute();
            }

            continue;
        }

        /* ----------------------------------------------
           ✅ CASE 2: ABSENT SELECTED
        ------------------------------------------------ */
        if (!$isPresent) {

            // ✅ If already absent → do nothing
            if ($oldStatus === "absent") {
                continue;
            }

            // ✅ Switch from present → absent
            $timeToSet = "00:00:00";
            $status = "absent";

            if ($existing) {
                $update->bind_param("ssi", $timeToSet, $status, $existing['id']);
                $update->execute();
            } else {
                $insert->bind_param("isss", $sid, $date, $timeToSet, $status);
                $insert->execute();
            }
        }
    }

    $conn->commit();
    header("Location: ../attendance.php?date={$date}&ok=1");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    header("Location: ../attendance.php?date={$date}&ok=0");
    exit;
}
