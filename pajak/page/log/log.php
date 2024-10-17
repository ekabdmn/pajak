<?php
include "./function/koneksi.php";
include "./function/log.php";

$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Semua';

try {
    // Use prepared statements to avoid SQL Injection
    if ($statusFilter == 'Semua') {
        // Menambahkan ORDER BY untuk mengurutkan data berdasarkan tanggal
        $stmt = $conn->prepare("SELECT * FROM log_histori ORDER BY tanggal DESC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM log_histori WHERE nama_tabel = ? ORDER BY tanggal DESC");

        $stmt->bind_param('s', $statusFilter);
    }

    $stmt->execute();
    $query = $stmt->get_result();
    $count = $query->num_rows;

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
        })
        </script>
    ";
}

// Pastikan statement ditutup setelah selesai digunakan
$stmt->close();
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Log Histori</h2>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th type="button" value="index.php?halaman=log_history&status=Semua">Nama Tabel</th>
                                <th>Aksi</th>
                                <th>Data Lama</th>
                                <th>Data Baru</th>
                                <th>Pengguna</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($count > 0) : ?>
                                <?php $i = 1; ?>
                                <?php $data_log = mysqli_fetch_all($query, MYSQLI_ASSOC); ?>
                                <?php foreach ($data_log as $value) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($value['nama_tabel']) ?></td>
                                        <td><?= htmlspecialchars($value['aksi']) ?></td>
                                        <td><?= htmlspecialchars($value['data_lama']) ?></td>
                                        <td><?= htmlspecialchars($value['data_baru']) ?></td>
                                        <td><?= htmlspecialchars($value['pengguna']) ?></td>
                                        <td><?= htmlspecialchars($value['tanggal']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data log</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
