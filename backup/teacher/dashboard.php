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
   ✅ Attendance for today
----------------------------------------------------------- */
$today = date('Y-m-d');

$att = $conn->query("
    SELECT time_in, time_out 
    FROM attendance 
    WHERE entity_type='teacher' 
      AND entity_id=$teacher_id 
      AND date='$today'
")->fetch_assoc();

$attendance_status = "Not Marked";
if ($att) {
    if ($att['time_in'] && !$att['time_out']) $attendance_status = "Present (Time-in marked)";
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
/* (styles unchanged – keeping your UI as-is) */
.card-box {
    flex:1;
    min-width:230px;
    background:white;
    padding:22px;
    border-radius:10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.07);
    transition:.2s;
}
.card-box:hover { transform: translateY(-3px); }
.card-title { font-size:22px; margin-bottom:8px; }
.card-link { display:inline-block; margin-top:10px; font-weight:600; color:#007bff; }
.summary-box {
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
    margin-bottom:25px;
}
.summary-grid { display:flex; gap:20px; flex-wrap:wrap; }
.summary-item {
    flex:1; min-width:200px; padding:15px;
    background:#f8f9fc; border-radius:10px;
}
.summary-item h3 { font-size:18px; margin-bottom:6px; }
.summary-value { font-size:26px; font-weight:bold; color:#333; }
.status-green { color:green; font-weight:bold; }
.status-orange { color:#ff8800; font-weight:bold; }
.status-red { color:red; font-weight:bold; }
</style>


<h2>👨‍🏫 Teacher Dashboard</h2>
<p>Welcome, <b><?= esc($teacher['first_name'] . ' ' . $teacher['last_name']) ?></b></p>


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
                <?php else: ?>
                    <span class="status-red">Not Marked</span>
                <?php endif; ?>
            </div>
            <small><?= $today ?></small>
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
<div style="display:flex; gap:20px; flex-wrap:wrap;">
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


<!-- ✅ Today's Timetable -->
<div class="summary-box">
    <h3>📅 Today's Timetable (<?= $todayName ?>)</h3>

    <?php if ($timetable->num_rows == 0): ?>
        <p style="color:#999;">No periods scheduled for today.</p>
    <?php else: ?>
        <table cellpadding="8" style="width:100%;border-collapse:collapse;background:white;">
            <thead style="background:#007bff;color:white;">
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
                    <td><?= $tt['start_time'] ?> - <?= $tt['end_time'] ?></td>
                    <td><?= esc($tt['subject_name']) ?></td>
                    <td><?= esc($tt['class_name']) ?></td>
                    <td><?= esc($tt['section_name']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <br>
    <a href="timetable.php" class="btn-sm">📆 View Weekly Timetable</a>
</div>


<?php include '../partials/portal_footer.php'; ?>
