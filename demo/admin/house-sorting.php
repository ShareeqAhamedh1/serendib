<?php
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';
requireLogin();

/* ===============================
   FETCH AVAILABLE PEOPLE
================================ */
$students = $conn->query("
  SELECT id, CONCAT(first_name,' ',last_name) AS name, class_id
  FROM students
  WHERE isSchool = 1
  AND id NOT IN (
    SELECT entity_id FROM house_members WHERE entity_type='student'
  )
  ORDER BY first_name
");

$teachers = $conn->query("
  SELECT id, CONCAT(first_name,' ',last_name) AS name
  FROM teachers
  WHERE id NOT IN (
    SELECT entity_id FROM house_members WHERE entity_type='teacher'
  )
  ORDER BY first_name
");

/* ===============================
   HOUSE COUNTS
================================ */
$counts = [];
$q = $conn->query("
  SELECT h.name,h.logo, COUNT(m.id) total
  FROM houses h
  LEFT JOIN house_members m ON m.house_id = h.id
  GROUP BY h.id
");
while($r=$q->fetch_assoc()){
  $counts[$r['name']] = $r['total'];
}
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

<!-- Confetti Library -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<style>

.house-logo{
width:150px;
height:150px;
object-fit:contain;
margin-bottom:6px;
}

.sorting-box{
background:#fff;
padding:20px;
border-radius:12px;
max-width:720px;
margin:20px auto;
}

select,button{
width:100%;
padding:12px;
margin:10px 0;
font-size:16px;
}

button{
background:#6f42c1;
color:#fff;
border:none;
font-size:18px;
cursor:pointer;
}

.house-counts{
display:flex;
justify-content:center;
gap:15px;
margin:20px 0;
}

.house{
padding:12px 18px;
border-radius:12px;
color:#fff;
font-size:18px;
text-align:center;
}

#wheelWrapper{
display:flex;
justify-content:center;
align-items:center;
flex-direction:column;
margin-top:30px;
}

.pointer{
font-size:32px;
margin-bottom:10px;
}

.wheel{
width:420px;
height:420px;
border-radius:50%;
position:relative;
background:conic-gradient(
#001640 0deg 120deg,
#156B43 120deg 240deg,
#9C231C 240deg 360deg
);
transition:transform 19s cubic-bezier(.15,.85,.25,1);
box-shadow:0 0 30px rgba(0,0,0,.4);
}

.label{
position:absolute;
width:60%;
text-align:center;
top:50%;
transform-origin:center;
font-size:22px;
font-weight:bold;
color:#fff;
}

.label.serendor{transform:rotate(60deg) translateY(-190px) translateX(20px)}
.label.luminara{transform:rotate(180deg) translateY(-100px) translateX(-90px);color:#000}
.label.nagathorn{transform:rotate(300deg) translateY(-50px) translateX(50px)}

/* Logo animation */
.logoReveal{
animation:pop 1s ease;
}

@keyframes pop{
0%{transform:scale(0) rotate(-180deg)}
70%{transform:scale(1.2)}
100%{transform:scale(1)}
}

</style>
</head>

<body>

<div class="container-fluid">

<h2 style="text-align:center">🏰 House Sorting Ceremony</h2>

<div class="sorting-box">

<select id="entityType">
<option value="">Select Type</option>
<option value="student">Student</option>
<option value="teacher">Teacher</option>
</select>

<select id="entitySelect">
<option value="">Select Person</option>
</select>

<button onclick="startSorting()">🎡 Start Sorting</button>

</div>

<div class="house-counts">

<?php
$housesQ = $conn->query("SELECT name,logo,color FROM houses");
while($h=$housesQ->fetch_assoc()):
?>

<div class="house" style="background:<?= esc($h['color']) ?>">
<img src="../uploads/houses/<?= esc($h['logo']) ?>" class="house-logo">
<div><?= esc($h['name']) ?></div>
<b><?= $counts[$h['name']] ?? 0 ?></b>
</div>

<?php endwhile; ?>

</div>

<div id="wheelWrapper">

<div class="pointer">▼</div>

<div class="wheel" id="wheel">

<span class="label serendor">Serendor</span>
<span class="label luminara">Luminara</span>
<span class="label nagathorn">Nagathorn</span>

</div>

</div>

</div>

<audio id="sortingSound" src="<?= BASE_URL ?>assets/sounds/sorting-hat5.mp3"></audio>

<script>

const students = <?= json_encode($students->fetch_all(MYSQLI_ASSOC)) ?>;
const teachers = <?= json_encode($teachers->fetch_all(MYSQLI_ASSOC)) ?>;

const entityType = document.getElementById('entityType');
const entitySelect = document.getElementById('entitySelect');
const wheel = document.getElementById('wheel');
const sound = document.getElementById('sortingSound');

const HOUSE_ANGLES = {
'Serendor':0,
'Luminara':120,
'Nagathorn':240
};

entityType.onchange=()=>{

entitySelect.innerHTML='<option value="">Select Person</option>';

const data = entityType.value==='student'?students:teachers;

data.forEach(p=>{
const o=document.createElement('option');
o.value=p.id;
o.textContent=p.name;
entitySelect.appendChild(o);
});

};

function startSorting(){

if(!entityType.value || !entitySelect.value){
alert('Please select a person');
return;
}

sound.currentTime = 0;
sound.play();

fetch('<?= BASE_URL ?>backend/assign-house.php',{
method:'POST',
headers:{'Content-Type':'application/json'},
body:JSON.stringify({
type:entityType.value,
id:entitySelect.value
})
})

.then(r=>r.json())

.then(res=>{

const baseAngle = HOUSE_ANGLES[res.house];
const spins = 10*360;
const finalAngle = spins + (360-baseAngle-60);

wheel.style.transform=`rotate(${finalAngle}deg)`;

setTimeout(()=>{

sound.pause();

confetti({
particleCount:200,
spread:120,
origin:{y:0.6}
});

Swal.fire({

title:res.house,

html:`

<img src="../uploads/houses/${res.logo}"
class="logoReveal"
style="width:140px;margin:15px auto;display:block">

<h3 style="text-align:center;margin-top:10px;">🏆 House Assigned!</h3>

`,

background:res.color,
color:'#fff',
confirmButtonText:'Continue'

})

.then(()=>location.reload());

},19000);

});

}

</script>

<?php include 'partials/footer.php'; ?>