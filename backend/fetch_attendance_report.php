<?php
// include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$date = $_GET['date'] ?? date('Y-m-d');
$type = $_GET['type'] ?? '';
$class_id = $_GET['class_id'] ?? '';
$section_id = $_GET['section_id'] ?? '';

/* ----------------------------------------------------
   ✅ AUTO-MARK ABSENT FOR ALL STUDENTS (NO SCAN = ABSENT)
----------------------------------------------------- */

$studentWhere = [];
if ($class_id) $studentWhere[] = "class_id = " . (int)$class_id;
if ($section_id) $studentWhere[] = "section_id = " . (int)$section_id;

$studentWhereSql = count($studentWhere) ? "WHERE " . implode(" AND ", $studentWhere) : "";

// ✅ Get all students in class/section
$allStudents = $conn->query("SELECT id FROM students $studentWhereSql");

// ✅ For each student, check if attendance exists for selected date
while ($s = $allStudents->fetch_assoc()) {
    $sid = $s['id'];

    $check = $conn->query("
        SELECT 1 FROM attendance
        WHERE entity_type='student'
        AND entity_id=$sid
        AND date='$date'
        LIMIT 1
    ")->num_rows;

    // ✅ If no attendance row exists → insert ABSENT
    if ($check == 0) {
        $conn->query("
            INSERT INTO attendance (entity_id, entity_type, status, date)
            VALUES ($sid, 'student', 'Absent', '$date')
        ");
    }
}

echo "<h3>Attendance Report - " . esc($date) . "</h3>";


/**
 * -------------------------------
 * STUDENT ATTENDANCE
 * -------------------------------
 */
if ($type === '' || $type === 'student') {
  $where = [];
  if ($class_id) $where[] = "s.class_id = " . (int)$class_id;
  if ($section_id) $where[] = "s.section_id = " . (int)$section_id;
  $whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

  $q = "
    SELECT 
      s.id AS entity_id,
      'Student' AS entity_type,
      s.admission_no AS code,
      CONCAT(s.first_name, ' ', s.last_name) AS name,
      c.class_name,
      sec.section_name,
      COALESCE(a.status, 'Absent') AS status,
      a.date,
      a.time_in
    FROM students s
    LEFT JOIN attendance a 
      ON a.entity_id = s.id 
      AND a.entity_type = 'student'
      AND a.date = '$date'
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN sections sec ON s.section_id = sec.id
    $whereSql
    ORDER BY c.class_name, sec.section_name, s.first_name
  ";

  $res = $conn->query($q);
  if (!$res) {
    echo "<p style='color:red'>SQL Error: {$conn->error}</p>";
  } elseif ($res->num_rows === 0) {
    echo "<p style='color:gray;'>No student data found.</p>";
  } else {
    echo "<h4>👩‍🎓 Student Attendance</h4>";
    echo "<table border='1' cellpadding='6' style='width:100%; border-collapse:collapse; background:#fff;'>";
    echo "<thead style='background:#007bff; color:white;'>
            <tr>
              <th>Admission No</th>
              <th>Name</th>
              <th>Class</th>
              <th>Section</th>
              <th>Date</th>
              <th>Time In</th>
              <th>Status</th>
            </tr>
          </thead><tbody>";

    while ($r = $res->fetch_assoc()) {
      $cls = strtolower($r['status']) === 'present' ? 'present' : 'absent';
      echo "<tr>
              <td>" . esc($r['code']) . "</td>
              <td><a href='student-details.php?id=" . (int)$r['entity_id'] . "' style='color:#007bff; text-decoration:none;'>" . esc($r['name']) . "</a></td>
              <td>" . esc($r['class_name']) . "</td>
              <td>" . esc($r['section_name']) . "</td>
              <td>" . esc($r['date'] ?: $date) . "</td>
              <td>" . esc($r['time_in'] ?: '-') . "</td>
              <td class='status-cell $cls'>" . ucfirst($r['status']) . "</td>
            </tr>";
    }
    echo "</tbody></table>";
  }
}

/**
 * -------------------------------
 * TEACHER ATTENDANCE
 * -------------------------------
 */
if ($type === '' || $type === 'teacher') {
  $q = "
    SELECT 
      t.id AS entity_id,
      'Teacher' AS entity_type,
      t.teacher_code AS code,
      CONCAT(t.first_name, ' ', t.last_name) AS name,
      COALESCE(a.status, 'Absent') AS status,
      a.date,
      a.time_in
    FROM teachers t
    LEFT JOIN attendance a 
      ON a.entity_id = t.id 
      AND a.entity_type = 'teacher'
      AND a.date = '$date'
    ORDER BY t.first_name
  ";

  $res = $conn->query($q);
  if (!$res) {
    echo "<p style='color:red'>SQL Error: {$conn->error}</p>";
  } elseif ($res->num_rows === 0) {
    echo "<p style='color:gray;'>No teacher data found.</p>";
  } else {
    echo "<br><h4>👨‍🏫 Teacher Attendance</h4>";
    echo "<table border='1' cellpadding='6' style='width:100%; border-collapse:collapse; background:#fff;'>";
    echo "<thead style='background:#28a745; color:white;'>
            <tr>
              <th>Teacher Code</th>
              <th>Name</th>
              <th>Date</th>
              <th>Time In</th>
              <th>Status</th>
            </tr>
          </thead><tbody>";

    while ($r = $res->fetch_assoc()) {
      $cls = strtolower($r['status']) === 'present' ? 'present' : 'absent';
      echo "<tr>
              <td>" . esc($r['code']) . "</td>
              <td><a href='teacher-details.php?id=" . (int)$r['entity_id'] . "' style='color:#28a745; text-decoration:none;'>" . esc($r['name']) . "</a></td>
              <td>" . esc($r['date'] ?: $date) . "</td>
              <td>" . esc($r['time_in'] ?: '-') . "</td>
              <td class='status-cell $cls'>" . ucfirst($r['status']) . "</td>
            </tr>";
    }
    echo "</tbody></table>";
  }
}
?>
