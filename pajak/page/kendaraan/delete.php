<?php
include "./function/koneksi.php";
include "./page/log/log.php"; // Pastikan Anda menyertakan file ini untuk fungsi logHistori

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
            // Redirect jika data tidak ditemukan
            header('Location: index.php?halaman=kendaraan');
            exit();
        }

        // Menyusun informasi lama untuk log
        $data_lama = implode("\n", [
            'Merk = ' . htmlspecialchars($data['merk']),
            'No Plat = ' . htmlspecialchars($data['no_plat']),
            'Tipe = ' . htmlspecialchars($data['tipe']),
            'Tahun Pembuatan = ' . htmlspecialchars($data['tahun_pembuatan']),
            'Pemakai = ' . htmlspecialchars($data['pemakai']),
        ]);

        // Catat log sebelum menghapus
        $pengguna = !isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'];
        logHistori('kendaraan', $id, 'Hapus Data', $data_lama, null, $pengguna); // Menggunakan logHistori

        // Prepared statement untuk DELETE, mencegah SQL injection
        $stmtDelete = $conn->prepare("DELETE FROM kendaraan WHERE id = ?");
        $stmtDelete->bind_param('i', $id);

        if ($stmtDelete->execute()) {
            $message = "Berhasil menghapus data";
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
            // Jika gagal, tampilkan pesan gagal dan tulis ke log
            $message = "Gagal menghapus data";
            error_log("Error DELETE: " . $stmtDelete->error, 3, "error_log.txt");
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
        $stmtSelect->close();
        $stmtDelete->close();
    } else {
        $message = "ID tidak ditemukan";
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
