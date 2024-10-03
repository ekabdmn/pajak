<?php
$conn = new mysqli('localhost', 'root', '', 'db_pajak');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$barang = $conn->query("
    SELECT b.id, wp.nama AS pemilik, b.nama_barang, b.kategori, b.nilai_barang, b.pajak
    FROM barang b
    JOIN wajib_pajak wp ON b.wajib_pajak_id = wp.id
");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang dan Pajak</title>
</head>
<body>
    <h1>Data Barang dan Pajak dan hhh</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Pemilik</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Nilai Barang (Rp)</th>
            <th>Pajak (Rp)</th>
            <th>Status Pajak</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $barang->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['pemilik'] ?></td>
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['kategori'] ?></td>
            <td><?= number_format($row['nilai_barang'], 2, ',', '.') ?></td>
            <td><?= number_format($row['pajak'], 2, ',', '.') ?></td>
            <td><!--$row['status_pajak']--> Dump </td>
            <td>
                <?php if ( 'dump' === 'belum_bayar'): ?>
                    <a href="bayar_pajak.php?id=<?= $row['id'] ?>">Bayar Pajak</a>
                <?php else: ?>
                    Sudah Dibayar
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
