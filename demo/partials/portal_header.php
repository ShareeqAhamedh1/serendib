<?php
require_once __DIR__ . '/../backend/conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . '/../backend/helpers.php';
$role = $_SESSION['role_name'] ?? 'guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= ucfirst($role) ?> Portal</title>
<link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/favicon.png">

<style>
:root {
    --primary:#003366;
    --primary-light:#0055aa;
    --bg:#f4f6fb;
    --card:#ffffff;
    --text:#222;
    --muted:#666;
    --radius:14px;
}

* {
    box-sizing:border-box;
}

body {
    margin:0;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    background:var(--bg);
    color:var(--text);
}

/* ================= SIDEBAR ================= */
.sidebar {
    width:240px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background: #002244;
    padding-top:18px;
    color:white;
    z-index:1000;
    transition:transform .3s ease;
}

.sidebar h3 {
    text-align:center;
    margin:10px 0 20px;
    font-size:20px;
    letter-spacing:.5px;
}

.sidebar a {
    display:flex;
    align-items:center;
    gap:10px;
    padding:14px 18px;
    margin:4px 12px;
    border-radius:10px;
    color:white;
    text-decoration:none;
    font-size:15px;
    transition:background .2s;
}

.sidebar a:hover {
    background:rgba(255,255,255,.14);
}

/* ================= TOPBAR ================= */
.topbar {
    margin-left:240px;
    padding:14px 18px;
    background:var(--card);
    border-bottom:1px solid #e3e6ef;
    display:flex;
    align-items:center;
    gap:14px;
    font-size:15px;
    position:sticky;
    top:0;
    z-index:900;
}

/* ================= CONTENT ================= */
.content {
    margin-left:240px;
    padding:22px;
}

/* ================= BURGER ================= */
.burger {
    display:none;
    font-size:26px;
    cursor:pointer;
}

/* ================= OVERLAY ================= */
.overlay {
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    z-index:900;
}

/* ================= MOBILE ================= */
@media (max-width:768px) {

    body {
        overflow-x:hidden;
    }

    .sidebar {
        transform:translateX(-100%);
        width:260px;
    }

    .sidebar.active {
        transform:translateX(0);
    }

    .topbar {
        margin-left:0;
    }

    .content {
        margin-left:0;
        padding:16px;
    }

    .burger {
        display:block;
    }

    .overlay.active {
        display:block;
    }

    .sidebar a {
        font-size:16px;
        padding:16px 18px;
    }
}
/* ===== SUBMENU ===== */
.menu-group {
    margin: 8px 12px;
}

.menu-group > .menu-title {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:14px 18px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
    font-weight:500;
}

.menu-group > .menu-title:hover {
    background:rgba(255,255,255,.14);
}

.submenu {
    display:none;
    margin-top:6px;
    padding-left:10px;
}

.submenu a {
    padding:12px 18px;
    font-size:14px;
    opacity:.95;
}

/* open state */
.menu-group.open .submenu {
    display:block;
}

.menu-arrow {
    font-size:14px;
    transition:.2s;
}

.menu-group.open .menu-arrow {
    transform:rotate(90deg);
}

</style>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.overlay').classList.toggle('active');
}

function toggleMenu(el) {
    el.parentElement.classList.toggle('open');
}


</script>

</head>
<body>

<div class="overlay" onclick="toggleSidebar()"></div>

<?php if (!empty($_SESSION['login_success'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon:'success',
    title:'Welcome Back!',
    text:'Login successful.',
    timer:2000,
    showConfirmButton:false
});
</script>
<?php unset($_SESSION['login_success']); endif; ?>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <h3><?= ucfirst($role) ?></h3>

<?php if($role == 'student'): ?>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="notes.php">📝 My Notes</a>
    <a href="homeworks.php">📚 Homework</a>
    <a href="attendance.php">📅 Attendance</a>
    <a href="fees.php">💰 Fees</a>
    <a href="exams.php">📝 Exams</a>

<?php elseif($role == 'teacher'): ?>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="attendance.php">📅 Attendance</a>

    <div class="menu-group">
        <div class="menu-title" onclick="toggleMenu(this)">
            <span>📆 Timetable</span>
            <span class="menu-arrow">▶</span>
        </div>

        <div class="submenu">
    <a href="class-timetable.php">🗓 Class Timetable</a>
    <a href="timetable.php">📆 My Timetable</a>
        </div>
    </div>
    <!-- HOMEWORK GROUP -->
    <div class="menu-group">
        <div class="menu-title" onclick="toggleMenu(this)">
            <span>📚 Homework</span>
            <span class="menu-arrow">▶</span>
        </div>

        <div class="submenu">
            <a href="assign-homework.php">➕ Assign Homework</a>
            <a href="view-homeworks.php">📚 View Homeworks</a>
            <a href="homework-submissions.php">📥 Submissions</a>
        </div>
    </div>

        <!-- HOMEWORK GROUP -->
    <div class="menu-group">
        <div class="menu-title" onclick="toggleMenu(this)">
            <span>📚 Notes</span>
            <span class="menu-arrow">▶</span>
        </div>

        <div class="submenu">
<a href="upload-notes.php">📚 Upload Notes</a>
<a href="view-notes.php">📂 My Notes</a>
        </div>
    </div>

    
    <a href="class-students.php">👨‍🎓 My Students</a>
    <a href="leave-request.php">📆 Leave Request</a>
    <a href="salary.php">$ My Salary</a>

    <!-- TEACHER -->


    <a href="marks.php">📝 Marks</a>
    <a href="marks-report.php">📊 Marks Report</a>




<?php elseif($role == 'parent'): ?>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 My Profile</a>
    <a href="children.php">👨‍👩‍👦 My Children</a>
    <a href="fees.php">💰 Fees</a>
    <a href="marks.php">📝 Exams</a>
<?php endif; ?>

    <a href="../backend/auth_portal.php?logout=1">🚪 Logout</a>
</div>

<!-- ================= TOPBAR ================= -->
<div class="topbar">
    <span class="burger" onclick="toggleSidebar()">☰</span>
    Welcome, <b><?= htmlspecialchars($_SESSION['full_name'] ?? '') ?></b>
</div>

<!-- ================= CONTENT ================= -->
<div class="content">
