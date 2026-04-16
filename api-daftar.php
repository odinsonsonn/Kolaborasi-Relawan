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
?>