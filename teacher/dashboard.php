<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

// ✅ Get logged-in teacher
$user_id = $_SESSION['user_id'];
$teacher = $conn->query("
    SELECT id, first_name, last_name, teacher_code 
    FROM teachers 
    WHERE user_id = $user_id LIMIT 1
")->fetch_assoc();

$teacher_id = $teacher['id'] ?? 0;


/* ---------------------------------------------------------
   ✅ Homework Stats
----------------------------------------------------------- */

// Homework assigned today
$hwToday = $conn->query("
    SELECT COUNT(*) AS total
    FROM homeworks
    WHERE teacher_id = $teacher_id
      AND DATE(created_at) = CURDATE()
")->fetch_assoc();

$homeworkTodayCount = $hwToday['total'];

// Total homework assigned
$hwTotal = $conn->query("
    SELECT COUNT(*) AS total
    FROM homeworks
    WHERE teacher_id = $teacher_id
")->fetch_assoc();

$totalHomework = $hwTotal['total'];

// Recent homework (last 5)
$recentHomework = $conn->query("
    SELECT 
        h.title,
        h.due_date,
        s.subject_name,
        c.class_name,
        sec.section_name
    FROM homeworks h
    JOIN subjects s ON s.id = h.subject_id
    JOIN classes c ON c.id = h.class_id
    JOIN sections sec ON sec.id = h.section_id
    WHERE h.teacher_id = $teacher_id
    ORDER BY h.created_at DESC
    LIMIT 5
");

/* ---------------------------------------------------------
   ✅ Attendance for today
----------------------------------------------------------- */
$today = date('Y-m-d');

$att = $conn->query("
    SELECT time_in, time_out ,status
    FROM attendance 
    WHERE entity_type='teacher' 
      AND entity_id=$teacher_id 
      AND date='$today'
")->fetch_assoc();

$attendance_status = "Not Marked";
if ($att) {
    if ($att['status'] == "present") $attendance_status = "Present (Time-in marked)";
    if ($att['status'] == "absent") $attendance_status = "Absent";
    if ($att['status'] == "") $attendance_status = "Not Marked";
    if ($att['time_in'] && $att['time_out']) $attendance_status = "Completed";
}


/* ---------------------------------------------------------
   ✅ Convert day number → day name
----------------------------------------------------------- */
$dayMap = [
    1 => "Monday",
    2 => "Tuesday",
    3 => "Wednesday",
    4 => "Thursday",
    5 => "Friday",
    6 => "Saturday",
    7 => "Sunday"
];

$todayNumber = date('N');
$todayName   = $dayMap[$todayNumber];


/* ---------------------------------------------------------
   ✅ Today's full timetable
----------------------------------------------------------- */
$timetable = $conn->query("
    SELECT 
        tt.*, 
        s.subject_name,
        c.class_name,
        sec.section_name
    FROM timetable tt
    JOIN subjects s ON s.id = tt.subject_id
    JOIN classes c ON c.id = tt.class_id
    JOIN sections sec ON sec.id = tt.section_id
    WHERE tt.teacher_id = $teacher_id
      AND tt.day_of_week = '$todayName'
    ORDER BY tt.start_time
");


/* ---------------------------------------------------------
   ✅ Current ongoing period
----------------------------------------------------------- */
$currentTime = date('H:i:s');

$currentPeriod = $conn->query("
    SELECT 
        tt.*, 
        s.subject_name,
        c.class_name,
        sec.section_name
    FROM timetable tt
    JOIN subjects s ON s.id = tt.subject_id
    JOIN classes c ON c.id = tt.class_id
    JOIN sections sec ON sec.id = tt.section_id
    WHERE tt.teacher_id = $teacher_id
      AND tt.day_of_week = '$todayName'
      AND '$currentTime' BETWEEN tt.start_time AND tt.end_time
    LIMIT 1
")->fetch_assoc();



?>
<style>
:root {
    --primary:#007bff;
    --bg:#f4f6fb;
    --card:#ffffff;
    --text:#333;
    --muted:#777;
    --radius:14px;
}

body {
    background: var(--bg);
}

/* ---------- HEADINGS ---------- */
h2 {
    font-size: 26px;
    margin-bottom: 6px;
}
h3 {
    font-size: 18px;
}

/* ---------- SUMMARY / CARDS ---------- */
.summary-box {
    background: var(--card);
    padding: 18px;
    border-radius: var(--radius);
    box-shadow: 0 6px 18px rgba(0,0,0,.06);
    margin-bottom: 22px;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap: 15px;
}

.summary-item {
    background:#f8f9fc;
    padding:16px;
    border-radius:12px;
}

.summary-item h3 {
    font-size:15px;
    color:var(--muted);
    margin-bottom:6px;
}

.summary-value {
    font-size:26px;
    font-weight:700;
    color:var(--text);
}

.status-green { color:#28a745; }
.status-orange { color:#ff9800; }
.status-red { color:#dc3545; }
.status-yellow { color:yellow; }

/* ---------- MAIN ACTION CARDS ---------- */
.card-container {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(240px,1fr));
    gap:18px;
    margin-bottom:25px;
}

.card-box {
    background:var(--card);
    padding:22px;
    border-radius:var(--radius);
    box-shadow:0 4px 14px rgba(0,0,0,.06);
    transition:.2s ease;
}

.card-box:hover {
    transform: translateY(-4px);
}

.card-title {
    font-size:20px;
    margin-bottom:6px;
}

.card-link {
    display:inline-block;
    margin-top:10px;
    font-weight:600;
    color:var(--primary);
    text-decoration:none;
}

/* ---------- CURRENT PERIOD ---------- */
.summary-box p {
    margin:6px 0;
    color:#444;
}

/* ---------- TABLE (DESKTOP) ---------- */
.table-wrap {
    width:100%;
    overflow-x:auto;
}

table {
    width:100%;
    border-collapse:collapse;
    font-size:15px;
}

thead {
    background:var(--primary);
    color:white;
}

th, td {
    padding:12px 10px;
    text-align:left;
}

tbody tr:nth-child(even) {
    background:#f9f9f9;
}

/* ---------- MOBILE TABLE ---------- */
@media (max-width: 768px) {

    h2 { font-size:22px; }

    table, thead, tbody, th, td, tr {
        display:block;
        width:100%;
    }

    thead {
        display:none;
    }

    tbody tr {
        background:white;
        margin-bottom:14px;
        border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,.05);
        padding:10px;
    }

    td {
        display:flex;
        justify-content:space-between;
        padding:8px 6px;
        border-bottom:1px solid #eee;
        font-size:14px;
    }

    td:last-child {
        border-bottom:none;
    }

    td::before {
        content: attr(data-label);
        font-weight:600;
        color:#555;
    }
}

/* ---------- HOMEWORK ---------- */
.hw-badge {
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-weight:600;
    font-size:14px;
}

.hw-yes {
    background:#e6f9ec;
    color:#0f5132;
}

.hw-no {
    background:#fdecea;
    color:#842029;
}

.hw-card {
    background:#f8f9fc;
    padding:14px;
    border-radius:12px;
    margin-bottom:12px;
}

.hw-card h4 {
    margin-bottom:6px;
    font-size:16px;
}

.hw-meta {
    font-size:14px;
    color:#555;
}

.hw-due {
    margin-top:6px;
    font-weight:600;
}

</style>



<h2>👨‍🏫 Teacher Dashboard</h2>
<!-- <p>Welcome, <b><?= esc($teacher['first_name'] . ' ' . $teacher['last_name']) ?></b></p> -->


<!-- ✅ Summary Section -->
<div class="summary-box">
    <h3>📌 Quick Summary</h3>

    <div class="summary-grid">

        <div class="summary-item">
            <h3>Today's Attendance</h3>
            <div class="summary-value">
                <?php if ($attendance_status == "Completed"): ?>
                    <span class="status-green">Completed</span>
                <?php elseif ($attendance_status == "Present (Time-in marked)"): ?>
                    <span class="status-orange">Present (In)</span>
                 <?php elseif ($attendance_status == "Absent"): ?>
                    <span class="status-red">Absent</span>              
                    <?php else: ?>
                    <span class="status-yellow">Not Marked</span>
                <?php endif; ?>
            </div>
            <small><p><?= date('d M Y - h:i A') ?></p></small>
        </div>

        <div class="summary-item">
    <h3>Homework Today</h3>
    <div class="summary-value">
        <?php if ($homeworkTodayCount > 0): ?>
            <span class="hw-badge hw-yes">Assigned</span>
        <?php else: ?>
            <span class="hw-badge hw-no">Not Assigned</span>
        <?php endif; ?>
    </div>
    <small>Total: <?= $totalHomework ?></small>
</div>

        <div class="summary-item">
            <h3>Teacher Code</h3>
            <div class="summary-value"><?= esc($teacher['teacher_code']) ?></div>
        </div>

    </div>
</div>


<!-- ✅ Current Period -->
<div class="summary-box">
    <h3>📘 Current Period</h3>

    <?php if ($currentPeriod): ?>
        <p><b>Subject:</b> <?= esc($currentPeriod['subject_name']) ?></p>
        <p><b>Time:</b> <?= esc($currentPeriod['start_time']) ?> - <?= esc($currentPeriod['end_time']) ?></p>
        <p><b>Class:</b> <?= esc($currentPeriod['class_name']) ?> - <?= esc($currentPeriod['section_name']) ?></p>
    <?php else: ?>
        <p style="color:#666;">No active period right now.</p>
    <?php endif; ?>
</div>


<!-- ✅ Main Cards -->
<div class="card-container">

    <div class="card-box">
        <h3 class="card-title">📚 My Classes</h3>
        <p>View your assigned classes.</p>
        <a href="class-students.php" class="card-link">View →</a>
    </div>

    <div class="card-box">
        <h3 class="card-title">📝 Mark Attendance</h3>
        <p>Scan or update attendance.</p>
        <a href="attendance.php" class="card-link">View →</a>
    </div>

    <div class="card-box">
        <h3 class="card-title">📊 Exam Marks</h3>
        <p>Enter or update student marks.</p>
        <a href="marks.php" class="card-link">View →</a>
    </div>
</div>

<div class="card-container">

    <div class="card-box">
        <h3 class="card-title">📘 Assign Homework</h3>
        <p>Create and send homework to students.</p>
        <a href="assign-homework.php" class="card-link">Assign →</a>
    </div>

    <div class="card-box">
        <h3 class="card-title">📚 View Homeworks</h3>
        <p>See all homework you’ve assigned.</p>
        <a href="view-homeworks.php" class="card-link">View →</a>
    </div>

</div>


<!-- ✅ Today's Timetable -->
<div class="summary-box">
    <h3>📅 Today's Timetable (<?= $todayName ?>)</h3>

    <?php if ($timetable->num_rows == 0): ?>
        <p style="color:#999;">No periods scheduled for today.</p>
    <?php else: ?>
<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>Time</th>
            <th>Subject</th>
            <th>Class</th>
            <th>Section</th>
        </tr>
    </thead>
    <tbody>
    <?php while($tt = $timetable->fetch_assoc()): ?>
        <tr>
            <td data-label="Time"><?= $tt['start_time'] ?> - <?= $tt['end_time'] ?></td>
            <td data-label="Subject"><?= esc($tt['subject_name']) ?></td>
            <td data-label="Class"><?= esc($tt['class_name']) ?></td>
            <td data-label="Section"><?= esc($tt['section_name']) ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>
<div class="summary-box">
    <h3>📝 Recent Homeworks</h3>

    <?php if ($recentHomework->num_rows == 0): ?>
        <p style="color:#888;">No homework assigned yet.</p>
    <?php else: ?>
        <?php while($hw = $recentHomework->fetch_assoc()): ?>
            <div class="hw-card">
                <h4><?= esc($hw['title']) ?></h4>
                <div class="hw-meta">
                    📘 <?= esc($hw['subject_name']) ?><br>
                    🏫 <?= esc($hw['class_name']) ?> - <?= esc($hw['section_name']) ?>
                </div>
                <div class="hw-due">
                    📅 Due: <?= esc($hw['due_date']) ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

    <?php endif; ?>

    <br>
    <a href="timetable.php" class="btn-sm">📆 View Weekly Timetable</a>
</div>


<?php include '../partials/portal_footer.php'; ?>
