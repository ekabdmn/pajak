<?php
include "./function/koneksi.php";
include "./function/log.php"; // Pastikan ini ada untuk menggunakan fungsi logHistori

if (!isset($_SESSION['nama'])) {
    header('Location: index.php?halaman=login');
    exit; // Tambahkan exit setelah header redirect
}

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Select Data
        $select = mysqli_query($conn, "SELECT * FROM elektronik WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=elektronik');
            exit; // Tambahkan exit setelah header redirect
        }

        // Menyimpan data lama untuk log
        $data_lama = implode("\n", [
            'nama peminjam = ' . htmlspecialchars($data['nama_peminjam']),
            'no telepon = ' . htmlspecialchars($data['no_telepon']),
            'merk laptop = ' . htmlspecialchars($data['merk_laptop']),
            'serial number = ' . htmlspecialchars($data['serial_number']),
            'kondisi = ' . htmlspecialchars($data['kondisi']),
            'tanggal peminjaman = ' . htmlspecialchars($data['tanggal_peminjaman']),
            'tanggal pengembalian = ' . htmlspecialchars($data['tanggal_pengembalian']),
            'status peminjaman = ' . htmlspecialchars($data['status_peminjaman']),
        ]);

        // Submit
        if (isset($_POST['submit'])) {
            $nama_peminjam = htmlspecialchars($_POST['nama_peminjam']);
            $no_telepon = htmlspecialchars($_POST['no_telepon']);
            $merk_laptop = htmlspecialchars($_POST['merk_laptop']);
            $serial_number = htmlspecialchars($_POST['serial_number']);
            $kondisi = htmlspecialchars($_POST['kondisi']);
            $tanggal_peminjaman = htmlspecialchars($_POST['tanggal_peminjaman']);
            $tanggal_pengembalian = htmlspecialchars($_POST['tanggal_pengembalian']);
            $status_peminjaman = htmlspecialchars($_POST['status_peminjaman']);

            // Update data elektronik
            $query = mysqli_query($conn, "UPDATE elektronik SET 
                nama_peminjam = '$nama_peminjam',
                no_telepon = '$no_telepon',
                merk_laptop = '$merk_laptop',
                serial_number = '$serial_number',
                kondisi = '$kondisi',
                tanggal_peminjaman = '$tanggal_peminjaman',
                tanggal_pengembalian = '$tanggal_pengembalian',
                status_peminjaman = '$status_peminjaman'
                WHERE id = '$id'");

            if ($query) {
                // Menyimpan data baru untuk log
                $data_baru = implode("\n", [
                    'Nama Peminjam = ' . $nama_peminjam,
                    'No Telepon = ' . $no_telepon,
                    'Merk Laptop = ' . $merk_laptop,
                    'serial number = ' . $serial_number,
                    'kondisi = ' . $kondisi,
                    'tanggal peminjaman = ' . $tanggal_peminjaman,
                    'tanggal pengembalian = ' . $tanggal_pengembalian,
                    'status peminjaman = ' . $status_peminjaman,
                ]);

                // Log histori untuk aksi 'UPDATE'
                $pengguna = !isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'];
                logHistori('elektronik', $id, 'Ubah Data', $data_lama, $data_baru, $pengguna); // Menggunakan logHistori

                $message = "Berhasil mengubah data";
                echo "
                <script>
                Swal.fire({
                    title: 'Berhasil',
                    text: '$message',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = 'index.php?halaman=elektronik';
                })
                </script>
                ";
            } else {
                $message = "Gagal mengubah data";
                echo "
                <script>
                Swal.fire({
                    title: 'Gagal',
                    text: '$message',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = 'index.php?halaman=elektronik';
                })
                </script>
                ";
            }
        }
    }
} catch (\Throwable $th) {
    echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Server error!',
        icon: 'error',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    }).then(() => {
        window.location.href = 'index.php?halaman=elektronik';
    })
    </script>
    ";
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Ubah Data Elektronik</h3>
                <p class="text-subtitle text-muted">
                    Halaman untuk mengubah data elektronik.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=elektronik">Elektronik</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Ubah Data Elektronik
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <a href="index.php?halaman=elektronik" class="btn btn-primary btn-sm mb-3">Kembali</a>
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_peminjam">Nama Peminjam</label>
                            <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="<?= $data['nama_peminjam'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?= $data['no_telepon'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="merk_laptop">Merk Laptop</label>
                            <input type="text" class="form-control" id="merk_laptop" name="merk_laptop" value="<?= $data['merk_laptop'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?= $data['serial_number'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kondisi">Kondisi</label>
                            <textarea class="form-control" id="kondisi" name="kondisi" required><?= $data['kondisi'] ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="tanggal_peminjaman" name="tanggal_peminjaman" value="<?= $data['tanggal_peminjaman'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="<?= $data['tanggal_pengembalian'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_peminjaman">Status Peminjaman</label>
                            <select class="form-select" id="status_peminjaman" name="status_peminjaman" required>
                                <option value="Dipinjam" <?= $data['status_peminjaman'] == 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                                <option value="Dikembalikan" <?= $data['status_peminjaman'] == 'Dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</div>
