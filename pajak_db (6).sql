-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2024 pada 03.54
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pajak_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `elektronik`
--

CREATE TABLE `elektronik` (
  `id` int(11) NOT NULL,
  `jenis_barang` varchar(50) DEFAULT NULL,
  `nama_peminjam` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  `tanggal_peminjaman` date DEFAULT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `status_peminjaman` varchar(50) DEFAULT NULL,
  `kondisi_saat_pengembalian` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti_peminjaman` varchar(255) DEFAULT NULL,
  `foto_barang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `elektronik`
--

INSERT INTO `elektronik` (`id`, `jenis_barang`, `nama_peminjam`, `no_telepon`, `merk`, `serial_number`, `kondisi`, `tanggal_peminjaman`, `tanggal_pengembalian`, `status_peminjaman`, `kondisi_saat_pengembalian`, `keterangan`, `bukti_peminjaman`, `foto_barang`) VALUES
(8, 'laptop', 'riarobb', 'uiyweghu', 'ssss', '098', 'bjjjjjjjjjjjj', '2026-02-02', '2024-02-02', 'Dipinjam', '', '', NULL, NULL),
(9, 'laptop', 'ri', '0851562555', 'aaa', 'i9998777', 'cbcbcbb', '2024-10-30', '2024-11-07', 'Dipinjam', 'sssssss', 'bbsbndnndn', 'uploads/1730250600_bukti_Screenshot (35).png', 'uploads/1730250600_foto_Screenshot (42).png'),
(11, 'kamera', 'rob', '0988777', 'aaa', '09imjhjuu', 'baik', '2024-11-01', '2024-11-05', 'Dipinjam', 'sssssss', 'ggggg', 'uploads/1730769939_bukti_Screenshot (33).png', 'uploads/1730769939_foto_Screenshot (36).png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL,
  `pemakai` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(15) DEFAULT NULL,
  `no_plat` varchar(10) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `tahun_pembuatan` int(11) DEFAULT NULL,
  `harga_pembelian` decimal(15,2) DEFAULT NULL,
  `harga_pajak` decimal(15,2) DEFAULT NULL,
  `status_pajak` varchar(20) DEFAULT NULL,
  `tenggat_pajak` date DEFAULT NULL,
  `foto_kendaraan` varchar(255) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `pemakai`, `no_telepon`, `no_plat`, `merk`, `tipe`, `tahun_pembuatan`, `harga_pembelian`, `harga_pajak`, `status_pajak`, `tenggat_pajak`, `foto_kendaraan`, `bukti_pembayaran`) VALUES
(14, 'YANTO', '988090', '98980', 'MIU', 'Motor', 9009, 890809.00, 9009.00, 'Nonaktif', '2023-09-07', 'uploads/1731466232_foto_Screenshot (35).png', '1731547258_bukti_Screenshot (33).png'),
(17, 'joni', '0851562555', 'j67788jj', 'supra', 'Motor', 2111, 1500000.00, 30000.00, 'Aktif', '2024-10-17', 'uploads/1730251590_foto_Screenshot (35).png', 'uploads/1730251590_bukti_Screenshot (36).png'),
(21, 'jjjjj', '0987777', 'j67788jj', 'aaa', 'Motor', 2018, 876666.00, 160000.00, 'Aktif', '2024-11-23', 'uploads/1730768645_foto_Screenshot (35).png', NULL),
(23, 'rob', '0851562555', 'd0999', 'g', 'Motor', 2020, 12000000.00, 160000.00, 'Aktif', '2024-11-20', 'uploads/1730864934_foto_Screenshot (36).png', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_histori`
--

CREATE TABLE `log_histori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_tabel` varchar(255) DEFAULT NULL,
  `id_data` int(11) DEFAULT NULL,
  `aksi` varchar(50) DEFAULT NULL,
  `data_lama` text DEFAULT NULL,
  `data_baru` text DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `log_histori`
--

INSERT INTO `log_histori` (`id`, `nama_tabel`, `id_data`, `aksi`, `data_lama`, `data_baru`, `pengguna`, `tanggal`) VALUES
(187, 'kendaraan', 14, 'Edit Data', '14\nYANT\n988090\n98980\nMIU\nMotor\n9009\n890809.00\n9009.00\nAktif\n2024-10-26\n\n', 'Pemakai = YANTO\nNo Telepon = 988090\nMerk = MIU\nNo Plat = 98980\nTipe = Motor\nTahun Pembuatan = 9009\nHarga Pembelian = 890809.00\nHarga Pajak = 9009.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-10-26', 'admin@gmail.com', '2024-11-06 03:45:05'),
(188, 'kendaraan', 22, 'Hapus Data', 'pemakai = ffff\nno telepon = 09998888\nmerk = supra\nno plat = j67788jj\ntipe = Motor\ntahun pembuatan = 2111\nharga pembelian = 13000.00\nharga pajak = 160000.00\nstatus pajak = Lunas\ntenggat pajak = 2024-11-01', NULL, 'admin@gmail.com', '2024-11-06 03:45:15'),
(189, 'kendaraan', 23, 'Tambah Data', NULL, 'Pemakai = rob\nNo Telepon = 0851562555\nMerk = g\nNo Plat = d0999\nTipe = Motor\nTahun Pembuatan = 2020\nHarga Pembelian = 12000000\nHarga Pajak = 160000\nStatus Pajak = Belum Lunas\nTenggat Pajak = 2024-11-20', 'admin@gmail.com', '2024-11-06 03:48:54'),
(190, 'kendaraan', 17, 'Edit Data', '17\njoni\n0851562555\nj67788jj\nsupra\nMotor\n2111\n1500000.00\n30000.00\nLunas\n2024-10-17\nuploads/1730251590_foto_Screenshot (35).png\nuploads/1730251590_bukti_Screenshot (36).png', 'Pemakai = joni\nNo Telepon = 0851562555\nMerk = supra\nNo Plat = j67788jj\nTipe = Motor\nTahun Pembuatan = 2111\nHarga Pembelian = 1500000.00\nHarga Pajak = 30000.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-10-17', 'admin@gmail.com', '2024-11-06 03:53:20'),
(191, 'kendaraan', 21, 'Edit Data', '21\njjjjj\n0987777\nj67788jj\naaa\nMotor\n2018\n876666.00\n160000.00\nLunas\n2024-11-22\nuploads/1730768645_foto_Screenshot (35).png\n', 'Pemakai = jjjjj\nNo Telepon = 0987777\nMerk = aaa\nNo Plat = j67788jj\nTipe = Motor\nTahun Pembuatan = 2018\nHarga Pembelian = 876666.00\nHarga Pajak = 160000.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-11-22', 'admin@gmail.com', '2024-11-06 03:53:30'),
(192, 'kendaraan', 23, 'Edit Data', '23\nrob\n0851562555\nd0999\ng\nMotor\n2020\n12000000.00\n160000.00\nBelum Lunas\n2024-11-20\nuploads/1730864934_foto_Screenshot (36).png\n', 'Pemakai = rob\nNo Telepon = 0851562555\nMerk = g\nNo Plat = d0999\nTipe = Motor\nTahun Pembuatan = 2020\nHarga Pembelian = 12000000.00\nHarga Pajak = 160000.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-11-20', 'admin@gmail.com', '2024-11-06 03:53:52'),
(193, 'pemeliharaan_kendaraan', 21, 'Edit Data', '21\nyannnnn\n8979798\nmio\n9887\nuu\nuu\n7777-08-09\n78687687.00\nnnsns\nScreenshot (36).png\nselesai', 'Nama Pemelihara = yannnnnto\nNo Telepon = 8979798\nJenis Kendaraan = mio\nPlat Nomor = 9887\nKondisi Sebelum = uu\nKondisi Setelah = uu\nTanggal Pemeliharaan = 7777-08-09\nBiaya Pemeliharaan = 78687687.00\nKeterangan = nnsns\nStatus Pemeliharaan = selesai', 'admin@gmail.com', '2024-11-07 01:47:42'),
(194, 'kendaraan', 14, 'Edit Data', '14\nYANTO\n988090\n98980\nMIU\nMotor\n9009\n890809.00\n9009.00\nAktif\n2024-10-26\n\n', 'Pemakai = YANTO\nNo Telepon = 988090\nMerk = MIU\nNo Plat = 98980\nTipe = Motor\nTahun Pembuatan = 9009\nHarga Pembelian = 890809.00\nHarga Pajak = 9009.00\nStatus Pajak = Nonaktif\nTenggat Pajak = 2024-10-26', 'admin@gmail.com', '2024-11-13 02:50:32'),
(195, 'kendaraan', 14, 'Edit Data', '14\nYANTO\n988090\n98980\nMIU\nMotor\n9009\n890809.00\n9009.00\nNonaktif\n2024-10-26\nuploads/1731466232_foto_Screenshot (35).png\n', 'Pemakai = YANTO\nNo Telepon = 988090\nMerk = MIU\nNo Plat = 98980\nTipe = Motor\nTahun Pembuatan = 9009\nHarga Pembelian = 890809.00\nHarga Pajak = 9009.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-10-26', 'admin@gmail.com', '2024-11-14 01:20:18'),
(196, 'kendaraan', 14, 'Edit Data', '14\nYANTO\n988090\n98980\nMIU\nMotor\n9009\n890809.00\n9009.00\nAktif\n2024-10-26\nuploads/1731466232_foto_Screenshot (35).png\n', 'Pemakai = YANTO\nNo Telepon = 988090\nMerk = MIU\nNo Plat = 98980\nTipe = Motor\nTahun Pembuatan = 9009\nHarga Pembelian = 890809.00\nHarga Pajak = 9009.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-10-07', 'admin@gmail.com', '2024-11-14 01:20:58'),
(197, 'kendaraan', 14, 'Edit Data', '14\nYANTO\n988090\n98980\nMIU\nMotor\n9009\n890809.00\n9009.00\nAktif\n2024-10-07\nuploads/1731466232_foto_Screenshot (35).png\n1731547258_bukti_Screenshot (33).png', 'Pemakai = YANTO\nNo Telepon = 988090\nMerk = MIU\nNo Plat = 98980\nTipe = Motor\nTahun Pembuatan = 9009\nHarga Pembelian = 890809.00\nHarga Pajak = 9009.00\nStatus Pajak = Nonaktif\nTenggat Pajak = 2023-09-07', 'admin@gmail.com', '2024-11-14 01:21:41'),
(198, 'kendaraan', 21, 'Edit Data', '21\njjjjj\n0987777\nj67788jj\naaa\nMotor\n2018\n876666.00\n160000.00\nAktif\n2024-11-22\nuploads/1730768645_foto_Screenshot (35).png\n', 'Pemakai = jjjjj\nNo Telepon = 0987777\nMerk = aaa\nNo Plat = j67788jj\nTipe = Motor\nTahun Pembuatan = 2018\nHarga Pembelian = 876666.00\nHarga Pajak = 160000.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-09-01', 'admin@gmail.com', '2024-11-14 01:22:34'),
(199, 'kendaraan', 21, 'Edit Data', '21\njjjjj\n0987777\nj67788jj\naaa\nMotor\n2018\n876666.00\n160000.00\nAktif\n2024-09-01\nuploads/1730768645_foto_Screenshot (35).png\n', 'Pemakai = jjjjj\nNo Telepon = 0987777\nMerk = aaa\nNo Plat = j67788jj\nTipe = Motor\nTahun Pembuatan = 2018\nHarga Pembelian = 876666.00\nHarga Pajak = 160000.00\nStatus Pajak = Aktif\nTenggat Pajak = 2024-11-23', 'admin@gmail.com', '2024-11-14 01:23:06'),
(200, 'pemeliharaan_elektronik', 25, 'Hapus Data', 'Nama Perangkat = bbbbb\nMerk = llllll\nTipe = kkkk\nTanggal Pemeliharaan = 2024-11-05\nDeskripsi = baik\nBiaya Pemeliharaan = 120000.00\nTeknisi = jjjjj\nNama Pengguna = kkkk\nNo Telepon Pengguna = kkkkkk\nStatus = Selesai\nCatatan = ', NULL, 'admin@gmail.com', '2024-11-14 01:40:54');

--
-- Trigger `log_histori`
--
DELIMITER $$
CREATE TRIGGER `hapus_log_lama` BEFORE INSERT ON `log_histori` FOR EACH ROW BEGIN
    DECLARE total_log INT;
    DECLARE id_tua INT;

    -- Hitung jumlah log
    SELECT COUNT(*) INTO total_log FROM log_histori;

    -- Jika jumlah log lebih dari 100, hapus log tertua
    IF total_log > 100 THEN
        -- Cari ID tertua yang ingin dihapus
        SELECT id INTO id_tua 
        FROM log_histori 
        ORDER BY tanggal ASC 
        LIMIT 1;
        
        -- Hapus log tertua
        DELETE FROM log_histori WHERE id = id_tua;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeliharaan_elektronik`
--

CREATE TABLE `pemeliharaan_elektronik` (
  `id` int(11) NOT NULL,
  `nama_perangkat` varchar(255) NOT NULL,
  `merk` varchar(100) NOT NULL,
  `tipe` varchar(100) NOT NULL,
  `tanggal_pemeliharaan` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `biaya_pemeliharaan` decimal(10,2) DEFAULT NULL,
  `teknisi` varchar(100) DEFAULT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `no_telepon_pengguna` varchar(15) DEFAULT NULL,
  `status` enum('Selesai','Dalam Proses','Dibatalkan') DEFAULT 'Dalam Proses',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `bukti_pemeliharaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemeliharaan_elektronik`
--

INSERT INTO `pemeliharaan_elektronik` (`id`, `nama_perangkat`, `merk`, `tipe`, `tanggal_pemeliharaan`, `deskripsi`, `biaya_pemeliharaan`, `teknisi`, `nama_pengguna`, `no_telepon_pengguna`, `status`, `bukti_pembayaran`, `catatan`, `bukti_pemeliharaan`) VALUES
(12, 'laptop', 'dddd', 'bbbbb', '2024-10-10', 'baik', 123444.00, 'rio', 'ria', '1233889999', 'Selesai', 'uploads/1729054017_WhatsApp.jpg', NULL, NULL),
(13, 'laptopaaaa', 'aaa', 'aaaa', '2024-10-27', 'baik', 90000000.00, 'aaa', 'ri', '20000000000', 'Selesai', 'uploads/1729986488_WhatsApp.jpg', NULL, NULL),
(23, 'aaaa', 'iu', 'hjb', '0008-08-08', 'hjb', 987987.00, 'uihiu', 'iuhiu', '897', 'Selesai', NULL, NULL, 'uploads/1730771066_bukti_Screenshot (36).png'),
(24, 'laptop', 'sus', '667', '0000-00-00', 'baik', 8987987.00, 'siso', 'siuk', '9879879879', 'Selesai', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeliharaan_kendaraan`
--

CREATE TABLE `pemeliharaan_kendaraan` (
  `id` int(11) NOT NULL,
  `nama_pemelihara` varchar(255) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `jenis_kendaraan` varchar(50) NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `kondisi_sebelum` text NOT NULL,
  `kondisi_setelah` text NOT NULL,
  `tanggal_pemeliharaan` date NOT NULL,
  `biaya_pemeliharaan` decimal(10,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `bukti` varchar(255) NOT NULL,
  `status_pemeliharaan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemeliharaan_kendaraan`
--

INSERT INTO `pemeliharaan_kendaraan` (`id`, `nama_pemelihara`, `no_telepon`, `jenis_kendaraan`, `plat_nomor`, `kondisi_sebelum`, `kondisi_setelah`, `tanggal_pemeliharaan`, `biaya_pemeliharaan`, `keterangan`, `bukti`, `status_pemeliharaan`) VALUES
(12, 'kkkkhhggghhhh', '112222', 'mobil', 'b212fzi', 'ppppp', 'ddddd', '2024-10-16', 12222.00, 'ssss', 'foto.jpg', 'Selesai'),
(18, 'riojjjjjjjh', '08955555', 'mobil', 'h689ko', 'bbbbb', 'kkkkkk', '2024-11-01', 200000.00, 'jjjjjj', 'Screenshot (34).png', 'Selesai'),
(19, 'oooojjjjiiiiiuuuu', '0851562555', 'mobil', '0099999', 'kkkkkk', 'jjjjj', '2024-11-05', 120000.00, 'jjjjjj', 'Screenshot (36).png', 'Selesai'),
(20, 'siuk', 'u8u8', 'mi', '9878', 'h', 'kj', '0009-08-08', 879889.00, 'hinlk', 'Screenshot (35).png', 'Selesai'),
(21, 'yannnnnto', '8979798', 'mio', '9887', 'uu', 'uu', '7777-08-09', 78687687.00, 'nnsns', 'Screenshot (36).png', 'selesai'),
(22, 'to', '8979798', 'mio', '9887', 'uu', 'uu', '7777-08-09', 78687687.00, 'nnsns', 'Screenshot (36).png', 'selesai'),
(24, 'yanti', '879', 'mio', '9879', 'iuhu', 'uhuh', '4444-07-05', 6756576.00, 'ytvyt', './uploads/1730775455_bukti_Screenshot (35).png', 'Selesai'),
(25, 'hjjj', '08955555', 'mobil', 'h689ko', 'sssss', 'aaaa', '2024-11-05', 200000.00, 'aaaa', './uploads/1730775586_bukti_Screenshot (70).png', 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_penggunaan`
--

CREATE TABLE `riwayat_penggunaan` (
  `id` int(11) NOT NULL,
  `kendaraan_id` int(11) DEFAULT NULL,
  `tanggal_penggunaan` date DEFAULT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `tujuan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(2, 'admin@gmail.com', 'admin', '$2y$10$hVSvpLYAyirFtJDvLB0rLeOTXwf7zhqMRb7GxtfXs4TFOwKeWUcZe'),
(3, 'aa', 'aaa', '$2y$10$CH2f9dKwTNqeYv1SJP2gIuBMkLheY.HbJ8BkjZ3JgmX5BfCBjphsC'),
(4, 'aa', 'aa', '$2y$10$./JuC3V7EoJ2dYnRx9HQzuzSVbZxnbq1IFILOdAr4JSRg2Vgn5jpq'),
(5, 'ria', 'ria123', '$2y$10$RZ1D.gjxa8KaHPCZFXeTD.2GiW9Ta01jltdUHwAR2AuaA1lBoPAc2');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `elektronik`
--
ALTER TABLE `elektronik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_histori`
--
ALTER TABLE `log_histori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemeliharaan_elektronik`
--
ALTER TABLE `pemeliharaan_elektronik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemeliharaan_kendaraan`
--
ALTER TABLE `pemeliharaan_kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_penggunaan`
--
ALTER TABLE `riwayat_penggunaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kendaraan_id` (`kendaraan_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `elektronik`
--
ALTER TABLE `elektronik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `log_histori`
--
ALTER TABLE `log_histori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT untuk tabel `pemeliharaan_elektronik`
--
ALTER TABLE `pemeliharaan_elektronik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `pemeliharaan_kendaraan`
--
ALTER TABLE `pemeliharaan_kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `riwayat_penggunaan`
--
ALTER TABLE `riwayat_penggunaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `riwayat_penggunaan`
--
ALTER TABLE `riwayat_penggunaan`
  ADD CONSTRAINT `riwayat_penggunaan_ibfk_1` FOREIGN KEY (`kendaraan_id`) REFERENCES `kendaraan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
