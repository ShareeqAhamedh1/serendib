<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

date_default_timezone_set('Asia/Colombo');

/* ===============================
   LOGGED-IN STUDENT
================================ */
$user_id = $_SESSION['user_id'];

$student = $conn->query("
    SELECT id, first_name, last_name
    FROM students
    WHERE user_id = $user_id
    LIMIT 1
")->fetch_assoc();

if (!$student) {
    die("Student record not found");
}

$student_id = (int)$student['id'];

/* ===============================
   MONTH SELECTION
================================ */
$month = $_GET['month'] ?? date('Y-m');
$firstDay = date('Y-m-01', strtotime($month));
$lastDay  = date('Y-m-t', strtotime($month));
$currentYear = date('Y');

/* ===============================
   MONTHLY ATTENDANCE
================================ */
$attQ = $conn->prepare("
    SELECT date, status
    FROM attendance
    WHERE entity_type='student'
      AND entity_id=?
      AND date BETWEEN ? AND ?
");
$attQ->bind_param("iss", $student_id, $firstDay, $lastDay);
$attQ->execute();

$attendance = [];
$monthPresent = 0;
$monthTotal   = 0;

$res = $attQ->get_result();
while ($r = $res->fetch_assoc()) {
    $attendance[$r['date']] = $r['status'];

    if (in_array($r['status'], ['Present','Absent'])) {
        $monthTotal++;
        if ($r['status'] === 'Present') {
            $monthPresent++;
        }
    }
}
$attQ->close();

$monthPercent = $monthTotal > 0
    ? round(($monthPresent / $monthTotal) * 100, 1)
    : 0;

/* ===============================
   ANNUAL ATTENDANCE
================================ */
$yearQ = $conn->prepare("
    SELECT status
    FROM attendance
    WHERE entity_type='student'
      AND entity_id=?
      AND YEAR(date)=?
");
$yearQ->bind_param("ii", $student_id, $currentYear);
$yearQ->execute();

$yearPresent = 0;
$yearTotal   = 0;

$res = $yearQ->get_result();
while ($r = $res->fetch_assoc()) {
    if (in_array($r['status'], ['Present','Absent'])) {
        $yearTotal++;
        if ($r['status'] === 'Present') {
            $yearPresent++;
        }
    }
}
$yearQ->close();

$yearPercent = $yearTotal > 0
    ? round(($yearPresent / $yearTotal) * 100, 1)
    : 0;

/* ===============================
   BADGE COLOR HELPER
================================ */
function badgeColor($p) {
    if ($p >= 75) return 'green';
    if ($p >= 60) return 'orange';
    return 'red';
}
?>

<style>
.attendance-container {
    max-width: 1000px;
    margin: auto;
    padding: 15px;
}

/* ---------- SUMMARY ---------- */
.summary {
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin:15px 0;
}
.summary-box {
    background:white;
    padding:18px;
    border-radius:14px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    min-width:220px;
}

/* ---------- BADGES ---------- */
.badge {
    padding:6px 14px;
    border-radius:16px;
    font-weight:600;
    font-size:14px;
}
.green  { background:#e6f9ec; color:#0f5132; }
.orange { background:#fff3cd; color:#664d03; }
.red    { background:#fdecea; color:#842029; }

/* ---------- CALENDAR ---------- */
.calendar {
    display:grid;
    grid-template-columns: repeat(7,1fr);
    gap:8px;
    margin-top:15px;
}
.day {
    padding:12px 0;
    border-radius:10px;
    background:#f3f4f6;
    text-align:center;
    font-weight:600;
}
.present { background:#d1fae5; color:#065f46; }
.absent  { background:#fee2e2; color:#991b1b; }
.empty   { background:#eee; color:#aaa; }
.weekday {
    background:#004080;
    color:white;
    font-weight:700;
}

/* ---------- RESPONSIVE ---------- */
@media(max-width:600px){
    .calendar { gap:6px }
    .day { font-size:13px; padding:10px 0 }
}
</style>

<div class="attendance-container">

<h2>📅 Attendance Calendar</h2>
<p><b>Student:</b> <?= esc($student['first_name'].' '.$student['last_name']) ?></p>

<!-- ================= SUMMARY ================= -->
<div class="summary">
    <div class="summary-box">
        <p><b>📆 This Month</b></p>
        <span class="badge <?= badgeColor($monthPercent) ?>">
            <?= $monthPercent ?>%
        </span>
    </div>

    <div class="summary-box">
        <p><b>📅 Annual</b></p>
        <span class="badge <?= badgeColor($yearPercent) ?>">
            <?= $yearPercent ?>%
        </span>
    </div>
</div>

<!-- ================= MONTH FILTER ================= -->
<form method="get" style="margin-bottom:18px; display:flex; gap:10px; flex-wrap:wrap;">
    <input type="month" name="month" value="<?= $month ?>">
    <button style="padding:8px 14px;">🔍 View</button>
    <a href="attendance-calendar.php" style="padding:8px 14px; text-decoration:none;">🔄 Reset</a>
</form>

<!-- ================= CALENDAR ================= -->
<div class="calendar">
<?php
$weekdays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
foreach ($weekdays as $w) {
    echo "<div class='day weekday'>$w</div>";
}

$startDay = date('w', strtotime($firstDay));
for ($i = 0; $i < $startDay; $i++) {
    echo "<div class='day empty'></div>";
}

$daysInMonth = date('t', strtotime($month));
for ($d = 1; $d <= $daysInMonth; $d++) {
    $date = sprintf('%s-%02d', $month, $d);
    $status = $attendance[$date] ?? '';

    $class = 'day';
    if ($status === 'Present') $class .= ' present';
    elseif ($status === 'Absent') $class .= ' absent';

    echo "<div class='$class'>$d</div>";
}
?>
</div>

<p style="margin-top:15px;">
🟢 Present &nbsp;&nbsp; 🔴 Absent &nbsp;&nbsp; ⚪ Not Marked
</p>

</div>

<?php include '../partials/portal_footer.php'; ?>
