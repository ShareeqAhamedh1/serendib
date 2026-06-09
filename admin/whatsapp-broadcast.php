<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");

/* Load students */
$students = $conn->query("
  SELECT s.id, s.first_name, s.last_name, c.class_name
  FROM students s
  LEFT JOIN classes c ON s.class_id = c.id
  ORDER BY s.first_name
");
?>

<h2>📢 WhatsApp Broadcast</h2>
<p>Send WhatsApp messages to parents using approved templates.</p>

<div style="background:#fff;padding:20px;border-radius:10px;max-width:800px">

<form method="post" action="<?= BASE_URL ?>backend/send_whatsapp_broadcast.php">

<?= csrf_field() ?>

<!-- TARGET -->
<label><b>Send To</b></label>
<select name="target" id="target" required style="width:100%;padding:8px">
  <option value="">-- Select --</option>
  <option value="all">All Parents</option>
  <option value="class">By Class</option>
  <option value="student">Selected Student</option>
</select>

<br><br>

<!-- CLASS -->
<div id="classBox" style="display:none">
  <label><b>Class</b></label>
  <select name="class_id" style="width:100%;padding:8px">
    <option value="">-- Select Class --</option>
    <?php while($c=$classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>
</div>

<!-- STUDENT -->
<div id="studentBox" style="display:none">
  <label><b>Student (type to search)</b></label>
  <select name="student_id"
          id="studentSelect"
          size="6"
          style="width:100%;padding:8px">
    <option value="">-- Select Student --</option>
    <?php while($s=$students->fetch_assoc()): ?>
      <option value="<?= $s['id'] ?>">
        <?= esc($s['first_name'].' '.$s['last_name']) ?>
        (<?= esc($s['class_name']) ?>)
      </option>
    <?php endwhile; ?>
  </select>
</div>

<br>

<!-- TEMPLATE -->
<label><b>Message Type</b></label>
<select name="template" id="template" required style="width:100%;padding:8px">
  <option value="">-- Select Template --</option>
  <option value="school_announcement">📢 School Announcement</option>
  <option value="parents_meeting_notice">🧑‍🏫 Parents Meeting</option>
  <option value="student_specific_notice">🎓 Student Specific Message</option>
</select>

<br><br>

<!-- ANNOUNCEMENT -->
<div id="announcementBox" style="display:none">
  <label><b>Announcement Message</b></label>
  <textarea name="announcement"
            rows="4"
            placeholder="Type announcement text here..."
            style="width:100%;padding:10px"></textarea>
</div>

<!-- PARENTS MEETING -->
<div id="meetingBox" style="display:none">

  <label><b>School Name</b></label>
  <input type="text" name="school_name"
         value="Serendib High School"
         style="width:100%;padding:8px">

  <br><br>

  <label><b>Meeting Date</b></label>
  <input type="date" name="meeting_date" style="width:100%;padding:8px">

  <br><br>

  <label><b>Meeting Time</b></label>
  <input type="text" name="meeting_time"
         placeholder="09:00 AM"
         style="width:100%;padding:8px">

  <br><br>

  <label><b>Venue</b></label>
  <input type="text" name="venue"
         placeholder="School Main Hall"
         style="width:100%;padding:8px">
</div>

<!-- STUDENT MESSAGE -->
<div id="studentMsgBox" style="display:none">
  <label><b>Message for Student</b></label>
  <textarea name="student_message"
            rows="4"
            placeholder="Type message regarding the selected student..."
            style="width:100%;padding:10px"></textarea>
</div>

<p style="color:#777;font-size:13px;margin-top:10px">
⚠ Only approved WhatsApp templates will be sent.
</p>

<button style="padding:10px 20px;background:#007bff;color:white;border:0;border-radius:6px">
📨 Send WhatsApp Message
</button>

</form>

</div>

<script>
const target     = document.getElementById('target');
const template   = document.getElementById('template');

const classBox   = document.getElementById('classBox');
const studentBox = document.getElementById('studentBox');

const annBox     = document.getElementById('announcementBox');
const meetBox    = document.getElementById('meetingBox');
const studMsgBox = document.getElementById('studentMsgBox');

const studentSelect = document.getElementById('studentSelect');

/* -------------------------------
   Type-to-search inside dropdown
-------------------------------- */
if (studentSelect) {
  let typed = '';
  let lastTime = 0;

  studentSelect.addEventListener('keydown', e => {
    const now = Date.now();

    if (now - lastTime > 600) typed = '';
    lastTime = now;

    if (e.key.length === 1) {
      typed += e.key.toLowerCase();

      for (let i = 0; i < studentSelect.options.length; i++) {
        const opt = studentSelect.options[i];
        if (opt.text.toLowerCase().includes(typed)) {
          studentSelect.selectedIndex = i;
          break;
        }
      }
    }
  });
}

/* -------------------------------
   Template restrictions
-------------------------------- */
function updateTemplateOptions() {
  const isStudent = target.value === 'student';

  [...template.options].forEach(opt => {
    if (opt.value === 'student_specific_notice') {
      opt.hidden = !isStudent;
    }
  });

  if (!isStudent && template.value === 'student_specific_notice') {
    template.value = '';
  }
}

/* -------------------------------
   Target toggle
-------------------------------- */
target.addEventListener('change', () => {

  classBox.style.display   = target.value === 'class' ? 'block' : 'none';
  studentBox.style.display = target.value === 'student' ? 'block' : 'none';

  updateTemplateOptions();

  annBox.style.display = 'none';
  meetBox.style.display = 'none';
  studMsgBox.style.display = 'none';
});

/* -------------------------------
   Template toggle
-------------------------------- */
template.addEventListener('change', () => {
  annBox.style.display      = template.value === 'school_announcement' ? 'block' : 'none';
  meetBox.style.display    = template.value === 'parents_meeting_notice' ? 'block' : 'none';
  studMsgBox.style.display = template.value === 'student_specific_notice' ? 'block' : 'none';
});

/* Init */
updateTemplateOptions();
</script>

<?php include 'partials/footer.php'; ?>
