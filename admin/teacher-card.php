<?php
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

$id = (int)($_GET['id'] ?? 0);

/* ---------------- FETCH TEACHER ---------------- */
$stmt = $conn->prepare("
    SELECT 
        t.teacher_code,
        t.first_name,
        t.last_name,
        t.photo,
        t.phone,
        t.email,
        t.join_date,
        t.gender,
        c.class_name,
        sec.section_name,
        sub.subject_name
    FROM teachers t
    LEFT JOIN classes c ON t.class_id = c.id
    LEFT JOIN sections sec ON t.section_id = sec.id
    LEFT JOIN subjects sub ON t.subject_id = sub.id
    WHERE t.id = ?
    LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

if (!$teacher) {
    die("Teacher not found");
}

/* ---------------- FORMAT DATA ---------------- */
$teacherCode = $teacher['teacher_code'];
$fullName    = $teacher['first_name'].' '.$teacher['last_name'];
$phone       = $teacher['phone'] ?: '-';
$subject     = $teacher['subject_name'] ?: '-';
$joinDate    = $teacher['join_date']
                ? date('d M Y', strtotime($teacher['join_date']))
                : '-';

/* ---------------- BARCODE ---------------- */
$generator = new BarcodeGeneratorPNG();
$barcode = base64_encode(
    $generator->getBarcode($teacherCode, $generator::TYPE_CODE_128, 2, 60)
);

/* ---------------- SCHOOL SETTINGS ---------------- */
$yearRes = $conn->query("SELECT academic_year FROM school_settings LIMIT 1");
$academicYear = $yearRes->fetch_assoc()['academic_year'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Teacher ID Card</title>

<style>
@page {
  size: A4;
  margin: 15mm;
}

body {
  font-family: Arial, sans-serif;
  background: #f2f2f2;
}

/* ---------- CARD WRAPPER ---------- */
.card-wrapper {
  display: flex;
  gap: 30mm;
  justify-content: center;
  margin-top: 40px;
}

/* ---------- CARD BASE ---------- */
.card {
  width: 85.6mm;
  height: 54mm;
  border-radius: 10px;
  background: white;
  box-shadow: 0 2px 6px rgba(0,0,0,.2);
  overflow: hidden;
  position: relative;
}

/* ---------- SCHOOL THEME ---------- */
.theme-bar {
  height: 10mm;
  background: #004080;
  display: flex;
  align-items: center;
  padding-left: 6mm;
}

.theme-bar img {
  height: 10mm;
}

/* ---------- FRONT ---------- */
.front-body {
  display: flex;
  padding: 6mm;
  gap: 6mm;
}

.photo-box img {
  width: 26mm;
  height: 32mm;
  object-fit: cover;
  border-radius: 6px;
  border: 2px solid #004080;
}

.details {
  flex: 1;
  font-size: 8.5pt;
}

.details .name {
  font-size: 11pt;
  font-weight: bold;
  color: #004080;
  margin-bottom: 4px;
}

.details .row {
  margin-bottom: 3px;
}

.label {
  font-weight: bold;
  color: #333;
}

/* ---------- BACK ---------- */
.back-body {
  padding: 10mm 8mm;
  text-align: center;
  padding-top: 25px;
}

.barcode img {
  width: 100%;
  height: auto;
}

.footer {
  position: absolute;
  bottom: 4mm;
  width: 100%;
  font-size: 6.5pt;
  color: #555;
  text-align: center;
}

/* PRINT */
@media print {
  body { background: white; }
  .print-btn { display:none; }
}
</style>
</head>

<body>

<div class="card-wrapper">

  <!-- ================= FRONT ================= -->
  <div class="card">
    <div class="theme-bar">
      <img src="<?= BASE_URL ?>admin/uploads/school-logo.png">
      <span style="color:white;padding-left:12px;font-weight:bold;">
        Serendib High School
      </span>
    </div>

    <div class="front-body">
      <div class="photo-box">
        <img src="<?= BASE_URL ?>uploads/<?= esc($teacher['photo'] ?: 'default.png') ?>">
      </div>

      <div class="details">
        <div class="name"><?= esc($fullName) ?></div>

        <div class="row">
          <span class="label">Teacher ID:</span> <?= esc($teacherCode) ?>
        </div>

        <div class="row">
          <span class="label">Subject:</span> <?= esc($subject) ?>
        </div>

        <div class="row">
          <span class="label">Class:</span>
          <?= esc($teacher['class_name'] ?? '-') ?>
          <?= esc($teacher['section_name'] ?? '') ?>
        </div>

        <div class="row">
          <span class="label">Phone:</span> <?= esc($phone) ?>
        </div>

        <div class="row">
          <span class="label">Academic Year:</span> <?= esc($academicYear) ?>
        </div>
      </div>
    </div>
  </div>

  <!-- ================= BACK ================= -->
  <div class="card">
    <div class="theme-bar"></div>

    <div class="back-body">
      <div class="barcode">
        <img src="data:image/png;base64,<?= $barcode ?>">
      </div>
    </div>

    <div class="footer">
      This card is school property • Must be carried on duty
    </div>
  </div>

</div>

<div style="text-align:center;margin-top:20px;">
  <button class="print-btn" onclick="window.print()">🖨 Print Teacher ID Card</button>
</div>

</body>
</html>
