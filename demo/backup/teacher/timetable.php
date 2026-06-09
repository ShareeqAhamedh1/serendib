<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// ✅ Logged-in teacher
$user_id = $_SESSION['user_id'];
$t = $conn->query("SELECT id FROM teachers WHERE user_id=$user_id LIMIT 1")->fetch_assoc();
$teacher_id = $t['id'];

// ✅ Days list
$days = [
    "Monday", "Tuesday", "Wednesday", "Thursday",
    "Friday", "Saturday", "Sunday"
];

// ✅ Current day name
$todayName = date('l');  // Monday, Tuesday...

// ✅ Filter input
$filterDay = $_GET['day'] ?? "";
$filterClass = $_GET['class_id'] ?? "";

// ✅ Fetch class list (to filter timetable)
$classList = $conn->query("
    SELECT DISTINCT c.id, c.class_name
    FROM timetable tt
    JOIN classes c ON c.id = tt.class_id
    WHERE tt.teacher_id = $teacher_id
    ORDER BY c.class_name
");

// ✅ Build WHERE clause
$where = " WHERE tt.teacher_id = $teacher_id ";

if ($filterDay != "") {
    $dayEsc = $conn->real_escape_string($filterDay);
    $where .= " AND tt.day_of_week = '$dayEsc' ";
}

if ($filterClass != "") {
    $class_id = (int)$filterClass;
    $where .= " AND tt.class_id = $class_id ";
}

// ✅ Fetch timetable
$q = "
    SELECT 
        tt.*,
        s.subject_name,
        c.class_name,
        sec.section_name
    FROM timetable tt
    JOIN subjects s ON s.id = tt.subject_id
    JOIN classes c ON c.id = tt.class_id
    JOIN sections sec ON sec.id = tt.section_id
    $where
    ORDER BY FIELD(tt.day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),
             tt.start_time
";

$timetable = $conn->query($q);
?>

<style>
.day-header {
    background:#f3f6ff;
    padding:12px;
    border-left:5px solid #007bff;
    font-size:20px;
    font-weight:bold;
    margin-top:25px;
}
.today {
    background:#d1ffd6 !important;
    border-left:5px solid #28a745 !important;
}
.tt-table {
    width:100%;
    border-collapse:collapse;
    background:white;
    margin-bottom:15px;
}
.tt-table th {
    background:#007bff;
    color:white;
    padding:10px;
}
.tt-table td {
    padding:10px;
    border-bottom:1px solid #ddd;
}
.filter-box {
    background:white;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
}
</style>

<h2>📆 Weekly Timetable</h2>

<!-- ✅ Filter Section -->
<div class="filter-box">
    <form method="get" style="display:flex; gap:15px; flex-wrap:wrap;">

        <!-- Day Filter -->
        <select name="day" style="padding:8px;">
            <option value="">-- All Days --</option>
            <?php foreach ($days as $d): ?>
                <option value="<?= $d ?>" <?= $filterDay === $d ? 'selected' : '' ?>>
                    <?= $d ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Class Filter -->
        <select name="class_id" style="padding:8px;">
            <option value="">-- All Classes --</option>
            <?php while($cl = $classList->fetch_assoc()): ?>
                <option value="<?= $cl['id'] ?>" <?= $filterClass == $cl['id'] ? 'selected' : '' ?>>
                    <?= esc($cl['class_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button style="padding:8px 14px; background:#007bff; color:white; border:none; border-radius:6px;">
            Apply Filters
        </button>

        <a href="timetable.php" 
           style="padding:8px 12px; background:#6c757d; color:white; text-decoration:none; border-radius:6px;">
            Reset
        </a>
    </form>
</div>


<!-- ✅ Render Timetable -->
<?php
$currentDay = "";
if ($timetable->num_rows == 0):
?>

<p style="color:#888;">No timetable entries found for selected filters.</p>

<?php else: ?>

<?php while($tt = $timetable->fetch_assoc()): ?>

    <?php if ($currentDay != $tt['day_of_week']): 
        if ($currentDay != "") echo "</tbody></table>";
        $currentDay = $tt['day_of_week'];
    ?>

        <!-- ✅ Day Header -->
        <div class="day-header <?= $currentDay == $todayName ? 'today' : '' ?>">
            <?= $currentDay ?>
            <?php if ($currentDay == $todayName): ?>
                ✅ (Today)
            <?php endif; ?>
        </div>

        <!-- ✅ Start New Day Table -->
        <table class="tt-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Section</th>
                </tr>
            </thead>
        <tbody>
    <?php endif; ?>

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

<?php include '../partials/portal_footer.php'; ?>
