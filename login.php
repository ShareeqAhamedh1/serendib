<?php require_once 'backend/conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | School User</title>
<link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/favicon.png">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root {
  --primary:#007bff;
  --primary-dark:#0056b3;
  --bg1:#0056b3;
  --bg2:#00b4d8;
  --radius:14px;
}

* {
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body {
  font-family: system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
  min-height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  background: linear-gradient(135deg, var(--bg1), var(--bg2));
  padding:16px;
}

/* ---------- LOGIN CARD ---------- */
.login-card {
  width:100%;
  max-width:380px;
  background:#fff;
  border-radius:var(--radius);
  padding:28px 22px;
  box-shadow:0 10px 28px rgba(0,0,0,.18);
  animation: fadeIn .6s ease;
}

/* ---------- TITLE ---------- */
.login-card h2 {
  display:flex;
  align-items:center;
  justify-content:center;
  gap:10px;
  text-align:center;
  color:#002b5c;
  margin-bottom:22px;
  font-size:22px;
  font-weight:600;
}

.login-card h2 img {
  width:42px;
}

/* ---------- FORM ---------- */
.login-card label {
  font-size:14px;
  font-weight:600;
  color:#333;
  margin-bottom:6px;
  display:block;
}

.login-card input {
  width:100%;
  padding:14px;
  border:1px solid #ccd6e0;
  border-radius:8px;
  margin-bottom:16px;
  font-size:16px; /* IMPORTANT for mobile zoom */
}

.login-card input:focus {
  border-color:var(--primary);
  outline:none;
  box-shadow:0 0 0 3px rgba(0,123,255,.15);
}

/* ---------- BUTTON ---------- */
.login-card button {
  width:100%;
  padding:14px;
  background:var(--primary);
  border:none;
  border-radius:8px;
  color:#fff;
  font-size:16px;
  font-weight:600;
  cursor:pointer;
  transition:.25s;
}

.login-card button:hover {
  background:var(--primary-dark);
}

/* ---------- ERROR ---------- */
.error-msg {
  background:#f8d7da;
  color:#842029;
  padding:10px;
  border-radius:8px;
  margin-bottom:16px;
  font-size:14px;
  text-align:center;
}

/* ---------- MOBILE REFINEMENTS ---------- */
@media (max-width:480px) {

  body {
    padding:12px;
  }

  .login-card {
    padding:22px 18px;
  }

  .login-card h2 {
    font-size:20px;
  }
}

/* ---------- ANIMATION ---------- */
@keyframes fadeIn {
  from { opacity:0; transform: translateY(14px); }
  to { opacity:1; transform: translateY(0); }
}
</style>

</head>

<body>

<?php if (!empty($_SESSION['login_error'])): ?>
<script>
Swal.fire({
  icon: 'error',
  title: 'Login Failed',
  text: '<?= $_SESSION['login_error'] ?>',
  timer: 2500,
  showConfirmButton: false
});
</script>
<?php unset($_SESSION['login_error']); endif; ?>

<?php if (isset($_GET['password_changed'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Password Updated',
    text: 'Login using your new password.',
    timer: 3000,
    showConfirmButton:false
});
</script>
<?php endif; ?>

<?php if (!empty($_SESSION['password_reset_success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Password Updated!',
    text: 'Please login using your new password.',
    timer: 3000,
    showConfirmButton: true
});
</script>
<?php unset($_SESSION['password_reset_success']); endif; ?>

<div class="login-card">

  <h2><img src="assets/img/favicon.png" 
       alt="Admin" 
       style="width:50px; vertical-align:middle; margin-right:10px;"> Serendib User Login</h2>

  <?php if (isset($_GET['error'])): ?>
    <div class="error-msg">Invalid username or password</div>
  <?php endif; ?>

  <form method="POST" action="<?= BASE_URL ?>backend/auth_portal.php">

    <label>Username or Email</label>
    <input type="text" name="username" placeholder="Enter username or email" required>

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter password" required>

    <button type="submit" name="login">Sign In</button>

  </form>
</div>

</body>
</html>
