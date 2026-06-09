<?php
require 'conn.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$type = $data['type'];
$id   = (int)$data['id'];

$grade_id = null;
$gender   = null;
$isSchool = 0;

/* ===============================
   GET STUDENT INFO
================================ */

if ($type === 'student') {

    $stmt = $conn->prepare("
        SELECT class_id, gender, isSchool
        FROM students
        WHERE id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    $grade_id = $row['class_id'];
    $gender   = $row['gender'];
    $isSchool = $row['isSchool'];
}

/* ===============================
   GET HOUSE STATISTICS
================================ */

$sql = "
SELECT
h.id,
h.name,
h.logo,
h.color,

COUNT(m.id) AS total,

SUM(
CASE
WHEN m.entity_type='student'
AND s.class_id=?
THEN 1 ELSE 0
END
) AS grade_count,

SUM(
CASE
WHEN m.entity_type='student'
AND s.gender=?
THEN 1 ELSE 0
END
) AS gender_count,

SUM(
CASE
WHEN m.entity_type='teacher'
THEN 1 ELSE 0
END
) AS teacher_count

FROM houses h

LEFT JOIN house_members m
ON m.house_id = h.id

LEFT JOIN students s
ON m.entity_id = s.id
AND m.entity_type='student'

GROUP BY h.id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is",$grade_id,$gender);
$stmt->execute();
$res = $stmt->get_result();

/* ===============================
   CALCULATE HOUSE SCORE
================================ */

$houses = [];
$bestScore = PHP_INT_MAX;

while($row = $res->fetch_assoc()){

    $score =
        ($row['total'] * 3) +
        ($row['grade_count'] * 2) +
        ($row['gender_count'] * 2) +
        ($row['teacher_count'] * 1);

    $row['score'] = $score;

    if($score < $bestScore){
        $bestScore = $score;
    }

    $houses[] = $row;
}

/* ===============================
   WEIGHTED RANDOM SELECTION
================================ */

$weights = [];
$totalWeight = 0;

foreach($houses as $h){

    $weight = ($bestScore + 5) - $h['score'];

    if($weight < 1) $weight = 1;

    $weights[] = [
        'house'=>$h,
        'weight'=>$weight
    ];

    $totalWeight += $weight;
}

if($totalWeight == 0){
    echo json_encode(["error"=>"No house available"]);
    exit;
}

$rand = mt_rand(1,$totalWeight);
$current = 0;

foreach($weights as $w){

    $current += $w['weight'];

    if($rand <= $current){
        $house = $w['house'];
        break;
    }
}

/* ===============================
   INSERT MEMBER
================================ */

$stmt = $conn->prepare("
INSERT INTO house_members
(entity_type, entity_id, grade_id, house_id)
VALUES (?,?,?,?)
");

$stmt->bind_param("siii",$type,$id,$grade_id,$house['id']);
$stmt->execute();

/* ===============================
   RETURN RESULT
================================ */

echo json_encode([
    'house'=>$house['name'],
    'logo'=>$house['logo'],
    'color'=>$house['color']
]);