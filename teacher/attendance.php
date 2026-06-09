<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$user_id = $_SESSION['user_id'] ?? 0;

// ✅ Find teacher's assigned class + section
$q = $conn->prepare("
    SELECT tc.class_id, tc.section_id, c.class_name, s.section_name
    FROM teacher_classes tc
    JOIN classes c ON tc.class_id = c.id
    JOIN sections s ON tc.section_id = s.id
    WHERE tc.teacher_id = (SELECT id FROM teachers WHERE user_id = ? LIMIT 1)
    LIMIT 1
");
$q->bind_param("i", $user_id);
$q->execute();
$classInfo = $q->get_result()->fetch_assoc();

if (!$classInfo) {
    echo "<h3 style='color:red;'>You are not assigned to any class.</h3>";
    include '../partials/portal_footer.php';
    exit;
}

$class_id   = $classInfo['class_id'];
$section_id = $classInfo['section_id'];
$class_name = $classInfo['class_name'];
$section_name = $classInfo['section_name'];

$date = $_GET['date'] ?? date('Y-m-d');

// ✅ Fetch students of this class + section
$students = $conn->query("
    SELECT id, admission_no, first_name, last_name
    FROM students
    WHERE class_id = $class_id AND section_id = $section_id
    ORDER BY first_name
");

// ✅ Fetch existing attendance for selected date
$att = [];
$res = $conn->query("
    SELECT entity_id, time_in, status
    FROM attendance
    WHERE entity_type='student' AND date='$date'
");

while ($r = $res->fetch_assoc()) {
    $att[$r['entity_id']] = [
        'time_in' => $r['time_in'],
        'status'  => $r['status']
    ];
}

?>

<style>
.table {width:100%; border-collapse:collapse; background:white;}
.table th, .table td {padding:10px; border-bottom:1px solid #ddd;}
.table th {background:#003366; color:white;}

.present {color:green; font-weight:bold;}
.absent {color:red; font-weight:bold;}

.alert {padding:10px; border-radius:6px; margin-bottom:15px; display:none;}
.alert.success {background:#d4edda; color:#155724;}
.alert.error {background:#f8d7da; color:#721c24;}

</style>

<h2>📅 Class Attendance</h2>

<p>
<b>Class:</b> <?= $class_name ?> -
<b>Section:</b> <?= $section_name ?><br>
<b>Date:</b> 
<input type="date" id="attendanceDate" value="<?= $date ?>" style="padding:6px;">
</p>

<div id="msgBox" class="alert"></div>

<form method="post" action="backend/save_class_attendance.php">
    <?= csrf_field() ?>
    <input type="hidden" name="class_id" value="<?= $class_id ?>">
    <input type="hidden" name="section_id" value="<?= $section_id ?>">
    <input type="hidden" name="date" value="<?= $date ?>">

<table class="table">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Admission No</th>
        <th>Status</th>
        <th>Mark</th>
        <th>Time</th>
    </tr>

    <?php $i=1; while($s = $students->fetch_assoc()): ?>
        <?php 
        $stud_id = $s['id']; 
        $hasRecord = isset($att[$stud_id]);
        $status = $hasRecord ? $att[$stud_id]['status'] : 'Absent';
        $time_in = $hasRecord ? $att[$stud_id]['time_in'] : '-';

        $isPresent = ($status === 'present');

        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= esc($s['first_name'].' '.$s['last_name']) ?></td>
            <td><?= esc($s['admission_no']) ?></td>

            <td>
                <?php if ($isPresent): ?>
                    <span class="present">Present</span>
                <?php else: ?>
                    <span class="absent">Absent</span>
                <?php endif; ?>
            </td>


            <td>
                <input type="checkbox" name="present[<?= $stud_id ?>]" 
                       <?= $isPresent ? "checked" : "" ?>>

                <input type="hidden" name="all_ids[]" value="<?= $stud_id ?>">
            </td>

            <td>
                <?= $time_in ?>

            </td>
        </tr>
    <?php endwhile; ?>

</table>

<br>
<button class="btn-sm" style="padding:10px 20px; background:#007bff; color:white;">
    ✅ Save Attendance
</button>

</form>

<script>
// ✅ Auto-change date
document.getElementById("attendanceDate").addEventListener("change", function(){
    window.location = "attendance.php?date=" + this.value;
});

// ✅ Auto hide success message
const urlParams = new URLSearchParams(window.location.search);
if(urlParams.get("ok") === "1") {
    const box = document.getElementById("msgBox");
    box.classList.add("success");
    box.textContent = "✅ Attendance saved successfully";
    box.style.display = "block";
    setTimeout(() => box.style.display = "none", 2500);
}
if(urlParams.get("ok") === "0") {
    const box = document.getElementById("msgBox");
    box.classList.add("error");
    box.textContent = "❌ Failed to save attendance";
    box.style.display = "block";
    setTimeout(() => box.style.display = "none", 2500);
}
</script>

<?php include '../partials/portal_footer.php'; ?>
