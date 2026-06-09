<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$subject = [
    'id'=>0,
    'subject_name'=>'',
    'subject_code'=>'',
    'subject_type'=>'Normal',
    'basket_group'=>''
];

if ($id) {

    $stmt = $conn->prepare("
        SELECT *
        FROM subjects
        WHERE id = ?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();

    $subject = $stmt->get_result()->fetch_assoc();
}
?>

<style>
.subject-card{
    max-width:700px;
    margin:auto;

    background:#fff;

    padding:28px;

    border-radius:18px;

    box-shadow:0 8px 30px rgba(0,0,0,.08);
}

.subject-card h2{
    margin-top:0;
    margin-bottom:24px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:7px;
    font-weight:600;
}

.form-control{
    width:100%;
    padding:12px 14px;

    border:1px solid #dcdcdc;

    border-radius:12px;

    font-size:15px;
}

.btn-save{
    width:100%;

    background:linear-gradient(135deg,#2563eb,#1d4ed8);

    color:#fff;

    border:none;

    padding:14px;

    border-radius:14px;

    font-size:15px;
    font-weight:700;

    cursor:pointer;

    transition:.25s;
}

.btn-save:hover{
    transform:translateY(-2px);
}

#basketWrap{
    display:none;
}
</style>

<div class="subject-card">

<h2>
    <?= $id ? '✏️ Edit Subject' : '📚 Add Subject' ?>
</h2>

<form method="post"
      action="<?= BASE_URL ?>backend/subjects.php?action=<?= $id ? 'update' : 'create' ?>">

<?= csrf_field() ?>

<?php if($id): ?>

<input type="hidden"
       name="id"
       value="<?= $subject['id'] ?>">

<?php endif; ?>

<!-- SUBJECT NAME -->
<div class="form-group">

<label>Subject Name</label>

<input type="text"
       name="subject_name"
       class="form-control"
       required
       value="<?= esc($subject['subject_name']) ?>">

</div>

<!-- SUBJECT CODE -->
<?php

/* AUTO SUBJECT CODE */
$nextCode = '001';

if(!$id){

    $codeRes = $conn->query("
        SELECT subject_code
        FROM subjects
        ORDER BY id DESC
        LIMIT 1
    ");

    if($codeRes && $codeRes->num_rows){

        $lastCode = $codeRes->fetch_assoc()['subject_code'];

        $nextCode = str_pad(
            ((int)$lastCode + 1),
            3,
            '0',
            STR_PAD_LEFT
        );
    }

}else{

    $nextCode = $subject['subject_code'];
}
?>

<div class="form-group">

<label>Subject Code</label>

<input type="text"
       class="form-control"
       value="<?= esc($nextCode) ?>"
       readonly>

</div>

<!-- SUBJECT TYPE -->
<div class="form-group">

<label>Subject Type</label>

<select name="subject_type"
        id="subjectType"
        class="form-control"
        required>

<option value="Normal"
<?= $subject['subject_type']=='Normal'?'selected':'' ?>>
Normal Subject
</option>

<option value="First Language"
<?= $subject['subject_type']=='First Language'?'selected':'' ?>>
First Language
</option>

<option value="Second Language"
<?= $subject['subject_type']=='Second Language'?'selected':'' ?>>
Second Language
</option>

<option value="Group Subject"
<?= $subject['subject_type']=='Group Subject'?'selected':'' ?>>
Group Subject
</option>

</select>

</div>

<!-- BASKET -->
<div class="form-group" id="basketWrap">

<label>Basket Group</label>

<select name="basket_group"
        class="form-control">

<option value="">Select Basket</option>

<option value="G1"
<?= $subject['basket_group']=='G1'?'selected':'' ?>>
G1
</option>

<option value="G2"
<?= $subject['basket_group']=='G2'?'selected':'' ?>>
G2
</option>

<option value="G3"
<?= $subject['basket_group']=='G3'?'selected':'' ?>>
G3
</option>

</select>

</div>

<button type="submit" class="btn-save">

    <?= $id ? 'Update Subject' : 'Save Subject' ?>

</button>

</form>

</div>

<script>

const subjectType = document.getElementById('subjectType');
const basketWrap = document.getElementById('basketWrap');

function toggleBasket(){

    if(subjectType.value === 'Group Subject'){

        basketWrap.style.display = 'block';

    } else {

        basketWrap.style.display = 'none';
    }
}

subjectType.addEventListener('change', toggleBasket);

window.addEventListener('DOMContentLoaded', toggleBasket);

</script>

<?php include 'partials/footer.php'; ?>