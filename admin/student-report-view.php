<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$student_id = (int)($_GET['student_id'] ?? 0);
$exam_id = (int)($_GET['exam_id'] ?? 0);

if(!$student_id || !$exam_id){
  echo "<p style='color:red;'>Invalid student or exam.</p>";
  include 'partials/footer.php';
  exit;
}

// ✅ Fetch student info
$q = $conn->prepare("
  SELECT s.*, c.class_name, sec.section_name 
  FROM students s
  LEFT JOIN classes c ON s.class_id=c.id
  LEFT JOIN sections sec ON s.section_id=sec.id
  WHERE s.id=?
");
$q->bind_param("i", $student_id);
$q->execute();
$student = $q->get_result()->fetch_assoc();

if(!$student){
  echo "<p style='color:red;'>No student found.</p>";
  include 'partials/footer.php';
  exit;
}

// ✅ Fetch exam info
$exam = $conn->prepare("SELECT exam_name, start_date, end_date FROM exams WHERE id=?");
$exam->bind_param("i", $exam_id);
$exam->execute();
$exam_info = $exam->get_result()->fetch_assoc();
$exam_name = $exam_info['exam_name'] ?? 'Unknown Exam';
$exam_date = ($exam_info['start_date'] ?? '') ? date('d M Y', strtotime($exam_info['start_date'])) : 'N/A';

// ✅ Fetch subject-wise marks
$res = $conn->prepare("
  SELECT sub.subject_name, em.marks_obtained, em.grade, em.status
  FROM exam_marks em
  JOIN subjects sub ON em.subject_id=sub.id
  WHERE em.exam_id=? AND em.student_id=?
  ORDER BY sub.subject_name
");
$res->bind_param("ii", $exam_id, $student_id);
$res->execute();
$marks = $res->get_result();
?>

<style>
.report-card {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  margin-top: 20px;
}
.report-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 2px solid #007bff;
  padding-bottom: 10px;
}
.report-header img {
  border-radius: 8px;
  width: 90px;
  height: 90px;
  object-fit: cover;
  border: 2px solid #ddd;
}
.report-info p {
  margin: 4px 0;
}
.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
.table th, .table td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: center;
}
.table th {
  background: #007bff;
  color: white;
}
.summary {
  margin-top: 20px;
  font-weight: bold;
  color: #004080;
}
.btn {
  background: #28a745;
  color: white;
  padding: 10px 14px;
  border-radius: 5px;
  text-decoration: none;
}
.btn:hover {
  background: #218838;
}
</style>

<h2>🧾 Student Report Card</h2>

<div class="report-card">
  <div class="report-header">
    <div class="report-info">
      <p><b>Exam:</b> <?= esc($exam_name) ?> (<?= esc($exam_date) ?>)</p>
      <p><b>Student:</b> <?= esc($student['first_name'].' '.$student['last_name']) ?> (<?= esc($student['admission_no']) ?>)</p>
      <p><b>Class:</b> <?= esc($student['class_name'] ?? '-') ?> - <?= esc($student['section_name'] ?? '-') ?></p>
      <p><b>Gender:</b> <?= ucfirst(esc($student['gender'])) ?> | <b>Medium:</b> <?= esc($student['medium']) ?></p>
    </div>
    <div>
      <?php if(!empty($student['photo'])): ?>
        <img src="<?= BASE_URL ?>uploads/<?= esc($student['photo']) ?>" alt="Student Photo">
      <?php else: ?>
        <img src="<?= BASE_URL ?>assets/img/default-student.png" alt="No Photo">
      <?php endif; ?>
    </div>
  </div>

  <?php if($marks->num_rows == 0): ?>
    <p style="margin-top:20px;">No marks recorded for this student in this exam.</p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Subject</th>
          <th>Marks Obtained</th>
          <th>Grade</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0; $count = 0; $passed = 0;
        while($r = $marks->fetch_assoc()):
          $color = $r['status'] == 'Pass' ? 'green' : 'red';
          $total += $r['marks_obtained'];
          $count++;
          if ($r['status'] == 'Pass') $passed++;
        ?>
          <tr>
            <td><?= esc($r['subject_name']) ?></td>
            <td><?= esc($r['marks_obtained']) ?></td>
            <td><?= esc($r['grade']) ?></td>
            <td style="color:<?= $color ?>;"><b><?= esc($r['status']) ?></b></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <?php 
      $avg = $count ? round($total / $count, 2) : 0;
      $overallGrade = ($avg >= 75 ? 'A' : ($avg >= 60 ? 'B' : ($avg >= 45 ? 'C' : ($avg >= 35 ? 'D' : 'F'))));
      $remark = ($passed == $count) ? "Excellent performance!" : (($passed >= $count/2) ? "Needs improvement." : "Failed.");
    ?>

    <div class="summary">
      <p>🎯 <b>Total Marks:</b> <?= $total ?> | <b>Average:</b> <?= $avg ?> | <b>Overall Grade:</b> <?= $overallGrade ?></p>
      <p>🗒️ <b>Remarks:</b> <?= $remark ?></p>
    </div>

    <div style="margin-top:20px;">
      <a href="<?= BASE_URL ?>backend/export_student_report_excel.php?student_id=<?= $student_id ?>&exam_id=<?= $exam_id ?>" class="btn">
        📗 Export to Excel
      </a>
    </div>
  <?php endif; ?>
</div>

<?php include 'partials/footer.php'; ?>
