<?php include 'partials/header.php'; ?>
<?php
// Get summary counts
$students = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];
$teachers = $conn->query("SELECT COUNT(*) AS total FROM teachers")->fetch_assoc()['total'];
$classes = $conn->query("SELECT COUNT(*) AS total FROM classes")->fetch_assoc()['total'];
$subjects = $conn->query("SELECT COUNT(*) AS total FROM subjects")->fetch_assoc()['total'];
$exams = $conn->query("SELECT COUNT(*) AS total FROM exams")->fetch_assoc()['total'];
?>

<style>
.dashboard {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
  margin-top: 20px;
}
.card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  padding: 20px;
  text-align: center;
  transition: transform 0.2s, box-shadow 0.2s;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.card h3 {
  font-size: 16px;
  color: #555;
  margin-bottom: 10px;
}
.card p {
  font-size: 28px;
  font-weight: bold;
  color: #004080;
  margin: 0;
}
.quick-links {
  margin-top: 40px;
}
.quick-links h3 {
  color: #004080;
  margin-bottom: 15px;
}
.quick-links a {
  display: inline-block;
  background: #004080;
  color: white;
  padding: 10px 15px;
  border-radius: 5px;
  margin: 5px;
  text-decoration: none;
  transition: background 0.2s;
}
.quick-links a:hover {
  background: #007bff;
}
</style>

<h2>🏫 Admin Dashboard</h2>
<p>Welcome to your school ERP dashboard! Here’s a quick overview of key statistics.</p>

<div class="dashboard">
  <div class="card">
    <h3>👨‍🎓 Total Students</h3>
    <p><?= esc($students) ?></p>
  </div>
  <div class="card">
    <h3>👩‍🏫 Total Teachers</h3>
    <p><?= esc($teachers) ?></p>
  </div>
  <div class="card">
    <h3>🏫 Classes</h3>
    <p><?= esc($classes) ?></p>
  </div>
  <div class="card">
    <h3>📚 Subjects</h3>
    <p><?= esc($subjects) ?></p>
  </div>
  <div class="card">
    <h3>🧾 Exams</h3>
    <p><?= esc($exams) ?></p>
  </div>
</div>

<div class="quick-links">
  <h3>⚡ Quick Actions</h3>
  <a href="<?= BASE_URL ?>admin/attendance-scanner.php">📋 Mark Attendance</a>
  <a href="<?= BASE_URL ?>admin/attendance-report.php">📈 Attendance Report</a>
  <a href="<?= BASE_URL ?>admin/enter-marks.php">✏️ Enter Marks</a>
  <a href="<?= BASE_URL ?>admin/student-marks-report.php">📘 View Marks</a>
  <a href="<?= BASE_URL ?>admin/fee-categories.php">💰 Manage Fees</a>
  
</div>

<?php include 'partials/footer.php'; ?>
