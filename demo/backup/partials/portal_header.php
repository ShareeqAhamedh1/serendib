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
<html>
<head>
<meta charset="UTF-8">
<title><?= ucfirst($role) ?> Portal</title>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}
.sidebar {
    width: 220px;
    height: 100vh;
    position: fixed;
    left:0;
    top:0;
    background: #003366;
    padding-top: 20px;
    color:white;
}
.sidebar a {
    display: block;
    color:white;
    padding: 12px;
    text-decoration:none;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}
.sidebar a:hover {
    background:#0055aa;
}
.topbar {
    margin-left:220px;
    padding:15px;
    background:white;
    border-bottom:1px solid #ddd;
}
.content {
    margin-left:220px;
    padding:20px;
}
</style>
</head>
<body>

<div class="sidebar">
    <h3 style="text-align:center;"><?= ucfirst($role) ?></h3>
    <?php if($role == 'student'): ?>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="profile.php">👤 Profile</a>
        <a href="attendance.php">📅 Attendance</a>
        <a href="fees.php">💰 Fees</a>
        <a href="exams.php">📝 Exams</a>
<?php elseif($role == 'teacher'): ?>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="profile.php">👤 Profile</a>
    <a href="attendance.php">📅 Attendance</a>
    <a href="class-students.php">👨‍🎓 My Students</a>
    <a href="class-timetable.php">🗓 Class Timetable</a>
<a href="timetable.php">📆 My Timetable</a>

    <!-- MARKS MENU -->
    <a href="marks.php">📝 Marks</a>
    <!-- <a href="enter-marks-bulk.php">📝 Enter Marks – Bulk</a> -->
    <a href="marks-report.php">📊 Marks Report</a>

    <?php elseif($role == 'parent'): ?>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="profile.php">👤 My Profile</a>
        <a href="children.php">👨‍👩‍👦 My Children</a>
        <a href="attendance.php">📅 Attendance</a>
        <a href="fees.php">💰 Fees</a>
        <a href="exams.php">📝 Exams</a>
    <?php endif; ?>

    <a href="../backend/auth.php?logout=1">🚪 Logout</a>
</div>

<div class="topbar">
    Welcome, <?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>
</div>

<div class="content">
