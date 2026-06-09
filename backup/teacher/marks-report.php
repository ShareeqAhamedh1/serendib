<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

$user_id = (int)($_SESSION['user_id'] ?? 0);

// teacher's class/section
$tc = $conn->query("
  SELECT tc.class_id, tc.section_id
  FROM teacher_classes tc
  JOIN teachers t ON t.id=tc.teacher_id
  WHERE t.user_id={$user_id} LIMIT 1
")->fetch_assoc();

if (!$tc) { echo "<p style='color:red'>No class assigned.</p>"; include '../partials/portal_footer.php'; exit; }

$class_id   = (int)$tc['class_id'];
$section_id = (int)$tc['section_id'];

// exams list (optional: show active/current first)
$exams = $conn->query("SELECT id, exam_name, term FROM exams ORDER BY start_date DESC");

// chosen filters
$exam_id    = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;

// subjects configured for this exam and class
$subjects = ($exam_id>0) ? $conn->query("
  SELECT es.subject_id, s.subject_name
  FROM exam_subjects es
  JOIN subjects s ON s.id = es.subject_id
  WHERE es.exam_id={$exam_id} AND es.class_id={$class_id}
  ORDER BY s.subject_name
") : false;

// students
$students = $conn->query("
  SELECT id, admission_no, first_name, last_name
  FROM students
  WHERE class_id={$class_id} AND section_id={$section_id}
  ORDER BY first_name, last_name
");
?>
<h2>📊 Marks Report</h2>

<div style="background:#fff;padding:14px;border-radius:10px;margin-bottom:14px;">
  <form method="get">
    <label>Exam:</label>
    <select name="exam_id" required>
      <option value="">-- Select Exam --</option>
      <?php while($e = $exams->fetch_assoc()): ?>
        <option value="<?= $e['id'] ?>" <?= $exam_id==$e['id']?'selected':'' ?>>
          <?= esc($e['exam_name']) ?> <?= $e['term'] ? '('.esc($e['term']).')':'' ?>
        </option>
      <?php endwhile; ?>
    </select>

    <?php if ($exam_id): ?>
      &nbsp; &nbsp;
      <label>Subject:</label>
      <select name="subject_id">
        <option value="0">All</option>
        <?php while($s = $subjects->fetch_assoc()): ?>
          <option value="<?= $s['subject_id'] ?>" <?= $subject_id==$s['subject_id']?'selected':'' ?>>
            <?= esc($s['subject_name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    <?php endif; ?>

    &nbsp; <button>Apply</button>
  </form>
</div>

<?php
if ($exam_id):
  // Build subject columns to show
  $subList = [];
  $subRes = $conn->query("
    SELECT es.subject_id, s.subject_name
    FROM exam_subjects es
    JOIN subjects s ON s.id=es.subject_id
    WHERE es.exam_id={$exam_id} AND es.class_id={$class_id}
    ORDER BY s.subject_name
  ");
  while($row = $subRes->fetch_assoc()) $subList[] = $row;
  if ($subject_id) {
    $subList = array_values(array_filter($subList, fn($r) => (int)$r['subject_id']===$subject_id));
  }

  if (empty($subList)) {
    echo "<p style='color:#555'>No subjects configured for this filter.</p>";
  } else {
    // Preload marks: [student_id][subject_id] = marks
    $marksMap = [];
    $mr = $conn->query("
      SELECT student_id, subject_id, marks_obtained
      FROM exam_marks
      WHERE exam_id={$exam_id} AND class_id={$class_id} AND section_id={$section_id}
    ");
    if ($mr) while($m = $mr->fetch_assoc()) {
      $sid = (int)$m['student_id']; $sub = (int)$m['subject_id'];
      $marksMap[$sid][$sub] = (float)$m['marks_obtained'];
    }

    // Count of subjects for averaging (visible subset)
    $subjectCount = count($subList);
?>
<div style="background:#fff;padding:14px;border-radius:10px;">
  <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
    <thead style="background:#0b5ed7;color:#fff;">
      <tr>
        <th>#</th>
        <th>Adm No</th>
        <th>Name</th>
        <?php foreach($subList as $s): ?>
          <th><?= esc($s['subject_name']) ?></th>
        <?php endforeach; ?>
        <th>Total</th>
        <th>Average</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; while($st = $students->fetch_assoc()): 
        $sid = (int)$st['id'];
        $total = 0; $count = 0;
      ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= esc($st['admission_no']) ?></td>
        <td><?= esc($st['first_name'].' '.$st['last_name']) ?></td>
        <?php foreach($subList as $s): 
          $m = $marksMap[$sid][$s['subject_id']] ?? null;
          if ($m !== null) { $total += $m; $count++; }
        ?>
          <td><?= $m === null ? '-' : number_format($m,2) ?></td>
        <?php endforeach; ?>
        <td><b><?= number_format($total,2) ?></b></td>
        <td><?= $subjectCount ? number_format($total / $subjectCount, 2) : '-' ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php
  }
endif;

include '../partials/portal_footer.php';
