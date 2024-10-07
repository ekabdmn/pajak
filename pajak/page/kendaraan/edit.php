<?php
include "./function/koneksi.php";

if (!isset($_SESSION['nama'])) {
    header('Location: index.php?halaman=login');
}


try {
    $message = "";
    $success = FALSE;
    $error = FALSE;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Select Data
        $select = mysqli_query($conn, "SELECT * FROM kendaraan WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=kendaraan');
        }

        // Submit
        if (isset($_POST['submit'])) {
            $pemakai = htmlspecialchars($_POST['pemakai']);

            $query = mysqli_query($conn, "UPDATE kendaraan SET pemakai = '$pemakai' WHERE id = '$id'");

            if ($query == TRUE) {
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
                window.location.href = 'index.php?halaman=kendaraan';
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
                        <input type="text" class="form-control" id="nama" placeholder="John Doe" name="pemakai" value="<?= $data['pemakai'] ?>" required>
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