<?php
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';


// Logged-in teacher
$user_id = $_SESSION['user_id'];
$t = $conn->query("SELECT id FROM teachers WHERE user_id=$user_id LIMIT 1")->fetch_assoc();
$teacher_id = $t['id'];

// Homework ID
$hw_id = (int)($_GET['homework_id'] ?? 0);

// Fetch teacher's homework list (dropdown)
$hwList = $conn->query("
    SELECT id, title
    FROM homeworks
    WHERE teacher_id = $teacher_id
    ORDER BY created_at DESC
");

// Fetch selected homework
$homework = null;
if ($hw_id) {
    $homework = $conn->query("
        SELECT *
        FROM homeworks
        WHERE id = $hw_id AND teacher_id = $teacher_id
        LIMIT 1
    ")->fetch_assoc();
}

$submissions = null;
$students = null;
// =========================
// REMOVE SUBMISSION
// =========================
if (isset($_GET['remove'])) {

    $subId = (int)$_GET['remove'];

    // get submission
    $subQ = $conn->query("
        SELECT sub.*
        FROM homework_submissions sub
        JOIN homeworks h ON h.id = sub.homework_id
        WHERE sub.id = $subId
        AND h.teacher_id = $teacher_id
        LIMIT 1
    ");

    if ($subQ->num_rows) {

        $sub = $subQ->fetch_assoc();

        // delete uploaded file
        if (!empty($sub['file_path']) && file_exists("../" . $sub['file_path'])) {
            unlink("../" . $sub['file_path']);
        }

        // =========================
        // REMOVE HOUSE POINTS
        // =========================
        $conn->query("
            DELETE FROM house_point_logs
            WHERE homework_id = {$sub['homework_id']}
              AND entity_id = {$sub['student_id']}
              AND entity_type = 'student'
        ");

        // =========================
        // DELETE SUBMISSION
        // =========================
        $conn->query("
            DELETE FROM homework_submissions
            WHERE id = $subId
        ");

        header("Location: ?homework_id=$hw_id&removed=1");
        exit;
    }
}

include '../partials/portal_header.php';
if ($homework) {

    // Submitted students
    $submissions = $conn->query("
        SELECT 
            sub.id,
            sub.student_id,
            s.first_name,
            s.last_name,
            sub.file_path,
            sub.note,
            sub.submitted_at
        FROM homework_submissions sub
        JOIN students s ON s.id = sub.student_id
        WHERE sub.homework_id = $hw_id
        ORDER BY sub.submitted_at DESC
    ");

    // Students who did NOT submit
    $students = $conn->query("
        SELECT s.first_name, s.last_name
        FROM students s
        WHERE s.class_id = {$homework['class_id']}
          AND s.section_id = {$homework['section_id']}
          AND s.id NOT IN (
              SELECT student_id
              FROM homework_submissions
              WHERE homework_id = $hw_id
          )
        ORDER BY s.first_name
    ");
}


?>

<style>
.hw-wrap {
    max-width: 1000px;
    margin: auto;
}

.filter-box {
    background:white;
    padding:16px;
    border-radius:14px;
    box-shadow:0 4px 14px rgba(0,0,0,.08);
    margin-bottom:22px;
}

.filter-box select {
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
    width:100%;
    max-width:400px;
}

.section-title {
    margin:20px 0 10px;
}

.table-wrap {
    overflow-x:auto;
}

.sub-table {
    width:100%;
    border-collapse:collapse;
    background:white;
}

.sub-table th {
    background:#007bff;
    color:white;
    padding:12px;
}

.sub-table td {
    padding:12px;
    border-bottom:1px solid #eee;
}

.status-ok {
    color:#0f5132;
    font-weight:600;
}

.status-pending {
    color:#842029;
    font-weight:600;
}

/* Mobile cards */
.sub-cards {
    display:none;
}

.sub-card {
    background:white;
    padding:16px;
    border-radius:14px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    margin-bottom:14px;
}

@media (max-width:768px) {
    .sub-table { display:none; }
    .sub-cards { display:block; }
}

/* ---------- ACTION BUTTON ---------- */
.remove-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    padding:8px 16px;
    border-radius:30px;
    background:linear-gradient(135deg,#ff4d4d,#dc3545);
    color:white;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    transition:.25s ease;
    border:none;
    box-shadow:0 4px 12px rgba(220,53,69,.25);
}

.remove-btn:hover{
    background:linear-gradient(135deg,#dc3545,#b02a37);
    color:white;
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(220,53,69,.35);
}

/* MOBILE BUTTON */
.mobile-actions{
    margin-top:14px;
}

.mobile-actions .remove-btn{
    width:100%;
    padding:10px;
    font-size:14px;
}

/* ---------- VIEW BUTTON ---------- */
.view-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    width:100%;
    padding:10px;
    border-radius:12px;
    background:linear-gradient(135deg,#0d6efd,#0b5ed7);
    color:white;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
    transition:.25s ease;
    box-shadow:0 4px 12px rgba(13,110,253,.25);
}

.view-btn:hover{
    background:linear-gradient(135deg,#0b5ed7,#084298);
    color:white;
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(13,110,253,.35);
}
</style>

<div class="hw-wrap">

<h2>📥 Homework Submissions</h2>

<!-- Homework selector -->
<div class="filter-box">
<form method="get">
    <label><b>Select Homework</b></label><br>
    <select name="homework_id" onchange="this.form.submit()">
        <option value="">-- Select Homework --</option>
        <?php while($h = $hwList->fetch_assoc()): ?>
            <option value="<?= $h['id'] ?>" <?= $hw_id == $h['id'] ? 'selected' : '' ?>>
                <?= esc($h['title']) ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>
</div>

<?php if ($homework): ?>

<h3 class="section-title">✅ Submitted</h3>

<?php if ($submissions->num_rows == 0): ?>
<p style="color:#777;">No submissions yet.</p>
<?php else: ?>

<!-- Desktop -->
<div class="table-wrap">
<table class="sub-table">
<thead>
<tr>
    <th>Student</th>
    <th>Submitted At</th>
    <th>File</th>
    <th>Note</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php while($s = $submissions->fetch_assoc()): ?>
<tr>
    <td><?= esc($s['first_name'].' '.$s['last_name']) ?></td>
    <td><?= esc($s['submitted_at']) ?></td>
    <td>
        <a href="../<?= esc($s['file_path']) ?>" target="_blank">View</a>
    </td>
    <td><?= esc($s['note']) ?></td>
    <td>
        <a href="?homework_id=<?= $hw_id ?>&remove=<?= $s['id'] ?>"
        class="remove-btn"
        onclick="return confirm('Remove this submission?')">

        <i class="fas fa-trash"></i>
        Remove

        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<!-- Mobile -->
<div class="sub-cards">
<?php
$submissions->data_seek(0);

while($s = $submissions->fetch_assoc()):
?>
<div class="sub-card">

    <div class="d-flex justify-content-between align-items-start mb-2">
        <b>
            <?= esc($s['first_name'].' '.$s['last_name']) ?>
        </b>

        <span class="badge bg-success">
            Submitted
        </span>
    </div>

    <div class="mb-2">
        📅 <?= esc($s['submitted_at']) ?>
    </div>

        <div class="mobile-actions mb-2">

            <a href="../<?= esc($s['file_path']) ?>" 
            target="_blank"
            class="view-btn">

            <i class="fas fa-eye"></i>
            View File

            </a>

        </div>

    <?php if (!empty($s['note'])): ?>
        <div class="mb-2">
            📝 <?= esc($s['note']) ?>
        </div>
    <?php endif; ?>

    <!-- ACTION BUTTON -->
    <div class="mobile-actions">

        <a href="?homework_id=<?= $hw_id ?>&remove=<?= $s['id'] ?>"
           class="remove-btn"
           onclick="return confirm('Remove this submission?')">

           <i class="fas fa-trash"></i>
           Remove Submission

        </a>

    </div>

</div>
<?php endwhile; ?>
</div>

<?php endif; ?>

<h3 class="section-title">❌ Not Submitted</h3>

<?php if ($students->num_rows == 0): ?>

<p class="status-ok">
    All students have submitted 🎉
</p>

<?php else: ?>

<div class="sub-card">

<?php while($st = $students->fetch_assoc()): ?>

    <div class="d-flex justify-content-between align-items-center border-bottom py-2">

        <span class="status-pending">
            <?= esc($st['first_name'].' '.$st['last_name']) ?>
        </span>


    </div>

<?php endwhile; ?>

</div>

<?php endif; ?>

<?php endif; ?>

</div>

<?php include '../partials/portal_footer.php'; ?>

<?php if(isset($_GET['removed'])): ?>
<script>
Swal.fire({
    icon:'success',
    title:'Submission Removed',
    timer:1500,
    showConfirmButton:false
}).then(()=>{
    window.history.replaceState({}, document.title, window.location.pathname + '?homework_id=<?= $hw_id ?>');
});
</script>
<?php endif; ?>