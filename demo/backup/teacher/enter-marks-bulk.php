<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

if (!isset($_GET['exam_id'])) {
  echo "<h3 style='color:red;'>No exam selected.</h3>";
  include '../partials/portal_footer.php';
  exit;
}

$exam_id = (int)$_GET['exam_id'];
$user_id = (int)($_SESSION['user_id'] ?? 0);

// Get teacher's class/section
$cRes = $conn->query("
  SELECT tc.class_id, tc.section_id
  FROM teacher_classes tc
  JOIN teachers t ON t.id = tc.teacher_id
  WHERE t.user_id = {$user_id}
  LIMIT 1
");
$tc = $cRes ? $cRes->fetch_assoc() : null;
if (!$tc) { echo "<p style='color:red'>No class assigned to you.</p>"; include '../partials/portal_footer.php'; exit; }

$class_id   = (int)$tc['class_id'];
$section_id = (int)$tc['section_id'];

// Subjects for this exam & class
$subjects = $conn->query("
  SELECT es.subject_id, s.subject_name, es.max_marks, es.pass_marks
  FROM exam_subjects es
  JOIN subjects s ON s.id = es.subject_id
  WHERE es.exam_id={$exam_id} AND es.class_id={$class_id}
  ORDER BY s.subject_name
");

// Students of this class/section
$students = $conn->query("
  SELECT id, admission_no, first_name, last_name
  FROM students
  WHERE class_id={$class_id} AND section_id={$section_id}
  ORDER BY first_name, last_name
");
?>
<h2>📝 Enter Marks (Bulk)</h2>

<div style="background:#fff;padding:18px;border-radius:10px">
  <form method="get" style="margin-bottom:16px;">
    <input type="hidden" name="exam_id" value="<?= $exam_id ?>">
    <label><b>Subject</b></label>
    <select name="subject_id" required style="padding:8px;">
      <option value="">-- Select Subject --</option>
      <?php while($s = $subjects->fetch_assoc()): ?>
        <option value="<?= $s['subject_id'] ?>" <?= (isset($_GET['subject_id']) && (int)$_GET['subject_id']==(int)$s['subject_id'])?'selected':'' ?>>
          <?= esc($s['subject_name']) ?> (Max: <?= (int)$s['max_marks'] ?>)
        </option>
      <?php endwhile; ?>
    </select>
    <button style="padding:8px 12px;">Load</button>
  </form>

  <?php
  if (!empty($_GET['subject_id'])):
    $subject_id = (int)$_GET['subject_id'];

    // Get subject meta (max/pass)
    $subMeta = $conn->query("
      SELECT es.max_marks, es.pass_marks, s.subject_name
      FROM exam_subjects es
      JOIN subjects s ON s.id=es.subject_id
      WHERE es.exam_id={$exam_id} AND es.class_id={$class_id} AND es.subject_id={$subject_id}
      LIMIT 1
    ")->fetch_assoc();

    if (!$subMeta) {
      echo "<p style='color:red'>Subject is not configured for this exam/class.</p>";
    } else {
      // load existing marks keyed by student_id
      $markMap = [];
      $rs = $conn->query("
        SELECT student_id, marks_obtained, grade, status
        FROM exam_marks
        WHERE exam_id={$exam_id} AND class_id={$class_id} AND section_id={$section_id} AND subject_id={$subject_id}
      ");
      if ($rs) while($r = $rs->fetch_assoc()) $markMap[(int)$r['student_id']] = $r;
  ?>
  <form method="post" action="backend/save_bulk_marks.php" id="bulkForm">
    <?= csrf_field() ?>
    <input type="hidden" name="exam_id" value="<?= $exam_id ?>">
    <input type="hidden" name="class_id" value="<?= $class_id ?>">
    <input type="hidden" name="section_id" value="<?= $section_id ?>">
    <input type="hidden" name="subject_id" value="<?= $subject_id ?>">

    <div style="margin-bottom:10px;color:#555">
      <b>Subject:</b> <?= esc($subMeta['subject_name']) ?> &nbsp; | &nbsp;
      <b>Max:</b> <?= (int)$subMeta['max_marks'] ?> &nbsp; | &nbsp;
      <b>Pass:</b> <?= (int)$subMeta['pass_marks'] ?>
    </div>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
      <thead style="background:#0b5ed7;color:#fff;">
        <tr>
          <th>#</th>
          <th>Adm No</th>
          <th>Name</th>
          <th style="width:160px;">Marks (0–<?= (int)$subMeta['max_marks'] ?>)</th>
          <th>Saved Grade</th>
          <th>Saved Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; while($st = $students->fetch_assoc()): 
          $sid = (int)$st['id'];
          $existing = $markMap[$sid] ?? null;
        ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= esc($st['admission_no']) ?></td>
          <td><?= esc($st['first_name'].' '.$st['last_name']) ?></td>
          <td>
            <input type="number" step="0.01" min="0" max="<?= (int)$subMeta['max_marks'] ?>"
                   name="marks[<?= $sid ?>]"
                   value="<?= $existing ? (float)$existing['marks_obtained'] : '' ?>"
                   style="width:150px;padding:6px;">
          </td>
          <td><?= esc($existing['grade'] ?? '-') ?></td>
          <td><?= esc($existing['status'] ?? '-') ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <br>
    <button style="padding:10px 14px;background:#198754;color:#fff;border:none;border-radius:6px;cursor:pointer">
      💾 Save All
    </button>
  </form>
  <?php } endif; ?>
</div>

<?php include '../partials/portal_footer.php'; ?>
