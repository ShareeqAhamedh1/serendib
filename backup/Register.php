<?php
// serendib_highschool/Register.php
require_once __DIR__ . '/backend/conn.php';   // makes DB + session available
require_once __DIR__ . '/backend/helpers.php';// for esc() or csrf_field() if available

// optional: show success message when redirected
$ok = $_GET['ok'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Registration | Serendib Highschool</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #eef1f7;
        padding: 25px;
    }
    .card {
        max-width: 900px;
        margin: 20px auto;
        background: #fff;
        padding: 30px;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    }
    h2 {
        margin-bottom: 18px;
        font-size: 26px;
        color: #333;
        text-align: center;
    }
    form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        grid-gap: 18px;
    }
    label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: #444;
    }
    input, select, textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccd2e0;
        border-radius: 8px;
        background: #fdfdfd;
        font-size: 14px;
    }
    textarea {
        resize: vertical;
    }
    .full {
        grid-column: 1 / -1; /* full width field */
    }
    button {
        background: #0069d9;
        padding: 12px;
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
        grid-column: 1 / -1;
        margin-top: 10px;
    }
    button:hover {
        background: #0052ad;
    }
    hr {
        grid-column: 1 / -1;
        margin: 10px 0;
        border: none;
        border-top: 1px solid #ddd;
    }
    h4 {
        grid-column: 1 / -1;
        margin-top: 10px;
        margin-bottom: -5px;
        color: #444;
    }
</style>

<div class="card">
    <h2>📥 New Student Registration</h2>

    <form method="post" action="<?= BASE_URL ?>backend/handle_registration.php">
        <?= function_exists('csrf_field') ? csrf_field() : '' ?>

        <div>
            <label>Full Name</label>
            <input type="text" name="full_name" required>
        </div>

        <div>
            <label>Date of Birth</label>
            <input type="date" name="dob">
        </div>

        <div>
            <label>Gender</label>
            <select name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div>
            <label>Joining Grade</label>
            <select name="joining_grade" required>
                <option value="">-- Select Grade --</option>
                <option value="6">Grade 6</option>
                <option value="7">Grade 7</option>
                <option value="8">Grade 8</option>
                <option value="9">Grade 9</option>
                <option value="10">Grade 10</option>
                <option value="11">Grade 11</option>
            </select>
        </div>

        <div>
            <label>Medium</label>
            <select name="medium">
                <option value="">-- Select Medium --</option>
                <option value="English">English</option>
                <option value="Sinhala">Sinhala</option>
                <option value="Tamil">Tamil</option>
            </select>
        </div>

        <hr>

        <h4>Parent / Guardian Details</h4>

        <div>
            <label>Parent / Guardian Name</label>
            <input type="text" name="parent_name">
        </div>

        <div>
            <label>Parent Email</label>
            <input type="email" name="parent_email">
        </div>

        <div>
            <label>Parent Phone</label>
            <input type="text" name="parent_phone">
        </div>

        <div class="full">
            <label>Previous School (optional)</label>
            <input type="text" name="previous_school">
        </div>

        <div class="full">
            <label>Address</label>
            <textarea name="address" rows="3"></textarea>
        </div>

        <div class="full">
            <label>Remarks</label>
            <textarea name="remarks" rows="3"></textarea>
        </div>

        <button type="submit">Submit Registration</button>
    </form>
</div>


<script>
setTimeout(()=> {
  const m = document.getElementById('msg');
  if (m) m.style.display = 'none';
}, 3500);
</script>

<?php if (isset($_GET['ok'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {

    <?php if ($_GET['ok'] == '1'): ?>
        Swal.fire({
            title: "Registration Successful!",
            text: "The student has been registered successfully.",
            icon: "success",
            confirmButtonColor: "#3085d6"
        });
    <?php else: ?>
        Swal.fire({
            title: "Registration Failed!",
            text: "Please check the details and try again.",
            icon: "error",
            confirmButtonColor: "#d33"
        });
    <?php endif; ?>

    // 🔥 Remove ?ok=1 or ?ok=0 from URL after alert is displayed
    window.history.replaceState({}, document.title, window.location.pathname);
});
</script>
<?php endif; ?>


</body>
</html>
