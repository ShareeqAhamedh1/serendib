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
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

/* ===============================
   PERIOD GENERATION (40 MIN)
================================ */
$periods = [];
$start = new DateTime('07:40');

for ($i = 1; $i <= 12; $i++) {

  /* 🔔 WEEKDAY INTERVAL HANDLING
     If period would start at 11:00,
     skip interval (11:00–11:20)
  */
  if ($start->format('H:i') === '11:00') {
      $start->modify('+20 minutes'); // jump to 11:20
  }

  $end = clone $start;
  $end->modify('+40 minutes');

  $periods[$i] = [
    'number' => $i,
    'label'  => $start->format('H:i') . ' - ' . $end->format('H:i'),
    'start'  => $start->format('H:i'),
    'end'    => $end->format('H:i')
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
<option value="<?= $c['id'] ?>" <?= $t['class_id']==$c['id']?'selected':'' ?>>
<?= esc($c['class_name']) ?>
</option>
<?php endwhile; ?>
</select>

<label>Section</label>
<select id="sectionSelect" name="section_id">
<option value="">-- Select Section --</option>
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
<option value="<?= $sub['id'] ?>" <?= $t['subject_id']==$sub['id']?'selected':'' ?>>
<?= esc($sub['subject_name']) ?>
</option>
<?php endwhile; ?>
</select>

<label id="basketLabel" style="display:none">Basket Group</label>
<select name="basket_group" id="basketGroup" style="display:none">
  <option value="">-- Not a Basket Subject --</option>
  <option value="F.Lang">First Language</option>
  <option value="G1">Group 1 (G1)</option>
  <option value="G2">Group 2 (G2)</option>
  <option value="G3">Group 3 (G3)</option>
</select>

<label>Teacher</label>
<select name="teacher_id" required>
<option value="">-- Select Teacher --</option>
<?php while($tr=$teachers->fetch_assoc()): ?>
<option value="<?= $tr['id'] ?>" <?= $t['teacher_id']==$tr['id']?'selected':'' ?>>
<?= esc($tr['first_name'].' '.$tr['last_name']) ?>
</option>
<?php endwhile; ?>
</select>

<div class="period-slot">
<label>Period</label>
<select name="period_number[]" class="periodSelect" required>
<option value="">-- Select Period --</option>
<?php foreach($periods as $p): ?>
<option value="<?= $p['number'] ?>"
  <?= ($t['period_number'] == $p['number']) ? 'selected' : '' ?>
  data-start="<?= $p['start'] ?>"
  data-end="<?= $p['end'] ?>">

<?= esc($p['label']) ?>
</option>
<?php endforeach; ?>
</select>
<input type="hidden" name="start_time[]" class="startTime">
<input type="hidden" name="end_time[]" class="endTime">
</div>

<button type="submit" class="btn btn-sm btn-warning"><?= $id ? 'Save' : 'Add' ?></button>
<?php if ($id): ?>
  <!-- <hr style="margin:20px 0">
<form method="post"
      action="<?= BASE_URL ?>backend/timetable.php?action=delete"
      onsubmit="return confirm('Delete this timetable entry?')">

  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= $t['id'] ?>">

  <button type="submit" style="background:#dc3545;color:#fff;border:none;padding:6px 10px;border-radius:6px">
    🗑 Delete
  </button> -->
</form>

<?php endif; ?>

</form>

<script>
/* ===============================
   TIME RULE CONFIG
================================ */
const WEEKDAYS = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
const WEEKENDS = ['Saturday','Sunday'];

const WEEKDAY_END = '14:00';
const WEEKEND_END = '18:00';
const BREAK_START = '11:00';
const BREAK_END   = '11:20';

function toMinutes(t){
  const [h,m] = t.split(':').map(Number);
  return h*60 + m;
}

/* ===============================
   ELEMENTS
================================ */
const classSelect   = document.getElementById('classSelect');
const sectionSelect = document.getElementById('sectionSelect');
const daySelect     = document.getElementById('daySelect');
const teacherSelect = document.querySelector('[name="teacher_id"]');

/* ===============================
   LOAD SECTIONS
================================ */
function loadSections(classId, preselect=''){
  if(!classId){
    sectionSelect.innerHTML='<option value="">-- Select Section --</option>';
    return Promise.resolve();
  }
  return fetch('<?= BASE_URL ?>backend/get_sections.php?class_id='+classId)
  .then(r=>r.json())
  .then(rows=>{
    sectionSelect.innerHTML='<option value="">-- Select Section --</option>';
    rows.forEach(r=>{
      let o=document.createElement('option');
      o.value=r.id; o.textContent=r.section_name;
      if(String(r.id)===String(preselect)) o.selected=true;
      sectionSelect.appendChild(o);
    });
  });
}

/* ===============================
   CONFLICT + TIME CHECKER
================================ */
function checkConflicts(){
  const day = daySelect.value;
  if(!day || !classSelect.value) return;

const basket = basketGroup ? basketGroup.value : '';

fetch(`<?= BASE_URL ?>backend/check_timetable_conflicts.php?` +
  `day=${day}` +
  `&teacher_id=${teacherSelect.value}` +
  `&class_id=${classSelect.value}` +
  `&section_id=${sectionSelect.value}` +
  `&basket_group=${basket}`
)
.then(r=>r.json())
  .then(data=>{
    const teacherBusy=data.teacher_conflicts||[];
    const classBusy=data.class_conflicts||[];

    const isWeekday=WEEKDAYS.includes(day);
    const endLimit=toMinutes(isWeekday?WEEKDAY_END:WEEKEND_END);
    const bStart=toMinutes(BREAK_START);
    const bEnd=toMinutes(BREAK_END);

    document.querySelectorAll('.periodSelect option').forEach(opt=>{
      if(!opt.value) return;

      const start=toMinutes(opt.dataset.start);
      const end=toMinutes(opt.dataset.end);
      let disable=false, note='';

      if(end>endLimit){
        disable=true; note=' (Outside Time)';
      }
      if(isWeekday && start<bEnd && end>bStart){
        disable=true; note=' (Interval)';
      }
      if(teacherBusy.includes(+opt.value)){
        disable=true; note=note?note+', Teacher Busy':' (Teacher Busy)';
      }
const basketBusy = data.basket_conflicts || [];

if (!basket && classBusy.includes(+opt.value)) {
  disable = true;
  note = note ? note + ', Class Busy' : ' (Class Busy)';
}

if (basket && basketBusy.includes(+opt.value)) {
  disable = true;
  note = note ? note + ', Basket Group Busy' : ' (Basket Group Busy)';
}


      opt.disabled=disable;
      opt.textContent=opt.textContent.replace(/\s*\(.*?\)$/,'');
      if(disable) opt.textContent+=note;
    });
  });
}

/* ===============================
   AUTOFILL TIMES
================================ */
document.addEventListener('change',e=>{
  if(e.target.classList.contains('periodSelect')){
    const o=e.target.selectedOptions[0];
    e.target.closest('.period-slot').querySelector('.startTime').value=o.dataset.start;
    e.target.closest('.period-slot').querySelector('.endTime').value=o.dataset.end;
  }
});

/* ===============================
   EVENTS
================================ */
classSelect.onchange=()=>loadSections(classSelect.value).then(checkConflicts);
sectionSelect.onchange=checkConflicts;
daySelect.onchange=checkConflicts;
teacherSelect.onchange=checkConflicts;

window.addEventListener('DOMContentLoaded', () => {
  loadSections('<?= $t['class_id'] ?>','<?= $t['section_id'] ?>')
    .then(() => {
      checkConflicts();
      autofillSelectedPeriods(); // ✅ FIX
    });
});


function autofillSelectedPeriods() {
  document.querySelectorAll('.periodSelect').forEach(sel => {
    if (!sel.value) return;

    const opt = sel.selectedOptions[0];
    if (!opt || !opt.dataset.start) return;

    const slot = sel.closest('.period-slot');
    slot.querySelector('.startTime').value = opt.dataset.start;
    slot.querySelector('.endTime').value   = opt.dataset.end;
  });
}

</script>
<script>
const GRADE_10_ID = 5;
const GRADE_11_ID = 6;

const basketGroup = document.getElementById('basketGroup');
const basketLabel = document.getElementById('basketLabel');

function toggleBasket() {
  const cls = parseInt(classSelect.value || 0);

  if (cls === GRADE_10_ID || cls === GRADE_11_ID) {
    basketGroup.style.display = 'block';
    basketLabel.style.display = 'block';
  } else {
    basketGroup.value = '';
    basketGroup.style.display = 'none';
    basketLabel.style.display = 'none';
  }

  checkConflicts();
}

classSelect.addEventListener('change', toggleBasket);
window.addEventListener('DOMContentLoaded', toggleBasket);
</script>

<?php include 'partials/footer.php'; ?>
