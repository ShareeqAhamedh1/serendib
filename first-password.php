<?php
require_once 'backend/conn.php';
require_once 'backend/helpers.php';

// 🔐 If no temp_user_id → redirect to login
if (!isset($_SESSION['temp_user_id'])) {
    header("Location: login.php");
    exit;
}

$error = "";

// 🔄 When submitting the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $p1 = trim($_POST['password']);
    $p2 = trim($_POST['confirm']);

if ($p1 !== $p2) {
    $error = "Passwords do not match!";
} else {
    $hash = password_hash($p1, PASSWORD_DEFAULT);
    $id = $_SESSION['temp_user_id'];

    $stmt = $conn->prepare("
        UPDATE users 
        SET password=?, must_reset_password=0
        WHERE id=?
    ");
    $stmt->bind_param("si", $hash, $id);
    $stmt->execute();

    unset($_SESSION['temp_user_id']);

    // 🔥 SET SESSION FOR SUCCESS ALERT AFTER LOGIN
    $_SESSION['password_reset_success'] = true;

    header("Location: login.php");
    exit;
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Set New Password | School ERP</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/favicon.png">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        background: #fff;
        width: 95%;
        max-width: 380px;
        padding: 30px 25px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        animation: fadeIn 0.5s ease;
    }

    h2 {
        text-align: center;
        color: #1e3c72;
        margin-bottom: 15px;
        font-size: 22px;
        font-weight: 700;
    }

    label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: #333;
    }

    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #cdd3dd;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 15px;
        transition: border-color 0.3s;
        background: #fdfdfd;
    }

    input:focus {
        border-color: #2a5298;
        outline: none;
        box-shadow: 0 0 5px rgba(42,82,152,0.3);
    }

    button {
        width: 100%;
        padding: 12px;
        border: none;
        background: #2a5298;
        color: white;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: 600;
    }

    button:hover {
        background: #1e3c72;
    }

    .error-msg {
        background: #fce4e4;
        color: #d63031;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
        margin-bottom: 18px;
        font-size: 14px;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>

<body>

<div class="card">
    <h2>🔒 Set Your Password</h2>

    <?php if (!empty($error)): ?>
        <div class="error-msg"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>New Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm" required>

        <button type="submit">Save Password</button>
    </form>
</div>

</body>
</html>
