<?php
session_start();
require_once __DIR__ . '../../../backend/conn.php';

$user_id = $_SESSION['user_id'];

/* ---------------------------------------
   UPDATE PROFILE INFO
--------------------------------------- */
if (isset($_POST['update_profile'])) {

    $full_name  = trim($_POST['full_name']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $occupation = trim($_POST['occupation']);
    $address    = trim($_POST['address']);

    if ($full_name === '' || $email === '') {
        header("Location: ../profile.php?error=Name and email are required");
        exit;
    }

    /* -------------------------------
       UPDATE USERS TABLE
       (FULL NAME INCLUDED ✔)
    -------------------------------- */
    $stmt = $conn->prepare("
        UPDATE users
        SET full_name = ?, email = ?, phone = ?
        WHERE id = ?
    ");
    $stmt->bind_param(
        'sssi',
        $full_name,
        $email,
        $phone,
        $user_id
    );
    $stmt->execute();
    $stmt->close();

    /* -------------------------------
       UPDATE PARENTS TABLE
       (FULL NAME INCLUDED ✔)
    -------------------------------- */
    $stmt = $conn->prepare("
        UPDATE parents
        SET full_name = ?, email = ?, phone = ?, occupation = ?, address = ?
        WHERE user_id = ?
    ");
    $stmt->bind_param(
        'sssssi',
        $full_name,
        $email,
        $phone,
        $occupation,
        $address,
        $user_id
    );
    $stmt->execute();
    $stmt->close();

    header("Location: ../profile.php?success=Profile updated successfully");
    exit;
}

/* ---------------------------------------
   CHANGE PASSWORD
--------------------------------------- */
if (isset($_POST['change_password'])) {

    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        header("Location: ../profile.php?error=Passwords do not match");
        exit;
    }

    if (strlen($new) < 6) {
        header("Location: ../profile.php?error=Password must be at least 6 characters");
        exit;
    }

    /* Get current password hash */
    $stmt = $conn->prepare("
        SELECT password FROM users WHERE id = ?
    ");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!password_verify($current, $row['password'])) {
        header("Location: ../profile.php?error=Current password incorrect");
        exit;
    }

    $hash = password_hash($new, PASSWORD_DEFAULT);

    /* Update USERS password */
    $stmt = $conn->prepare("
        UPDATE users
        SET password = ?, must_reset_password = 0
        WHERE id = ?
    ");
    $stmt->bind_param('si', $hash, $user_id);
    $stmt->execute();
    $stmt->close();

    /* Update PARENTS password */
    $stmt = $conn->prepare("
        UPDATE parents
        SET password = ?
        WHERE user_id = ?
    ");
    $stmt->bind_param('si', $hash, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../profile.php?success=Password changed successfully");
    exit;
}

/* ---------------------------------------
   FALLBACK
--------------------------------------- */
header("Location: ../profile.php");
exit;
