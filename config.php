<?php
// Koneksi ke Database MySQL
$servername = "localhost";
$username = "root";
$password = "";  // Default Xampp passwordnya kosong
$database = "kolaborasi_relawan";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("❌ Koneksi ke database gagal: " . $conn->connect_error);
}

// Set charset UTF-8
$conn->set_charset("utf8mb4");

// Return koneksi ke file yang butuh
?>