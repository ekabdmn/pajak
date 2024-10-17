<?php
include "./function/koneksi.php";

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_POST['submit'])) {
        // Mengambil dan membersihkan input dari form
        $nama_pemelihara = htmlspecialchars($_POST['nama_pemelihara']);
        $no_telepon = htmlspecialchars($_POST['no_telepon']);
        $jenis_kendaraan = htmlspecialchars($_POST['jenis_kendaraan']);
        $plat_nomor = htmlspecialchars($_POST['plat_nomor']);
        $kondisi_sebelum = htmlspecialchars($_POST['kondisi_sebelum']);
        $kondisi_setelah = htmlspecialchars($_POST['kondisi_setelah']);
        $tanggal_pemeliharaan = htmlspecialchars($_POST['tanggal_pemeliharaan']);
        $biaya_pemeliharaan = htmlspecialchars($_POST['biaya_pemeliharaan']);
        $keterangan = htmlspecialchars($_POST['keterangan']);
        $status_pemeliharaan = htmlspecialchars($_POST['status_pemeliharaan']); // New field for status
        
        // Mengunggah bukti pemeliharaan
        $bukti = $_FILES['bukti']['name'];
        $tmp_bukti = $_FILES['bukti']['tmp_name'];
        $folder = "./uploads/";

        // Memindahkan file ke folder tujuan
        if (move_uploaded_file($tmp_bukti, $folder . $bukti)) {
            // Menggunakan prepared statement untuk menghindari SQL injection
            $stmt = $conn->prepare("INSERT INTO pemeliharaan_kendaraan (nama_pemelihara, no_telepon, jenis_kendaraan, plat_nomor, kondisi_sebelum, kondisi_setelah, tanggal_pemeliharaan, biaya_pemeliharaan, keterangan, bukti, status_pemeliharaan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param(
                'sssssssssss',
                $nama_pemelihara,
                $no_telepon,
                $jenis_kendaraan,
                $plat_nomor,
                $kondisi_sebelum,
                $kondisi_setelah,
                $tanggal_pemeliharaan,
                $biaya_pemeliharaan,
                $keterangan,
                $bukti,
                $status_pemeliharaan // Bind status field
            );

            // Menampilkan hasil sukses atau gagal
            if ($stmt->execute()) {
                $message = "Berhasil menambahkan data pemeliharaan";
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
                    window.location.href = 'index.php?halaman=pemeliharaan';
                })
                </script>
                ";
            } else {
                $message = "Gagal menambahkan data";
                $error = true;
            }
        } else {
            $message = "Gagal mengunggah bukti";
            $error = true;
        }
    }
} catch (Exception $e) {
    $error = true;
    $message = "Terjadi kesalahan: " . $e->getMessage();
}
?>

<div class="page-heading">
    <h3>Tambah Data Pemeliharaan Kendaraan</h3>

    <div class="card">
        <div class="card-body">
            <?php if ($error) : ?>
                <div class="alert alert-danger"><?= $message ?></div>
            <?php endif; ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_pemelihara">Nama Pemelihara</label>
                        <input type="text" class="form-control" name="nama_pemelihara" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_telepon">No Telepon</label>
                        <input type="text" class="form-control" name="no_telepon" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kendaraan">Jenis Kendaraan</label>
                        <input type="text" class="form-control" name="jenis_kendaraan" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="plat_nomor">Plat Nomor</label>
                        <input type="text" class="form-control" name="plat_nomor" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kondisi_sebelum">Kondisi Sebelum Pemeliharaan</label>
                        <textarea class="form-control" name="kondisi_sebelum" required></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kondisi_setelah">Kondisi Setelah Pemeliharaan</label>
                        <textarea class="form-control" name="kondisi_setelah" required></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_pemeliharaan">Tanggal Pemeliharaan</label>
                        <input type="date" class="form-control" name="tanggal_pemeliharaan" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="biaya_pemeliharaan">Biaya Pemeliharaan</label>
                        <input type="text" class="form-control" name="biaya_pemeliharaan" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" required></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bukti">Bukti Pemeliharaan (Foto/Scan)</label>
                        <input type="file" class="form-control" name="bukti" accept="image/*" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status_pemeliharaan">Status Pemeliharaan</label>
                        <select class="form-control" name="status_pemeliharaan" required>
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
