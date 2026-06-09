<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

// Dropdown data
$classes  = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$teachers = $conn->query("SELECT id, CONCAT(first_name,' ',last_name) AS teacher_name FROM teachers ORDER BY first_name");
$days     = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

/* ===============================
   TIME SLOTS (UNTIL 2 PM)
================================ */
$timeSlots = [];
$start = new DateTime('07:40');

while ($start->format('H:i') < '14:00') {

    // ⛔ Interval (11:00 – 11:20)
    if ($start->format('H:i') === '11:00') {
        $timeSlots[] = [
            'label' => '11:00 - 11:20',
            'interval' => true
        ];
        $start->modify('+20 minutes');
        continue;
    }

    $end = clone $start;
    $end->modify('+40 minutes');

    $timeSlots[] = [
        'label' => $start->format('H:i').' - '.$end->format('H:i'),
        'start' => $start->format('H:i'),
        'end'   => $end->format('H:i'),
        'interval' => false
    ];

    $start = $end;
}

?>
<?php if (!empty($_SESSION['flash'])): 
  $flash = $_SESSION['flash'];
  unset($_SESSION['flash']); // 🔥 THIS REMOVES IT AFTER ONE LOAD
?>
<script>
Swal.fire({
  icon: '<?= $flash['type'] ?>',
  title: '<?= addslashes($flash['title']) ?>',
  text: '<?= addslashes($flash['text']) ?>',
  confirmButtonColor:'#005c2e'
});
</script>
<?php endif; ?>

<h2>📅 Weekly Class Timetable</h2>

<a href="<?= BASE_URL ?>admin/add-timetable.php" class="btn">➕ Add Period</a>

<!-- ================= FILTERS ================= -->
<div class="filter-bar">
  <select id="classFilter">
    <option value="">Class</option>
    <?php while($c = $classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <select id="sectionFilter">
    <option value="">Section</option>
  </select>

  <select id="teacherFilter">
    <option value="">Teacher</option>
    <?php while($t = $teachers->fetch_assoc()): ?>
      <option value="<?= $t['id'] ?>"><?= esc($t['teacher_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <button id="resetFilter" class="reset">Reset</button>
</div>

<!-- ================= TIMETABLE ================= -->
<div class="table-wrapper">
<table class="timetable">
  <thead>
    <tr>
      <th>Time</th>
      <?php foreach($days as $d): ?>
        <th><?= $d ?></th>
      <?php endforeach; ?>
    </tr>
  </thead>

  <tbody id="timetableBody">
    <?php foreach($timeSlots as $slot): ?>
      <tr class="<?= $slot['interval'] ? 'interval' : '' ?>">
        <td class="time-col"><?= $slot['label'] ?></td>

        <?php foreach($days as $d): ?>
          <td
            data-day="<?= $d ?>"
            data-start="<?= $slot['start'] ?? '' ?>"
            class="cell"
          >
            <?php if($slot['interval']): ?>
              <span class="interval-text">INTERVAL</span>
            <?php endif; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<style>
.filter-bar{
  display:flex;
  gap:8px;
  margin:15px 0;
  flex-wrap:wrap
}
.filter-bar select,
.filter-bar button{
  padding:6px 8px;
  font-size:14px
}
.filter-bar .reset{
  background:#777;color:#fff;border:none
}

.table-wrapper{overflow-x:auto;margin-top:15px}
.timetable{
  width:100%;
  border-collapse:collapse;
  background:#fff;
  box-shadow:0 4px 12px rgba(0,0,0,.08)
}
.timetable th,
.timetable td{
  border:1px solid #ddd;
  padding:8px;
  vertical-align:top
}
.timetable th{
  background:#005c2e;
  color:#fff;
  text-align:center
}
.time-col{
  font-weight:600;
  background:#f4f6f8;
  width:130px
}
.cell{
  min-height:70px;
  font-size:13px
}
.cell .entry{
  background:#e9f5ff;
  padding:6px;
  border-radius:6px;
  margin-bottom:4px
}
.cell .sub{font-weight:600}
.cell .teacher{font-size:12px;color:#555}
.interval{background:#fff3cd}
.interval-text{font-weight:700;color:#856404}
</style>

<script>
const classFilter   = document.getElementById('classFilter');
const sectionFilter = document.getElementById('sectionFilter');
const teacherFilter = document.getElementById('teacherFilter');

// ================= LOAD SECTIONS =================
classFilter.addEventListener('change', () => {
  sectionFilter.innerHTML = '<option value="">Section</option>';

  if (!classFilter.value) {
    loadTimetable();
    return;
  }

  fetch(`<?= BASE_URL ?>backend/fetch_sections.php?class_id=${classFilter.value}`)
    .then(r => r.json())
    .then(data => {
      data.forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.id;
        opt.textContent = s.section_name;
        sectionFilter.appendChild(opt);
      });
      loadTimetable();
    });
});

// ================= LOAD TIMETABLE =================

function loadTimetable() {
  // Clear existing cells (except interval rows)
  document.querySelectorAll('.cell').forEach(c => {
    if (!c.closest('.interval')) c.innerHTML = '';
  });

  const params = new URLSearchParams({
    class_id: classFilter.value,
    section_id: sectionFilter.value,
    teacher_id: teacherFilter.value
  });

  fetch(`<?= BASE_URL ?>backend/fetch_weekly_timetable.php?${params.toString()}`)
    .then(r => r.json())
    .then(rows => {
      rows.forEach(r => {
        const cell = document.querySelector(
          `.cell[data-day="${r.day_of_week}"][data-start="${r.start_time}"]`
        );

        if (cell) {
cell.innerHTML += `
  <a href="<?= BASE_URL ?>admin/add-timetable.php?id=${r.id}" class="entry-link">
    <div class="entry clickable">
      <div class="sub">${r.subject}</div>
      <div class="teacher">${r.teacher}</div>
      <div class="grade-sec">
        ${r.grade ? `<span>${r.grade}</span>` : ``}
        ${r.section ? `<span> - ${r.section}</span>` : ``}
      </div>
    </div>
  </a>
`;


        }
      });
    })
    .catch(err => {
      console.error('Timetable load error:', err);
    });
}



// ================= AUTO LOAD =================
sectionFilter.addEventListener('change', loadTimetable);
teacherFilter.addEventListener('change', loadTimetable);

// ================= RESET =================
document.getElementById('resetFilter').onclick = () => {
  classFilter.value = '';
  sectionFilter.innerHTML = '<option value="">Section</option>';
  teacherFilter.value = '';
  loadTimetable();
};

// Initial load (empty table)
window.addEventListener('DOMContentLoaded', loadTimetable);
function editTimetable(id){
  window.location.href = "<?= BASE_URL ?>admin/add-timetable.php?id=" + id;
}

</script>

<?php include 'partials/footer.php'; ?>
