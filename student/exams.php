<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

/* ===============================
   GET LOGGED STUDENT
================================ */
$user_id = $_SESSION['user_id'];

$stuRes = $conn->query("
    SELECT id
    FROM students
    WHERE user_id = $user_id
");

$stu = $stuRes->fetch_assoc();

$student_id = $stu['id'] ?? 0;

if (!$student_id) {

    echo "
    <div class='alert-error'>
        Student record not found.
    </div>";

    include '../partials/portal_footer.php';
    exit;
}

/* ===============================
   FETCH RESULTS
================================ */
$sql = "

SELECT 
    em.marks_obtained,
    em.grade,
    em.status AS mark_status,

    s.subject_name,
    s.subject_type,
    s.basket_group,

    e.term

FROM exam_marks em

JOIN exams e
    ON em.exam_id = e.id

JOIN subjects s
    ON em.subject_id = s.id

WHERE em.student_id = $student_id

ORDER BY 
    e.term ASC,
    s.subject_name ASC

";

$results = $conn->query($sql);
?>

<style>

.results-wrapper{
    margin-top:20px;
}

/* ===============================
   CARD
================================ */
.results-card{
    background:#fff;

    border-radius:18px;

    padding:20px;

    box-shadow:0 6px 20px rgba(0,0,0,.06);

    overflow:hidden;
}

/* ===============================
   TITLE
================================ */
.page-title{
    margin:0 0 18px;

    font-size:26px;
    font-weight:700;

    color:#1e293b;
}

/* ===============================
   TABLE
================================ */
.results-table{
    width:100%;

    border-collapse:collapse;
}

.results-table thead{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);

    color:#fff;
}

.results-table th{
    padding:14px 12px;

    text-align:left;

    font-size:14px;

    font-weight:700;
}

.results-table td{
    padding:14px 12px;

    border-bottom:1px solid #eef2f7;

    font-size:14px;
}

.results-table tbody tr:hover{
    background:#f8fbff;
}

/* ===============================
   SUBJECT BADGE
================================ */
.subject-badge{
    display:inline-block;

    padding:5px 10px;

    border-radius:999px;

    font-size:12px;
    font-weight:700;

    margin-top:4px;
}

.badge-group{
    background:#ede9fe;
    color:#6d28d9;
}

.badge-first{
    background:#dcfce7;
    color:#166534;
}

.badge-second{
    background:#fef3c7;
    color:#92400e;
}

/* ===============================
   MARKS
================================ */
.marks{
    font-weight:700;

    color:#0f172a;
}

/* ===============================
   STATUS
================================ */
.status{
    display:inline-flex;

    align-items:center;
    justify-content:center;

    padding:6px 12px;

    border-radius:999px;

    font-size:12px;
    font-weight:700;
}

.pass{
    background:#dcfce7;
    color:#166534;
}

.fail{
    background:#fee2e2;
    color:#b91c1c;
}

.pending{
    background:#e2e8f0;
    color:#475569;
}

/* ===============================
   EMPTY
================================ */
.empty-state{
    text-align:center;

    padding:40px 20px;

    color:#64748b;
}

/* ===============================
   MOBILE
================================ */
@media(max-width:768px){

    .results-card{
        padding:14px;
    }

    .page-title{
        font-size:22px;
    }

    .results-table,
    .results-table thead,
    .results-table tbody,
    .results-table th,
    .results-table td,
    .results-table tr{
        display:block;
        width:100%;
    }

    .results-table thead{
        display:none;
    }

    .results-table tr{
        background:#fff;

        border:1px solid #e5e7eb;

        border-radius:16px;

        margin-bottom:14px;

        overflow:hidden;

        box-shadow:0 4px 14px rgba(0,0,0,.05);
    }

    .results-table td{
        border:none;

        display:flex;

        justify-content:space-between;

        gap:12px;

        padding:12px 14px;

        font-size:14px;
    }

    .results-table td::before{
        content:attr(data-label);

        font-weight:700;

        color:#475569;

        min-width:90px;
    }
}

</style>

<div class="results-wrapper">

<div class="results-card">

<h2 class="page-title">
    📝 Exam Results
</h2>

<?php if(!$results || $results->num_rows == 0): ?>

<div class="empty-state">
    No exam results available yet.
</div>

<?php else: ?>

<table class="results-table">

<thead>
<tr>
    <th>Term</th>
    <th>Subject</th>
    <th>Marks</th>
    <th>Grade</th>
    <th>Result</th>
</tr>
</thead>

<tbody>

<?php while($r = $results->fetch_assoc()): ?>

<?php

/* ===============================
   SUBJECT LABEL
================================ */
$subjectLabel = $r['subject_name'];

$badge = '';

if($r['subject_type'] === 'Group Subject'){

    $subjectLabel .= ' ('.$r['basket_group'].')';

    $badge =
        '<span class="subject-badge badge-group">
            Group Subject
        </span>';
}

elseif($r['subject_type'] === 'First Language'){

    $subjectLabel .= ' (1st Language)';

    $badge =
        '<span class="subject-badge badge-first">
            1st Language
        </span>';
}

elseif($r['subject_type'] === 'Second Language'){

    $subjectLabel .= ' (2nd Language)';

    $badge =
        '<span class="subject-badge badge-second">
            2nd Language
        </span>';
}

/* ===============================
   MARKS / GRADE
================================ */
$marks =
    $r['marks_obtained'] !== null
    &&
    $r['marks_obtained'] !== ''
    ? $r['marks_obtained']
    : '-';

$grade =
    !empty($r['grade'])
    ? $r['grade']
    : '-';

/* ===============================
   STATUS
================================ */
$status = strtolower(trim($r['mark_status'] ?? ''));

if(
    $status === 'pass'
    ||
    $status === 'passed'
    ||
    $status === 'p'
){

    $statusHtml =
        '<span class="status pass">Pass</span>';

}
elseif(
    $status === 'fail'
    ||
    $status === 'failed'
    ||
    $status === 'f'
){

    $statusHtml =
        '<span class="status fail">Fail</span>';

}
else{

    $statusHtml =
        '<span class="status pending">Pending</span>';
}
?>

<tr>

<td data-label="Term">
    <?= htmlspecialchars($r['term'] ?: '-') ?>
</td>

<td data-label="Subject">

    <div>
        <div style="font-weight:700;">
            <?= htmlspecialchars($subjectLabel) ?>
        </div>

        <?= $badge ?>
    </div>

</td>

<td data-label="Marks">
    <span class="marks">
        <?= htmlspecialchars($marks) ?>
    </span>
</td>

<td data-label="Grade">
    <?= htmlspecialchars($grade) ?>
</td>

<td data-label="Result">
    <?= $statusHtml ?>
</td>

</tr>

<?php endwhile; ?>

</tbody>
</table>

<?php endif; ?>

</div>
</div>

<?php include '../partials/portal_footer.php'; ?>