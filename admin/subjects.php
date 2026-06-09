<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$res = $conn->query("
    SELECT *
    FROM subjects
    ORDER BY subject_code
");
?>

<style>
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.page-title{
    margin:0;
    font-size:28px;
    font-weight:700;
    color:#1e293b;
}

.btn-add{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    text-decoration:none;
    padding:12px 18px;
    border-radius:12px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:.25s;
}

.btn-add:hover{
    transform:translateY(-2px);
    color:#fff;
}

.subject-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 8px 30px rgba(0,0,0,.06);
}

.table-responsive{
    overflow-x:auto;
}

.subject-table{
    width:100%;
    border-collapse:collapse;
    min-width:850px;
}

.subject-table thead{
    background:#0f172a;
    color:#fff;
}

.subject-table th{
    padding:16px;
    font-size:14px;
    text-align:left;
}

.subject-table td{
    padding:16px;
    border-bottom:1px solid #edf2f7;
    vertical-align:middle;
    font-size:14px;
}

.subject-table tbody tr:hover{
    background:#f8fafc;
}

.badge{
    display:inline-block;
    padding:6px 10px;
    border-radius:30px;
    font-size:12px;
    font-weight:700;
}

.badge.normal{
    background:#e2e8f0;
    color:#334155;
}

.badge.first{
    background:#dbeafe;
    color:#1d4ed8;
}

.badge.second{
    background:#fef3c7;
    color:#b45309;
}

.badge.group{
    background:#dcfce7;
    color:#166534;
}

.basket-chip{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:45px;
    padding:6px 10px;
    border-radius:30px;
    background:#ede9fe;
    color:#6d28d9;
    font-size:12px;
    font-weight:700;
}

.action-buttons{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.btn-action{
    text-decoration:none;
    padding:8px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:6px;
    transition:.2s;
}

.btn-edit{
    background:#dbeafe;
    color:#1d4ed8;
}

.btn-delete{
    background:#fee2e2;
    color:#dc2626;
}

.btn-action:hover{
    transform:translateY(-1px);
}

.empty-box{
    padding:40px;
    text-align:center;
    color:#777;
}

/* MOBILE */
@media(max-width:768px){

    .page-title{
        font-size:22px;
    }

    .btn-add{
        width:100%;
        justify-content:center;
    }

    .subject-table{
        min-width:700px;
    }

    .subject-table th,
    .subject-table td{
        padding:12px;
        font-size:13px;
    }

    .action-buttons{
        flex-direction:column;
    }

    .btn-action{
        justify-content:center;
    }
}
</style>
<?php if(isset($_GET['inuse'])): ?>

<div class="alert-error">

<?php
$type = $_GET['inuse'];

if($type === 'timetable'){
    echo "Subject cannot be deleted because it is used in timetable.";
}
elseif($type === 'homeworks'){
    echo "Subject cannot be deleted because homework exists.";
}
elseif($type === 'notes'){
    echo "Subject cannot be deleted because notes exist.";
}
elseif($type === 'examsubjects'){
    echo "Subject cannot be deleted because exam subjects exist.";
}
elseif($type === 'exammarks'){
    echo "Subject cannot be deleted because exam marks exist.";
}
?>

</div>

<?php endif; ?>
<div class="page-header">

    <h2 class="page-title">📚 Subjects</h2>

    <a href="<?= BASE_URL ?>admin/add-subject.php" class="btn-add">
        <i class="fa-solid fa-plus"></i>
        Add Subject
    </a>

</div>

<?php if(isset($_GET['created'])): ?>

<script>
Swal.fire({
    icon:'success',
    title:'Subject Created',
    timer:1500,
    showConfirmButton:false
});

window.history.replaceState({}, document.title, window.location.pathname);
</script>

<?php endif; ?>

<div class="subject-card">

<div class="table-responsive">

<table class="subject-table">

<thead>
<tr>
    <th>#</th>
    <th>Subject</th>
    <th>Code</th>
    <th>Type</th>
    <th>Basket</th>
    <th width="180">Actions</th>
</tr>
</thead>

<tbody>

<?php if($res->num_rows == 0): ?>

<tr>
    <td colspan="6">

        <div class="empty-box">
            No subjects added yet
        </div>

    </td>
</tr>

<?php endif; ?>

<?php
$count = 1;

while($r = $res->fetch_assoc()):
?>

<tr>

    <td><?= $count++ ?></td>

    <td>
        <strong><?= esc($r['subject_name']) ?></strong>
    </td>

    <td>
        <?= esc($r['subject_code']) ?: '-' ?>
    </td>

    <td>

        <?php
        $type = $r['subject_type'] ?? 'Normal';

        $class = 'normal';

        if($type == 'First Language'){
            $class = 'first';
        }
        elseif($type == 'Second Language'){
            $class = 'second';
        }
        elseif($type == 'Group Subject'){
            $class = 'group';
        }
        ?>

        <span class="badge <?= $class ?>">
            <?= esc($type) ?>
        </span>

    </td>

    <td>

        <?php if(!empty($r['basket_group'])): ?>

            <span class="basket-chip">
                <?= esc($r['basket_group']) ?>
            </span>

        <?php else: ?>

            -

        <?php endif; ?>

    </td>

    <td>

        <div class="action-buttons">

            <a href="<?= BASE_URL ?>admin/add-subject.php?id=<?= $r['id'] ?>"
               class="btn-action btn-edit">

                <i class="fa-solid fa-pen"></i>
                Edit

            </a>

            <a href="<?= BASE_URL ?>backend/subjects.php?action=delete&id=<?= $r['id'] ?>"
               class="btn-action btn-delete"
               onclick="return confirm('Delete this subject?')">

                <i class="fa-solid fa-trash"></i>
                Delete

            </a>

        </div>

    </td>

</tr>

<?php endwhile; ?>

</tbody>
</table>

</div>
</div>

<?php include 'partials/footer.php'; ?>