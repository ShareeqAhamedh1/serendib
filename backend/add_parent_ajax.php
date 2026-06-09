<?php
require 'conn.php';
require 'helpers.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Invalid request.']);
  exit;
}

$name = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$occupation = trim($_POST['occupation'] ?? '');
$address = trim($_POST['address'] ?? '');

if ($name === '' || $email === '') {
  echo json_encode(['success' => false, 'message' => 'Name and email are required.']);
  exit;
}

// Default password
$password = password_hash('12345', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO parents (full_name, email, phone, occupation, address, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $email, $phone, $occupation, $address, $password);
$stmt->execute();

$newId = $conn->insert_id;

echo json_encode([
  'success' => true,
  'message' => 'Parent added successfully!',
  'parent_id' => $newId,
  'parent_name' => $name
]);
