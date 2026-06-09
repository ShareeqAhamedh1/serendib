<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;

// Academic year
$yearRes = $conn->query("SELECT academic_year FROM school_settings LIMIT 1");
$academicYear = $yearRes->fetch_assoc()['academic_year'] ?? '';

$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");

$class_id   = (int)($_GET['class_id'] ?? 0);
$section_id = (int)($_GET['section_id'] ?? 0);

$students = [];

if ($class_id && $section_id) {
    $stmt = $conn->prepare("
        SELECT 
            s.admission_no, s.first_name, s.last_name, s.photo, s.dob,
            p.phone AS parent_phone,
            c.class_name, sec.section_name
        FROM students s
        LEFT JOIN parents p ON s.parent_id = p.id
        LEFT JOIN classes c ON s.class_id = c.id
        LEFT JOIN sections sec ON s.section_id = sec.id
        WHERE s.class_id=? AND s.section_id=?
        ORDER BY s.first_name
    ");
    $stmt->bind_param("ii", $class_id, $section_id);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$generator = new BarcodeGeneratorPNG();
?>

<h2>🪪 Bulk Student ID Cards</h2>

<form method="get" style="margin-bottom:20px;">
  <select name="class_id" required>
    <option value="">Select Class</option>
    <?php while($c=$classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>" <?= $class_id==$c['id']?'selected':'' ?>>
        <?= esc($c['class_name']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <select name="section_id" required id="sectionSelect">
    <option value="">Select Section</option>
  </select>

  <button type="submit">Load Students</button>
</form>

<?php if($students): ?>
<button onclick="window.print()">🖨 Print All ID Cards</button>
<?php endif; ?>

<style>
@page { size: A4; margin: 10mm; }

body { font-family: Arial; }

.print-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12mm;
  margin-top: 20px;
}

.card {
  width: 85.6mm;
  height: 54mm;
  border-radius: 10px;
  background: white;
  box-shadow: 0 2px 6px rgba(0,0,0,.2);
  overflow: hidden;
  position: relative;
  padding:0;
}

.theme {
  background:#004080;
  color:white;
  padding:4mm;
  font-weight:bold;
  font-size:9pt;
}

.body {
  display:flex;
  gap:5mm;
  padding:5mm;
  font-size:8pt;
}

.photo img {
  width:26mm;
  height:32mm;
  object-fit:cover;
  border:2px solid #004080;
  border-radius:5px;
}
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

.barcode img {
  width: 100%;
  height: auto;
 
}


.barcode{
    padding-top:25px;
}
@media print {
  button, form { display:none; }
}
.footer {
  position: absolute;
  bottom: 4mm;
  width: 100%;
  font-size: 6.5pt;
  color: #555;
  text-align: center;
}

.label {
  font-weight: bold;
  color: #333;
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

.details {
  flex: 1;
  font-size: 8.5pt;
}

</style>

<div class="print-grid">

<?php foreach($students as $s): 
  $barcode = base64_encode(
    $generator->getBarcode($s['admission_no'], $generator::TYPE_CODE_128, 2, 50)
  );
?>

<div class="card">
      <div class="theme-bar">
      <img src="<?= BASE_URL ?>admin/uploads/school-logo.png">
      <span style="color:white;padding-left:12px;font-weight:bold;">
        Serendib College
      </span>
    </div>
  <div class="body">
    <div class="photo">
      <img src="<?= BASE_URL ?>uploads/<?= esc($s['photo'] ?: 'default.png') ?>">
    </div>
    <div class="details">
      <div class="name"><?= esc($s['first_name'].' '.$s['last_name']) ?></div>
      <div class="row">
      <span class="label">Admission No:</span><?= esc($s['admission_no']) ?>
    </div>
      <div class="row">
      <span class="label">Class:</span> <?= esc($s['class_name'].' '.$s['section_name']) ?>
      </div>
      <div class="row">
      <span class="label">DOB:</span><?= date('d M Y', strtotime($s['dob'])) ?>
    </div>
      <div class="row">
      <span class="label">Parent:</span><?= esc($s['parent_phone']) ?>
    </div>
      <div class="row">
      <span class="label">Academic Year:</span> <?= esc($academicYear) ?>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="theme"></div>
  <div class="body barcode">
    <img src="data:image/png;base64,<?= $barcode ?>">
  </div>
      <div class="footer">
      This card is school property • Must be carried daily
    </div>
</div>

<?php endforeach; ?>
</div>

<script>
document.querySelector('[name="class_id"]').addEventListener('change', e => {
  fetch("<?= BASE_URL ?>backend/get_sections.php?class_id="+e.target.value)
    .then(r=>r.json())
    .then(d=>{
      sectionSelect.innerHTML='<option value="">Select Section</option>';
      d.forEach(s=>{
        sectionSelect.innerHTML+=`<option value="${s.id}">${s.section_name}</option>`;
      });
    });
});
</script>

<?php include 'partials/footer.php'; ?>
