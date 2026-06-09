<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';
requireLogin();

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - School ERP</title>
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/favicon.png">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/app.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* ===== Layout ===== */
    body {
      margin: 0;
      font-family: 'Poppins', 'Segoe UI', sans-serif;
      background: #f4f6f9;
      display: flex;
      min-height: 100vh;
    }

    /* ===== Sidebar ===== */
    .sidebar {
      width: 240px;
      background: #002b5c;
      color: #fff;
      display: flex;
      flex-direction: column;
      padding-top: 15px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      box-shadow: 2px 0 5px rgba(0,0,0,0.2);
      overflow-y: auto;
    }

    .sidebar h2 {
      text-align: center;
      font-size: 20px;
      margin: 10px 0 20px;
      color: #fff;
      letter-spacing: 1px;
    }

    .sidebar a,
    .dropdown-btn {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px 18px;
      font-size: 15px;
      border-left: 4px solid transparent;
      transition: all 0.2s;
      background: none;
      cursor: pointer;
      text-align: left;
      border: none;
      width: 100%;
    }

    .sidebar a:hover,
    .dropdown-btn:hover {
      background: rgba(255,255,255,0.1);
      border-left: 4px solid #00b4d8;
    }

    .dropdown-container {
      display: none;
      background: rgba(255,255,255,0.08);
    }

    .dropdown-container a {
      padding-left: 35px;
      font-size: 14px;
      color: #cce0ff;
    }

    .dropdown-container a:hover {
      color: #fff;
    }

    /* ===== Main Area ===== */
    main {
      margin-left: 240px;
      flex-grow: 1;
      padding: 20px;
      transition: margin-left 0.3s;
    }

    /* ===== Responsive ===== */
    @media(max-width: 768px) {
      .sidebar {
        width: 60px;
      }

      .sidebar h2 {
        display: none;
      }

      .sidebar a,
      .dropdown-btn {
        font-size: 0;
        padding: 14px;
        text-align: center;
      }

      .sidebar a::after,
      .dropdown-btn::after {
        content: attr(data-icon);
        font-size: 18px;
      }

      main {
        margin-left: 60px;
      }
    }
  </style>
</head>
<body>
<?php if (!empty($_SESSION['login_success'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
  icon: 'success',
  title: 'Welcome Back!',
  text: 'Login successful.',
  timer: 2000,
  showConfirmButton: false
});
</script>
<?php unset($_SESSION['login_success']); endif; ?>

<!-- ===== Sidebar ===== -->
 
<div class="sidebar">
  <h2>  <img src="<?= BASE_URL ?>assets/img/favicon.png" 
       alt="Admin" 
       style="width:50px; vertical-align:middle; margin-right:10px;"> School ERP</h2>

  <a href="<?= BASE_URL ?>admin/index.php">🏠 Dashboard</a>

  <button class="dropdown-btn">👨‍🎓 Students ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/students.php">Student List</a>
    <a href="<?= BASE_URL ?>admin/student-marks-report.php">Exam Marks</a>
    <a href="<?= BASE_URL ?>admin/report-card.php">Report Card</a>
    <a href="<?= BASE_URL ?>admin/registrations.php">New Registrations</a>
  </div>

  <button class="dropdown-btn">👩‍🏫 Teachers ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/teachers.php">Teacher List</a>
    <a href="<?= BASE_URL ?>admin/assign-teacher-classes.php">Assign Class</a>
    <a href="<?= BASE_URL ?>admin/teacher-salary.php">Salary Management</a>
    <a href="<?= BASE_URL ?>admin/teacher-payments-report.php">Salary Reports</a>
    <a href="<?= BASE_URL ?>admin/leave-requests.php">Leave Management</a>
  </div>

  <button class="dropdown-btn">👨‍👩‍👧 Parents ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/manage-parents.php">Manage Parents</a>
    <a href="<?= BASE_URL ?>admin/link-parent.php">Link Parent to Student</a>
    <a href="<?= BASE_URL ?>admin/whatsapp-broadcast.php">Message Parents</a>
  </div>

  <button class="dropdown-btn">📘 Academics ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/classes.php">Classes</a>
    <a href="<?= BASE_URL ?>admin/sections.php">Sections</a>
    <a href="<?= BASE_URL ?>admin/subjects.php">Subjects</a>
    <a href="<?= BASE_URL ?>admin/mappings.php">Mappings</a>
    <a href="<?= BASE_URL ?>admin/timetable.php">Timetable</a>
  </div>

  <button class="dropdown-btn">🕓 Attendance ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/attendance-scanner.php">Mark Attendance</a>
    <a href="<?= BASE_URL ?>admin/attendance-report.php">View Reports</a>
  </div>

  <button class="dropdown-btn">🧾 Exams ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/exams.php">Exam List</a>
    <a href="<?= BASE_URL ?>admin/add-exam.php">Add Exam</a>
    <a href="<?= BASE_URL ?>admin/exam-subjects.php">Assign Subjects</a>
    <a href="<?= BASE_URL ?>admin/enter-marks.php">Enter Marks</a>
  </div>

<button class="dropdown-btn"> 🏘️ Houses ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/house-sorting.php">Assign House</a>
    <a href="<?= BASE_URL ?>admin/house-points.php">House Points</a>
    <a href="<?= BASE_URL ?>admin/house-members.php">House Members</a>
    <a href="<?= BASE_URL ?>admin/house-leaderboard.php">Leader Board</a>
  </div>

  <button class="dropdown-btn">💰 Fees ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/fee-types.php">Fee Types</a>
    <a href="<?= BASE_URL ?>admin/assign-fees.php">Assign Fees</a>
    <a href="<?= BASE_URL ?>admin/record-payment.php">Record Payment</a>
  </div>

  <button class="dropdown-btn">💵 Expenses ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/expense-categories.php">Expense Categories</a>
    <a href="<?= BASE_URL ?>admin/add-expense.php">Add Expense</a>
    <a href="<?= BASE_URL ?>admin/expense-list.php">Expense List</a>
  </div>



  <button class="dropdown-btn">💹 Finance ▾</button>
  <div class="dropdown-container">
    <a href="<?= BASE_URL ?>admin/finance-dashboard.php">Finance Dashboard</a>
  </div>

    <a href="<?= BASE_URL ?>admin/smart-announcement.php">📢 Announcement</a>
  <a href="<?= BASE_URL ?>backend/auth.php?logout=1">🚪 Logout</a>
</div>

<!-- ===== Main Content ===== -->
<main>
