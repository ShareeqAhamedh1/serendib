<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$students = mysqli_query($conn,"
SELECT
    s.id,
    s.first_name,
    s.last_name,
    h.name AS house_name
FROM students s
LEFT JOIN house_members hm
    ON hm.entity_type='student'
   AND hm.entity_id=s.id
LEFT JOIN houses h
    ON h.id=hm.house_id
ORDER BY s.first_name,s.last_name
");
?>

<style>
.sow-card{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
    margin-bottom:25px;
}

.sow-title{
    margin:0 0 20px;
    color:#003366;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.form-group{
    margin-bottom:15px;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.btn-save{
    background:#198754;
    color:#fff;
    border:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:600;
}

.badge-active{
    background:#d1fae5;
    color:#065f46;
    padding:5px 10px;
    border-radius:20px;
}

.badge-old{
    background:#eee;
    color:#666;
    padding:5px 10px;
    border-radius:20px;
}

@media(max-width:768px){
    .form-grid{
        grid-template-columns:1fr;
    }

    .table{
        display:block;
        overflow-x:auto;
    }
}
.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    background:#0d6efd;
    color:#fff;
    padding:12px;
}

.table td{
    padding:12px;
    border-bottom:1px solid #eee;
    vertical-align:middle;
}

.table tr:hover{
    background:#f9f9f9;
}

.winner-photo{
    width:55px;
    height:55px;
    object-fit:cover;
    border-radius:50%;
    border:3px solid #ddd;
}

.btn-action{
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    color:#fff;
    font-size:13px;
    margin-right:5px;
}

.btn-active{
    background:#198754;
}

.btn-delete{
    background:#dc3545;
}
</style>

<div class="sow-card">

<h2 class="sow-title">
🏆 Student of the Week
</h2>

<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success">
    Winner saved successfully.
</div>
<?php endif; ?>

<?php if(isset($_GET['activated'])): ?>
<div class="alert alert-success">
    Winner activated successfully.
</div>
<?php endif; ?>

<?php if(isset($_GET['deleted'])): ?>
<div class="alert alert-danger">
    Winner deleted successfully.
</div>
<?php endif; ?>

<form
action="<?= BASE_URL ?>backend/save-student-of-the-week.php"
method="POST"
enctype="multipart/form-data">

<div class="form-grid">

<div class="form-group">
<label>Student</label>

<select
name="student_id"
class="form-control"
required>

<option value="">
Select Student
</option>

<?php while($s=mysqli_fetch_assoc($students)): ?>

<option value="<?= $s['id'] ?>">

<?= htmlspecialchars(
$s['first_name'].' '.$s['last_name']
) ?>

<?= $s['house_name']
? ' - '.$s['house_name']
: '' ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="form-group">
<label>Points Awarded</label>

<input
type="number"
name="points_awarded"
value="50"
min="1"
required
class="form-control">

</div>

</div>

<div class="form-group">

<label>Title</label>

<input
type="text"
name="title"
value="Student of the Week"
required
class="form-control">

</div>

<div class="form-group">

<label>Description</label>

<textarea
name="description"
rows="5"
required
class="form-control"></textarea>

</div>

<div class="form-grid">

<div class="form-group">

<label>Week Date</label>

<input
type="date"
name="week_date"
value="<?= date('Y-m-d') ?>"
required
class="form-control">

</div>

<div class="form-group">

<label>Winner Image</label>

<input
type="file"
name="image"
accept="image/*"
class="form-control">

</div>

</div>

<button
type="submit"
class="btn-save">
🏆 Save Winner
</button>

</form>

</div>

<div class="sow-card">

<h3>Previous Winners</h3>

<table class="table">

<thead>

<tr>
<th>Photo</th>
<th>Student</th>
<th>Title</th>
<th>Points</th>
<th>Week</th>
<th>Status</th>
<th>Actions</th>
</tr>

</thead>

<tbody>

<?php

$winners = mysqli_query($conn,"
SELECT
sw.*,
s.first_name,
s.last_name
FROM student_of_the_week sw
INNER JOIN students s
ON s.id=sw.student_id
ORDER BY sw.week_date DESC
");

while($row=mysqli_fetch_assoc($winners)):
?>

<tr>

<td>

<?php if(!empty($row['image'])): ?>

<img
    src="<?= BASE_URL ?>uploads/student-of-the-week/<?= $row['image'] ?>"
    class="winner-photo">

<?php else: ?>

-

<?php endif; ?>

</td>

<td>
<?= htmlspecialchars(
$row['first_name'].' '.$row['last_name']
) ?>
</td>

<td>
<?= htmlspecialchars($row['title']) ?>
</td>

<td>
⭐ <?= (int)$row['points_awarded'] ?>
</td>

<td>
<?= date('d M Y',
strtotime($row['week_date'])) ?>
</td>

<td>

<?php if($row['is_active']): ?>

<span class="badge-active">
Active
</span>

<?php else: ?>

<span class="badge-old">
Previous
</span>

<?php endif; ?>

</td>

<td>

<?php if(!$row['is_active']): ?>

<a
class="btn-action btn-active"
href="<?= BASE_URL ?>backend/set-student-week-active.php?id=<?= $row['id'] ?>">
✅ Make Active
</a>

<?php endif; ?>

<a
class="btn-action btn-delete"
onclick="return confirm('Delete this winner?')"
href="<?= BASE_URL ?>backend/delete-student-of-the-week.php?id=<?= $row['id'] ?>">
🗑 Delete
</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include 'partials/footer.php'; ?>