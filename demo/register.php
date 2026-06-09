<?php
// serendib_highschool/Register.php
require_once __DIR__ . '/backend/conn.php';
require_once __DIR__ . '/backend/helpers.php';

$ok = $_GET['ok'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Student Registration | Serendib Highschool</title>
<link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/favicon.png">
<meta name="viewport" content="width=device-width,initial-scale=1">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root{
  --bg:#eef1f7;
  --card:#ffffff;
  --primary:#0069d9;
  --primary-700:#0052ad;
  --muted:#6b7280;
  --input-border:#d6dbe7;
  --radius:12px;
  --gap:16px;
  --max-width:920px;
}

*{box-sizing:border-box}
body{
  font-family:"Segoe UI",Arial,sans-serif;
  background:linear-gradient(180deg,#eef1f7 0%, #f7fbff 100%);
  padding:20px;
  margin:0;
  color:#1f2937;
}

.wrap{
  max-width:var(--max-width);
  margin:24px auto;
  padding:20px;
}

.home-btn{
  display:inline-block;
  margin-bottom:18px;
  padding:10px 16px;
  border-radius:10px;
  background:#fff;
  border:1px solid #d0d7e4;
  font-weight:600;
  color:#0f172a;
  text-decoration:none;
  box-shadow:0 4px 10px rgba(0,0,0,0.06);
  transition:0.2s;
}
.home-btn:hover{background:#f0f4fa;}

.card{
  background:var(--card);
  padding:26px;
  border-radius:var(--radius);
  box-shadow:0 6px 26px rgba(16,24,40,0.06);
}

.header-row{
  display:flex;
  align-items:center;
  gap:16px;
  margin-bottom:18px;
}

h2{margin:0;font-size:20px;}
p.lead{margin:0;color:var(--muted);font-size:14px;}

form{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:var(--gap);
  margin-top:18px;
}

label{
  font-weight:600;
  font-size:13px;
  margin-bottom:6px;
  display:block;
}

input,select,textarea{
  width:100%;
  padding:11px 12px;
  border:1px solid var(--input-border);
  border-radius:10px;
  font-size:14px;
}

input:focus,select:focus,textarea:focus{
  outline:none;
  border-color:var(--primary);
  box-shadow:0 4px 14px rgba(3,102,214,0.08);
}

.full{grid-column:1/-1;}

.actions{
  grid-column:1/-1;
  display:flex;
  justify-content:space-between;
  margin-top:6px;
}

.btn{
  background:var(--primary);
  color:#fff;
  border:none;
  padding:12px 18px;
  border-radius:10px;
  font-weight:700;
  cursor:pointer;
}
.btn:hover{background:var(--primary-700);}

@media (max-width:880px){
  form{grid-template-columns:1fr;}
}
</style>
</head>

<body>
<div class="wrap">

<a href="<?= BASE_URL ?>" class="home-btn">← Back to Home</a>

<div class="card">
<div class="header-row">
  <img src="<?= BASE_URL ?>assets/img/favicon.png" style="width:70px;">
  <div>
    <h2>New Student Registration</h2>
    <p class="lead">Fill in the details below to register a new student.</p>
  </div>
</div>

<form method="post" action="<?= BASE_URL ?>backend/handle_registration.php" autocomplete="off">
<?= function_exists('csrf_field') ? csrf_field() : '' ?>

<div>
<label>Full Name *</label>
<input type="text" name="full_name" required>
</div>

<div>
<label>Date of Birth *</label>
<input type="date" name="dob" required>
</div>

<div>
<label>Gender *</label>
<select name="gender" required>
<option value="" disabled selected>Select</option>
<option value="male">Male</option>
<option value="female">Female</option>
</select>
</div>

<div>
<label>Joining Grade / Stream *</label>
<select name="joining_grade" required>
<option value="">-- Select Grade / Stream --</option>

<optgroup label="Ordinary Level Grades">
<option value="6">Grade 6</option>
<option value="7">Grade 7</option>
<option value="8">Grade 8</option>
<option value="9">Grade 9</option>
<option value="10">Grade 10</option>
<option value="11">Grade 11</option>
</optgroup>

<optgroup label="A/L 2028 Streams">
<option value="2028_physical_science">2028 Physical Science</option>
<option value="2028_biological_science">2028 Biological Science</option>
<option value="2028_commerce">2028 Commerce</option>
<option value="2028_arts">2028 Arts</option>
</optgroup>

</select>
</div>

<div>
<label>Medium *</label>
<select name="medium" required>
<option value="" disabled selected>-- Select Medium --</option>
<option value="English">English</option>
<option value="Sinhala">Sinhala</option>
<option value="Tamil">Tamil</option>
</select>
</div>

<hr class="full" style="border:none;border-top:1px solid #eef1f5;margin:8px 0 14px;">

<div class="full">
<label>Parent / Guardian Name *</label>
<input type="text" name="parent_name" required>
</div>

<div>
<label>Parent Email</label>
<input type="email" name="parent_email">
</div>

<div>
<label>Parent Phone *</label>
<input type="tel" name="parent_phone" required>
</div>

<div class="full">
<label>Previous School</label>
<input type="text" name="previous_school">
</div>

<div class="full">
<label>Address *</label>
<textarea name="address" required></textarea>
</div>

<div class="full">
<label>Remarks</label>
<textarea name="remarks"></textarea>
</div>

<div class="actions">
<div style="color:#6b7280;font-size:13px;">All required fields are marked *</div>
<button type="submit" class="btn">Submit Registration</button>
</div>

</form>
</div>
</div>

<?php if(isset($_GET['ok'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
Swal.fire({
title: <?= ($ok=='1' ? '"Registration Successful!"' : '"Registration Failed!"') ?>,
text: <?= ($ok=='1' ? '"The student has been registered successfully."' : '"Please check the details and try again."') ?>,
icon: <?= ($ok=='1' ? '"success"' : '"error"') ?>,
confirmButtonColor:"#3085d6"
});
window.history.replaceState({}, document.title, window.location.pathname);
});
</script>
<?php endif; ?>

</body>
</html>