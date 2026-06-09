<?php
require_once __DIR__ . '/../backend/conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . '/../backend/helpers.php';
$role = $_SESSION['role_name'] ?? 'guest';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= ucfirst($role) ?> Portal</title>
<link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/favicon.png">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
:root{
    --primary:#003366;
    --primary-light:#0055aa;
    --bg:#f4f6fb;
    --card:#ffffff;
    --text:#222;
    --muted:#666;
    --radius:14px;
}

/* ================= GLOBAL ================= */
*{
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    margin:0;
    font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
    background:var(--bg);
    color:var(--text);
    overflow-x:hidden;
}

/* ================= SIDEBAR ================= */
.sidebar{
    width:270px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:linear-gradient(180deg,#002244,#00152d);
    padding-top:18px;
    color:#fff;
    z-index:1000;
    transition:transform .3s ease;

    overflow-y:auto;
    overflow-x:hidden;

    scrollbar-width:thin;
    scrollbar-color:rgba(255,255,255,.2) transparent;
}

/* CHROME SCROLLBAR */
.sidebar::-webkit-scrollbar{
    width:6px;
}

.sidebar::-webkit-scrollbar-track{
    background:transparent;
}

.sidebar::-webkit-scrollbar-thumb{
    background:rgba(255,255,255,.2);
    border-radius:20px;
}

.sidebar::-webkit-scrollbar-thumb:hover{
    background:rgba(255,255,255,.4);
}

/* ================= LOGO ================= */
.sidebar-logo{
    text-align:center;
    padding:10px 20px 24px;
    border-bottom:1px solid rgba(255,255,255,.08);
    margin-bottom:12px;
}

.sidebar-logo img{
    width:60px;
    height:60px;
    object-fit:contain;
    margin-bottom:10px;
}

.sidebar-logo h3{
    margin:0;
    font-size:20px;
    font-weight:700;
    color:#fff;
}

/* ================= SIDEBAR LINKS ================= */
.sidebar a,
.menu-title{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;

    width:calc(100% - 24px);

    padding:14px 18px;
    margin:4px 12px;

    border-radius:12px;

    color:#fff;
    text-decoration:none;

    font-size:15px;
    font-weight:500;

    transition:.25s ease;

    white-space:nowrap;
    cursor:pointer;
}

/* LEFT SIDE */
.sidebar a i,
.menu-title i{
    width:18px;
    min-width:18px;
    text-align:center;
}

/* HOVER */
.sidebar a:hover,
.menu-title:hover{
    background:rgba(255,255,255,.12);
    transform:translateX(2px);
}

/* ACTIVE */
.sidebar a.active{
    background:linear-gradient(135deg,#0d6efd,#0056b3);
    box-shadow:0 6px 16px rgba(13,110,253,.25);
}

/* ================= MENU GROUP ================= */
.menu-group{
    margin-top:6px;
}

/* ================= SUBMENU ================= */
.submenu{
    display:none;
    margin-top:4px;
    padding-left:10px;
}

.submenu a{
    font-size:14px;
    padding:12px 16px;
    margin:4px 0 4px 12px;
    background:rgba(255,255,255,.03);
}

/* OPEN */
.menu-group.open .submenu{
    display:block;
}

/* ================= MENU ARROW ================= */
.menu-arrow{
    margin-left:auto;
    font-size:13px;
    transition:.25s ease;
}

.menu-group.open .menu-arrow{
    transform:rotate(90deg);
}

/* ================= TOPBAR ================= */
.topbar{
    margin-left:270px;
    padding:14px 22px;
    background:var(--card);
    border-bottom:1px solid #e3e6ef;

    display:flex;
    align-items:center;
    gap:14px;

    position:sticky;
    top:0;
    z-index:900;

    box-shadow:0 2px 10px rgba(0,0,0,.04);
}

/* ================= TOPBAR USER ================= */
.topbar-user{
    margin-left:auto;
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:600;
    color:#333;
}

.topbar-user i{
    font-size:20px;
    color:#0d6efd;
}

/* ================= CONTENT ================= */
.content{
    margin-left:270px;
    padding:24px;
}

/* ================= BURGER ================= */
.burger{
    display:none;
    font-size:24px;
    cursor:pointer;
    color:#333;
}

/* ================= OVERLAY ================= */
.overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    z-index:900;
    backdrop-filter:blur(2px);
}

/* ================= MOBILE ================= */
@media (max-width:768px){

    .sidebar{
        transform:translateX(-100%);
        width:280px;

        overflow-y:auto;
        -webkit-overflow-scrolling:touch;
    }

    .sidebar.active{
        transform:translateX(0);
    }

    .topbar{
        margin-left:0;
        padding:14px 16px;
    }

    .content{
        margin-left:0;
        padding:16px;
    }

    .burger{
        display:block;
    }

    .overlay.active{
        display:block;
    }

    .sidebar a,
    .menu-title{
        font-size:15px;
        padding:15px 16px;
    }

    .submenu a{
        font-size:14px;
        padding:13px 14px;
    }

    .topbar-user{
        font-size:14px;
    }

    .topbar-user i{
        font-size:18px;
    }
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
    <div class="sidebar-logo">

    <img src="<?= BASE_URL ?>assets/img/favicon.png" alt="Logo">

    <h3><?= ucfirst($role) ?> Portal</h3>

</div>

<?php if($role == 'student'): ?>
<a href="dashboard.php" class="<?= $currentPage=='dashboard.php'?'active':'' ?>">
    <i class="fas fa-house"></i> Dashboard
</a>

<a href="profile.php" class="<?= $currentPage=='profile.php'?'active':'' ?>">
    <i class="fas fa-user"></i> Profile
</a>

<a href="notes.php">
    <i class="fas fa-book"></i> My Notes
</a>

<a href="homeworks.php">
    <i class="fas fa-book-open"></i> Homework
</a>

<a href="attendance.php">
    <i class="fas fa-calendar-check"></i> Attendance
</a>

<a href="fees.php">
    <i class="fas fa-money-bill-wave"></i> Fees
</a>

<a href="exams.php">
    <i class="fas fa-file-pen"></i> Exams
</a>

<?php elseif($role == 'teacher'): ?>
<a href="dashboard.php" 
   class="<?= $currentPage=='dashboard.php'?'active':'' ?>">

    <i class="fas fa-house"></i>
    Dashboard

</a>

<a href="profile.php" 
   class="<?= $currentPage=='profile.php'?'active':'' ?>">

    <i class="fas fa-user"></i>
    Profile

</a>

<a href="attendance.php" 
   class="<?= $currentPage=='attendance.php'?'active':'' ?>">

    <i class="fas fa-calendar-check"></i>
    Attendance

</a>

<!-- TIMETABLE -->
<div class="menu-group">

    <div class="menu-title" onclick="toggleMenu(this)">

        <span>
            <i class="fas fa-calendar-days"></i>
            Timetable
        </span>

        <span class="menu-arrow">
            <i class="fas fa-chevron-right"></i>
        </span>

    </div>

    <div class="submenu">

        <a href="class-timetable.php"
           class="<?= $currentPage=='class-timetable.php'?'active':'' ?>">

            <i class="fas fa-table"></i>
            Class Timetable

        </a>

        <a href="timetable.php"
           class="<?= $currentPage=='timetable.php'?'active':'' ?>">

            <i class="fas fa-clock"></i>
            My Timetable

        </a>

    </div>

</div>

<!-- HOMEWORK -->
<div class="menu-group">

    <div class="menu-title" onclick="toggleMenu(this)">

        <span>
            <i class="fas fa-book-open"></i>
            Homework
        </span>

        <span class="menu-arrow">
            <i class="fas fa-chevron-right"></i>
        </span>

    </div>

    <div class="submenu">

        <a href="assign-homework.php"
           class="<?= $currentPage=='assign-homework.php'?'active':'' ?>">

            <i class="fas fa-plus"></i>
            Assign Homework

        </a>

        <a href="view-homeworks.php"
           class="<?= $currentPage=='view-homeworks.php'?'active':'' ?>">

            <i class="fas fa-eye"></i>
            View Homeworks

        </a>

        <a href="homework-submissions.php"
           class="<?= $currentPage=='homework-submissions.php'?'active':'' ?>">

            <i class="fas fa-file-upload"></i>
            Submissions

        </a>

    </div>

</div>

<!-- NOTES -->
<div class="menu-group">

    <div class="menu-title" onclick="toggleMenu(this)">

        <span>
            <i class="fas fa-book"></i>
            Notes
        </span>

        <span class="menu-arrow">
            <i class="fas fa-chevron-right"></i>
        </span>

    </div>

    <div class="submenu">

        <a href="upload-notes.php"
           class="<?= $currentPage=='upload-notes.php'?'active':'' ?>">

            <i class="fas fa-cloud-upload-alt"></i>
            Upload Notes

        </a>

        <a href="view-notes.php"
           class="<?= $currentPage=='view-notes.php'?'active':'' ?>">

            <i class="fas fa-folder-open"></i>
            My Notes

        </a>

    </div>

</div>

<a href="class-students.php"
   class="<?= $currentPage=='class-students.php'?'active':'' ?>">

    <i class="fas fa-users"></i>
    My Students

</a>

<a href="leave-request.php"
   class="<?= $currentPage=='leave-request.php'?'active':'' ?>">

    <i class="fas fa-calendar-minus"></i>
    Leave Request

</a>

<a href="salary.php"
   class="<?= $currentPage=='salary.php'?'active':'' ?>">

    <i class="fas fa-wallet"></i>
    My Salary

</a>

<a href="marks.php"
   class="<?= $currentPage=='marks.php'?'active':'' ?>">

    <i class="fas fa-marker"></i>
    Marks

</a>

<a href="marks-report.php"
   class="<?= $currentPage=='marks-report.php'?'active':'' ?>">

    <i class="fas fa-chart-column"></i>
    Marks Report

</a>

<?php elseif($role == 'parent'): ?>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 My Profile</a>
    <a href="children.php">👨‍👩‍👦 My Children</a>
    <a href="fees.php">💰 Fees</a>
    <a href="marks.php">📝 Exams</a>
<?php endif; ?>

<a href="../backend/auth_portal.php?logout=1"
   style="margin-top:20px;background:rgba(220,53,69,.15);">

   <i class="fas fa-right-from-bracket"></i>
   Logout

</a>
</div>

<!-- ================= TOPBAR ================= -->
<div class="topbar">

    <span class="burger" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </span>

    <div class="topbar-user">

        <i class="fas fa-circle-user"></i>

        <?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>

    </div>

</div>

<!-- ================= CONTENT ================= -->
<div class="content">
