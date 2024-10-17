<?php 
include "./function/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("DELETE FROM pemeliharaan_elektronik WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "
        <script>
            Swal.fire({
                title: 'Berhasil',
                text: 'Data pemeliharaan elektronik berhasil dihapus!',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(function() {
                window.location.href = 'index.php?halaman=pemeliharaan_elektronik';
            });
        </script>
        ";
    } else {
        echo "
        <script>
            Swal.fire({
                title: 'Gagal',
                text: 'Gagal menghapus data pemeliharaan elektronik!',
                icon: 'error',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        </script>
        ";
    }

    $stmt->close();
    $conn->close();
}
?>
