<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// ✅ Logged-in student
$user_id = $_SESSION['user_id'];

$student = $conn->query("
    SELECT 
        s.id,
        s.class_id,
        s.section_id,
        s.first_language,
        s.second_language,
        s.g1_subject_id,
        s.g2_subject_id,
        s.g3_subject_id,

        c.class_name

    FROM students s

    LEFT JOIN classes c
        ON c.id = s.class_id

    WHERE s.user_id = $user_id

    LIMIT 1
")->fetch_assoc();

$class_id   = $student['class_id'];
$section_id = $student['section_id'];
/* -----------------------------
   SENIOR GRADE CHECK
------------------------------ */

$isSeniorGrade = false;

$className = strtolower($student['class_name'] ?? '');

/*
Examples:
Grade 10
10-A
Class 11
Year 11
*/

if(
    strpos($className, '10') !== false ||
    strpos($className, '11') !== false
){
    $isSeniorGrade = true;
}

/* -----------------------------
   GROUP SUBJECTS
------------------------------ */

$groupSubjects = null;

if($isSeniorGrade){

$g1Subjects = $conn->query("
    SELECT DISTINCT
        t.subject_id,
        s.subject_name

    FROM timetable t
    JOIN subjects s ON s.id = t.subject_id

    WHERE t.class_id = $class_id
    AND t.section_id = $section_id
    AND t.basket_group = 'G1'

    ORDER BY s.subject_name
");

$g2Subjects = $conn->query("
    SELECT DISTINCT
        t.subject_id,
        s.subject_name

    FROM timetable t
    JOIN subjects s ON s.id = t.subject_id

    WHERE t.class_id = $class_id
    AND t.section_id = $section_id
    AND t.basket_group = 'G2'

    ORDER BY s.subject_name
");

$g3Subjects = $conn->query("
    SELECT DISTINCT
        t.subject_id,
        s.subject_name

    FROM timetable t
    JOIN subjects s ON s.id = t.subject_id

    WHERE t.class_id = $class_id
    AND t.section_id = $section_id
    AND t.basket_group = 'G3'

    ORDER BY s.subject_name
");
}
/* -----------------------------
   CHECK SUBJECT SELECTION
------------------------------ */

$needsSelection = false;

/* first + second language required */
if(
    empty($student['first_language']) ||
    empty($student['second_language'])
){
    $needsSelection = true;
}

/* group subject only for grade 10 & 11 */
/* =====================================
   GROUP SUBJECTS ONLY FOR GRADE 10/11
===================================== */
if(
    $isSeniorGrade
    &&
    (
        empty($student['g1_subject_id']) ||
        empty($student['g2_subject_id']) ||
        empty($student['g3_subject_id'])
    )
){
    $needsSelection = true;
}

/* -----------------------------
   SAVE SUBJECTS
------------------------------ */
if(isset($_POST['save_subjects'])){

    $first_language  = $conn->real_escape_string($_POST['first_language']);
    $second_language = $conn->real_escape_string($_POST['second_language']);

/* =====================================
   DEFAULT NULL
===================================== */
$g1 = "NULL";
$g2 = "NULL";
$g3 = "NULL";

/* =====================================
   ONLY FOR GRADE 10/11
===================================== */
if($isSeniorGrade){

    $g1 = !empty($_POST['g1_subject_id'])
        ? (int)$_POST['g1_subject_id']
        : "NULL";

    $g2 = !empty($_POST['g2_subject_id'])
        ? (int)$_POST['g2_subject_id']
        : "NULL";

    $g3 = !empty($_POST['g3_subject_id'])
        ? (int)$_POST['g3_subject_id']
        : "NULL";
}

$conn->query("
    UPDATE students
    SET
        first_language = '$first_language',
        second_language = '$second_language',

        g1_subject_id = $g1,
        g2_subject_id = $g2,
        g3_subject_id = $g3

    WHERE id = {$student['id']}
");

    echo "<script>
        window.location='homeworks.php';
    </script>";

    exit;
}
/* -----------------------------
   Fetch homework
------------------------------ */
$firstLang  = trim($student['first_language'] ?? '');
$secondLang = trim($student['second_language'] ?? '');

$g1SubjectId = (int)($student['g1_subject_id'] ?? 0);
$g2SubjectId = (int)($student['g2_subject_id'] ?? 0);
$g3SubjectId = (int)($student['g3_subject_id'] ?? 0);

$homeworks = $conn->query("

SELECT 
    h.*,
    s.subject_name,
    s.subject_type,
    s.basket_group,

    t.first_name,
    t.last_name,

    sub.submitted_at

FROM homeworks h

JOIN subjects s
    ON s.id = h.subject_id

JOIN teachers t
    ON t.id = h.teacher_id

LEFT JOIN homework_submissions sub
    ON sub.homework_id = h.id
   AND sub.student_id = {$student['id']}

WHERE h.class_id = $class_id
AND h.section_id = $section_id

AND (

    /* =========================
/* =========================
   NORMAL SUBJECTS
========================= */
(
    s.subject_type = 'Normal'
    OR s.subject_type IS NULL
    OR s.subject_type = ''
)

    /* =========================
       FIRST LANGUAGE
    ========================= */
    OR (
        s.subject_type = 'First Language'
        AND LOWER(s.subject_name)
            LIKE LOWER('%{$firstLang}%')
    )

    /* =========================
       SECOND LANGUAGE
    ========================= */
    OR (
        s.subject_type = 'Second Language'
        AND LOWER(s.subject_name)
            LIKE LOWER('%{$secondLang}%')
    )

    /* =========================
       G1
    ========================= */
    OR (
        h.subject_id = $g1SubjectId
    )

    /* =========================
       G2
    ========================= */
    OR (
        h.subject_id = $g2SubjectId
    )

    /* =========================
       G3
    ========================= */
    OR (
        h.subject_id = $g3SubjectId
    )

)

ORDER BY h.due_date ASC

");
?>

<style>
/* ---------- TABLE ---------- */
.hw-table {
    width:100%;
    border-collapse:collapse;
    background:white;
}

.hw-table th {
    background:#007bff;
    color:white;
    padding:12px;
}

.hw-table td {
    padding:12px;
    border-bottom:1px solid #eee;
}

/* ---------- STATUS ---------- */
.hw-status {
    padding:6px 12px;
    border-radius:20px;
    font-weight:600;
    font-size:13px;
}

.hw-pending {
    background:#fff3cd;
    color:#664d03;
}

.hw-overdue {
    background:#fdecea;
    color:#842029;
}

/* ---------- MOBILE CARDS ---------- */
.hw-cards {
    display:none;
}

.hw-card {
    background:white;
    padding:16px;
    border-radius:14px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    margin-bottom:16px;
}

.hw-card h4 {
    margin-bottom:6px;
}

.hw-meta {
    font-size:14px;
    color:#555;
}

.hw-actions {
    margin-top:10px;
}

.hw-actions a {
    display:inline-block;
    margin-right:10px;
    color:#007bff;
    font-weight:600;
    text-decoration:none;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width:768px) {
    .hw-table { display:none; }
    .hw-cards { display:block; }
}
.hw-submitted {
    background:#e6f9ec;
    color:#0f5132;
}

/* ---------- BUTTONS ---------- */

.hw-btn-group,
.hw-actions {
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn-view,
.btn-download {
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:9px 16px;
    border-radius:10px;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
    transition:all .25s ease;
}

/* View Button */
.btn-view {
    background:linear-gradient(135deg,#4f46e5,#6366f1);
    color:white;
    box-shadow:0 4px 10px rgba(79,70,229,.25);
}

.btn-view:hover {
    transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(79,70,229,.35);
}

/* Download Button */
.btn-download {
    background:linear-gradient(135deg,#059669,#10b981);
    color:white;
    box-shadow:0 4px 10px rgba(5,150,105,.25);
}

.btn-download:hover {
    transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(5,150,105,.35);
}

/* Mobile */
@media (max-width:768px) {

    .btn-view,
    .btn-download {
        width:100%;
        justify-content:center;
    }

}

/* ================= SUBJECT POPUP ================= */

.subject-overlay{
    position:fixed;
    inset:0;

    background:rgba(0,0,0,.6);

    display:flex;
    justify-content:center;
    align-items:center;

    z-index:9999;

    padding:20px;
}

.subject-modal{
    width:100%;
    max-width:420px;

    background:#fff;

    border-radius:20px;

    padding:28px;

    box-shadow:0 20px 50px rgba(0,0,0,.25);

    animation:popup .25s ease;
}

@keyframes popup{
    from{
        transform:scale(.9);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

.subject-modal h3{
    margin-top:0;
    margin-bottom:10px;

    color:#111827;
}

.subject-modal p{
    color:#666;
    margin-bottom:20px;
}

.subject-modal label{
    display:block;
    margin-bottom:6px;
    margin-top:12px;

    font-weight:600;
}

.subject-modal select{
    width:100%;

    padding:12px;

    border-radius:12px;

    border:1px solid #ddd;

    font-size:15px;
}

.subject-modal button{
    width:100%;

    margin-top:20px;

    border:none;

    background:linear-gradient(135deg,#2563eb,#1d4ed8);

    color:#fff;

    padding:13px;

    border-radius:12px;

    font-size:15px;
    font-weight:700;

    cursor:pointer;

    transition:.25s;
}

.subject-modal button:hover{
    transform:translateY(-2px);
}
</style>
<?php if($needsSelection): ?>

<div class="subject-overlay">

    <div class="subject-modal">

        <h3>📚 Select Your Subjects</h3>

<p>
    Please select your
    <?= $isSeniorGrade
        ? 'languages and group subjects'
        : 'languages'
    ?>
</p>

        <form method="POST">

            <!-- FIRST LANGUAGE -->
            <label>1st Language</label>

            <select name="first_language" id="first_language" required>

                <option value="">Select</option>

                <option value="Sinhala">Sinhala</option>
                <option value="Tamil">Tamil</option>

            </select>

            <!-- SECOND LANGUAGE -->
            <label>2nd Language</label>

            <select name="second_language" id="second_language" required>

                <option value="">Select</option>

                <option value="Sinhala">Sinhala</option>
                <option value="Tamil">Tamil</option>

            </select>

            <?php if($isSeniorGrade): ?>

<?php if($isSeniorGrade): ?>

<!-- G1 -->
<label>G1 Subject</label>

<select name="g1_subject_id" id="g1_subject" required>

    <option value="">Select G1 Subject</option>

    <?php while($g1 = $g1Subjects->fetch_assoc()): ?>

        <option value="<?= $g1['subject_id'] ?>">

            <?= esc($g1['subject_name']) ?>

        </option>

    <?php endwhile; ?>

</select>

<!-- G2 -->
<label>G2 Subject</label>

<select name="g2_subject_id" id="g2_subject" required>

    <option value="">Select G2 Subject</option>

    <?php while($g2 = $g2Subjects->fetch_assoc()): ?>

        <option value="<?= $g2['subject_id'] ?>">

            <?= esc($g2['subject_name']) ?>

        </option>

    <?php endwhile; ?>

</select>

<!-- G3 -->
<label>G3 Subject</label>

<select name="g3_subject_id" id="g3_subject" required>

    <option value="">Select G3 Subject</option>

    <?php while($g3 = $g3Subjects->fetch_assoc()): ?>

        <option value="<?= $g3['subject_id'] ?>">

            <?= esc($g3['subject_name']) ?>

        </option>

    <?php endwhile; ?>

</select>

<?php endif; ?>

            <?php endif; ?>

            <button type="submit" name="save_subjects">

                Save Subjects

            </button>

        </form>

    </div>

</div>

<?php endif; ?>
<h2>📘 My Homework</h2>
<p style="color:#555;">Here are all homework assignments for your class.</p>

<?php if ($homeworks->num_rows == 0): ?>
<p style="color:#777;">🎉 No homework assigned yet.</p>
<?php else: ?>

<!-- DESKTOP TABLE -->
<table class="hw-table">
<thead>
<tr>
    <th>Title</th>
    <th>Subject</th>
    <th>Teacher</th>
    <th>Due Date</th>
    <th>Status</th>
    <th>Attachment</th>
</tr>
</thead>
<tbody>
<?php while($hw = $homeworks->fetch_assoc()): 
    if ($hw['submitted_at']) {
    $status = 'submitted';
} elseif ($hw['due_date'] < date('Y-m-d')) {
    $status = 'overdue';
} else {
    $status = 'pending';
}

?>
<tr>
    <td><?= esc($hw['title']) ?></td>
    <td><?= esc($hw['subject_name']) ?></td>
    <td><?= esc($hw['first_name'].' '.$hw['last_name']) ?></td>
    <td><?= esc($hw['due_date']) ?></td>
<td>
<?php if ($status === 'submitted'): ?>
    <span class="hw-status hw-submitted">Submitted</span>
<?php elseif ($status === 'overdue'): ?>
    <span class="hw-status hw-overdue">Overdue</span>
<?php else: ?>
    <span class="hw-status hw-pending">Pending</span>
<?php endif; ?>
</td>

<td class="hw-btn-group">

    <!-- Always show View button -->
    <a href="homework-view.php?id=<?= $hw['id'] ?>" class="btn-view">
        👁 View
    </a>

    <!-- Show download only if attachment exists -->
    <?php if ($hw['attachment']): ?>
        <a href="../<?= esc($hw['attachment']) ?>" 
           target="_blank" 
           class="btn-download">
            ⬇ Download
        </a>
    <?php endif; ?>

</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- MOBILE CARDS -->
<div class="hw-cards">
<?php
$homeworks->data_seek(0);
while($hw = $homeworks->fetch_assoc()):

    if ($hw['submitted_at']) {
        $status = 'submitted';
    } elseif ($hw['due_date'] < date('Y-m-d')) {
        $status = 'overdue';
    } else {
        $status = 'pending';
    }

?>
<div class="hw-card">
    <h4><?= esc($hw['title']) ?></h4>
    <div class="hw-meta">
        📘 <?= esc($hw['subject_name']) ?><br>
        👩‍🏫 <?= esc($hw['first_name'].' '.$hw['last_name']) ?><br>
        📅 Due: <?= esc($hw['due_date']) ?>
    </div>

    <div style="margin-top:8px;">
        <span class="hw-status hw-<?= $status ?>">
    <?= ucfirst($status) ?>
</span>

    </div>

<div class="hw-actions">

    <!-- Always visible -->
    <a href="homework-view.php?id=<?= $hw['id'] ?>" class="btn-view">
        👁 View Details
    </a>

    <!-- Only if attachment exists -->
    <?php if ($hw['attachment']): ?>
        <a href="../<?= esc($hw['attachment']) ?>" 
           target="_blank" 
           class="btn-download">
            ⬇ Download
        </a>
    <?php endif; ?>

</div>
</div>
<?php endwhile; ?>
</div>

<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>

<script>

const g1 = document.getElementById('g1_subject');
const g2 = document.getElementById('g2_subject');
const g3 = document.getElementById('g3_subject');

function updateGroupOptions(){

    const values = [
        g1?.value,
        g2?.value,
        g3?.value
    ];

    [g1,g2,g3].forEach(select => {

        if(!select) return;

        [...select.options].forEach(option => {

            option.hidden = false;

            if(
                option.value &&
                values.includes(option.value) &&
                option.value !== select.value
            ){
                option.hidden = true;
            }

        });

    });

}

[g1,g2,g3].forEach(select => {

    if(select){

        select.addEventListener('change', updateGroupOptions);

    }

});

updateGroupOptions();


/* =========================
   SUBJECT VALIDATION
========================= */

const firstLang  = document.getElementById('first_language');
const secondLang = document.getElementById('second_language');

/* -------------------------
   UPDATE LANGUAGE OPTIONS
-------------------------- */
function updateLanguageOptions(){

    if(!firstLang || !secondLang) return;

    const firstValue  = firstLang.value;
    const secondValue = secondLang.value;

    // RESET OPTIONS
    [...secondLang.options].forEach(option => {
        option.hidden = false;
    });

    [...firstLang.options].forEach(option => {
        option.hidden = false;
    });

    // HIDE DUPLICATES
    if(firstValue){

        [...secondLang.options].forEach(option => {

            if(option.value === firstValue){
                option.hidden = true;
            }

        });

    }

    if(secondValue){

        [...firstLang.options].forEach(option => {

            if(option.value === secondValue){
                option.hidden = true;
            }

        });

    }

    // SAFETY CHECK
    if(
        firstValue &&
        secondValue &&
        firstValue === secondValue
    ){

        Swal.fire({
            icon:'warning',
            title:'Invalid Selection',
            text:'1st and 2nd language cannot be the same'
        });

        secondLang.value = '';
    }
}

/* -------------------------
   GROUP VALIDATION
-------------------------- */


/* EVENTS */
if(firstLang && secondLang){

    firstLang.addEventListener('change', updateLanguageOptions);

    secondLang.addEventListener('change', updateLanguageOptions);

    updateLanguageOptions();
}



</script>
