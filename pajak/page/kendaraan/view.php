<?php
include "./function/koneksi.php";

// Initialize variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Handle data retrieval
try {
    if ($statusFilter == 'Semua') {
        $stmt = $conn->prepare("SELECT * FROM kendaraan ORDER BY tenggat_pajak DESC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM kendaraan WHERE status_pajak = ? ORDER BY tenggat_pajak DESC");
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
                <h3>Data Kendaraan</h3>
                <p class="text-subtitle text-muted">Halaman Tampil Data Kendaraan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Kendaraan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="index.php?halaman=tambah_kendaraan" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Data
                </a>
                <a href="javascript:void(0)" class="btn btn-success btn-sm" id="printButton">
                    <i class="bi bi-file-earmark-pdf"></i> Print PDF
                </a>
                <script>
                    document.getElementById('printButton').addEventListener('click', function () {
                        window.open('print_kendaraan.php?status=<?= urlencode($statusFilter) ?>', '_blank');
                    });
                </script>
            </div>
            <div>
                <select onchange="window.location.href=this.value" class="form-select" aria-label="Status Filter">
                    <option value="index.php?halaman=kendaraan&status=Semua" <?= $statusFilter == 'Semua' ? 'selected' : '' ?>>Semua</option>
                    <option value="index.php?halaman=kendaraan&status=Lunas" <?= $statusFilter == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                    <option value="index.php?halaman=kendaraan&status=Belum Lunas" <?= $statusFilter == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
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
                                <th>Pemakai</th>
                                <th>No Telepon</th>
                                <th>No Plat</th>
                                <th>Merk</th>
                                <th>Tipe</th>
                                <th>Tahun Pembuatan</th>
                                <th>Harga Pembelian</th>
                                <th>Harga Pajak</th>
                                <th>Status Pajak</th>
                                <th>Tenggat Pajak</th>
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
                                        <td><?= htmlspecialchars($data['pemakai']) ?></td>
                                        <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                                        <td><?= htmlspecialchars($data['no_plat']) ?></td>
                                        <td><?= htmlspecialchars($data['merk']) ?></td>
                                        <td><?= htmlspecialchars($data['tipe']) ?></td>
                                        <td><?= htmlspecialchars($data['tahun_pembuatan']) ?></td>
                                        <td>Rp <?= number_format($data['harga_pembelian'], 2, ',', '.') ?></td>
                                        <td>Rp <?= number_format($data['harga_pajak'], 2, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($data['status_pajak']) ?></td>
                                        <td><?= htmlspecialchars($data['tenggat_pajak']) ?></td>
                                        <td>
                                             <a href="<?= $data['bukti_pembayaran'] ?>" target="_blank" class="btn btn-info btn-sm">
                                                <i class="bi bi-file-earmark-text"></i> Lihat
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-warning btn-sm me-2"
                                                    href="index.php?halaman=ubah_kendaraan&id=<?= $data['id'] ?>" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm"
                                                    href="index.php?halaman=hapus_kendaraan&id=<?= $data['id'] ?>"
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
                                    <td colspan="13" class="text-center">Tidak ada data kendaraan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
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

    .card:hover {
        transform: translateY(-10px);
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
</script>