<?php
// ADMIN LOGIN ONLY

require 'conn.php';
require 'helpers.php';

// Use ADMINSESS for admin authentication
session_name("ADMINSESS");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    /* ------------------------------------------
       1️⃣ Fetch ONLY Admin Users
    -------------------------------------------*/
    $sql = "
        SELECT u.id, u.username, u.email, u.password, u.role_id, u.must_reset_password,
               u.full_name
        FROM users u
        WHERE (u.username = ? OR u.email = ?)
        AND u.role_id = 1
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    /* ------------------------------------------
       2️⃣ Admin Not Found
    -------------------------------------------*/
    if (!$user) {
        $_SESSION['login_error'] = "Incorrect username or password";
        header('Location: ' . BASE_URL . 'admin/login.php');
        exit;
    }

    /* ------------------------------------------
       3️⃣ First-time Password Setup
    -------------------------------------------*/
    if ($user['must_reset_password'] == 1) {

        // Switch to LOGIN session for password reset
        session_name("LOGINSESS");
        session_start();

        $_SESSION['temp_user_id'] = $user['id'];

        header('Location: ' . BASE_URL . 'first-password.php');
        exit;
    }

    /* ------------------------------------------
       4️⃣ Validate Password
    -------------------------------------------*/
    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_error'] = "Incorrect username or password";
        header('Location: ' . BASE_URL . 'admin/login.php');
        exit;
    }

    /* ------------------------------------------
       5️⃣ SUCCESS — Start Admin Session
    -------------------------------------------*/
    session_regenerate_id(true);

    $_SESSION['user_id']   = $user['id'];
    $_SESSION['username']  = $user['username'];
    $_SESSION['role_id']   = 1;
    $_SESSION['role_name'] = "Admin";
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['login_success'] = true;

    /* ------------------------------------------
       6️⃣ Redirect to Admin Dashboard
    -------------------------------------------*/
    header('Location: ' . BASE_URL . 'admin/index.php');
    exit;
}

/* ------------------------------------------
   LOGOUT
-------------------------------------------*/
if (isset($_GET['logout'])) {
    session_name("ADMINSESS");
    session_start();
    session_destroy();

    header('Location: ' . BASE_URL . 'admin/login.php');
    exit;
}
