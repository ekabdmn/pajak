<?php
$conn = new mysqli('localhost', 'root', '', 'db_pajak');

if (isset($_GET['id'])) {
    $barang_id = $_GET['id'];

    $barang = $conn->query("SELECT * FROM barang WHERE id = $barang_id")->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tanggal_bayar = $_POST['tanggal_bayar'];
        $jumlah_pajak = $barang['pajak'];

        // Insert ke tabel pembayaran
        $stmt = $conn->prepare("INSERT INTO pembayaran (barang_id, jumlah_pajak, tanggal_bayar) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $barang_id, $jumlah_pajak, $tanggal_bayar);

        if ($stmt->execute()) {
            // Update status pajak barang
            $conn->query("UPDATE barang SET status_pajak = 'sudah_bayar' WHERE id = $barang_id");
            echo "Pembayaran berhasil!";
        } else {
            echo "Pembayaran gagal!";
        }

        $stmt->close();
    }
} else {
    echo "Barang tidak ditemukan.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pajak</title>
</head>
<body>
    <h1>Pembayaran Pajak untuk Barang: <?= $barang['nama_barang'] ?></h1>
    <p>Nilai Pajak: Rp<?= number_format($barang['pajak'], 2, ',', '.') ?></p>
    <form method="POST" action="bayar_pajak.php?id=<?= $barang_id ?>">
        <label>Tanggal Pembayaran:</label><br>
        <input type="date" name="tanggal_bayar" required><br><br>
        <button type="submit">Bayar Pajak</button>
    </form>
</body>
</html>
