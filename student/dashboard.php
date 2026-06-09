<?php
include '../partials/portal_header.php';

require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Logged-in student
$user_id = $_SESSION['user_id'];

$student = $conn->query("
    SELECT id, class_id, section_id
    FROM students
    WHERE user_id = $user_id
    LIMIT 1
")->fetch_assoc();

$student_id = $student['id'];
$class_id   = $student['class_id'];
$section_id = $student['section_id'];
/* ===============================
   HOUSE + HOUSE TOTAL POINTS
================================ */
$house = $conn->query("
  SELECT 
    h.id,
    h.name,
    h.color,
    h.logo,
    COALESCE(SUM(l.points),0) AS total_points
  FROM house_members hm
  JOIN houses h ON h.id = hm.house_id
  LEFT JOIN house_point_logs l
    ON l.house_id = h.id
   AND l.academic_year_id = (
     SELECT id FROM academic_years WHERE is_active=1 LIMIT 1
   )
  WHERE hm.entity_type='student'
    AND hm.entity_id = $student_id
  GROUP BY h.id
")->fetch_assoc();
/* ===============================
   STUDENT CONTRIBUTION TOTAL
================================ */
$myContribution = 0;

if ($house) {
  $row = $conn->query("
    SELECT COALESCE(SUM(
      CASE 
        WHEN action='ADD' THEN points
        WHEN action='DEDUCT' THEN -points
        ELSE 0
      END
    ),0) AS total
    FROM house_point_logs
    WHERE entity_type='student'
      AND entity_id = $student_id
      AND house_id = {$house['id']}
      AND academic_year_id = (
        SELECT id FROM academic_years WHERE is_active=1 LIMIT 1
      )
  ")->fetch_assoc();

  $myContribution = $row['total'];
}

// Homework count (not expired)
/* ===============================
   STUDENT SUBJECT FILTERS
================================ */
$studentInfo = $conn->query("
    SELECT
        first_language,
        second_language,

        g1_subject_id,
        g2_subject_id,
        g3_subject_id

    FROM students
    WHERE id = $student_id
    LIMIT 1
")->fetch_assoc();

$firstLang =
    trim($studentInfo['first_language'] ?? '');

$secondLang =
    trim($studentInfo['second_language'] ?? '');

$g1SubjectId =
    (int)($studentInfo['g1_subject_id'] ?? 0);

$g2SubjectId =
    (int)($studentInfo['g2_subject_id'] ?? 0);

$g3SubjectId =
    (int)($studentInfo['g3_subject_id'] ?? 0);

/* ===============================
   HOMEWORK COUNT
================================ */
$hw = $conn->query("

SELECT COUNT(*) AS total

FROM homeworks h

JOIN subjects s
    ON s.id = h.subject_id

LEFT JOIN homework_submissions sub
    ON sub.homework_id = h.id
   AND sub.student_id = $student_id

WHERE h.class_id = $class_id

AND h.section_id = $section_id

AND h.due_date >= CURDATE()

AND sub.id IS NULL

AND (

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
       GROUP SUBJECTS
    ========================= */
    OR (
        h.subject_id IN (
            $g1SubjectId,
            $g2SubjectId,
            $g3SubjectId
        )
    )

)

")->fetch_assoc();

$homeworkCount = (int)$hw['total'];
?>


<h2 style="margin-bottom:15px;">🎓 Student Dashboard</h2>
<p style="color:#666; margin-top:-8px;">
🕒 <?= date('d M Y - h:i A') ?>
</p>
<?php if ($homeworkCount > 0): ?>
<div class="hw-alert">
    📚 You have <b><?= $homeworkCount ?></b> homework assignment<?= $homeworkCount > 1 ? 's' : '' ?> pending.
    <a href="homeworks.php">View</a>
</div>
<?php endif; ?>

<p>Welcome to your student portal. Choose an option below:</p>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.card-box {
    background: white;
    padding: 22px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: 0.2s;
}

.card-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}

.card-box h3 {
    margin-top: 0;
}

.card-button {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 16px;
    background: #0055aa;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
}

.card-button:hover {
    background: #003d7a;
}

/* ---------- HOMEWORK ALERT ---------- */
.hw-alert {
    background:#fff3cd;
    color:#664d03;
    padding:14px 16px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
}

.hw-alert a {
    background:#ff9800;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    text-decoration:none;
    font-weight:600;
}

.hw-alert a:hover {
    background:#e68900;
}
.house-banner{
  background:#fff;
  padding:18px;
  border-radius:14px;
  display:flex;
  align-items:center;
  gap:16px;
  margin-bottom:25px;
  box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.house-banner img{
  width:70px;
  height:70px;
  object-fit:contain;
}

.house-banner h3{
  margin:0 0 4px;
}

.house-btn{
  display:inline-block;
  margin-top:6px;
  padding:6px 14px;
  background:#0055aa;
  color:#fff;
  border-radius:20px;
  text-decoration:none;
  font-size:14px;
}

.house-btn:hover{
  background:#003d7a;
}

.no-house{
  background:#f1f3f5;
  color:#555;
  font-weight:600;
}

</style>
<?php if ($house): ?>
<div class="house-banner" style="border-left:6px solid <?= esc($house['color']) ?>">
  <img src="../uploads/houses/<?= esc($house['logo']) ?>" alt="House Logo">

  <div>
    <h3 style="color:<?= esc($house['color']) ?>">
      🏰 <?= esc($house['name']) ?>
    </h3>

    <p>🏆 Total House Points: <b><?= $house['total_points'] ?></b></p>

    <p>
      ⭐ You have contributed <b><?= $myContribution ?></b> points
    </p>

    <a href="my-house.php" class="house-btn">
      View My Contributions →
    </a>
  </div>
</div>
<?php else: ?>
<div class="house-banner no-house">
  🏰 You have not been assigned to a house yet.
</div>
<?php endif; ?>


<div class="dashboard-grid">

    <!-- Attendance -->
    <div class="card-box">
        <h3>📅 Attendance</h3>
        <p>View your attendance records.</p>
        <a class="card-button" href="attendance.php">Open</a>
    </div>

    <!-- Fees -->
    <div class="card-box">
        <h3>💰 Fee Summary</h3>
        <p>Check your payments and outstanding fees.</p>
        <a class="card-button" href="fees.php">Open</a>
    </div>

    <!-- Exams -->
    <div class="card-box">
        <h3>📝 Exam Results</h3>
        <p>See your grades for recent exams.</p>
        <a class="card-button" href="exams.php">Open</a>
    </div>

    <!-- Profile -->
    <div class="card-box">
        <h3>👤 Profile</h3>
        <p>View and update your personal details.</p>
        <a class="card-button" href="profile.php">Open</a>
    </div>

<div class="card-box">
    <h3>📘 Homework</h3>
    <p>
        <?php if ($homeworkCount > 0): ?>
            You have <b><?= $homeworkCount ?></b> pending homework.
        <?php else: ?>
            No homework assigned 🎉
        <?php endif; ?>
    </p>
    <a class="card-button" href="homeworks.php">Open</a>
</div>

</div>

<?php include '../partials/portal_footer.php'; ?>
