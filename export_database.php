<?php
/**
 * Script untuk export database ke file SQL
 * Jalankan dari browser: http://localhost/export_database.php
 */

// Include config untuk koneksi database
include 'config.php';

// Nama database
$database = 'kolaborasi_relawan';

// Path output file
$backupFile = __DIR__ . DIRECTORY_SEPARATOR . 'kolaborasi_relawan.sql';

// Cek koneksi
if ($conn->connect_error) {
    die("❌ Koneksi gagal: " . $conn->connect_error);
}

// Buat backup menggunakan mysqldump
$command = "mysqldump -u root $database > " . escapeshellarg($backupFile);

// Coba jalankan command
$output = shell_exec($command . " 2>&1");

if (file_exists($backupFile) && filesize($backupFile) > 0) {
    $fileSize = filesize($backupFile);
    echo "✅ Database berhasil di-export!<br>";
    echo "📁 File: kolaborasi_relawan.sql<br>";
    echo "📊 Ukuran: " . round($fileSize / 1024, 2) . " KB<br>";
    echo "<br>📝 Kirim file ini ke teman untuk import database.<br>";
} else {
    echo "❌ Export gagal!<br>";
    echo "Output: " . htmlspecialchars($output) . "<br>";
    echo "<br>Alternatif: Gunakan phpMyAdmin untuk export database.";
}

$conn->close();
?>
