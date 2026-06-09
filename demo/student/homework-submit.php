<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$user_id = $_SESSION['user_id'];

/* ===============================
   FETCH STUDENT + HOUSE
================================ */
$student = $conn->query("
    SELECT s.id, s.class_id, s.section_id, hm.house_id
    FROM students s
    LEFT JOIN house_members hm 
      ON hm.entity_type='student'
     AND hm.entity_id=s.id
    WHERE s.user_id = $user_id
    LIMIT 1
")->fetch_assoc();

if (!$student) die('Student not found');

$student_id = $student['id'];
$house_id   = $student['house_id'];

/* ===============================
   ACTIVE YEAR
================================ */
$year = $conn->query("
  SELECT id FROM academic_years
  WHERE is_active=1 LIMIT 1
")->fetch_assoc();

$year_id = $year['id'] ?? 0;

/* ===============================
   HOMEWORK
================================ */
$hw_id = (int)($_GET['id'] ?? 0);

$hw = $conn->query("
    SELECT * FROM homeworks
    WHERE id=$hw_id
      AND class_id={$student['class_id']}
      AND section_id={$student['section_id']}
    LIMIT 1
")->fetch_assoc();

if (!$hw) die('Homework not found');

/* ===============================
   EXISTING SUBMISSION
================================ */
$submission = $conn->query("
  SELECT * FROM homework_submissions
  WHERE homework_id=$hw_id
    AND student_id=$student_id
")->fetch_assoc();

$success = false;
$pointsAwarded = 0;
$isLate = false;

/* ===============================
   HANDLE SUBMISSION
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $note = trim($_POST['note']);
  $filePath = $submission['file_path'] ?? null;

  /* FILE UPLOAD */
  if (!empty($_FILES['answer']['name'])) {
    $ext = strtolower(pathinfo($_FILES['answer']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, ['pdf','jpg','jpeg','png'])) {
      $newName = "ans_{$hw_id}_".time().".$ext";
      $dir = '../uploads/homework_answers/';
      if (!is_dir($dir)) mkdir($dir,0777,true);
      move_uploaded_file($_FILES['answer']['tmp_name'], $dir.$newName);
      $filePath = 'uploads/homework_answers/'.$newName;
    }
  }

  /* SAVE SUBMISSION */
  if ($submission) {
    $stmt = $conn->prepare("
      UPDATE homework_submissions
      SET file_path=?, note=?, submitted_at=NOW()
      WHERE id=?
    ");
    $stmt->bind_param("ssi",$filePath,$note,$submission['id']);
  } else {
    $stmt = $conn->prepare("
      INSERT INTO homework_submissions
      (homework_id, student_id, file_path, note, submitted_at)
      VALUES (?,?,?,?,NOW())
    ");
    $stmt->bind_param("iiss",$hw_id,$student_id,$filePath,$note);
  }
  $stmt->execute();

  /* ===============================
     HOUSE POINT LOGIC
  ================================ */
  if ($house_id && $year_id && !$submission) {

    // Was penalty (-2) already added?
$penalty = $conn->query("
  SELECT id, points
  FROM house_point_logs
  WHERE house_id = $house_id
    AND academic_year_id = $year_id
    AND entity_type = 'student'
    AND entity_id = $student_id
    AND homework_id = $hw_id
    AND source = 'HOMEWORK'
    AND action = 'DEDUCT'
  LIMIT 1
")->fetch_assoc();


    // Remove penalty if exists
if ($penalty) {
  $conn->query("DELETE FROM house_point_logs WHERE id={$penalty['id']}");

  $conn->query("
    UPDATE house_points
    SET total_points = total_points + {$penalty['points']}
    WHERE house_id=$house_id
      AND academic_year_id=$year_id
  ");
}


    // Late check
$isLate = false;
if (!empty($hw['due_date'])) {
  $isLate = time() > strtotime($hw['due_date']);
}

$points = $isLate ? 1 : 3;


    // Insert reward log
$stmt = $conn->prepare("
  INSERT INTO house_point_logs
  (
    house_id,
    academic_year_id,
    entity_type,
    entity_id,
    homework_id,
    points,
    action,
    reason,
    source
  )
  VALUES (?,?,?,?,?,?,'ADD',?, 'HOMEWORK')
");

$entity_type = 'student';
$reason = $isLate
  ? 'Late homework submission'
  : 'On-time homework submission';

$stmt->bind_param(
  "iisiiss",
  $house_id,     // i
  $year_id,      // i
  $entity_type,  // s
  $student_id,   // i
  $hw_id,        // i
  $points,       // i
  $reason        // s
);


$stmt->execute();

    // Update total
    $conn->query("
      INSERT INTO house_points (house_id, academic_year_id, total_points)
      VALUES ($house_id,$year_id,$points)
      ON DUPLICATE KEY UPDATE total_points = total_points + $points
    ");

    $pointsAwarded = $points;
  }

  $success = true;
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.sub-card{
  max-width:650px;
  margin:40px auto;
  background:#fff;
  padding:30px;
  border-radius:20px;
  box-shadow:0 12px 32px rgba(0,0,0,.15);
}
.sub-status{
  padding:14px;
  border-radius:14px;
  font-weight:700;
  margin-bottom:16px;
}
.done{background:#e6f9ec;color:#0f5132}
.pending{background:#fff3cd;color:#664d03}
.house-bonus{
  margin-top:14px;
  padding:14px;
  background:#eef4ff;
  color:#084298;
  border-radius:14px;
  font-weight:700;
}
button{
  width:100%;
  padding:14px;
  background:#005c2e;
  color:#fff;
  border:none;
  border-radius:14px;
  font-size:17px;
}

.sub-card{
  max-width:640px;
  margin:40px auto;
  background:#fff;
  padding:28px;
  border-radius:20px;
  box-shadow:0 10px 30px rgba(0,0,0,.12);
}
.sub-card h2{margin-bottom:6px}
.sub-card textarea,
.sub-card input[type=file]{
  width:100%;
  padding:14px;
  margin-top:8px;
  border-radius:12px;
  border:1px solid #ccc;
}
.sub-card button{
  margin-top:18px;
  width:100%;
  padding:14px;
  background:#005c2e;
  border:none;
  color:white;
  font-size:17px;
  border-radius:12px;
}
.sub-status{
  margin-bottom:16px;
  padding:12px;
  border-radius:14px;
  font-weight:600;
}
.done{background:#e6f9ec;color:#0f5132}
.pending{background:#fff3cd;color:#664d03}
.house-bonus{
  margin-top:14px;
  padding:12px;
  border-radius:14px;
  background:#eef4ff;
  color:#084298;
  font-weight:700;
}
</style>
<div class="sub-card">

<h2>📤 Submit Homework</h2>
<p><b><?= esc($hw['title']) ?></b></p>

<div class="sub-status <?= $submission?'done':'pending' ?>">
<?= $submission?'✅ Submitted':'⏳ Not submitted yet' ?>
</div>

<form method="post" enctype="multipart/form-data">
<input type="file" name="answer" accept="application/pdf,image/*" required>
<textarea name="note" rows="4"><?= esc($submission['note'] ?? '') ?></textarea>
<button><?= $submission?'🔄 Update':'📤 Submit Homework' ?></button>
</form>

<?php if ($pointsAwarded): ?>
<div class="house-bonus">
🏰 +<?= $pointsAwarded ?> House Points
<?= $isLate ? '(Late)' : '(On-time)' ?>
</div>
<?php endif; ?>

</div>

<?php if ($success): ?>
<script>
Swal.fire({
  icon:'success',
  title:'Homework Submitted',
  html:'House points updated successfully 🏆',
  confirmButtonColor:'#005c2e'
}).then(()=>location.href='homeworks.php');
</script>
<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>
