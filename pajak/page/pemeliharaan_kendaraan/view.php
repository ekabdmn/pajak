<?php
include "./function/koneksi.php";

// Initialize variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Handle data retrieval
try {
    if ($statusFilter == 'Semua') {
        $stmt = $conn->prepare("SELECT * FROM pemeliharaan_kendaraan ORDER BY tanggal_pemeliharaan DESC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM pemeliharaan_kendaraan WHERE status_pemeliharaan = ? ORDER BY tanggal_pemeliharaan DESC");
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
    <!-- Heading and Breadcrumbs -->
</div>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pemeliharaan Kendaraan</h3>
                <p class="text-subtitle text-muted">Halaman Tampil Data Pemeliharaan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pemeliharaan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

<section class="section">
    <!-- Buttons and Status Filter -->
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="index.php?halaman=tambah_pemeliharaan_kendaraan" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Data
            </a>
            <a href="javascript:void(0)" class="btn btn-success btn-sm" id="printButton">
                <i class="bi bi-file-earmark-pdf"></i> Print PDF
            </a>
            <script>
                document.getElementById('printButton').addEventListener('click', function() {
                    window.open('print_pemeliharaan.php?status=<?= urlencode($statusFilter) ?>', '_blank');
                });
            </script>
        </div>
        <div>
            <select onchange="window.location.href=this.value" class="form-select" aria-label="Status Filter">
                <option value="index.php?halaman=pemeliharaan&status=Semua" <?= $statusFilter == 'Semua' ? 'selected' : '' ?>>Semua</option>
                <option value="index.php?halaman=pemeliharaan&status=Lunas" <?= $statusFilter == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                <option value="index.php?halaman=pemeliharaan&status=Belum Lunas" <?= $statusFilter == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
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
                            <th>Nama Pemelihara</th>
                            <th>No Telepon</th>
                            <th>Jenis Kendaraan</th>
                            <th>Plat Nomor</th>
                            <th>Kondisi Sebelum</th>
                            <th>Kondisi Setelah</th>
                            <th>Tanggal Pemeliharaan</th>
                            <th>Biaya Pemeliharaan</th>
                            <th>Keterangan</th>
                            <th>Bukti</th>
                            <th>Status Pemeliharaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($count > 0) : ?>
                            <?php $i = 1; ?>
                            <?php while ($data = $query->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($data['nama_pemelihara']) ?></td>
                                    <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                                    <td><?= htmlspecialchars($data['jenis_kendaraan']) ?></td>
                                    <td><?= htmlspecialchars($data['plat_nomor']) ?></td>
                                    <td><?= htmlspecialchars($data['kondisi_sebelum']) ?></td>
                                    <td><?= htmlspecialchars($data['kondisi_setelah']) ?></td>
                                    <td><?= htmlspecialchars($data['tanggal_pemeliharaan']) ?></td>
                                    <td>Rp <?= number_format($data['biaya_pemeliharaan'], 2, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($data['keterangan']) ?></td>
                                    <td>
                                        <?php if (!empty($data['bukti'])) : ?>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#imageModal" 
                                                onclick="showImage('uploads/<?= htmlspecialchars($data['bukti']) ?>')">
                                                <i class="bi bi-file-earmark-text"></i> Lihat
                                            </button>
                                        <?php else : ?>
                                            <span class="text-muted">Tidak ada bukti</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($data['status_pemeliharaan']) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-warning btn-sm me-2" href="index.php?halaman=ubah_pemeliharaan_kendaraan&id=<?= $data['id'] ?>" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="index.php?halaman=hapus_pemeliharaan_kendaraan&id=<?= $data['id'] ?>" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="13" class="text-center">Tidak ada data pemeliharaan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</div>

<!-- Modal for showing image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Bukti" />
            </div>
        </div>
    </div>
</div>

<script>
    function showImage(imageSrc) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc; // Mengatur sumber gambar ke modal
    }
</script>

