<?php
include "./function/koneksi.php";

try {
    $message = "";
    $success = false;
    $error = false;

    // Memastikan ID kendaraan tersedia
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Mengambil data kendaraan dari database
        $stmt = $conn->prepare("SELECT * FROM kendaraan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika data ditemukan
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            $message = "Data tidak ditemukan.";
            $error = true;
        }
    } else {
        $message = "ID tidak tersedia.";
        $error = true;
    }

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

        // Handling file upload untuk bukti pembayaran (opsional)
        $bukti_pembayaran = $data['bukti_pembayaran']; // Mengambil nilai lama
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

        // Menggunakan prepared statement untuk memperbarui data
        $stmt = $conn->prepare("UPDATE kendaraan SET pemakai=?, no_telepon=?, no_plat=?, merk=?, tipe=?, tahun_pembuatan=?, harga_pembelian=?, harga_pajak=?, status_pajak=?, tenggat_pajak=?, bukti_pembayaran=? WHERE id=?");
        $stmt->bind_param(
            'ssssssddsssi',
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
            $bukti_pembayaran,
            $id
        );

        // Menampilkan hasil sukses atau gagal
        if ($stmt->execute()) {
            $message = "Berhasil mengedit data";
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
            $message = "Gagal mengedit data";
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
                <h3>Edit Data Kendaraan</h3>
                <p class="text-subtitle text-muted">Halaman untuk mengedit data kendaraan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Data Kendaraan</li>
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
                            <input type="text" class="form-control" name="pemakai" value="<?= $data['pemakai'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" value="<?= $data['no_telepon'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_plat">Plat Nomor</label>
                            <input type="text" class="form-control" name="no_plat" value="<?= $data['no_plat'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" value="<?= $data['merk'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipe">Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <option value="Motor" <?= $data['tipe'] == 'Motor' ? 'selected' : '' ?>>Motor</option>
                                <option value="Mobil" <?= $data['tipe'] == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun_pembuatan">Tahun Pembuatan</label>
                            <input type="number" class="form-control" name="tahun_pembuatan" value="<?= $data['tahun_pembuatan'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_pembelian">Harga Pembelian</label>
                            <input type="number" class="form-control" name="harga_pembelian" value="<?= $data['harga_pembelian'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_pajak">Harga Pajak</label>
                            <input type="number" class="form-control" name="harga_pajak" value="<?= $data['harga_pajak'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_pajak">Status Pajak</label>
                            <select name="status_pajak" class="form-control" required>
                                <option value="Lunas" <?= $data['status_pajak'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                                <option value="Belum Lunas" <?= $data['status_pajak'] == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tenggat_pajak">Tenggat Pajak</label>
                            <input type="date" class="form-control" name="tenggat_pajak" value="<?= $data['tenggat_pajak'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bukti_pembayaran">Bukti Pembayaran (opsional)</label>
                            <input type="file" class="form-control" name="bukti_pembayaran">
                            <?php if ($data['bukti_pembayaran']): ?>
                                <small>File Saat Ini: <a href="<?= $data['bukti_pembayaran'] ?>" target="_blank">Lihat Bukti</a></small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </section>
</div>

