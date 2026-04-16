<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

require 'config.php';

if (!$conn) {
    echo json_encode(['success' => false, 'errors' => ['Database connection failed']]);
    exit;
}

$id = $_POST['id'] ?? null;
if (!$id || !is_numeric($id)) {
    echo json_encode(['success' => false, 'error' => 'ID tidak valid']);
    exit;
}

$id = intval($id);

// Cek apakah event ada
$check = $conn->query("SELECT id FROM events WHERE id = $id");
if (!$check || $check->num_rows === 0) {
    echo json_encode(['success' => false, 'errors' => ['Event tidak ditemukan']]);
    exit;
}

// Delete
$query = "DELETE FROM events WHERE id = $id";
if ($conn->query($query)) {
    echo json_encode(['success' => true, 'message' => 'Event berhasil dihapus!']);
    exit;
} else {
    echo json_encode(['success' => false, 'errors' => ['Error: ' . $conn->error]]);
    exit;
}

$conn->close();
?>
