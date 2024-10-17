<?php
include "./function/koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM kendaraan");


?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Kedaraan</h3>
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
                            Lihat Data Kendaraan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <a href="index.php?halaman=tambah_kendaraan" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Plat Nomor</th>
                                <th>Merek</th>
                                <th>Tipe</th>
                                <th>Tahun Pembuatan</th>
                                <th>Pemakai</th>
                                <th>Status Pajak</th>
                                <th>aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($query->num_rows > 0) : ?>
                                <?php
                                $i = 1;
                                while ($data = mysqli_fetch_assoc($query)) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $data['no_plat'] ?></td>
                                        <td><?= $data['merk'] ?></td>
                                        <td><?= $data['tipe'] ?></td>
                                        <td><?= $data['tahun_pembuatan'] ?></td>
                                        <td><?= $data['pemakai'] ?></td>
                                        <td><a class="btn btn-primary btn-sm" href="index.php?halaman=status_pajak&id=<?= $data['id'] ?>">Lihat</a>
                                        </td>

                                        <td>
                                            <a class="btn btn-primary btn-sm" href="index.php?halaman=ubah_kendaraan&id=<?= $data['id'] ?>">Ubah</a>
                                            <a class="btn btn-danger btn-sm" id="btn-hapus" href="index.php?halaman=hapus_kendaraan&id=<?= $data['id'] ?>" onclick="confirmModal(event)">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="./assets/static/js/pages/simple-datatables.js"></script>