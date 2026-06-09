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
$classMap = [];

$classes2 = $conn->query("
    SELECT id,class_name
    FROM classes
");

while($c2 = $classes2->fetch_assoc()){

    $classMap[$c2['id']] = $c2['class_name'];
}
$sections = $conn->query("SELECT id,section_name FROM sections ORDER BY section_name");
$subjects = $conn->query("
    SELECT
        id,
        subject_name,
        subject_type,
        basket_group
    FROM subjects
    ORDER BY subject_name
");
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

<select name="subject_id"
        id="subjectSelect"
        required>

<option value="">-- Select Subject --</option>

<?php while($sub=$subjects->fetch_assoc()): ?>

<?php

$type   = $sub['subject_type'] ?? 'Normal';
$basket = $sub['basket_group'] ?? '';

$label = $sub['subject_name'];

if($type == 'First Language'){
    $label .= ' (1st Language)';
}

elseif($type == 'Second Language'){
    $label .= ' (2nd Language)';
}

elseif($type == 'Group Subject'){
    $label .= ' ('.$basket.')';
}

?>

<option
    value="<?= $sub['id'] ?>"

    data-type="<?= esc($type) ?>"
    data-basket="<?= esc($basket) ?>"

    <?= $t['subject_id']==$sub['id']?'selected':'' ?>>

    <?= esc($label) ?>

</option>

<?php endwhile; ?>

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

<div style="
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    margin-top:20px;
">

<button
    type="submit"
    class="btn btn-sm btn-warning"
>
    <?= $id ? '💾 Save Changes' : '➕ Add Timetable' ?>
</button>

<?php if ($id): ?>

<a
    href="<?= BASE_URL ?>backend/timetable.php?action=delete&id=<?= $t['id'] ?>"
    
    onclick="return confirm('Delete this timetable entry?')"

    style="
        background:#dc3545;
        color:#fff;
        text-decoration:none;

        padding:10px 16px;

        border-radius:8px;

        font-weight:600;

        display:inline-flex;
        align-items:center;
        gap:6px;
    "
>
    🗑 Delete
</a>

<?php endif; ?>

</div>

</form>

<script>

/* ===============================
   TIME RULE CONFIG
================================ */
const WEEKDAYS = [
  'Monday',
  'Tuesday',
  'Wednesday',
  'Thursday',
  'Friday'
];

const WEEKENDS = [
  'Saturday',
  'Sunday'
];

const WEEKDAY_END = '14:00';
const WEEKEND_END = '18:00';

const BREAK_START = '11:00';
const BREAK_END   = '11:20';

function toMinutes(t){

  const [h,m] = t.split(':').map(Number);

  return h * 60 + m;
}

/* ===============================
   ELEMENTS
================================ */
const classSelect   = document.getElementById('classSelect');
const sectionSelect = document.getElementById('sectionSelect');
const daySelect     = document.getElementById('daySelect');

const teacherSelect =
  document.querySelector('[name="teacher_id"]');

const subjectSelect =
  document.getElementById('subjectSelect');

/* ===============================
   CLASS MAP
================================ */
const classMap = <?= json_encode($classMap) ?>;

/* ===============================
   GET SELECTED SUBJECT
================================ */
function getSelectedSubject(){

    const opt =
        subjectSelect.selectedOptions[0];

    return {

        type:
            opt?.dataset?.type || '',

        basket:
            opt?.dataset?.basket || ''
    };
}

/* ===============================
   LOAD SECTIONS
================================ */
function loadSections(classId, preselect=''){

  if(!classId){

    sectionSelect.innerHTML =
      '<option value="">-- Select Section --</option>';

    return Promise.resolve();
  }

  return fetch(
    '<?= BASE_URL ?>backend/get_sections.php?class_id='
    + classId
  )
  .then(r => r.json())
  .then(rows => {

    sectionSelect.innerHTML =
      '<option value="">-- Select Section --</option>';

    rows.forEach(r => {

      let o = document.createElement('option');

      o.value = r.id;
      o.textContent = r.section_name;

      if(String(r.id) === String(preselect)){
        o.selected = true;
      }

      sectionSelect.appendChild(o);
    });
  });
}

/* ===============================
   FILTER SUBJECTS
================================ */
function filterSubjects(){

    const clsId = classSelect.value;

    const className =
      (classMap[clsId] || '').toLowerCase();

    const isSeniorGrade =
        className.includes('10') ||
        className.includes('11');

    [...subjectSelect.options].forEach(opt => {

        if(!opt.value) return;

        const type =
          opt.dataset.type || '';

        /*
          hide group subjects
          for non 10/11
        */
        if(
          type === 'Group Subject'
          &&
          !isSeniorGrade
        ){

            opt.hidden = true;

        } else {

            opt.hidden = false;
        }
    });
}

/* ===============================
   CHECK CONFLICTS
================================ */
function checkConflicts(){

  const day = daySelect.value;

  if(!day || !classSelect.value){
    return;
  }

  fetch(
    `<?= BASE_URL ?>backend/check_timetable_conflicts.php?`
    + `day=${day}`
    + `&teacher_id=${teacherSelect.value}`
    + `&class_id=${classSelect.value}`
    + `&section_id=${sectionSelect.value}`
    + `&subject_id=${subjectSelect.value}`
  )

  .then(r => r.json())

  .then(data => {

    const teacherBusy =
      data.teacher_conflicts || [];

    const classBusy =
      data.class_conflicts || [];

    const basketBusy =
      data.basket_conflicts || [];

    const selected =
      getSelectedSubject();

    const subjectType =
      selected.type;

    const isGroup =
      subjectType === 'Group Subject';

    const isFirstLang =
      subjectType === 'First Language';

    const isSecondLang =
      subjectType === 'Second Language';

    const isWeekday =
      WEEKDAYS.includes(day);

    const endLimit =
      toMinutes(
        isWeekday
          ? WEEKDAY_END
          : WEEKEND_END
      );

    const bStart =
      toMinutes(BREAK_START);

    const bEnd =
      toMinutes(BREAK_END);

    document
      .querySelectorAll('.periodSelect option')

      .forEach(opt => {

      if(!opt.value) return;

      const start =
        toMinutes(opt.dataset.start);

      const end =
        toMinutes(opt.dataset.end);

      let disable = false;

      let notes = [];

      /* =========================
         OUTSIDE TIME
      ========================= */
      if(end > endLimit){

        disable = true;

        notes.push('Outside Time');
      }

      /* =========================
         INTERVAL
      ========================= */
      if(
        isWeekday
        &&
        start < bEnd
        &&
        end > bStart
      ){

        disable = true;

        notes.push('Interval');
      }

      /* =========================
         TEACHER BUSY
      ========================= */
      if(
        teacherBusy.includes(+opt.value)
      ){

        disable = true;

        notes.push('Teacher Busy');
      }

      /* =========================
   GROUP SUBJECTS
========================= */
if(isGroup){

    if(
      basketBusy.includes(+opt.value)
    ){

        disable = true;

        notes.push('Basket Busy');
    }
}

/* =========================
   FIRST LANGUAGE
========================= */
else if(isFirstLang){

    if(
      basketBusy.includes(+opt.value)
    ){

        disable = true;

        notes.push('1st Language Busy');
    }
}

/* =========================
   SECOND LANGUAGE
========================= */
else if(isSecondLang){

    if(
      basketBusy.includes(+opt.value)
    ){

        disable = true;

        notes.push('2nd Language Busy');
    }
}

/* =========================
   NORMAL SUBJECTS
========================= */
else{

    if(
      classBusy.includes(+opt.value)
    ){

        disable = true;

        notes.push('Class Busy');
    }
}
      /* =========================
         APPLY
      ========================= */
      opt.disabled = disable;

      opt.textContent =
        opt.textContent.replace(
          /\s*\(.*?\)$/,''
        );

      if(disable){

        opt.textContent +=
          ' (' + notes.join(', ') + ')';
      }
    });
  });
}

/* ===============================
   AUTOFILL PERIOD TIMES
================================ */
document.addEventListener('change', e => {

  if(
    e.target.classList.contains(
      'periodSelect'
    )
  ){

    const o =
      e.target.selectedOptions[0];

    const slot =
      e.target.closest('.period-slot');

    slot.querySelector('.startTime').value =
      o.dataset.start;

    slot.querySelector('.endTime').value =
      o.dataset.end;
  }
});

/* ===============================
   AUTO FILL ON EDIT
================================ */
function autofillSelectedPeriods(){

  document
    .querySelectorAll('.periodSelect')

    .forEach(sel => {

      if(!sel.value) return;

      const opt =
        sel.selectedOptions[0];

      if(!opt || !opt.dataset.start){
        return;
      }

      const slot =
        sel.closest('.period-slot');

      slot.querySelector('.startTime').value =
        opt.dataset.start;

      slot.querySelector('.endTime').value =
        opt.dataset.end;
    });
}

/* ===============================
   EVENTS
================================ */
classSelect.onchange = () => {

  loadSections(classSelect.value)

    .then(() => {

      filterSubjects();

      checkConflicts();
    });
};

sectionSelect.onchange = checkConflicts;

daySelect.onchange = checkConflicts;

teacherSelect.onchange = checkConflicts;

subjectSelect.onchange = checkConflicts;

/* ===============================
   PAGE LOAD
================================ */
window.addEventListener(
  'DOMContentLoaded',
  () => {

    loadSections(
      '<?= $t['class_id'] ?>',
      '<?= $t['section_id'] ?>'
    )

    .then(() => {

      filterSubjects();

      checkConflicts();

      autofillSelectedPeriods();
    });
});
</script>

<?php include 'partials/footer.php'; ?>
