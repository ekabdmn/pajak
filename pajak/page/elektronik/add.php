<?php
include "./function/koneksi.php";
include "./function/log.php";

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_POST['submit'])) {
        // Mengambil dan membersihkan input dari form
        $nama_peminjam = htmlspecialchars($_POST['nama_peminjam']);
        $no_telepon = htmlspecialchars($_POST['no_telepon']);
        $merk_laptop = htmlspecialchars($_POST['merk_laptop']);
        $serial_number = htmlspecialchars($_POST['serial_number']);
        $kondisi = htmlspecialchars($_POST['kondisi']);
        $tanggal_peminjaman = htmlspecialchars($_POST['tanggal_peminjaman']);
        $tanggal_pengembalian = htmlspecialchars($_POST['tanggal_pengembalian']);
        $status_peminjaman = htmlspecialchars($_POST['status_peminjaman']);

        // Menggunakan prepared statement untuk menghindari SQL injection
        $stmt = $conn->prepare(
            "INSERT INTO elektronik (nama_peminjam, no_telepon, merk_laptop, serial_number, kondisi, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            'ssssssss',
            $nama_peminjam,
            $no_telepon,
            $merk_laptop,
            $serial_number,
            $kondisi,
            $tanggal_peminjaman,
            $tanggal_pengembalian,
            $status_peminjaman
        );
        
        // Menampilkan hasil sukses atau gagal
        if ($stmt->execute()) {
            $id_data = $conn->insert_id;
            $pengguna=!isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'];
            kelolaLogHistori($conn);
             $baru = (                
                "nama peminjam = ". $nama_peminjam .  
                "\n no telepon = ". $no_telepon.  
                "\n merk laptop = ". $merk_laptop.  
                "\n serial number = ". $serial_number. 
                "\n kondisi = ". $kondisi. 
                "\n tanggal peminjaman = ". $tanggal_peminjaman. 
                "\n tanggal pengembalian = ". $tanggal_pengembalian. 
                "\n status peminjaman = ". $status_peminjaman  
            );
            // Log histori untuk aksi 'INSERT'
            logHistori('elektronik', $id_data, 'Tambah Data', null,$baru, $pengguna);

            
            // Pesan sukses
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
                    window.location.href = 'index.php?halaman=elektronik';
                });
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
    <h3>Tambah Data Elektronik</h3>

    <div class="card">
        <div class="card-body">
            <?php if ($error) : ?>
                <div class="alert alert-danger"><?= $message ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_peminjam">Nama Peminjam</label>
                        <input type="text" class="form-control" name="nama_peminjam" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_telepon">No Telepon</label>
                        <input type="text" class="form-control" name="no_telepon" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="merk_laptop">Merk Laptop</label>
                        <input type="text" class="form-control" name="merk_laptop" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="serial_number">Serial Number</label>
                        <input type="text" class="form-control" name="serial_number" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kondisi">Kondisi</label>
                        <textarea class="form-control" name="kondisi" required></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
                        <input type="date" class="form-control" name="tanggal_peminjaman" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                        <input type="date" class="form-control" name="tanggal_pengembalian" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status_peminjaman">Status Peminjaman</label>
                        <select class="form-select" name="status_peminjaman" required>
                            <option value="Dipinjam">Dipinjam</option>
                            <option value="Dikembalikan">Dikembalikan</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
