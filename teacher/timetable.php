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
:root {
    --primary:#007bff;
    --success:#28a745;
    --bg:#f4f6fb;
    --card:#ffffff;
    --muted:#666;
    --radius:14px;
}

/* ---------- FILTER ---------- */
.filter-box {
    background:var(--card);
    padding:16px;
    border-radius:var(--radius);
    box-shadow:0 4px 14px rgba(0,0,0,.08);
    margin-bottom:20px;
}

.filter-box form {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(160px,1fr));
    gap:12px;
}

.filter-box select,
.filter-box button,
.filter-box a {
    padding:12px;
    border-radius:10px;
    font-size:14px;
}

.filter-box button {
    background:var(--primary);
    color:white;
    border:none;
}

.filter-box a {
    background:#6c757d;
    color:white;
    text-decoration:none;
    text-align:center;
}

/* ---------- WEEK GRID ---------- */
.week-grid {
    display:grid;
    grid-template-columns: repeat(7, minmax(240px, 1fr));
    gap:16px;
}

/* ---------- DAY COLUMN ---------- */
.day-column {
    background:var(--card);
    border-radius:var(--radius);
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    padding:14px;
    display:flex;
    flex-direction:column;
}

.day-title {
    font-weight:700;
    font-size:16px;
    margin-bottom:12px;
    padding-bottom:6px;
    border-bottom:2px solid var(--primary);
}

.day-title.today {
    color:var(--success);
    border-color:var(--success);
}

/* ---------- PERIOD CARD ---------- */
.period-card {
    background:#f8f9fc;
    border-radius:10px;
    padding:12px;
    margin-bottom:10px;
    font-size:14px;
}

.period-card:last-child {
    margin-bottom:0;
}

.period-time {
    font-weight:600;
    margin-bottom:4px;
}

.period-meta {
    color:var(--muted);
    font-size:13px;
    line-height:1.4;
}

/* ---------- MOBILE ---------- */
@media (max-width: 768px) {

    .week-grid {
        display:flex;
        overflow-x:auto;
        gap:14px;
        padding-bottom:10px;
        scroll-snap-type:x mandatory;
    }

    .day-column {
        min-width:85%;
        scroll-snap-align:start;
    }

    .day-title {
        font-size:17px;
    }

    .period-card {
        padding:14px;
        font-size:15px;
    }

    .period-meta {
        font-size:14px;
    }
}
</style>


<h2>📆 Weekly Timetable</h2>
<p style="color:#666;margin-bottom:12px;">
    Swipe left/right on mobile to view days →
</p>

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
if ($timetable->num_rows == 0):
?>
<p style="color:#888;">No timetable entries found for selected filters.</p>
<?php else: ?>

<div class="week-grid">

<?php
// Prepare array by day
$byDay = [];
while ($tt = $timetable->fetch_assoc()) {
    $byDay[$tt['day_of_week']][] = $tt;
}

foreach ($days as $day):
    if (!isset($byDay[$day])) continue;
?>
    <div class="day-column">
        <div class="day-title <?= $day == $todayName ? 'today' : '' ?>">
            <?= $day ?> <?= $day == $todayName ? '✅' : '' ?>
        </div>

        <?php foreach ($byDay[$day] as $tt): ?>
            <div class="period-card">
                <div class="period-time">
                    <?= $tt['start_time'] ?> - <?= $tt['end_time'] ?>
                </div>
                <div class="period-meta">
                    📘 <?= esc($tt['subject_name']) ?><br>
                    🏫 <?= esc($tt['class_name']) ?> - <?= esc($tt['section_name']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

</div>
<?php endif; ?>


<?php include '../partials/portal_footer.php'; ?>
