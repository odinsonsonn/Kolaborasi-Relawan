<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

require 'config.php';

if (!$conn) {
    echo json_encode(['success' => false, 'errors' => ['Database connection failed']]);
    exit;
}

$_POST = json_decode(file_get_contents('php://input'), true) ?? $_POST;

$id = $_POST['id'] ?? null;
if (!$id || !is_numeric($id)) {
    echo json_encode(['success' => false, 'errors' => ['ID tidak valid']]);
    exit;
}

$id = intval($id);

// Validasi
$errors = [];
$title = $_POST['title'] ?? '';
$category = $_POST['category'] ?? '';
$location = $_POST['location'] ?? '';
$description = $_POST['description'] ?? '';
$event_date = $_POST['event_date'] ?? '';
$event_time = $_POST['event_time'] ?? '';
$organizer = $_POST['organizer'] ?? '';
$requirements = $_POST['requirements'] ?? '';
$image_url = $_POST['image_url'] ?? '';

if (empty($title)) $errors[] = "Judul kegiatan harus diisi";
if (empty($category)) $errors[] = "Kategori harus dipilih";
if (empty($location)) $errors[] = "Lokasi harus diisi";
if (empty($description)) $errors[] = "Deskripsi harus diisi";
if (empty($event_date)) $errors[] = "Tanggal harus diisi";
if (empty($event_time)) $errors[] = "Waktu harus diisi";

if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
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

$query = "UPDATE events SET 
          title = '$title',
          category = '$category',
          location = '$location',
          description = '$description',
          event_date = '$event_date',
          event_time = '$event_time',
          organizer = '$organizer',
          requirements = '$requirements',
          image_url = '$image_url'
          WHERE id = $id";

if ($conn->query($query)) {
    echo json_encode(['success' => true, 'message' => 'Event berhasil diperbarui!']);
    exit;
} else {
    echo json_encode(['success' => false, 'errors' => ['Error: ' . $conn->error]]);
    exit;
}

$conn->close();
?>
