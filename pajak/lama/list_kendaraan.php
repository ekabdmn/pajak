<?php
include 'koneksi.php';

$kendaraan = $conn->query("SELECT * FROM kendaraan");
if ($kendaraan->num_rows == 0) {
    echo "<p>Tidak ada data kendaraan.</p>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kendaraan</title>
    <style>
        /* CSS untuk mempercantik tampilan */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            color: #ff0000;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Daftar Kendaraan</h1>
    <a class="btn-tambah" href="tambah_kendaraan.php">Tambah Data</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nomor Plat</th>
            <th>Merk</th>
            <th>Tipe</th>
            <th>Tahun Pembuatan</th>
            <th>Pemilik</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $kendaraan->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['no_plat'] ?></td>
            <td><?= $row['merk'] ?></td>
            <td><?= $row['tipe'] ?></td>
            <td><?= $row['tahun_pembuatan'] ?></td>
            <td><?= $row['pemilik'] ?></td>
            <td>
                <a href="hapus_kendaraan.php?id=<?= $row['id'] ?>">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
