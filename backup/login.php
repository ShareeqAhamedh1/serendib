<?php require_once 'backend/conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | School ERP</title>

<style>
  /* ----------- Global Reset ----------- */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #0056b3, #00b4d8);
    padding: 20px;
  }

  /* ----------- Login Card ----------- */
  .login-card {
    width: 360px;
    background: #fff;
    border-radius: 12px;
    padding: 30px 25px;
    box-shadow: 0px 8px 25px rgba(0,0,0,0.15);
    animation: fadeIn 0.6s ease;
  }

  .login-card h2 {
    text-align: center;
    color: #002b5c;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: 600;
  }

  /* ----------- Inputs ----------- */
  .login-card label {
    font-weight: 500;
    display: block;
    margin-bottom: 5px;
    color: #333;
  }

  .login-card input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccd6e0;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 15px;
    transition: 0.2s;
  }

  .login-card input:focus {
    border-color: #007bff;
    box-shadow: 0 0 4px rgba(0,123,255,0.5);
    outline: none;
  }

  /* ----------- Button ----------- */
  .login-card button {
    width: 100%;
    padding: 12px;
    background: #007bff;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.25s;
    font-weight: 600;
  }

  .login-card button:hover {
    background: #0056b3;
  }

  /* ----------- Error Message ----------- */
  .error-msg {
    background: #f8d7da;
    color: #842029;
    padding: 8px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 14px;
    text-align: center;
  }

  /* Animation */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
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


<div class="login-card">

  <h2>🔐 School ERP Login</h2>

  <?php if (isset($_GET['error'])): ?>
    <div class="error-msg">Invalid username or password</div>
  <?php endif; ?>

  <form method="POST" action="<?= BASE_URL ?>backend/auth.php">

    <label>Username or Email</label>
    <input type="text" name="username" placeholder="Enter username or email" required>

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter password" required>

    <button type="submit" name="login">Sign In</button>

  </form>
</div>

</body>
</html>
