<?php 
include "./function/koneksi.php";

// Initialize variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Handle data retrieval
try {
    // Use prepared statements to avoid SQL Injection
    if ($statusFilter == 'Semua') {
        $stmt = $conn->prepare("SELECT * FROM elektronik");
    } else {
        $stmt = $conn->prepare("SELECT * FROM elektronik WHERE status_peminjaman = ?");
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
?>

<div class="page-heading">
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Elektornik</h3>
                <p class="text-subtitle text-muted">
                    Halaman Tampil Data
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=kontak">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Lihat Data Elektornik
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div> 


    <div class="d-flex justify-content-between mb-3">
        <div>
            <script>
                document.getElementById('printButton').addEventListener('click', function() {
                    window.open('print_elektronik.php?status=<?= urlencode($statusFilter) ?>', '_blank');
                });
            </script>
        </div>
        <div>

        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-10">
                <a href="index.php?halaman=tambah_elektronik" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                <a href="javascript:void(0)" class="btn btn-success btn-sm mb-3" id="printButton"><i class="bi bi-file-earmark-pdf"></i> Print PDF</a>
            </div>   
            <div class="col-2">
                <select onchange="window.location.href=this.value" class="form-select" aria-label="Status Filter">
                    <option value="index.php?halaman=elektronik&status=Semua" <?= $statusFilter == 'Semua' ? 'selected' : '' ?>>Semua</option>
                    <option value="index.php?halaman=elektronik&status=Dipinjam" <?= $statusFilter == 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                    <option value="index.php?halaman=elektronik&status=Dikembalikan" <?= $statusFilter == 'Dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
                </select>
            </div>  
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered" id="table">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Peminjam</th>
                            <th>No Telepon</th>
                            <th>Merk Laptop</th>
                            <th>Serial Number</th>
                            <th>Kondisi</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status Peminjaman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($count > 0) : ?>
                            <?php $i = 1; ?>
                            <?php while ($data = $query->fetch_assoc()) : ?>
                                <tr onclick="window.location='https://example.com/profile/1'">
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($data['nama_peminjam']) ?></td>
                                    <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                                    <td><?= htmlspecialchars($data['merk_laptop']) ?></td>
                                    <td><?= htmlspecialchars($data['serial_number']) ?></td>
                                    <td><?= htmlspecialchars($data['kondisi']) ?></td>
                                    <td><?= htmlspecialchars($data['tanggal_peminjaman']) ?></td>
                                    <td><?= htmlspecialchars($data['tanggal_pengembalian']) ?></td>
                                    <td><?= htmlspecialchars($data['status_peminjaman']) ?></td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" href="index.php?halaman=ubah_elektronik&id=<?= $data['id'] ?>" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm mt-1" href="index.php?halaman=hapus_elektronik&id=<?= $data['id'] ?>" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data elektronik.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                </div>
                
            </div>
        </div>
    </section>
</div>

<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script>
    let table = document.querySelector('#table');
    let dataTable = new simpleDatatables.DataTable(table, {
        sortable: false
    });
</script>
