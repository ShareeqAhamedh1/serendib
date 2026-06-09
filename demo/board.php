<?php
require_once __DIR__ . '/backend/conn.php';

/* ===============================
   STEP 1: GET CLASS / SECTION
================================ */
$class_id   = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
$section_id = isset($_GET['section_id']) ? (int)$_GET['section_id'] : 0;

/* ===============================
   FETCH CLASSES (IF NOT SELECTED)
================================ */
if (!$class_id) {
    $classes = $conn->query("
        SELECT id, class_name
        FROM classes
        ORDER BY class_name
    ");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Smart Board</title>

<style>
*{box-sizing:border-box}
body{
  margin:0;
  background:#0e0e0e;
  color:#fff;
  font-family:'Segoe UI',Arial,sans-serif;
}

/* ================= SELECT SCREEN ================= */
.selector{
  display:flex;
  justify-content:center;
  align-items:center;
  height:100vh;
}
.selector-box{
  background:#1f1f1f;
  padding:30px;
  border-radius:18px;
  width:340px;
  box-shadow:0 10px 30px rgba(0,0,0,.5);
}
.selector-box h2{
  text-align:center;
  margin-bottom:20px;
}
.selector-box select,
.selector-box button{
  width:100%;
  padding:14px;
  margin-top:12px;
  font-size:16px;
  border-radius:10px;
  border:none;
}
.selector-box button{
  background:#0d6efd;
  color:#fff;
  cursor:pointer;
}

/* ================= HEADER ================= */
.header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:18px 25px;
  background:#005c2e;
}
.header-title{
  font-size:26px;
  font-weight:600;
}
.clock{
  font-size:22px;
  font-weight:600;
}

/* ================= CONTENT ================= */
.container{
  padding:25px;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:20px;
}
.card{
  background:#1f1f1f;
  padding:25px;
  border-radius:18px;
  min-height:170px;
  box-shadow:0 6px 18px rgba(0,0,0,.4);
}
.card h2{
  margin:10px 0 5px;
  font-size:30px;
}
.card .teacher{
  font-size:18px;
  color:#bbb;
}
.label{
  font-size:18px;
  color:#ccc;
}

/* ================= STATUS COLORS ================= */
.interval{
  background:#3b2f0b;
}
.ended{
  background:#5a1a1a;
}
.not-started{
  background:#1a2a4f;
}

/* ================= ANNOUNCEMENTS ================= */
.messages{
  grid-column:1 / -1;
}
.announcement{
  background:#222;
  padding:18px;
  border-radius:14px;
  margin-bottom:12px;
  font-size:20px;
}
.announcement.urgent{
  background:#8b0000;
  animation:pulse 1.5s infinite;
}

@keyframes pulse{
  0%{opacity:1}
  50%{opacity:.7}
  100%{opacity:1}
}

.big-announcement{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.9);
  display:flex;
  align-items:center;
  justify-content:center;
  z-index:99999;
}
.big-box{
  background:#8b0000;
  padding:40px;
  border-radius:25px;
  font-size:42px;
  text-align:center;
  animation:zoom 0.4s ease;
}
@keyframes zoom{
  from{transform:scale(.7)}
  to{transform:scale(1)}
}

</style>
</head>

<body>

<?php if (!$class_id): ?>
<!-- ================= CLASS SELECT ================= -->
<div class="selector">
  <div class="selector-box">
    <h2>📺 Select Class</h2>

    <select id="classSelect">
      <option value="">-- Select Class --</option>
      <?php while($c = $classes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>">
          <?= htmlspecialchars($c['class_name']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <select id="sectionSelect" style="display:none">
      <option value="">-- Select Section --</option>
    </select>

    <button onclick="startBoard()">Start Board</button>
  </div>
</div>

<script>
const classSelect = document.getElementById('classSelect');
const sectionSelect = document.getElementById('sectionSelect');

classSelect.onchange = () => {
  sectionSelect.style.display='none';
  sectionSelect.innerHTML='<option value="">-- Select Section --</option>';

  if(!classSelect.value) return;

  fetch('backend/fetch_sections.php?class_id='+classSelect.value)
    .then(r=>r.json())
    .then(d=>{
      if(d.length){
        sectionSelect.style.display='block';
        d.forEach(s=>{
          const o=document.createElement('option');
          o.value=s.id;
          o.textContent=s.section_name;
          sectionSelect.appendChild(o);
        });
      }
    });
};

function startBoard(){
  if(!classSelect.value){
    alert('Please select a class');
    return;
  }
  let url=`board.php?class_id=${classSelect.value}`;
  if(sectionSelect.value){
    url+=`&section_id=${sectionSelect.value}`;
  }
  location.href=url;
}
</script>

<?php else: ?>
<!-- ================= SMART BOARD ================= -->

<div class="header">
  <div class="header-title">📘 Classroom Smart Board</div>
  <div id="clock" class="clock">--:--:--</div>
</div>

<div class="container">
  <div id="current" class="card">Loading...</div>
  <div id="next" class="card">Loading...</div>
  <div id="messages" class="messages"></div>
</div>
<div id="announcementPopup" style="display:none"></div>
<audio id="audio"></audio>

<script>
const CLASS_ID = <?= $class_id ?>;
const SECTION_ID = <?= $section_id ?>;

const currentDiv = document.getElementById('current');
const nextDiv = document.getElementById('next');
const messagesDiv = document.getElementById('messages');
const audio = document.getElementById('audio');
const clock = document.getElementById('clock');

/* ================= CLOCK ================= */
function updateClock(){
  const d=new Date();
  clock.textContent=d.toLocaleTimeString();
}
setInterval(updateClock,1000);
updateClock();

/* ================= BOARD REFRESH ================= */
function refreshBoard(){
  fetch(`backend/board-data.php?class_id=${CLASS_ID}&section_id=${SECTION_ID}`)
    .then(r=>r.json())
    .then(d=>{
      currentDiv.className='card';
      nextDiv.className='card';

      if(d.status==='interval') currentDiv.classList.add('interval');
      if(d.status==='ended') currentDiv.classList.add('ended');
      if(d.status==='not_started') currentDiv.classList.add('not-started');

      currentDiv.innerHTML=`
        <div class="label">🕘 Current</div>
        <h2>${d.current.subject}</h2>
        <div class="teacher">${d.current.teacher}</div>
      `;

      nextDiv.innerHTML=`
        <div class="label">➡ Next</div>
        <h2>${d.next.subject}</h2>
        <div class="teacher">${d.next.teacher}</div>
      `;

      messagesDiv.innerHTML='';
      d.messages.forEach(m=>{
        messagesDiv.innerHTML+=`
          <div class="announcement ${m.priority==='urgent'?'urgent':''}">
            📢 ${m.message}
          </div>
        `;
      });

if(d.sound){
  audio.pause();
  audio.currentTime = 0;
  audio.src='uploads/sounds/'+d.sound + '?t=' + Date.now();
  safePlay();
}

    });
}
function safePlay(){
  // Always reset before playing
  audio.pause();
  audio.currentTime = 0;

  return audio.play().catch(err=>{
    console.warn('Audio blocked:', err.message);
  });
}


setInterval(refreshBoard,10000);
refreshBoard();
</script>

<?php endif; ?>
<script>
  let lastAnnouncementId = 0;

/* ================= BELL CHECK ================= */
function checkSchoolEvents(){
  fetch('backend/school-events.php')
    .then(r=>r.json())
    .then(d=>{
      if(d.ring){
        playBell(d.sound, d.times);
      }
    });
}

function playBell(sound, times){
  let count = 0;

  audio.pause();
  audio.currentTime = 0;
  audio.src = 'uploads/announcements/' + sound + '?t=' + Date.now();
  flashScreen();

  audio.onended = () => {
    count++;
    if(count < times){
      audio.currentTime = 0;
      safePlay();
    }
  };

  safePlay();
}



/* ================= ANNOUNCEMENTS ================= */
function checkAnnouncement(){
  fetch('backend/active-announcement.php')
    .then(r=>r.json())
    .then(a=>{
      if(!a.id || a.id === lastAnnouncementId) return;

      lastAnnouncementId = a.id;

      // Play announcement sound
if(a.sound_file){
  audio.src = 'uploads/announcements/' + a.sound_file;
  flashScreen();
  safePlay();
}


      // Show popup
      const box = document.getElementById('announcementPopup');
      box.innerHTML = `
        <div class="big-announcement">
          <div class="big-box">
            <h1>${a.title}</h1>
            <p>${a.message}</p>
          </div>
        </div>
      `;
      box.style.display='block';

      setTimeout(()=>box.style.display='none', 15000);
    });
}

/* ================= INTERVALS ================= */
setInterval(checkSchoolEvents, 10000);
setInterval(checkAnnouncement, 5000);

</script>
<script>
let audioUnlocked = false;

function unlockAudio(){
  if(audioUnlocked) return;
  audioUnlocked = true;

  audio.muted = true;
  safePlay().then(()=>{
    audio.pause();
    audio.muted = false;
    console.log('🔓 Audio unlocked');
  }).catch(()=>{});
}

document.addEventListener('click', unlockAudio, { once:true });
document.addEventListener('touchstart', unlockAudio, { once:true });

function flashScreen(){
  document.body.style.background='#222';
  setTimeout(()=>document.body.style.background='#0e0e0e',200);
}

</script>

</body>
</html>
