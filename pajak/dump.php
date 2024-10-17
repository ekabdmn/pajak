<div class="navbar">
        <h1>Dashboard</h1>
        <ul>
            <a href="daftar_wajib_pajak.php">Daftar Wajib Pajak</a>
            <a href="daftar_barang.php">Daftar Barang</a>
            <a href="list_barang.php">List Barang</a>
            <a href="bayar_pajak.php">Bayar Pajak</a>
            <a href="list_kendaraan.php">List Kendaraan</a>
            
        </ul>
    </div>
    <div class="container">
        <h1>Indeks Pajak Barang</h1>
        <footer>
            <p>&copy; 2024 Pajak Barang</p>
        </footer>   
    </div>
    <!-- main -->

    window.location.href = 'index.php?halaman=login';

    <?= $count ?>

    <div class="table-responsive">
        <table class="table table-bordered" id="table">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Nama Peminjam</th>
                    <th>No Telepon</th>
                    <th>Merk Laptop</th>
                    <th>Serial Number</th>
                    <th>Kondisi</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status Peminjaman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($count > 0) : ?>
                    <?php $i = 1; ?>
                    <?php while ($data = $query->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($data['nama_peminjam']) ?></td>
                            <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                            <td><?= htmlspecialchars($data['merk_laptop']) ?></td>
                            <td><?= htmlspecialchars($data['serial_number']) ?></td>
                            <td><?= htmlspecialchars($data['kondisi']) ?></td>
                            <td><?= htmlspecialchars($data['tanggal_peminjaman']) ?></td>
                            <td><?= htmlspecialchars($data['tanggal_pengembalian']) ?></td>
                            <td><?= htmlspecialchars($data['status_peminjaman']) ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="index.php?halaman=ubah_elektronik&id=<?= $data['id'] ?>" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="index.php?halaman=hapus_elektronik&id=<?= $data['id'] ?>" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data elektronik.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>