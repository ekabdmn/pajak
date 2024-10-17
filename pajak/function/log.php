<?php
include "./function/koneksi.php";

function logHistori($nama_tabel, $id_data, $aksi, $data_lama, $data_baru, $pengguna) {
    global $conn; // Mengambil variabel koneksi dari file koneksi.php

    // Buat query insert ke tabel log_histori
    $query = "INSERT INTO log_histori (nama_tabel, id_data, aksi, data_lama, data_baru, pengguna)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nama_tabel, $id_data, $aksi,$data_lama, $data_baru, $pengguna]);
}

function kelolaLogHistori($conn) {
    // Menghitung jumlah total log
    $sql = "SELECT COUNT(*) AS total_log FROM log_histori";
    $result = $conn->query($sql);

    // Cek apakah query berhasil
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_log = $row['total_log'];

        // Jika jumlah log lebih dari 100, hapus log tertua
        if ($total_log > 100) {
            // Hapus log tertua
            $delete_sql = "DELETE FROM log_histori WHERE id = (SELECT id FROM log_histori ORDER BY tanggal ASC LIMIT 1)";
            if ($conn->query($delete_sql) === FALSE) {
                echo "Error saat menghapus log: " . $conn->error;
            }
        } 
    }
}

kelolaLogHistori($conn);
?>



