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
    echo "<p style='color:red'>Student record not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

$student_id = (int)$student['id'];

/* ===============================
   MONTH
================================ */
$month = $_GET['month'] ?? date('Y-m');
$year  = date('Y');

$firstDay = date('Y-m-01', strtotime($month));
$lastDay  = date('Y-m-t', strtotime($month));

/* ===============================
   FETCH MONTHLY ATTENDANCE
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
$present = 0;
$total   = 0;

$res = $attQ->get_result();
while ($r = $res->fetch_assoc()) {
    $attendance[$r['date']] = $r['status'];

    if (in_array($r['status'], ['present','absent'])) {
        $total++;
        if ($r['status'] === 'present') $present++;
    }
}
$attQ->close();

$monthPercent = $total > 0 ? round(($present / $total) * 100, 1) : 0;

/* ===============================
   ANNUAL
================================ */
$yearQ = $conn->prepare("
    SELECT 
        SUM(status='present') AS present_count,
        SUM(status IN ('present','absent')) AS total_count
    FROM attendance
    WHERE entity_type='student'
      AND entity_id=?
      AND YEAR(date)=?
");
$yearQ->bind_param("ii", $student_id, $year);
$yearQ->execute();
$yearRow = $yearQ->get_result()->fetch_assoc();
$yearQ->close();

$yearPercent = $yearRow['total_count'] > 0
    ? round(($yearRow['present_count'] / $yearRow['total_count']) * 100, 1)
    : 0;

function badgeColor($p){
    if ($p >= 75) return 'green';
    if ($p >= 60) return 'orange';
    return 'red';
}
?>

<style>
.attendance-container{max-width:1000px;margin:auto;padding:15px}

/* ---------- SUMMARY ---------- */
.summary{display:flex;gap:15px;flex-wrap:wrap;margin-bottom:15px}
.summary-box{
    background:#fff;padding:18px;border-radius:14px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);min-width:220px
}

/* ---------- BADGES ---------- */
.badge{padding:6px 14px;border-radius:16px;font-weight:600}
.green{background:#e6f9ec;color:#0f5132}
.orange{background:#fff3cd;color:#664d03}
.red{background:#fdecea;color:#842029}

/* ---------- CALENDAR ---------- */
.calendar{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:8px;
}
.day{
    padding:12px 0;
    border-radius:10px;
    background:#f3f4f6;
    text-align:center;
    font-weight:600;
}
.weekday{background:#004080;color:#fff}
.present{background:#d1fae5;color:#065f46}
.absent{background:#fee2e2;color:#991b1b}
.empty{background:#eee;color:#aaa}

/* ---------- RESPONSIVE ---------- */
@media(max-width:600px){
    .calendar{gap:6px}
    .day{font-size:13px}
}
</style>

<div class="attendance-container">

<h2>📅 My Attendance</h2>
<p><b><?= esc($student['first_name'].' '.$student['last_name']) ?></b></p>

<!-- SUMMARY -->
<div class="summary">
    <div class="summary-box">
        <p><b>📆 This Month</b></p>
        <span class="badge <?= badgeColor($monthPercent) ?>"><?= $monthPercent ?>%</span>
    </div>
    <div class="summary-box">
        <p><b>📅 Annual</b></p>
        <span class="badge <?= badgeColor($yearPercent) ?>"><?= $yearPercent ?>%</span>
    </div>
</div>

<!-- MONTH SELECT -->
<form method="get" style="margin-bottom:15px;display:flex;gap:10px;flex-wrap:wrap">
    <input type="month" name="month" value="<?= $month ?>">
    <button>🔍 View</button>
    <a href="attendance.php">🔄 Reset</a>
</form>

<!-- CALENDAR -->
<div class="calendar">
<?php
$weekdays=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
foreach($weekdays as $w) echo "<div class='day weekday'>$w</div>";

$start = date('w', strtotime($firstDay));
for($i=0;$i<$start;$i++) echo "<div class='day empty'></div>";

$days = date('t', strtotime($month));
for($d=1;$d<=$days;$d++){
    $date = sprintf('%s-%02d',$month,$d);
    $status = $attendance[$date] ?? '';
    $cls='day';
    if($status==='present') $cls.=' present';
    elseif($status==='absent') $cls.=' absent';
    echo "<div class='$cls'>$d</div>";
}
?>
</div>

<p style="margin-top:15px">
🟢 Present &nbsp; 🔴 Absent &nbsp; ⚪ Not Marked
</p>

</div>

<?php include '../partials/portal_footer.php'; ?>
