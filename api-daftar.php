<?php
header('Content-Type: application/json; charset=utf-8');
ob_start();

// Koneksi database
$conn = new mysqli("localhost", "root", "", "kolaborasi_relawan");

if ($conn->connect_error) {
    http_response_code(500);
    ob_end_clean();
    die(json_encode(['success' => false, 'errors' => ['Koneksi database gagal']]));
}

$conn->set_charset("utf8mb4");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    ob_end_clean();
    die(json_encode(['success' => false, 'errors' => ['Metode tidak diizinkan']]));
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !is_array($data)) {
    $data = $_POST;
}

$event_id = $data['event_id'] ?? '';
$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$phone = trim($data['phone'] ?? '');

$errors = [];

if (!$event_id || !is_numeric($event_id)) {
    $errors[] = 'event_id tidak valid';
}

if (!$name) {
    $errors[] = 'Nama harus diisi';
} elseif (mb_strlen($name) > 255) {
    $errors[] = 'Nama terlalu panjang';
}

if (!$email) {
    $errors[] = 'Email harus diisi';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email tidak valid';
} elseif (mb_strlen($email) > 255) {
    $errors[] = 'Email terlalu panjang';
}

if (!$phone) {
    $errors[] = 'Nomor telepon harus diisi';
} elseif (mb_strlen($phone) > 50) {
    $errors[] = 'Nomor telepon terlalu panjang';
}

if (count($errors) > 0) {
    ob_end_clean();
    echo json_encode(['success' => false, 'errors' => $errors]);
    $conn->close();
    exit;
}

$event_id = intval($event_id);
$eventCheck = $conn->prepare('SELECT id FROM events WHERE id = ?');
$eventCheck->bind_param('i', $event_id);
$eventCheck->execute();
$eventCheck->store_result();
if ($eventCheck->num_rows === 0) {
    $eventCheck->close();
    ob_end_clean();
    echo json_encode(['success' => false, 'errors' => ['Event tidak ditemukan']]);
    $conn->close();
    exit;
}
$eventCheck->close();

$stmt = $conn->prepare('INSERT INTO registrations (event_id, name, email, phone) VALUES (?, ?, ?, ?)');
$stmt->bind_param('isss', $event_id, $name, $email, $phone);

if ($stmt->execute()) {
    ob_end_clean();
    echo json_encode(['success' => true, 'message' => 'Pendaftaran berhasil disimpan']);
} else {
    ob_end_clean();
    http_response_code(500);
    echo json_encode(['success' => false, 'errors' => ['Error: ' . $stmt->error]]);
}

$stmt->close();
$conn->close();
?>