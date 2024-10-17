<?php

$host = 'localhost';     // Server database
$user = 'root';          // Username MySQL
$password = '';          // Password MySQL
$dbname = 'db_pajak';    // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
// Jika ingin menggunakan mysqli_connect_errno(), berikut alternatif koneksi menggunakan mysqli_connect_errno():
// $conn = mysqli_connect($host, $user, $password, $dbname);

// Jika ingin menggunakan PDO, berikut alternatif koneksi menggunakan PDO:
// try {
//     $dsn = "mysql:host=$host;dbname=$dbname";
//     $pdo = new PDO($dsn, $user, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Koneksi gagal: " . $e->getMessage());
// }

