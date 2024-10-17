<?php
include "./function/koneksi.php";
include "./function/log.php";

// Memastikan pengguna sudah login
if (!isset($_SESSION['nama'])) {
    header('Location: index.php?halaman=login');
    exit();
}

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepared statement untuk SELECT, mencegah SQL injection
        $stmtSelect = $conn->prepare("SELECT * FROM kendaraan WHERE id = ?");
        $stmtSelect->bind_param('i', $id);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {
            header('Location: index.php?halaman=kendaraan');
            exit();
        }

        // Submit
        if (isset($_POST['submit'])) {
            $pemakai = htmlspecialchars($_POST['pemakai']);
            

            // Prepared statement untuk UPDATE
            $stmtUpdate = $conn->prepare("UPDATE kendaraan SET pemakai = ? WHERE id = ?");
            $stmtUpdate->bind_param('si', $pemakai, $id);
                $data_lama = implode("\n", [
                'Pemakai = ' . htmlspecialchars($data['pemakai']),
                // Tambahkan field lain yang relevan
            ]);

            // Prepared statement untuk UPDATE


            if ($stmtUpdate->execute()) {
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
                    window.location.href = 'index.php?halaman=kendaraan';
                })
                </script>
                ";
                    // Menyimpan data baru untuk log
                    $data_baru = implode("\n", [
                        'Pemakai = ' . $pemakai,
                        // Tambahkan field lain yang relevan
                    ]);
    
                    // Log histori untuk aksi 'UPDATE'
                    $pengguna = $_SESSION['nama'];
                    logHistori('kendaraan', $id, 'Ubah Data', $data_lama, $data_baru, $pengguna);   
            } else {
                // Jika gagal, tampilkan pesan gagal dan tulis ke log
                $message = "Gagal mengubah data";
                error_log("Error UPDATE: " . $stmtUpdate->error, 3, "error_log.txt");
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
            $stmtUpdate->close();
        }

        // Menutup statement SELECT
        $stmtSelect->close();
    }
} catch (Exception $e) {
    // Catat error ke log jika ada pengecualian
    error_log("Exception: " . $e->getMessage(), 3, "error_log.txt");
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
        window.location.href = 'index.php?halaman=kendaraan';
    })
    </script>
    ";
}

// Tutup koneksi database
$conn->close();
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kendaraan</h3>
                <p class="text-subtitle text-muted">
                    Halaman Ubah Data kendaraan
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=kendaraan">Kendaraan</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Ubah Data Kendaraan
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
                        <input type="text" class="form-control" id="nama" placeholder="John Doe" name="pemakai" value="<?= htmlspecialchars($data['pemakai']) ?>" required>
                        <label for="nama">Ubah Nama Pemakai</label>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
