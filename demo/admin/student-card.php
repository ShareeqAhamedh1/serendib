<?php
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("
    SELECT 
        s.admission_no,
        s.first_name,
        s.last_name,
        s.photo,
        s.dob,
        c.class_name,
        sec.section_name,
        p.phone AS parent_phone
    FROM students s
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN sections sec ON s.section_id = sec.id
    LEFT JOIN parents p ON s.parent_id = p.id
    WHERE s.id = ?
    LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    die("Student not found");
}

$admissionNo = $student['admission_no'];
$fullName    = $student['first_name'].' '.$student['last_name'];
$dob         = $student['dob'] ? date('d M Y', strtotime($student['dob'])) : '-';
$parentPhone = $student['parent_phone'] ?: '-';

$generator = new BarcodeGeneratorPNG();
$barcode = base64_encode(
    $generator->getBarcode($admissionNo, $generator::TYPE_CODE_128, 2, 60)
);

$yearRes = $conn->query("SELECT academic_year FROM school_settings LIMIT 1");
$academicYear = $yearRes->fetch_assoc()['academic_year'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Student ID Card</title>

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
   padding-top:25px;
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
        Serendib College
      </span>
    </div>

    <div class="front-body">
      <div class="photo-box">
        <img src="<?= BASE_URL ?>uploads/<?= esc($student['photo'] ?: 'default.png') ?>">
      </div>

      <div class="details">
        <div class="name"><?= esc($fullName) ?></div>

        <div class="row">
          <span class="label">Admission No:</span> <?= esc($admissionNo) ?>
        </div>

        <div class="row">
          <span class="label">Class:</span>
          <?= esc($student['class_name'] ?? '-') ?>
          <?= esc($student['section_name'] ?? '') ?>
        </div>

        <div class="row">
          <span class="label">DOB:</span> <?= esc($dob) ?>
        </div>

        <div class="row">
          <span class="label">Parent:</span> <?= esc($parentPhone) ?>
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
      This card is school property • Must be carried daily
    </div>
  </div>

</div>

<div style="text-align:center;margin-top:20px;">
  <button class="print-btn" onclick="window.print()">🖨 Print Student ID Card</button>
</div>

</body>
</html>
