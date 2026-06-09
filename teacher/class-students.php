<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

// Logged-in teacher user_id
$user_id = $_SESSION['user_id'];

// ✅ Get teacher ID
$teacher = $conn->query("
    SELECT id 
    FROM teachers 
    WHERE user_id = $user_id
")->fetch_assoc();

$teacher_id = $teacher['id'] ?? 0;

if (!$teacher_id) {

    echo "
    <div class='alert-box error-box'>
        <i class='fas fa-circle-exclamation'></i>
        Teacher record not found.
    </div>";

    include '../partials/portal_footer.php';
    exit;
}

// ✅ Check assigned class + section
$q = $conn->query("
    SELECT 
        tc.class_id,
        tc.section_id,
        c.class_name,
        s.section_name
    FROM teacher_classes tc
    JOIN classes c ON tc.class_id = c.id
    JOIN sections s ON tc.section_id = s.id
    WHERE tc.teacher_id = $teacher_id
    LIMIT 1
");

$assign = $q->fetch_assoc();

if (!$assign) {

    echo "
    <div class='alert-box warning-box'>
        <i class='fas fa-triangle-exclamation'></i>

        <div>
            <b>No Class Assigned</b><br>
            Please contact the administrator.
        </div>
    </div>";

    include '../partials/portal_footer.php';
    exit;
}

$class_id   = $assign['class_id'];
$section_id = $assign['section_id'];

// ✅ Fetch students
$students = $conn->query("
    SELECT 
        id,
        admission_no,
        first_name,
        last_name,
        gender,
        photo
    FROM students
    WHERE class_id = $class_id
    AND section_id = $section_id
    ORDER BY first_name
");
?>

<style>
/* ================= PAGE TITLE ================= */
.page-title{
    font-size:28px;
    font-weight:700;
    margin-bottom:20px;
}

/* ================= CLASS CARD ================= */
.class-card{
    background:#fff;
    padding:20px;
    border-radius:18px;
    margin-bottom:24px;
    box-shadow:0 6px 20px rgba(0,0,0,.06);
}

.class-card h3{
    margin:0;
    font-size:22px;
    color:#222;
}

.class-card p{
    margin:8px 0 0;
    color:#666;
}

/* ================= ALERT ================= */
.alert-box{
    padding:18px;
    border-radius:14px;
    display:flex;
    gap:14px;
    align-items:flex-start;
    margin-bottom:20px;
    font-size:15px;
}

.alert-box i{
    font-size:22px;
    margin-top:2px;
}

.error-box{
    background:#fee2e2;
    color:#b91c1c;
}

.warning-box{
    background:#fef3c7;
    color:#b45309;
}

/* ================= TABLE ================= */
.student-table-wrap{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 6px 20px rgba(0,0,0,.06);
}

.student-table{
    width:100%;
    border-collapse:collapse;
}

.student-table thead{
    background:linear-gradient(135deg,#0d6efd,#0056b3);
    color:#fff;
}

.student-table th{
    padding:16px;
    text-align:left;
    font-size:14px;
}

.student-table td{
    padding:14px 16px;
    border-bottom:1px solid #f1f1f1;
    vertical-align:middle;
    font-size:14px;
}

.student-table tr:hover{
    background:#f9fbff;
}

/* ================= PHOTO ================= */
.student-photo{
    width:52px;
    height:52px;
    border-radius:14px;
    object-fit:cover;
    border:2px solid #eef2ff;
}

/* ================= ACTION BUTTONS ================= */
.action-buttons{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.action-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    padding:10px 14px;

    border-radius:12px;
    text-decoration:none;

    font-size:13px;
    font-weight:600;

    color:#fff;

    transition:.25s ease;
}

.action-btn:hover{
    transform:translateY(-2px);
    color:#fff;
}

.btn-view{
    background:linear-gradient(135deg,#0d6efd,#0056b3);
    box-shadow:0 6px 16px rgba(13,110,253,.25);
}

.btn-marks{
    background:linear-gradient(135deg,#198754,#157347);
    box-shadow:0 6px 16px rgba(25,135,84,.25);
}

.btn-time{
    background:linear-gradient(135deg,#fd7e14,#e8590c);
    box-shadow:0 6px 16px rgba(253,126,20,.25);
}

/* ================= MOBILE CARDS ================= */
.mobile-students{
    display:none;
}

.student-card{
    background:#fff;
    border-radius:18px;
    padding:18px;
    margin-bottom:16px;
    box-shadow:0 6px 20px rgba(0,0,0,.06);
}

.student-card-top{
    display:flex;
    gap:14px;
    align-items:center;
    margin-bottom:14px;
}

.student-card h4{
    margin:0;
    font-size:17px;
}

.student-card small{
    color:#666;
}

.student-info{
    margin-bottom:14px;
    color:#444;
    font-size:14px;
}

.mobile-actions{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.mobile-actions .action-btn{
    width:100%;
    font-size:14px;
    padding:12px;
}

/* ================= EMPTY ================= */
.empty-row{
    text-align:center;
    color:#777;
    padding:25px !important;
}

/* ================= MOBILE ================= */
@media(max-width:768px){

    .student-table-wrap{
        display:none;
    }

    .mobile-students{
        display:block;
    }

    .page-title{
        font-size:24px;
    }

    .class-card{
        padding:18px;
    }

    .class-card h3{
        font-size:18px;
    }
}
</style>

<h2 class="page-title">
    <i class="fas fa-users"></i>
    My Students
</h2>

<div class="class-card">

    <h3>
        <?= htmlspecialchars($assign['class_name']) ?>
        —
        <?= htmlspecialchars($assign['section_name']) ?>
    </h3>

    <p>
        Below is the list of students assigned to your class.
    </p>

</div>

<!-- ================= DESKTOP TABLE ================= -->
<div class="student-table-wrap">

<table class="student-table">

    <thead>
        <tr>
            <th>Photo</th>
            <th>Admission No</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

    <?php if ($students->num_rows == 0): ?>

        <tr>
            <td colspan="5" class="empty-row">
                No students found in this class.
            </td>
        </tr>

    <?php else: ?>

        <?php while ($s = $students->fetch_assoc()): ?>

        <tr>

            <td>
                <img src="../uploads/<?= htmlspecialchars($s['photo'] ?: 'default.png') ?>"
                     class="student-photo">
            </td>

            <td>
                <?= htmlspecialchars($s['admission_no']) ?>
            </td>

            <td>
                <?= htmlspecialchars($s['first_name'].' '.$s['last_name']) ?>
            </td>

            <td>
                <?= htmlspecialchars(ucfirst($s['gender'])) ?>
            </td>

            <td>

                <div class="action-buttons">

                    <a href="view-student.php?id=<?= $s['id'] ?>"
                       class="action-btn btn-view">

                        <i class="fas fa-eye"></i>
                        View

                    </a>

                    <a href="marks.php?student=<?= $s['id'] ?>"
                       class="action-btn btn-marks">

                        <i class="fas fa-marker"></i>
                        Marks

                    </a>

                    <a href="class-timetable.php"
                       class="action-btn btn-time">

                        <i class="fas fa-calendar-days"></i>
                        Timetable

                    </a>

                </div>

            </td>

        </tr>

        <?php endwhile; ?>

    <?php endif; ?>

    </tbody>

</table>

</div>

<!-- ================= MOBILE VIEW ================= -->
<div class="mobile-students">

<?php
$students->data_seek(0);

while ($s = $students->fetch_assoc()):
?>

<div class="student-card">

    <div class="student-card-top">

        <img src="../uploads/<?= htmlspecialchars($s['photo'] ?: 'default.png') ?>"
             class="student-photo">

        <div>

            <h4>
                <?= htmlspecialchars($s['first_name'].' '.$s['last_name']) ?>
            </h4>

            <small>
                Admission No:
                <?= htmlspecialchars($s['admission_no']) ?>
            </small>

        </div>

    </div>

    <div class="student-info">
        Gender:
        <b><?= htmlspecialchars(ucfirst($s['gender'])) ?></b>
    </div>

    <div class="mobile-actions">

        <a href="view-student.php?id=<?= $s['id'] ?>"
           class="action-btn btn-view">

            <i class="fas fa-eye"></i>
            View Student

        </a>

        <a href="marks.php?student=<?= $s['id'] ?>"
           class="action-btn btn-marks">

            <i class="fas fa-marker"></i>
            View Marks

        </a>

        <a href="class-timetable.php"
           class="action-btn btn-time">

            <i class="fas fa-calendar-days"></i>
            Class Timetable

        </a>

    </div>

</div>

<?php endwhile; ?>

</div>

<?php include '../partials/portal_footer.php'; ?>