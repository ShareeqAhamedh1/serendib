<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$t = [
  'id'=>0,'class_id'=>'','section_id'=>'','day_of_week'=>'Monday',
  'period_number'=>1,'subject_id'=>'','teacher_id'=>'',
  'start_time'=>'','end_time'=>''
];
if ($id) {
  $stmt = $conn->prepare("SELECT * FROM timetable WHERE id=?");
  $stmt->bind_param("i",$id);
  $stmt->execute();
  $t = $stmt->get_result()->fetch_assoc();
}

$classes = $conn->query("SELECT id,class_name FROM classes ORDER BY class_name");
$sections = $conn->query("SELECT id,section_name FROM sections ORDER BY section_name");
$subjects = $conn->query("SELECT id,subject_name FROM subjects ORDER BY subject_name");
$teachers = $conn->query("SELECT id,first_name,last_name FROM teachers ORDER BY first_name");
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

// Generate fixed time slots (45 minutes each)
$periods = [];
$start = new DateTime('08:00');
for ($i = 1; $i <= 8; $i++) {
  $end = clone $start;
  $end->modify('+45 minutes');
  $periods[$i] = [
    'number' => $i,
    'label' => $start->format('H:i') . ' - ' . $end->format('H:i'),
    'start' => $start->format('H:i'),
    'end' => $end->format('H:i')
  ];
  $start = $end;
}
?>

<h2><?= $id ? 'Edit' : 'Add' ?> Timetable Entry</h2>

<form method="post" action="<?= BASE_URL ?>backend/timetable.php?action=<?= $id ? 'update' : 'create' ?>">
  <?= csrf_field() ?>
  <?php if($id): ?><input type="hidden" name="id" value="<?= $t['id'] ?>"><?php endif; ?>

  <label>Class</label>
  <select id="classSelect" name="class_id" required>
    <option value="">-- Select Class --</option>
    <?php while($c=$classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>" <?= $t['class_id']==$c['id']?'selected':'' ?>><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Section</label>
  <select id="sectionSelect" name="section_id">
    <option value="">-- Select Section --</option>
    <?php if($t['class_id']): 
      $classSections = $conn->query("SELECT id, section_name FROM sections WHERE class_id=".(int)$t['class_id']);
      while($s=$classSections->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>" <?= $t['section_id']==$s['id']?'selected':'' ?>><?= esc($s['section_name']) ?></option>
      <?php endwhile; 
    endif; ?>
  </select>

  <label>Day of Week</label>
  <select id="daySelect" name="day_of_week" required>
    <?php foreach($days as $d): ?>
      <option value="<?= $d ?>" <?= $t['day_of_week']==$d?'selected':'' ?>><?= $d ?></option>
    <?php endforeach; ?>
  </select>

  <label>Subject</label>
  <select name="subject_id" required>
    <option value="">-- Select Subject --</option>
    <?php while($sub=$subjects->fetch_assoc()): ?>
      <option value="<?= $sub['id'] ?>" <?= $t['subject_id']==$sub['id']?'selected':'' ?>><?= esc($sub['subject_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Teacher</label>
  <select name="teacher_id" required>
    <option value="">-- Select Teacher --</option>
    <?php while($tr=$teachers->fetch_assoc()): ?>
      <option value="<?= $tr['id'] ?>" <?= $t['teacher_id']==$tr['id']?'selected':'' ?>><?= esc($tr['first_name'].' '.$tr['last_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Number of Periods</label>
  <select id="numPeriods" name="num_periods" disabled>
    <option value="1">1</option>
    <option value="2">2</option>
  </select>

  <div id="periodContainer">
    <!-- Period slot 1 -->
    <div class="period-slot" data-index="1">
      <label>Period</label>
      <select name="period_number[]" class="periodSelect" required>
        <option value="">-- Select Period --</option>
        <?php foreach($periods as $p): ?>
          <option value="<?= $p['number'] ?>" data-start="<?= $p['start'] ?>" data-end="<?= $p['end'] ?>">
            <?= esc($p['label']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <input type="hidden" name="start_time[]" class="startTime">
      <input type="hidden" name="end_time[]" class="endTime">
    </div>
  </div>

  <button type="submit"><?= $id ? 'Save' : 'Add' ?></button>
</form>

<script>
// ✅ Elements
const classSelect   = document.getElementById('classSelect');
const sectionSelect = document.getElementById('sectionSelect');
const daySelect     = document.getElementById('daySelect');
const teacherSelect = document.querySelector('select[name="teacher_id"]');

// ✅ Load sections for selected class
function loadSections(classId, preselect = '') {
    if (!classId) {
        sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
        return Promise.resolve();
    }

    return fetch('<?= BASE_URL ?>backend/get_sections.php?class_id=' + classId)
        .then(r => r.json())
        .then(rows => {
            sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
            rows.forEach(row => {
                let opt = document.createElement('option');
                opt.value = row.id;
                opt.textContent = row.section_name;
                if (String(row.id) === String(preselect)) opt.selected = true;
                sectionSelect.appendChild(opt);
            });
        });
}

// ✅ Main conflict checker
function checkConflicts() {
    const day       = daySelect.value;
    const teacherId = teacherSelect.value;
    const classId   = classSelect.value;
    const sectionId = sectionSelect.value;

    if (!day || !classId) return;

    fetch(`<?= BASE_URL ?>backend/check_timetable_conflicts.php?day=${day}&teacher_id=${teacherId}&class_id=${classId}&section_id=${sectionId}`)
        .then(r => r.json())
        .then(data => {
            let teacherBusy = data.teacher_conflicts || [];
            let classBusy   = data.class_conflicts || [];

            document.querySelectorAll('.periodSelect').forEach(sel => {
                [...sel.options].forEach(opt => {
                    if (!opt.value) return;
                    const period = parseInt(opt.value);

                    let disable = false;
                    let note = '';

                    if (teacherBusy.includes(period)) {
                        disable = true;
                        note = ' (Teacher Busy)';
                    }
                    if (classBusy.includes(period)) {
                        disable = true;
                        note = note ? note + ', Class Busy' : ' (Class Busy)';
                    }

                    opt.disabled = disable;

                    // remove old notes
                    opt.textContent = opt.textContent.replace(/\s*\(.*?\)$/,'');

                    if (disable) opt.textContent += note;
                });
            });
        });
}

// ✅ Period time autofill
document.addEventListener('change', (e) => {
    if (e.target.classList.contains('periodSelect')) {
        const opt = e.target.selectedOptions[0];
        const start = opt.dataset.start;
        const end   = opt.dataset.end;
        const parent = e.target.closest('.period-slot');
        parent.querySelector('.startTime').value = start;
        parent.querySelector('.endTime').value = end;
    }
});

// ✅ Event Listeners
classSelect.addEventListener('change', () => {
    loadSections(classSelect.value).then(checkConflicts);
});
sectionSelect.addEventListener('change', checkConflicts);
daySelect.addEventListener('change', checkConflicts);
teacherSelect.addEventListener('change', checkConflicts);

// ✅ On page ready → ensure section list loads first, THEN conflicts compute
window.addEventListener('DOMContentLoaded', () => {
    const preClass = '<?= $t['class_id'] ?>';
    const preSec   = '<?= $t['section_id'] ?>';

    if (preClass) {
        loadSections(preClass, preSec).then(() => {
            checkConflicts();
        });
    } else {
        checkConflicts();
    }
});
</script>


<?php include 'partials/footer.php'; ?>
