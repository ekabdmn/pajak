<?php
$conn = new mysqli('localhost', 'root', '', 'db_pajak');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wajib_pajak_id = $_POST['wajib_pajak_id'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $nilai_barang = $_POST['nilai_barang'];
    $tanggal_beli = $_POST['tanggal_beli'];
    $pajak = $nilai_barang * 0.10; // Hitung pajak 10%

    $stmt = $conn->prepare("INSERT INTO barang (wajib_pajak_id, nama_barang, kategori, nilai_barang, tanggal_beli, pajak) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssds", $wajib_pajak_id, $nama_barang, $kategori, $nilai_barang, $tanggal_beli, $pajak);

    if ($stmt->execute()) {
        echo "Barang berhasil didaftarkan.";
    } else {
        echo "Gagal mendaftarkan barang.";
    }

    $stmt->close();
}

$wajib_pajak = $conn->query("SELECT id, nama FROM wajib_pajak");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
</head>

<body>
    <h1>Formulir Pendaftaran Barang</h1>
    <form method="POST" action="daftar_barang.php">
        <label>Pemilik Barang:</label><br>
        <select name="wajib_pajak_id" required>
            <?php while ($row = $wajib_pajak->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option <?php endwhile; ?> </select><br><br>

            <label>Nama Barang:</label><br>
            <input type="text" name="nama_barang" required><br><br>

            <label>Kategori:</label><br>
            <input type="text" name="kategori" required><br><br>

            <label>Nilai Barang (Rp):</label><br>
            <input type="number" name="nilai_barang" required><br><br>

            <label>Tanggal Pembelian:</label><br>
            <input type="date" name="tanggal_beli" required><br><br>

            <button type="submit">Daftarkan Barang</button>
    </form>
</body>

</html>