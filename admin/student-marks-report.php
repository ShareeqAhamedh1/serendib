<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

/* ===============================
   FETCH FILTER DATA
================================ */
$exams = $conn->query("
    SELECT id, exam_name
    FROM exams
    ORDER BY exam_name
");

$classes = $conn->query("
    SELECT id, class_name
    FROM classes
    ORDER BY class_name
");

$subjects = $conn->query("
    SELECT
        id,
        subject_name,
        subject_type,
        basket_group
    FROM subjects
    ORDER BY subject_name
");
?>

<style>

/* ===============================
   PAGE
================================ */
.page-header{
    margin-bottom:22px;
}

.page-title{
    font-size:28px;
    font-weight:800;
    color:#0f172a;

    margin:0 0 6px;
}

.page-subtitle{
    color:#64748b;
    margin:0;
}

/* ===============================
   CARD
================================ */
.filter-card{
    background:#fff;

    border-radius:20px;

    padding:22px;

    box-shadow:0 6px 24px rgba(0,0,0,.06);

    margin-bottom:20px;
}

/* ===============================
   GRID
================================ */
.filter-grid{
    display:grid;

    grid-template-columns:
        repeat(auto-fit,minmax(220px,1fr));

    gap:18px;
}

/* ===============================
   FORM
================================ */
.form-group label{
    display:block;

    margin-bottom:7px;

    font-size:14px;
    font-weight:700;

    color:#334155;
}

.form-control{
    width:100%;

    padding:12px 14px;

    border:1px solid #dbe2ea;

    border-radius:14px;

    font-size:14px;

    background:#fff;

    transition:.2s;
}

.form-control:focus{
    outline:none;

    border-color:#2563eb;

    box-shadow:0 0 0 4px rgba(37,99,235,.12);
}

/* ===============================
   BUTTONS
================================ */
.button-row{
    display:flex;

    gap:12px;

    flex-wrap:wrap;

    margin-top:22px;
}

.btn{
    border:none;

    padding:12px 18px;

    border-radius:14px;

    font-size:14px;
    font-weight:700;

    cursor:pointer;

    transition:.25s;

    display:inline-flex;

    align-items:center;

    gap:8px;
}

.btn:hover{
    transform:translateY(-2px);
}

.btn-primary{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
}

.btn-reset{
    background:#eef2f7;
    color:#334155;
}

.btn-export{
    background:linear-gradient(135deg,#16a34a,#15803d);
    color:#fff;
}

/* ===============================
   RESULTS
================================ */
.results-card{
    background:#fff;

    border-radius:20px;

    padding:18px;

    box-shadow:0 6px 24px rgba(0,0,0,.06);

    min-height:120px;
}

/* ===============================
   SUBJECT TAGS
================================ */
.subject-option{
    font-weight:600;
}

.subject-meta{
    color:#64748b;
    font-size:12px;
}

/* ===============================
   MOBILE
================================ */
@media(max-width:768px){

    .page-title{
        font-size:24px;
    }

    .filter-card{
        padding:16px;
    }

    .button-row{
        flex-direction:column;
    }

    .btn{
        width:100%;
        justify-content:center;
    }
}

</style>

<!-- ===============================
     HEADER
================================ -->
<div class="page-header">

<h2 class="page-title">
    📘 Student Marks Report
</h2>

<p class="page-subtitle">
    View student marks, grades and pass/fail reports.
</p>

</div>

<!-- ===============================
     FILTER CARD
================================ -->
<div class="filter-card">

<form id="filterForm">

<div class="filter-grid">

    <!-- EXAM -->
    <div class="form-group">

        <label>Exam</label>

        <select
            name="exam_id"
            id="exam_id"
            class="form-control"
        >

            <option value="">All Exams</option>

            <?php while($e = $exams->fetch_assoc()): ?>

            <option value="<?= $e['id'] ?>">
                <?= esc($e['exam_name']) ?>
            </option>

            <?php endwhile; ?>

        </select>

    </div>

    <!-- CLASS -->
    <div class="form-group">

        <label>Class</label>

        <select
            name="class_id"
            id="class_id"
            class="form-control"
        >

            <option value="">All Classes</option>

            <?php while($c = $classes->fetch_assoc()): ?>

            <option value="<?= $c['id'] ?>">
                <?= esc($c['class_name']) ?>
            </option>

            <?php endwhile; ?>

        </select>

    </div>

    <!-- SECTION -->
    <div class="form-group">

        <label>Section</label>

        <select
            name="section_id"
            id="section_id"
            class="form-control"
        >

            <option value="">All Sections</option>

        </select>

    </div>

    <!-- SUBJECT -->
    <div class="form-group">

        <label>Subject</label>

        <select
            name="subject_id"
            id="subject_id"
            class="form-control"
        >

            <option value="">All Subjects</option>

            <?php while($s = $subjects->fetch_assoc()): ?>

            <?php

            $subjectLabel = $s['subject_name'];

            if($s['subject_type'] === 'Group Subject'){

                $subjectLabel .=
                    ' ('.$s['basket_group'].')';
            }

            elseif($s['subject_type'] === 'First Language'){

                $subjectLabel .=
                    ' (1st Language)';
            }

            elseif($s['subject_type'] === 'Second Language'){

                $subjectLabel .=
                    ' (2nd Language)';
            }

            ?>

            <option value="<?= $s['id'] ?>">

                <?= esc($subjectLabel) ?>

            </option>

            <?php endwhile; ?>

        </select>

    </div>

    <!-- SEARCH -->
    <div class="form-group">

        <label>Admission No</label>

        <input
            type="text"
            name="admission_no"
            id="admission_no"
            class="form-control"
            placeholder="e.g. S001"
        >

    </div>

</div>

<!-- BUTTONS -->
<div class="button-row">

    <button
        type="button"
        id="applyFilter"
        class="btn btn-primary"
    >
        🔍 Apply Filters
    </button>

    <button
        type="button"
        id="resetFilter"
        class="btn btn-reset"
    >
        ↺ Reset
    </button>

    <button
        type="button"
        id="exportExcel"
        class="btn btn-export"
    >
        📗 Export Excel
    </button>

</div>

</form>

</div>

<!-- ===============================
     RESULTS
================================ -->
<div class="results-card">

<div id="resultsContainer">

    <div style="text-align:center;color:#64748b;padding:35px;">
        Loading report...
    </div>

</div>

</div>

<script>

/* ===============================
   LOAD SECTIONS
================================ */
document
.getElementById('class_id')
.addEventListener('change', function(){

    const classId = this.value;

    const sectionSelect =
        document.getElementById('section_id');

    if(!classId){

        sectionSelect.innerHTML =
            '<option value="">All Sections</option>';

        return;
    }

    sectionSelect.innerHTML =
        '<option>Loading...</option>';

    fetch(
        `<?= BASE_URL ?>backend/get_sections.php?class_id=${classId}`
    )

    .then(res => res.json())

    .then(data => {

        sectionSelect.innerHTML =
            '<option value="">All Sections</option>';

        data.forEach(sec => {

            sectionSelect.innerHTML += `
                <option value="${sec.id}">
                    ${sec.section_name}
                </option>
            `;
        });
    });
});

/* ===============================
   LOAD REPORT
================================ */
function loadReport(){

    const form =
        document.getElementById('filterForm');

    const params =
        new URLSearchParams(new FormData(form));

    document.getElementById('resultsContainer')
    .innerHTML = `
        <div style="
            text-align:center;
            padding:35px;
            color:#64748b;
        ">
            Loading report...
        </div>
    `;

    fetch(
        `<?= BASE_URL ?>backend/fetch_student_marks_report.php?${params.toString()}`
    )

    .then(res => res.text())

    .then(html => {

        document.getElementById('resultsContainer')
        .innerHTML = html;
    })

    .catch(err => {

        document.getElementById('resultsContainer')
        .innerHTML = `
            <div style="
                text-align:center;
                padding:35px;
                color:red;
            ">
                Error loading report.
            </div>
        `;

        console.error(err);
    });
}

/* ===============================
   APPLY FILTER
================================ */
document
.getElementById('applyFilter')
.addEventListener('click', loadReport);

/* ===============================
   RESET FILTER
================================ */
document
.getElementById('resetFilter')
.addEventListener('click', () => {

    document.getElementById('filterForm').reset();

    document.getElementById('section_id').innerHTML =
        '<option value="">All Sections</option>';

    loadReport();
});

/* ===============================
   EXPORT EXCEL
================================ */
document
.getElementById('exportExcel')
.addEventListener('click', () => {

    const params =
        new URLSearchParams(
            new FormData(
                document.getElementById('filterForm')
            )
        );

    window.location.href =
        `<?= BASE_URL ?>backend/export_student_marks_excel.php?${params.toString()}`;
});

/* ===============================
   AUTO LOAD
================================ */
window.addEventListener(
    'DOMContentLoaded',
    loadReport
);

</script>

<?php include 'partials/footer.php'; ?>