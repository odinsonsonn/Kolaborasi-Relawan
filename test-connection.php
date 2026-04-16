<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config.php';

echo "<!DOCTYPE html>";
echo "<html lang='id'>";
echo "<head><meta charset='UTF-8'><title>Test Koneksi</title>";
echo "<style>body{font-family:Arial;margin:20px;}h1{color:green;}</style></head>";
echo "<body>";

if ($conn->connect_error) {
    echo "<h1>❌ Koneksi Gagal</h1>";
    echo "<p>Error: " . $conn->connect_error . "</p>";
} else {
    echo "<h1>✅ Koneksi Berhasil!</h1>";
    echo "<p>Database: <strong>kolaborasi_relawan</strong></p>";
    
    $result = $conn->query("SELECT * FROM events");
    
    if ($result) {
        echo "<h2>📋 Data Events:</h2>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Lokasi</th></tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "<td>" . $row['location'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>❌ Query error: " . $conn->error . "</p>";
    }
}

$conn->close();
echo "</body></html>";
?>