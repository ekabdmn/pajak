<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    $conn = new mysqli('localhost', 'root', '', 'pajak_barang');
    
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO wajib_pajak (nama, email, alamat, no_telepon) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $email, $alamat, $no_telepon);
    
    if ($stmt->execute()) {
        echo "Wajib pajak berhasil didaftarkan.";
    } else {
        echo "Gagal mendaftarkan wajib pajak.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Wajib Pajak</title>
</head>
<body>
    <h1>Formulir Pendaftaran Wajib Pajak</h1>
    <form method="POST" action="daftar_wajib_pajak.php">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat" required></textarea><br><br>

        <label>No Telepon:</label><br>
        <input type="text" name="no_telepon" required><br><br>

        <button type="submit">Daftar</button>
    </form>
</body>
</html>
