<?php
include "./function/koneksi.php";

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_POST['submit'])) {
        // Mengambil dan membersihkan input dari form
        $pemakai = htmlspecialchars($_POST['pemakai']);
        $no_telepon = htmlspecialchars($_POST['no_telepon']);
        $merk = htmlspecialchars($_POST['merk']);
        $no_plat = htmlspecialchars($_POST['no_plat']);
        $tipe = htmlspecialchars($_POST['tipe']);
        $tahun_pembuatan = htmlspecialchars($_POST['tahun_pembuatan']);
        $harga_pembelian = htmlspecialchars($_POST['harga_pembelian']);
        $harga_pajak = htmlspecialchars($_POST['harga_pajak']);
        $status_pajak = htmlspecialchars($_POST['status_pajak']);
        $tenggat_pajak = htmlspecialchars($_POST['tenggat_pajak']);
        
        // Handling file upload untuk bukti pembayaran
        $bukti_pembayaran = "";
        if ($_FILES['bukti_pembayaran']['name']) {
            $target_dir = "uploads/";
            $file_name = basename($_FILES["bukti_pembayaran"]["name"]);
            $target_file = $target_dir . time() . '_' . $file_name; // Membuat nama file unik
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Memeriksa apakah file yang diupload adalah gambar
            $check = getimagesize($_FILES["bukti_pembayaran"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File bukan gambar.";
                $uploadOk = 0;
            }

            // Hanya memperbolehkan format gambar tertentu
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Maaf, hanya file JPG, JPEG, dan PNG yang diperbolehkan.";
                $uploadOk = 0;
            }

            // Jika tidak ada error, upload file
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
                    $bukti_pembayaran = $target_file; // Simpan path file ke database
                } else {
                    echo "Maaf, terjadi kesalahan saat mengupload file.";
                }
            }
        }

        // Menggunakan prepared statement untuk mencegah SQL injection
        $stmt = $conn->prepare("INSERT INTO kendaraan (pemakai, no_telepon, no_plat, merk, tipe, tahun_pembuatan, harga_pembelian, harga_pajak, status_pajak, tenggat_pajak, bukti_pembayaran) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");        
        $stmt->bind_param(
            'ssssssddsss',
            $pemakai,
            $no_telepon,
            $no_plat,
            $merk,
            $tipe,
            $tahun_pembuatan,
            $harga_pembelian,
            $harga_pajak,
            $status_pajak,
            $tenggat_pajak,
            $bukti_pembayaran
        );

        // Menampilkan hasil sukses atau gagal
        if ($stmt->execute()) {
            $message = "Berhasil menambahkan data";
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
                window.location.href = 'index.php?halaman=kendaraan';
            })
            </script>
            ";
        } else {
            $message = "Gagal menambahkan data";
            $error = true;
        }
    }
} catch (Exception $e) {
    $error = true;
    $message = "Terjadi kesalahan: " . $e->getMessage();
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Kendaraan</h3>
                <p class="text-subtitle text-muted">Halaman untuk menambahkan data kendaraan baru</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Kendaraan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <?php if ($error) : ?>
                    <div class="alert alert-danger"><?= $message ?></div>
                <?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pemakai">Pemakai</label>
                            <input type="text" class="form-control" name="pemakai" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_plat">Plat Nomor</label>
                            <input type="text" class="form-control" name="no_plat" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipe">Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <option value="Motor">Motor</option>
                                <option value="Mobil">Mobil</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun_pembuatan">Tahun Pembuatan</label>
                            <input type="number" class="form-control" name="tahun_pembuatan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_pembelian">Harga Pembelian</label>
                            <input type="number" class="form-control" name="harga_pembelian" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_pajak">Harga Pajak</label>
                            <input type="number" class="form-control" name="harga_pajak" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_pajak">Status Pajak</label>
                            <select name="status_pajak" class="form-control" required>
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tenggat_pajak">Tenggat Pajak</label>
                            <input type="date" class="form-control" name="tenggat_pajak" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bukti_pembayaran">Bukti Pembayaran (Foto)</label>
                            <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*" required>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?halaman=kendaraan" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
