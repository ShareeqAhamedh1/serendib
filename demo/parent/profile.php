<?php
include '../partials/portal_header.php';
require_once __DIR__ . '../../backend/conn.php';

$user_id = $_SESSION['user_id'];

/* Fetch parent data */
$stmt = $conn->prepare("
    SELECT full_name, email, phone, occupation, address
    FROM parents
    WHERE user_id = ?
");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$parent = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<style>
/* ---------- GENERAL ---------- */
.profile-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 15px;
}

.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* ---------- CARD ---------- */
.card {
    background: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.card h3 {
    margin-bottom: 15px;
    color: #004080;
}

/* ---------- FORM ---------- */
.form-group {
    margin-bottom: 12px;
}

.form-group label {
    font-weight: 600;
    font-size: 14px;
    display: block;
    margin-bottom: 5px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

/* ---------- BUTTON ---------- */
.btn {
    background: #004080;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
}

.btn:hover {
    background: #003060;
}

/* ---------- ALERTS ---------- */
.alert-success {
    background: #e6f9ec;
    color: #0f5132;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.alert-error {
    background: #fdecea;
    color: #842029;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* ---------- MOBILE ---------- */
@media (max-width: 768px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-container">

    <h2>👤 Parent Profile</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert-success"><?= esc($_GET['success']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert-error"><?= esc($_GET['error']) ?></div>
    <?php endif; ?>

    <div class="profile-grid">

        <!-- ================= PROFILE INFO ================= -->
        <div class="card">
            <h3>📝 Profile Information</h3>

            <form method="post" action="backend/update_profile.php">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?= esc($parent['full_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= esc($parent['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?= esc($parent['phone']) ?>">
                </div>

                <div class="form-group">
                    <label>Occupation</label>
                    <input type="text" name="occupation" value="<?= esc($parent['occupation']) ?>">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address"><?= esc($parent['address']) ?></textarea>
                </div>

                <button type="submit" name="update_profile" class="btn">
                    Update Profile
                </button>

            </form>
        </div>

        <!-- ================= PASSWORD ================= -->
        <div class="card">
            <h3>🔐 Change Password</h3>

            <form method="post" action="backend/update_profile.php">

                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required>
                </div>

                <button type="submit" name="change_password" class="btn">
                    Change Password
                </button>

            </form>
        </div>

    </div>
</div>

<?php include '../partials/portal_footer.php'; ?>
