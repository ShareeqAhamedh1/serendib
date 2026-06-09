<?php
include '../partials/portal_header.php';
?>

<h2 style="margin-bottom:15px;">🎓 Student Dashboard</h2>
<p>Welcome to your student portal. Choose an option below:</p>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.card-box {
    background: white;
    padding: 22px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: 0.2s;
}

.card-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}

.card-box h3 {
    margin-top: 0;
}

.card-button {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 16px;
    background: #0055aa;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
}

.card-button:hover {
    background: #003d7a;
}
</style>

<div class="dashboard-grid">

    <!-- Attendance -->
    <div class="card-box">
        <h3>📅 Attendance</h3>
        <p>View your attendance records.</p>
        <a class="card-button" href="attendance.php">Open</a>
    </div>

    <!-- Fees -->
    <div class="card-box">
        <h3>💰 Fee Summary</h3>
        <p>Check your payments and outstanding fees.</p>
        <a class="card-button" href="fees.php">Open</a>
    </div>

    <!-- Exams -->
    <div class="card-box">
        <h3>📝 Exam Results</h3>
        <p>See your grades for recent exams.</p>
        <a class="card-button" href="exams.php">Open</a>
    </div>

    <!-- Profile -->
    <div class="card-box">
        <h3>👤 Profile</h3>
        <p>View and update your personal details.</p>
        <a class="card-button" href="profile.php">Open</a>
    </div>

</div>

<?php include '../partials/portal_footer.php'; ?>
