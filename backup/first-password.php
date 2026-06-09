<?php
require_once 'backend/conn.php';
if (!isset($_SESSION['temp_user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p1 = $_POST['password'];
    $p2 = $_POST['confirm'];

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
        header("Location: login.php?set=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Set Password</title>
<style>
/* your login style */
</style>
</head>
<body>

<div class="login-card">
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
