<?php

if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];

    switch ($halaman) {
        // Halaman beranda
        case 'beranda':
            include "page/index.php";
            break;

        // Halaman logout
        case 'logout':
            include "page/logout.php";
            break;

        // CRUD Kendaraan
        case 'kendaraan':
            include "page/kendaraan/view.php";
            break;
        case 'tambah_kendaraan':
            include "page/kendaraan/add.php";
            break;
        case 'ubah_kendaraan':
            include "page/kendaraan/edit.php";
            break;
        case 'hapus_kendaraan':
            include "page/kendaraan/delete.php";
            break;

        // CRUD Elektronik
        case 'elektronik':
            include "page/elektronik/view.php";
            break;
        case 'tambah_elektronik':
            include "page/elektronik/add.php";
            break;
        case 'ubah_elektronik':
            include "page/elektronik/edit.php";
            break;
        case 'hapus_elektronik':
            include "page/elektronik/delete.php";
            break;

             // CRUD Pemeliharaan
        case 'pemeliharaan':
            include "page/pemeliharaan_kendaraan/view.php";
            break;
        case 'tambah_pemeliharaan':
            include "page/pemeliharaan_kendaraan/add.php";
            break;
        case 'ubah_pemeliharaan':
            include "page/pemeliharaan_kendaraan/edit.php";
            break;
        case 'hapus_pemeliharaan':
            include "page/pemeliharaan_kendaraan/delete.php";
            break;

        // CRUD Pemeliharaan Elektronik

        case 'pemeliharaan_elektronik':
            include "page/pemeliharaan_elektronik/view.php";
            break;
        case 'tambah_pemeliharaan_elektronik':
            include "page/pemeliharaan_elektronik/add.php";
            break;
        case 'ubah_pemeliharaan_elektronik':
            include "page/pemeliharaan_elektronik/edit.php";
            break;
        case 'hapus_pemeliharaan_elektronik':
            include "page/pemeliharaan_elektronik/delete.php";
            break;

        case 'log_history':
            include "page/log/log.php";
            break;

        // Halaman error jika tidak ada halaman yang ditemukan
        default:
            include "page/error.php";
            break;
    }
} else {
    // Halaman default (beranda)
    include "page/index.php";
}
