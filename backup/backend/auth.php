<?php
require 'conn.php'; // includes session_start()
require 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    /* ------------------------------------------------------------------
       1️⃣ Get user by username OR email (admin, parent) 
          OR admission_no (student) 
          OR teacher_code (teacher)
    ------------------------------------------------------------------- */

    $sql = "
        SELECT u.id, u.username, u.email, u.password, u.role_id, u.must_reset_password,
               u.full_name, r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id
        WHERE 
            u.username = ? OR 
            u.email = ? OR 
            u.username = (SELECT admission_no FROM students WHERE admission_no = ?) OR
            u.username = (SELECT teacher_code FROM teachers WHERE teacher_code = ?)
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $username, $username, $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    /* ------------------------------------------------------------------
       2️⃣ If user not found → error
    ------------------------------------------------------------------- */
    if (!$user) {
        $_SESSION['login_error'] = "Invalid username or password.";
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }

    /* ------------------------------------------------------------------
       3️⃣ FIRST LOGIN → redirect to password setup page
    ------------------------------------------------------------------- */
    if ($user['must_reset_password'] == 1) {
        $_SESSION['temp_user_id'] = $user['id'];
        header('Location: ' . BASE_URL . 'first-password.php');
        exit;
    }

    /* ------------------------------------------------------------------
       4️⃣ Validate password
    ------------------------------------------------------------------- */
    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_error'] = "Invalid username or password.";
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }

    /* ------------------------------------------------------------------
       5️⃣ SUCCESS — Set session
    ------------------------------------------------------------------- */
    session_regenerate_id(true);

    $_SESSION['user_id']   = $user['id'];
    $_SESSION['username']  = $user['username'];
    $_SESSION['role_id']   = $user['role_id'];
    $_SESSION['role_name'] = $user['role_name'];
    $_SESSION['full_name'] = $user['full_name'];

    // ✅ SweetAlert success flag
    $_SESSION['login_success'] = true;

    /* ------------------------------------------------------------------
       6️⃣ Redirect based on role
    ------------------------------------------------------------------- */
    switch ($user['role_id']) {
        case 1: // Admin
            header('Location: ' . BASE_URL . 'admin/index.php');
            break;

        case 2: // Student
            header('Location: ' . BASE_URL . 'student/dashboard.php');
            break;

        case 3: // Teacher
            header('Location: ' . BASE_URL . 'teacher/dashboard.php');
            break;

        case 4: // Parent
            header('Location: ' . BASE_URL . 'parent/dashboard.php');
            break;

        default:
            header('Location: ' . BASE_URL . 'login.php');
    }
    exit;
}

/* ------------------------------------------------------------------
   LOGOUT
------------------------------------------------------------------- */
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}
