<?php
include "./function/koneksi.php";

// Initialize variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Handle data retrieval
try {
    if ($statusFilter == 'Semua') {
        $stmt = $conn->prepare("SELECT * FROM pemeliharaan_elektronik ORDER BY tanggal_pemeliharaan DESC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM pemeliharaan_elektronik WHERE status = ? ORDER BY tanggal_pemeliharaan DESC");
        $stmt->bind_param('s', $statusFilter);
    }

    $stmt->execute();
    $query = $stmt->get_result();
    $count = $query->num_rows;

} catch (Exception $e) {
    echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Terjadi kesalahan: {$e->getMessage()}',
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
                <h3>Data Pemeliharaan Elektronik</h3>
                <p class="text-subtitle text-muted">Halaman Tampil Data Pemeliharaan Elektronik</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pemeliharaan Elektronik</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="index.php?halaman=tambah_pemeliharaan_elektronik" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
                <a href="javascript:void(0)" class="btn btn-success btn-sm" id="printButton">
                    <i class="bi bi-file-earmark-pdf"></i> Print PDF
                </a>
                <script>
                    document.getElementById('printButton').addEventListener('click', function () {
                        window.open('print_pemeliharaan.php?status=<?= urlencode($statusFilter) ?>', '_blank');
                    });
                </script>
            </div>
            <div>
                <select onchange="window.location.href=this.value" class="form-select" aria-label="Status Filter">
                    <option value="index.php?halaman=pemeliharaan&status=Semua" <?= $statusFilter == 'Semua' ? 'selected' : '' ?>>Semua</option>
                    <option value="index.php?halaman=pemeliharaan&status=Selesai" <?= $statusFilter == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="index.php?halaman=pemeliharaan&status=Dalam Proses" <?= $statusFilter == 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
                    <option value="index.php?halaman=pemeliharaan&status=Dibatalkan" <?= $statusFilter == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
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
                                <th>Nama Perangkat</th>
                                <th>Merk</th>
                                <th>Tipe</th>
                                <th>Tanggal Pemeliharaan</th>
                                <th>Deskripsi</th>
                                <th>Biaya Pemeliharaan</th>
                                <th>Teknisi</th>
                                <th>Nama Pengguna</th>
                                <th>No Telepon Pengguna</th>
                                <th>Status</th>
                                <th>Bukti Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($count > 0): ?>
                                <?php $i = 1; ?>
                                <?php while ($data = $query->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($data['nama_perangkat']) ?></td>
                                        <td><?= htmlspecialchars($data['merk']) ?></td>
                                        <td><?= htmlspecialchars($data['tipe']) ?></td>
                                        <td><?= htmlspecialchars($data['tanggal_pemeliharaan']) ?></td>
                                        <td><?= htmlspecialchars($data['deskripsi']) ?></td>
                                        <td>Rp <?= number_format($data['biaya_pemeliharaan'], 2, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($data['teknisi']) ?></td>
                                        <td><?= htmlspecialchars($data['nama_pengguna']) ?></td>
                                        <td><?= htmlspecialchars($data['no_telepon_pengguna']) ?></td>
                                        <td><?= htmlspecialchars($data['status']) ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('<?= $data['bukti_pembayaran'] ?>')">
                                                <i class="bi bi-file-earmark-text"></i> Lihat
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-warning btn-sm me-2"
                                                    href="index.php?halaman=ubah_pemeliharaan_elektronik&id=<?= $data['id'] ?>" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm"
                                                    href="index.php?halaman=hapus_pemeliharaan_elektronik&id=<?= $data['id'] ?>"
                                                    title="Delete"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="13" class="text-center">Tidak ada data pemeliharaan elektronik.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal for showing the payment proof image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
    }

    thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
    }

    .btn i {
        vertical-align: middle;
    }

    .card {
        transition: transform 0.3s ease-in-out;
    }

    

    .d-flex {
        margin-bottom: 20px;
    }
</style>

<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script>
    let table = document.querySelector('#table');
    let dataTable = new simpleDatatables.DataTable(table, {
        sortable: false // Menonaktifkan pengurutan
    });

    function showImage(imageUrl) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl; // Set the image source to the clicked button's image URL
    }
</script>
