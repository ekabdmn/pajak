<?php
include "./function/koneksi.php";

// Fetch the data based on the ID
$id = isset($_GET['id']) ? $_GET['id'] : 0;
try {
    $stmt = $conn->prepare("SELECT * FROM pemeliharaan_elektronik WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        throw new Exception("Data tidak ditemukan.");
    }

    $message = "";
    $error = false;

    if (isset($_POST['submit'])) {
        // Mengambil dan membersihkan input dari form
        $nama_perangkat = htmlspecialchars($_POST['nama_perangkat']);
        $merk = htmlspecialchars($_POST['merk']);
        $tipe = htmlspecialchars($_POST['tipe']);
        $deskripsi = htmlspecialchars($_POST['deskripsi']);
        $tanggal_pemeliharaan = htmlspecialchars($_POST['tanggal_pemeliharaan']);
        $biaya_pemeliharaan = htmlspecialchars($_POST['biaya_pemeliharaan']);
        $teknisi = htmlspecialchars($_POST['teknisi']);
        $nama_pengguna = htmlspecialchars($_POST['nama_pengguna']);
        $no_telepon_pengguna = htmlspecialchars($_POST['no_telepon_pengguna']);
        $status = htmlspecialchars($_POST['status']);
        
        // Handling file upload for the payment receipt
        $bukti_pembayaran = $data['bukti_pembayaran'];
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

        // Update data with the provided values
        $stmt = $conn->prepare("UPDATE pemeliharaan_elektronik SET nama_perangkat = ?, merk = ?, tipe = ?, deskripsi = ?, tanggal_pemeliharaan = ?, biaya_pemeliharaan = ?, teknisi = ?, nama_pengguna = ?, no_telepon_pengguna = ?, status = ?, bukti_pembayaran = ? WHERE id = ?");
        $stmt->bind_param(
            'sssssdsssssi',
            $nama_perangkat,
            $merk,
            $tipe,
            $deskripsi,
            $tanggal_pemeliharaan,
            $biaya_pemeliharaan,
            $teknisi,
            $nama_pengguna,
            $no_telepon_pengguna,
            $status,
            $bukti_pembayaran,
            $id
        );

        // Menampilkan hasil sukses atau gagal
        if ($stmt->execute()) {
            $message = "Berhasil memperbarui data";
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
                window.location.href = 'index.php?halaman=pemeliharaan_elektronik';
            })
            </script>
            ";
        } else {
            $message = "Gagal memperbarui data";
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
                <h3>Edit Pemeliharaan Elektronik</h3>
                <p class="text-subtitle text-muted">Form untuk memperbarui data pemeliharaan elektronik</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Pemeliharaan Elektronik</li>
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
                            <label for="nama_perangkat">Nama Perangkat</label>
                            <input type="text" class="form-control" name="nama_perangkat" value="<?= htmlspecialchars($data['nama_perangkat']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" value="<?= htmlspecialchars($data['merk']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipe">Tipe</label>
                            <input type="text" class="form-control" name="tipe" value="<?= htmlspecialchars($data['tipe']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pemeliharaan">Tanggal Pemeliharaan</label>
                            <input type="date" class="form-control" name="tanggal_pemeliharaan" value="<?= htmlspecialchars($data['tanggal_pemeliharaan']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="deskripsi">Deskripsi Pemeliharaan</label>
                            <textarea class="form-control" name="deskripsi" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="biaya_pemeliharaan">Biaya Pemeliharaan</label>
                            <input type="number" class="form-control" name="biaya_pemeliharaan" value="<?= htmlspecialchars($data['biaya_pemeliharaan']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="teknisi">Teknisi</label>
                            <input type="text" class="form-control" name="teknisi" value="<?= htmlspecialchars($data['teknisi']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_pengguna">Nama Pengguna</label>
                            <input type="text" class="form-control" name="nama_pengguna" value="<?= htmlspecialchars($data['nama_pengguna']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon_pengguna">No Telepon Pengguna</label>
                            <input type="text" class="form-control" name="no_telepon_pengguna" value="<?= htmlspecialchars($data['no_telepon_pengguna']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Selesai" <?= $data['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                <option value="Dalam Proses" <?= $data['status'] == 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
                                <option value="Dibatalkan" <?= $data['status'] == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bukti_pemeliharaan">Bukti Pembayaran (Foto)</label>
                            <input type="file" class="form-control" name="bukti_pembayaran" accept="image/*">
                            <?php if ($data['bukti_pembayaran']): ?>
                                <p>File Saat Ini: <a href="<?= $data['bukti_pembayaran'] ?>" target="_blank"><?= basename($data['bukti_pembayaran']) ?></a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?halaman=pemeliharaan" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
