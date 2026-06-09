<?php
include '../partials/portal_header.php';
require_once '../backend/conn.php';
require_once '../backend/helpers.php';

$user_id = $_SESSION['user_id'];

// ✅ Fetch student record linked to user
$stmt = $conn->prepare("
    SELECT s.*, c.class_name, sec.section_name, 
           p.full_name AS parent_name, p.email AS parent_email, p.phone AS parent_phone,
           u.username, u.email AS user_email
    FROM students s
    JOIN users u ON u.id = s.user_id
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN sections sec ON s.section_id = sec.id
    LEFT JOIN parents p ON s.parent_id = p.id
    WHERE s.user_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    echo "<p style='color:red;'>Student record not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

// ✅ Flash messages (from portal_profile.php)
$ok  = $_GET['ok']  ?? '';
$err = $_GET['err'] ?? '';
?>

<style>
.profile-wrapper {
    max-width: 900px;
    margin:auto;
}
.profile-card {
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}
.profile-header {
    display:flex;
    align-items:center;
    gap:20px;
}
.profile-header img {
    width:110px;
    height:110px;
    border-radius:12px;
    object-fit:cover;
}
.section-title {
    margin-top:25px;
    font-size:20px;
    font-weight:bold;
}
.info-table {
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}
.info-table td {
    padding:8px 5px;
    border-bottom:1px solid #eee;
}
.info-table td:first-child {
    width:180px;
    font-weight:bold;
    color:#333;
}

.card-sub {
    background:white;
    padding:20px;
    margin-top:25px;
    border-radius:12px;
    box-shadow:0 1px 5px rgba(0,0,0,0.1);
}

.form-control {
    width:100%;
    padding:12px;
    margin-top:6px;
    border:1px solid #ccc;
    border-radius:8px;
}
.btn-primary {
    background:#007bff;
    color:white;
    padding:10px 15px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    margin-top:10px;
}
.btn-primary:hover {
    background:#0056b3;
}

.msg-ok {
    background:#d4edda;
    padding:10px;
    border-radius:8px;
    color:#155724;
    margin-bottom:15px;
}
.msg-err {
    background:#f8d7da;
    padding:10px;
    border-radius:8px;
    color:#721c24;
    margin-bottom:15px;
}
</style>

<div class="profile-wrapper">
    <h2>👤 My Profile</h2>

    <!-- ✅ Flash Messages -->
    <?php if($ok): ?>
        <div class="msg-ok">✅ <?= htmlspecialchars($ok) ?></div>
    <?php endif; ?>
    <?php if($err): ?>
        <div class="msg-err">⚠️ <?= htmlspecialchars($err) ?></div>
    <?php endif; ?>


    <!-- ✅ MAIN PROFILE CARD -->
    <div class="profile-card">

        <!-- ✅ Profile Header -->
        <div class="profile-header">
            <img src="../uploads/<?= $student['photo'] ?: 'default.png' ?>" alt="Student">

            <div>
                <h2 style="margin:0;"><?= esc($student['first_name'] . ' ' . $student['last_name']) ?></h2>
                <p style="margin:3px 0; color:#555;">Admission No: <b><?= esc($student['admission_no']) ?></b></p>
                <p style="margin:3px 0; color:#555;">
                    <?= esc($student['class_name']) ?> - <?= esc($student['section_name']) ?>
                </p>
            </div>
        </div>

        <!-- ✅ Basic Info -->
        <h3 class="section-title">📄 Basic Information</h3>
        <table class="info-table">
            <tr><td>Full Name</td><td><?= esc($student['first_name'].' '.$student['last_name']) ?></td></tr>
            <tr><td>Gender</td><td><?= esc(ucfirst($student['gender'])) ?></td></tr>
            <tr><td>Date of Birth</td><td><?= esc($student['dob']) ?></td></tr>
            <tr><td>Medium</td><td><?= esc($student['medium']) ?></td></tr>
            <tr><td>Address</td><td><?= esc($student['address']) ?></td></tr>
        </table>

        <!-- ✅ Parent Info -->
        <h3 class="section-title">👨‍👩‍👧 Parent Details</h3>
        <table class="info-table">
            <tr><td>Name</td><td><?= esc($student['parent_name'] ?: '-') ?></td></tr>
            <tr><td>Email</td><td><?= esc($student['parent_email'] ?: '-') ?></td></tr>
            <tr><td>Phone</td><td><?= esc($student['parent_phone'] ?: '-') ?></td></tr>
        </table>

    </div>

    <!-- ✅ Update Photo -->
    <!--<div class="card-sub">-->
    <!--    <h3>🖼 Update Profile Photo</h3>-->
    <!--    <form method="post" action="<?= BASE_URL ?>/student/backend/portal_profile.php?action=update_photo" enctype="multipart/form-data">-->
    <!--        <?= csrf_field() ?>-->
    <!--        <input type="hidden" name="who" value="student">-->

    <!--        <label>Choose New Photo</label>-->
    <!--        <input type="file" name="photo" class="form-control" accept="image/*" required>-->

    <!--        <button class="btn-primary">Upload</button>-->
    <!--    </form>-->
    <!--</div>-->

    <!-- ✅ Change Password -->
    <div class="card-sub">
        <h3>🔒 Change Password</h3>
        <form method="post" action="<?= BASE_URL ?>/student/backend/portal_profile.php?action=change_password">
            <?= csrf_field() ?>
            <input type="hidden" name="who" value="student">

            <label>Current Password</label>
            <input type="password" name="current_password" class="form-control" required>

            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" minlength="6" required>

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" minlength="6" required>

            <button class="btn-primary">Update Password</button>
        </form>
    </div>

</div>

<?php include '../partials/portal_footer.php'; ?>
