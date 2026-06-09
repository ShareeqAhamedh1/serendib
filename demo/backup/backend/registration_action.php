<?php
require_once __DIR__ . '/conn.php';

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {

    if ($action === 'check') {
        $stmt = $conn->prepare("UPDATE registrations SET status='checked' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: ../admin/registrations.php?ok=1&msg=Registration marked as checked");
        exit;
    }

    if ($action === 'uncheck') {
        $stmt = $conn->prepare("UPDATE registrations SET status='new' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: ../admin/registrations.php?ok=1&msg=Registration set back to NEW");
        exit;
    }
}

header("Location: ../admin/registrations.php?ok=0&msg=Invalid action");
exit;
