<?php
include "./function/koneksi.php";

if (!isset($_SESSION['nama'])) {
    header('Location: index.php?halaman=login');
}

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Select Data
        $select = mysqli_query($conn, "SELECT * FROM pemeliharaan_kendaraan WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=pemeliharaan');
        }

        // Submit
        if (isset($_POST['submit'])) {
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

            // If a new file is uploaded
            if (!empty($bukti)) {
                move_uploaded_file($tmp_bukti, $folder . $bukti);
                $query = mysqli_query($conn, "UPDATE pemeliharaan_kendaraan SET 
                    nama_pemelihara = '$nama_pemelihara',
                    no_telepon = '$no_telepon',
                    jenis_kendaraan = '$jenis_kendaraan',
                    plat_nomor = '$plat_nomor',
                    kondisi_sebelum = '$kondisi_sebelum',
                    kondisi_setelah = '$kondisi_setelah',
                    tanggal_pemeliharaan = '$tanggal_pemeliharaan',
                    biaya_pemeliharaan = '$biaya_pemeliharaan',
                    keterangan = '$keterangan',
                    status_pemeliharaan = '$status_pemeliharaan',
                    bukti = '$bukti'
                    WHERE id = '$id'");
            } else {
                // Update without changing the file
                $query = mysqli_query($conn, "UPDATE pemeliharaan_kendaraan SET 
                    nama_pemelihara = '$nama_pemelihara',
                    no_telepon = '$no_telepon',
                    jenis_kendaraan = '$jenis_kendaraan',
                    plat_nomor = '$plat_nomor',
                    kondisi_sebelum = '$kondisi_sebelum',
                    kondisi_setelah = '$kondisi_setelah',
                    tanggal_pemeliharaan = '$tanggal_pemeliharaan',
                    biaya_pemeliharaan = '$biaya_pemeliharaan',
                    keterangan = '$keterangan',
                    status_pemeliharaan = '$status_pemeliharaan'
                    WHERE id = '$id'");
            }

            if ($query) {
                $message = "Berhasil mengubah data pemeliharaan";
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
                    window.location.href = 'index.php?halaman=pemeliharaan';
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
        window.location.href = 'index.php?halaman=pemeliharaan';
    })
    </script>
    ";
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Ubah Data Pemeliharaan Kendaraan</h3>
                <p class="text-subtitle text-muted">
                    Halaman untuk mengubah data pemeliharaan kendaraan.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=pemeliharaan">Pemeliharaan</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Ubah Data Pemeliharaan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <a href="index.php?halaman=pemeliharaan" class="btn btn-primary btn-sm mb-3">Kembali</a>
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pemelihara">Nama Pemelihara</label>
                            <input type="text" class="form-control" id="nama_pemelihara" name="nama_pemelihara" value="<?= $data['nama_pemelihara'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?= $data['no_telepon'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" value="<?= $data['jenis_kendaraan'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="plat_nomor">Plat Nomor</label>
                            <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" value="<?= $data['plat_nomor'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kondisi_sebelum">Kondisi Sebelum Pemeliharaan</label>
                            <textarea class="form-control" id="kondisi_sebelum" name="kondisi_sebelum" required><?= $data['kondisi_sebelum'] ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kondisi_setelah">Kondisi Setelah Pemeliharaan</label>
                            <textarea class="form-control" id="kondisi_setelah" name="kondisi_setelah" required><?= $data['kondisi_setelah'] ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pemeliharaan">Tanggal Pemeliharaan</label>
                            <input type="date" class="form-control" id="tanggal_pemeliharaan" name="tanggal_pemeliharaan" value="<?= $data['tanggal_pemeliharaan'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="biaya_pemeliharaan">Biaya Pemeliharaan</label>
                            <input type="text" class="form-control" id="biaya_pemeliharaan" name="biaya_pemeliharaan" value="<?= $data['biaya_pemeliharaan'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" required><?= $data['keterangan'] ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_pemeliharaan">Status Pemeliharaan</label>
                            <select class="form-control" id="status_pemeliharaan" name="status_pemeliharaan" required>
                                <option value="Lunas" <?= $data['status_pemeliharaan'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                                <option value="Belum Lunas" <?= $data['status_pemeliharaan'] == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bukti">Bukti Pemeliharaan (Foto/Scan)</label>
                            <input type="file" class="form-control" id="bukti" name="bukti" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</div>
