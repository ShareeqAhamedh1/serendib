<?php
session_start();
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

/* =============================
   ROLE & USER CREATION
============================= */
function ensure_parent_role_id() {
    global $conn;
    $q = $conn->query("SELECT id FROM roles WHERE name='parent' LIMIT 1");
    if ($q && $q->num_rows > 0) return (int)$q->fetch_assoc()['id'];
    $conn->query("INSERT INTO roles (name, description) VALUES ('parent','Parent role')");
    return (int)$conn->insert_id;
}

function create_parent_user($full_name, $email) {
    global $conn;
    $role_id = ensure_parent_role_id();
    $hash = password_hash("parent123", PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO users (role_id, username, password, full_name, email, status, created_at)
        VALUES (?, ?, ?, ?, ?, 'active', NOW())
    ");
    $stmt->bind_param("issss", $role_id, $email, $hash, $full_name, $email);
    $stmt->execute();
    return (int)$stmt->insert_id;
}

/* =============================
   AJAX HANDLER
============================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    header('Content-Type: application/json');

    /* -------- DELETE -------- */
    if ($_POST['action'] === 'delete') {
        $pid = (int)$_POST['id'];

        $res = $conn->query("SELECT user_id FROM parents WHERE id=$pid");
        if ($row = $res->fetch_assoc()) {
            $conn->query("DELETE FROM users WHERE id=".(int)$row['user_id']);
        }
        $conn->query("DELETE FROM parents WHERE id=$pid");

        echo json_encode(['status'=>'success','msg'=>'Parent deleted successfully']);
        exit;
    }

    /* -------- UPDATE -------- */
    if ($_POST['action'] === 'update') {

        $pid   = (int)$_POST['parent_id'];
        $name  = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $occ   = trim($_POST['occupation']);
        $addr  = trim($_POST['address']);

        $uid = $conn->query("SELECT user_id FROM parents WHERE id=$pid")
                    ->fetch_assoc()['user_id'];

        $stmt = $conn->prepare("
            UPDATE parents SET full_name=?, email=?, phone=?, occupation=?, address=? WHERE id=?
        ");
        $stmt->bind_param("sssssi", $name, $email, $phone, $occ, $addr, $pid);
        $stmt->execute();

        $stmt = $conn->prepare("
            UPDATE users SET full_name=?, email=?, username=?, phone=? WHERE id=?
        ");
        $stmt->bind_param("ssssi", $name, $email, $email, $phone, $uid);
        $stmt->execute();

        echo json_encode(['status'=>'success','msg'=>'Parent updated successfully']);
        exit;
    }

    /* -------- ADD -------- */
    if ($_POST['action'] === 'add') {

        $name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $occ = trim($_POST['occupation']);
        $addr = trim($_POST['address']);

        $chk = $conn->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
        $chk->bind_param("s", $email);
        $chk->execute();

        if ($chk->get_result()->num_rows > 0) {
            echo json_encode(['status'=>'error','msg'=>'Email already exists']);
            exit;
        }

        $uid = create_parent_user($name, $email);
        $stmt = $conn->prepare("
            INSERT INTO parents (full_name,email,phone,occupation,address,user_id)
            VALUES (?,?,?,?,?,?)
        ");
        $stmt->bind_param("sssssi", $name, $email, $phone, $occ, $addr, $uid);
        $stmt->execute();

        echo json_encode(['status'=>'success','msg'=>'Parent added (password: parent123)']);
        exit;
    }
}

/* =============================
   FETCH PARENTS
============================= */
$parents = $conn->query("SELECT * FROM parents ORDER BY full_name");

include 'partials/header.php';
?>

<style>
.alert{padding:10px;border-radius:6px;margin-bottom:10px;display:none}
.alert.success{background:#d4edda}
.alert.error{background:#f8d7da}

.table{width:100%;background:#fff;border-collapse:collapse}
.table th{background:#004080;color:#fff;padding:10px}
.table td{padding:10px;border-bottom:1px solid #eee}

.btn{padding:6px 10px;border-radius:6px;cursor:pointer;border:none}
.btn.edit{background:#17a2b8;color:white}
.btn.del{background:#dc3545;color:white}

.modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,.5);align-items:center;justify-content:center}
.modal-content{background:white;padding:20px;border-radius:10px;width:95%;max-width:500px}
.modal-content input,.modal-content textarea{width:100%;margin-bottom:8px}
</style>

<h2>👨‍👩‍👧 Manage Parents</h2>

<div id="alertBox" class="alert"></div>

<!-- ADD -->
<div class="modal-content" style="margin-bottom:20px">
<h3>Add Parent</h3>
<form id="addForm">
<input name="full_name" placeholder="Full Name" required>
<input name="email" placeholder="Email" required>
<input name="phone" placeholder="Phone">
<input name="occupation" placeholder="Occupation">
<textarea name="address" placeholder="Address"></textarea>
<button class="btn edit">➕ Add Parent</button>
</form>
</div>

<!-- LIST -->
<table class="table" id="parentsTable">
<tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>

<?php $i=1; while($p=$parents->fetch_assoc()): ?>
<tr data-id="<?= $p['id'] ?>">
<td><?= $i++ ?></td>
<td class="name"><?= esc($p['full_name']) ?></td>
<td class="email"><?= esc($p['email']) ?></td>
<td class="phone"><?= esc($p['phone']) ?></td>
<td>
<button class="btn edit" onclick='openEdit(<?= json_encode($p) ?>)'>✏️</button>
<button class="btn del" onclick="deleteParent(<?= $p['id'] ?>)">🗑️</button>
</td>
</tr>
<?php endwhile; ?>
</table>

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
<div class="modal-content">
<h3>Edit Parent</h3>
<form id="editForm">
<input type="hidden" name="parent_id" id="pid">
<input name="full_name" id="pname" required>
<input name="email" id="pemail" required>
<input name="phone" id="pphone">
<input name="occupation" id="pocc">
<textarea name="address" id="paddr"></textarea>
<button class="btn edit">💾 Save</button>
<button type="button" class="btn del" onclick="closeEdit()">Cancel</button>
</form>
</div>
</div>

<script>
const alertBox=document.getElementById('alertBox');

function showAlert(msg,type){
alertBox.className='alert '+type;
alertBox.innerText=msg;
alertBox.style.display='block';
setTimeout(()=>alertBox.style.display='none',3000);
}

function ajax(formData){
return fetch('manage-parents.php',{method:'POST',body:formData})
.then(r=>r.json());
}

document.getElementById('addForm').onsubmit=e=>{
e.preventDefault();
let fd=new FormData(e.target);
fd.append('action','add');
ajax(fd).then(r=>{
showAlert(r.msg,r.status);
if(r.status==='success') location.reload();
});
};

function deleteParent(id){
if(!confirm('Delete parent and user?')) return;
let fd=new FormData();
fd.append('action','delete');
fd.append('id',id);
ajax(fd).then(r=>{
showAlert(r.msg,r.status);
if(r.status==='success')
document.querySelector(`tr[data-id='${id}']`).remove();
});
}

function openEdit(p){
pid.value=p.id;
pname.value=p.full_name;
pemail.value=p.email;
pphone.value=p.phone;
pocc.value=p.occupation;
paddr.value=p.address;
editModal.style.display='flex';
}

function closeEdit(){ editModal.style.display='none'; }

document.getElementById('editForm').onsubmit=e=>{
e.preventDefault();
let fd=new FormData(e.target);
fd.append('action','update');
ajax(fd).then(r=>{
showAlert(r.msg,r.status);
if(r.status==='success') location.reload();
});
};
</script>

<?php include 'partials/footer.php'; ?>
