<?php
include "./function/koneksi.php";
include "./function/log.php";

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_POST['submit'])) {
        // Mengambil dan membersihkan input dari form
        $merk = htmlspecialchars($_POST['merk']);
        $no_plat = htmlspecialchars($_POST['no_plat']);
        $tipe = htmlspecialchars($_POST['tipe']);
        $tahun_pembuatan = htmlspecialchars($_POST['tahun_pembuatan']);
        $pemakai = htmlspecialchars($_POST['pemakai']);

        // Debug: menampilkan data input
        var_dump($merk, $no_plat, $tipe, $tahun_pembuatan, $pemakai);

        // Menggunakan prepared statement untuk menghindari SQL injection
        $stmt = $conn->prepare("INSERT INTO kendaraan (no_plat, merk, tipe, tahun_pembuatan, pemakai) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $no_plat, $merk, $tipe, $tahun_pembuatan, $pemakai);

        // Eksekusi statement
        if ($stmt->execute()) {
            $lastInsertedId = $stmt->insert_id; // Ambil ID data baru
            $pengguna = !isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'];

            // Log data baru
            $baru = (                
                "Merk = ". $merk .  
                "\n Nomor Plat = ". $no_plat .  
                "\n Tipe = ". $tipe .  
                "\n Tahun Pembuatan = ". $tahun_pembuatan . 
                "\n Pemakai = ". $pemakai  
            );

            // Log histori untuk aksi 'INSERT'
            logHistori('kendaraan', $lastInsertedId, 'Tambah Data', null, $baru, $pengguna);

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
                window.location.href = 'index.php?halaman=kendaraan';
            })
            </script>
            ";
        } else {
            $message = "Gagal menambahkan data: " . $stmt->error;
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
                window.location.href = 'index.php?halaman=kendaraan';
            })
            </script>
            ";
        }

        // Menutup statement
        $stmt->close();
    }
} catch (Throwable $th) {
    echo "
    <script>
    Swal.fire({
        title: 'Gagal',
        text: 'Server error: " . $th->getMessage() . "',
        icon: 'error',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    }).then(() => {
        window.location.href = 'index.php?halaman=kendaraan';
    })
    </script>
    ";
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kendaraan</h3>
                <p class="text-subtitle text-muted">
                    Halaman Tambah Data
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=kendaraan">Kendaraan</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah Data Kendaraan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <a href="index.php?halaman=kendaraan" class="btn btn-primary btn-sm mb-3">Kembali</a>
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="merk" placeholder="Merk Kendaraan" name="merk" required>
                        <label for="merk">Merk Kendaraan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="no_plat" placeholder="Nomor Plat" name="no_plat" required>
                        <label for="no_plat">Nomor Plat</label>
                    </div>
                    <div class="dropdown mb-3">
                        <select class="form-select" id="tipe" name="tipe" required>
                            <option value="Mobil">Mobil</option>
                            <option value="Motor">Motor</option>
                        </select>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="tahun_pembuatan" placeholder="Tahun Pembuatan" name="tahun_pembuatan" required>
                        <label for="tahun_pembuatan">Tahun Pembuatan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="pemakai" placeholder="Nama Pemakai" name="pemakai" required>
                        <label for="pemakai">Nama Pemakai</label>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
