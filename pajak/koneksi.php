<?php
$host = 'localhost';     // Server database
$user = 'root';          // Username MySQL
$password = '';          // Password MySQL
$dbname = 'db_pajak';// Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika ingin menggunakan PDO, berikut alternatif koneksi menggunakan PDO:
// try {
//     $dsn = "mysql:host=$host;dbname=$dbname";
//     $pdo = new PDO($dsn, $user, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Koneksi gagal: " . $e->getMessage());
// }
?>
