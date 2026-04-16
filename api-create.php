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

// Ambil JSON dari request
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    ob_end_clean();
    die(json_encode(['success' => false, 'errors' => ['Data tidak valid']]));
}

// Validasi
$errors = [];
$title = $data['title'] ?? '';
$category = $data['category'] ?? '';
$location = $data['location'] ?? '';
$description = $data['description'] ?? '';
$event_date = $data['event_date'] ?? '';
$event_time = $data['event_time'] ?? '';
$organizer = $data['organizer'] ?? '';
$requirements = $data['requirements'] ?? '';
$image_url = $data['image_url'] ?? '';

if (!$title) $errors[] = "Judul kegiatan harus diisi";
if (!$category) $errors[] = "Kategori harus dipilih";
if (!$location) $errors[] = "Lokasi harus diisi";
if (!$description) $errors[] = "Deskripsi harus diisi";
if (!$event_date) $errors[] = "Tanggal harus diisi";
if (!$event_time) $errors[] = "Waktu harus diisi";
if (!$organizer) $errors[] = "Nama organisasi harus diisi";

if (strlen($title) > 255) $errors[] = "Judul terlalu panjang";
if (strlen($description) > 5000) $errors[] = "Deskripsi terlalu panjang";

if (count($errors) > 0) {
    ob_end_clean();
    echo json_encode(['success' => false, 'errors' => $errors]);
    $conn->close();
    exit;
}

// Escape
$title = $conn->real_escape_string($title);
$category = $conn->real_escape_string($category);
$location = $conn->real_escape_string($location);
$description = $conn->real_escape_string($description);
$event_date = $conn->real_escape_string($event_date);
$event_time = $conn->real_escape_string($event_time);
$organizer = $conn->real_escape_string($organizer);
$requirements = $conn->real_escape_string($requirements);
$image_url = $conn->real_escape_string($image_url);

// Insert
$sql = "INSERT INTO events (title, category, location, description, event_date, event_time, organizer, requirements, image_url, created_at) 
        VALUES ('$title', '$category', '$location', '$description', '$event_date', '$event_time', '$organizer', '$requirements', '$image_url', NOW())";

if ($conn->query($sql) === TRUE) {
    ob_end_clean();
    echo json_encode(['success' => true, 'message' => 'Event berhasil ditambahkan!']);
} else {
    ob_end_clean();
    echo json_encode(['success' => false, 'errors' => ['Error: ' . $conn->error]]);
}

$conn->close();
?>
