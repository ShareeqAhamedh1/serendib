<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$user_id = $_SESSION['user_id'] ?? 0;

// Fetch teacher linked to this user
$stmt = $conn->prepare("
  SELECT t.*, s.subject_name
  FROM teachers t
  LEFT JOIN subjects s ON t.subject_id = s.id
  WHERE t.user_id = ? LIMIT 1
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

if(!$teacher){
  echo "<p style='color:red'>Teacher record not found.</p>";
  include '../partials/portal_footer.php';
  exit;
}
?>
<style>
.card{background:#fff;padding:22px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.08);max-width:960px;margin:0 auto;}
.row{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.row-1{display:flex;gap:18px;align-items:center}
.avatar{width:110px;height:110px;border-radius:12px;object-fit:cover}
.section-title{margin-top:22px;font-weight:700}
.form-mini input[type="password"], .form-mini input[type="file"]{width:100%;padding:10px;border:1px solid #ddd;border-radius:6px}
.btn-sm{padding:8px 12px;border:0;border-radius:6px;background:#0047b3;color:#fff;cursor:pointer}
.btn-sm.secondary{background:#777}
.note{color:#666;font-size:13px}
.kv{width:100%;border-collapse:collapse;margin-top:8px}
.kv td{padding:8px 6px;border-bottom:1px solid #eee}
.kv td:first-child{width:180px;font-weight:600;color:#333}
.alert{padding:10px;border-radius:8px;margin-bottom:10px}
.alert.success{background:#e9f7ef;color:#19692c}
.alert.error{background:#fdecea;color:#611a15}
</style>

<div class="card">
  <div class="row-1">
    <img class="avatar" src="../uploads/<?= htmlspecialchars($teacher['photo'] ?: 'default.png') ?>" alt="">
    <div>
      <h2 style="margin:0"><?= esc($teacher['first_name'].' '.$teacher['last_name']) ?></h2>
      <div class="note">Code: <b><?= esc($teacher['teacher_code']) ?></b></div>
      <div class="note"><?= esc($teacher['subject_name'] ?? '-') ?></div>
      <div class="note">Status: <b><?= esc(ucfirst($teacher['status'])) ?></b></div>
    </div>
  </div>

  <h3 class="section-title">📄 Basic Information</h3>
  <table class="kv">
    <tr><td>First name</td><td><?= esc($teacher['first_name']) ?></td></tr>
    <tr><td>Last name</td><td><?= esc($teacher['last_name']) ?></td></tr>
    <tr><td>Gender</td><td><?= esc(ucfirst($teacher['gender'])) ?></td></tr>
    <tr><td>Email</td><td><?= esc($teacher['email']) ?></td></tr>
    <tr><td>Phone</td><td><?= esc($teacher['phone']) ?></td></tr>
    <tr><td>Subject</td><td><?= esc($teacher['subject_name'] ?? '-') ?></td></tr>
    <tr><td>Join Date</td><td><?= esc($teacher['join_date']) ?></td></tr>
  </table>

  <!-- Update Password -->
  <h3 class="section-title">🔑 Change Password</h3>
  <?php if(isset($_GET['pwd']) && $_GET['pwd']=='ok'): ?>
    <div class="alert success">Password updated successfully.</div>
  <?php elseif(isset($_GET['pwd']) && $_GET['pwd']=='fail'): ?>
    <div class="alert error">Failed to update password. Please check current password and try again.</div>
  <?php endif; ?>
  <form class="form-mini" method="post" action="backend/update_password.php">
    <?= csrf_field() ?>
    <input type="hidden" name="user_id" value="<?= (int)$_SESSION['user_id'] ?>">
    <div class="row">
      <div>
    <label>Current Password</label>
    <div style="position:relative;">
        <input type="password" name="current_password" required>
        <span class="pwd-toggle" style="position:absolute;right:10px;top:10px;cursor:pointer;">👁️</span>
    </div>
</div>

<div>
    <label>New Password</label>
    <div style="position:relative;">
        <input type="password" name="new_password" minlength="6" required>
        <span class="pwd-toggle" style="position:absolute;right:10px;top:10px;cursor:pointer;">👁️</span>
    </div>
</div>

<div>
    <label>Confirm New Password</label>
    <div style="position:relative;">
        <input type="password" name="confirm_password" minlength="6" required>
        <span class="pwd-toggle" style="position:absolute;right:10px;top:10px;cursor:pointer;">👁️</span>
    </div>
</div>

    </div>
    <br>
    <button class="btn-sm" type="submit">Save Password</button>
  </form>

  <!-- Update Photo -->
  <h3 class="section-title">🖼 Change Photo</h3>
  <?php if(isset($_GET['photo']) && $_GET['photo']=='ok'): ?>
    <div class="alert success">Photo updated successfully.</div>
  <?php elseif(isset($_GET['photo']) && $_GET['photo']=='fail'): ?>
    <div class="alert error">Failed to update photo. Try a JPG/PNG/GIF smaller file.</div>
  <?php endif; ?>
  <form class="form-mini" method="post" action="backend/update_photo.php" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="teacher_id" value="<?= (int)$teacher['id'] ?>">
    <div class="row">
      <div>
        <label>Upload new photo</label>
        <input type="file" name="photo" accept="image/*" required>
        <div class="note">Max ~2MB. Allowed: jpg, jpeg, png, gif</div>
      </div>
    </div>
    <br>
    <button class="btn-sm" type="submit">Save Photo</button>
    <a class="btn-sm secondary" href="profile.php">Cancel</a>
  </form>
</div>


<script>
// Auto hide success/error messages
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => el.style.display = "none");
}, 3000);

// Toggle eye visibility
document.querySelectorAll('.pwd-toggle').forEach(icon => {
    icon.addEventListener('click', function () {
        let input = this.parentElement.querySelector("input");
        if (input.type === "password") {
            input.type = "text";
            this.textContent = "🙈";
        } else {
            input.type = "password";
            this.textContent = "👁️";
        }
    });
});
</script>

<?php include '../partials/portal_footer.php'; ?>
