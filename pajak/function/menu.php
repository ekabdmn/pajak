<?php

if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
    switch ($halaman) {
        case 'beranda':
            include "page/index.php";
            break;
        case 'logout':
            include "page/logout.php";
            break;
            // crud kendaraan
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
            // end crud kendaraan

            // status pajak
            case 'status_pajak':
                include "page/status_pajak/view.php";
                break;

        default:
            include "page/error.php";
    }
} else {
    include "page/index.php";
}
