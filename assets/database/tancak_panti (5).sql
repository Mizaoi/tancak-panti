-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Bulan Mei 2026 pada 23.20
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
-- Database: `tancak_panti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '33ea7739f6e64d76acffbd21a8320d3e');

-- --------------------------------------------------------

--
-- Struktur dari tabel `denda`
--

CREATE TABLE `denda` (
  `id_denda` int(11) NOT NULL,
  `id_tiket` int(11) NOT NULL,
  `nama_wisatawan` varchar(100) NOT NULL,
  `nama_sampah` varchar(100) NOT NULL,
  `jumlah_hilang` int(11) NOT NULL,
  `total_denda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `denda`
--

INSERT INTO `denda` (`id_denda`, `id_tiket`, `nama_wisatawan`, `nama_sampah`, `jumlah_hilang`, `total_denda`) VALUES
(8, 5, 'Lukman', 'Botol Plastik', 1, 10000),
(9, 5, 'Lukman', 'Bungkus Makanan', 1, 10000),
(10, 24, 'yakin', 'Botol Plastik', 1, 10000),
(11, 24, 'yakin', 'Bungkus Makanan', 2, 20000),
(12, 24, 'yakin', 'Cup Plastik / Cup Mie', 1, 10000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id_fasilitas` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(500) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `fasilitas`
--

INSERT INTO `fasilitas` (`id_fasilitas`, `nama`, `deskripsi`, `gambar`, `icon`, `urutan`) VALUES
(1, 'Parkir Gratis', 'Area parkir luas untuk kendaraan Anda', NULL, '🅿️', 0),
(2, 'Toilet Bersih', 'Fasilitas toilet yang bersih dan terawat', NULL, '🚽', 0),
(3, 'Warung Makan', 'Berbagai pilihan makanan dan minuman', NULL, '🍽️', 0),
(4, 'Pemandu Wisata', 'Pemandu berpengalaman siap membantu', NULL, '🧭', 0),
(5, 'First Aid', 'Pos kesehatan dengan perlengkapan first aid', NULL, '🏥', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `pesan` text NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'baru'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rating`
--

CREATE TABLE `rating` (
  `id_rating` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `komentar` text DEFAULT NULL,
  `foto` varchar(500) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekap_laporan`
--

CREATE TABLE `rekap_laporan` (
  `id_laporan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_tiket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sampah`
--

CREATE TABLE `sampah` (
  `id_sampah` int(11) NOT NULL,
  `id_tiket` int(11) NOT NULL,
  `nama_sampah` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sampah`
--

INSERT INTO `sampah` (`id_sampah`, `id_tiket`, `nama_sampah`, `jumlah`) VALUES
(23, 5, 'Botol Plastik', 1),
(24, 5, 'Bungkus Makanan', 1),
(47, 21, 'Cup Plastik / Cup Mie', 1),
(48, 21, 'Kantong Plastik', 1),
(49, 21, 'Tisu', 1),
(53, 23, 'Cup Plastik / Cup Mie', 1),
(54, 23, 'Kantong Plastik', 1),
(55, 23, 'Tisu', 1),
(61, 24, 'Kantong Plastik', 2),
(62, 22, 'Cup Plastik / Cup Mie', 1),
(63, 29, 'Bungkus Makanan', 1),
(64, 29, 'Kantong Plastik', 1),
(65, 29, 'Tisu', 1),
(66, 30, 'Cup Plastik / Cup Mie', 1),
(67, 30, 'Kantong Plastik', 4),
(68, 30, 'Tisu', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `id_tiket` int(11) NOT NULL,
  `kode_tiket` varchar(15) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `orang` int(11) NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `telepon_1` varchar(20) NOT NULL,
  `telepon_2` varchar(20) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` enum('Belum Check-in','Masih di Wisata','Sudah Pulang') DEFAULT 'Belum Check-in'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`id_tiket`, `kode_tiket`, `nama`, `alamat`, `orang`, `tanggal_kunjungan`, `telepon_1`, `telepon_2`, `bukti_transfer`, `status`) VALUES
(5, 'TCK-NCY7UX', 'Lukman', 'bangsalsari', 31, '2026-05-04', '085855819394', '321321321321', 'https://i.ibb.co/93WbWGQV/BUKTI-TF-1777892407-67.jpg', 'Masih di Wisata'),
(6, 'TCK-RKIBMF', 'as', 'langkap', 1, '2026-05-04', '085855819394', '321312123123', 'https://i.ibb.co/JWXHnfMV/BUKTI-TF-1777892495-48.png', 'Masih di Wisata'),
(7, 'TCK-H4KOZJ', 'wildan', 'seruji', 1, '2026-05-04', '083836372284', '08512350660', 'https://i.ibb.co/SwYNT7Hh/BUKTI-TF-1777899745-65.png', 'Belum Check-in'),
(8, 'TCK-U1EV82', 'sendi', 'bondowoso', 1, '2026-05-04', '082141860564', '12345678909', 'https://i.ibb.co/SwYNT7Hh/BUKTI-TF-1777899745-65.png', 'Sudah Pulang'),
(17, 'TCK-D8B7971', 'wildan', 'seruji', 1, '2026-05-04', '083836372284', '085123506605', 'https://i.ibb.co/1GgGCY56/BUKTI-TF-1777904931.png', 'Sudah Pulang'),
(18, 'TCK-1EE2A3C', 'rating', 'bangsalsari', 12, '2026-05-04', '083836372284', '08512350660', 'https://i.ibb.co/RGYGG6fF/BUKTI-TF-1777905141.png', 'Belum Check-in'),
(19, 'TCK-5167048', 'Lukman', 'bangsalsari', 3, '2026-05-04', '085855819394', '23423423423423', 'https://i.ibb.co/zVv2KhXM/BUKTI-TF-1777905382.png', 'Sudah Pulang'),
(20, 'TCK-DE648C4', 'sendi', 'seruji', 15, '2026-05-04', '085855819394', '2867546345678', 'https://i.ibb.co/FLMc3b0R/BUKTI-TF-1777905580.png', 'Belum Check-in'),
(21, 'TCK-06406E8', 'sendi', 'seruji', 15, '2026-05-04', '085855819394', '2867546345678', 'https://i.ibb.co/FLMc3b0R/BUKTI-TF-1777905580.png', 'Sudah Pulang'),
(22, 'TCK-E7716F6', 'sendi', 'seruji', 15, '2026-05-04', '085855819394', '2867546345678', 'https://i.ibb.co/FLMc3b0R/BUKTI-TF-1777905580.png', 'Masih di Wisata'),
(23, 'TCK-8575657', 'sendi', 'seruji', 15, '2026-05-04', '085855819394', '2867546345678', 'https://i.ibb.co/FLMc3b0R/BUKTI-TF-1777905580.png', 'Sudah Pulang'),
(24, 'TCK-1A10E8B', 'yakin', 'seruji', 1, '2026-05-06', '085855819394', '321312123123', 'https://i.ibb.co/5hqH4LTf/ULASAN-1778000874-85.png', 'Masih di Wisata'),
(25, 'TCK-8442046', 'Tuntun', 'seruji', 1, '2026-05-08', '085855819394', '2', 'https://i.ibb.co/27b14P8Q/BUKTI-TF-1778176141.png', 'Belum Check-in'),
(26, 'TCK-00534F3', 'tuntun', 'bondowoso', 1, '2026-05-08', '085855819394', '123123123123123', 'https://i.ibb.co/prW3qq8Y/ULASAN-1778165516.png', 'Belum Check-in'),
(27, 'TCK-E3559B1', '1', '1', 1, '2026-05-08', '111111111111111', '111111111111111', 'https://i.ibb.co/prW3qq8Y/ULASAN-1778165516.png', 'Belum Check-in'),
(28, 'TCK-BB476A2', 'as', 'panti', 1, '2026-05-08', '085855819394', '12346879874', 'https://i.ibb.co/prW3qq8Y/ULASAN-1778165516.png', 'Belum Check-in'),
(29, 'TCK-F143228', 'babar', '1', 1, '2026-05-08', '085855819394', '234534545678', 'https://i.ibb.co/nM3r9DVg/BUKTI-TF-1778177245.png', 'Sudah Pulang'),
(30, 'TCK-DC37731', 'keyboard', 'bangsatsari', 1, '2026-05-08', '085855819394', '67546536536', 'https://i.ibb.co/V00f2XP4/BUKTI-TF-1778177512.png', 'Sudah Pulang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `rating` int(1) NOT NULL,
  `teks` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('pending','tolak','setuju') DEFAULT 'pending',
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `nama`, `rating`, `teks`, `gambar`, `status`, `tanggal`) VALUES
(7, 'Lukman', 5, 'semoga ini berhasil', 'https://i.ibb.co/GvJrYY4D/ULASAN-1777892630-56.png', 'tolak', '2026-05-07 21:28:53'),
(10, 'z', 5, 'z', 'https://i.ibb.co/DHTVxCxc/ULASAN-1778000830-22.png', 'tolak', '2026-05-07 21:28:53');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id_denda`);

--
-- Indeks untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id_fasilitas`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indeks untuk tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rating`);

--
-- Indeks untuk tabel `rekap_laporan`
--
ALTER TABLE `rekap_laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `fk_rekap_tiket` (`id_tiket`);

--
-- Indeks untuk tabel `sampah`
--
ALTER TABLE `sampah`
  ADD PRIMARY KEY (`id_sampah`),
  ADD KEY `fk_sampah_tiket` (`id_tiket`);

--
-- Indeks untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id_tiket`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `denda`
--
ALTER TABLE `denda`
  MODIFY `id_denda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id_fasilitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekap_laporan`
--
ALTER TABLE `rekap_laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sampah`
--
ALTER TABLE `sampah`
  MODIFY `id_sampah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `rekap_laporan`
--
ALTER TABLE `rekap_laporan`
  ADD CONSTRAINT `fk_rekap_tiket` FOREIGN KEY (`id_tiket`) REFERENCES `tiket` (`id_tiket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sampah`
--
ALTER TABLE `sampah`
  ADD CONSTRAINT `fk_sampah_tiket` FOREIGN KEY (`id_tiket`) REFERENCES `tiket` (`id_tiket`) ON DELETE CASCADE;

DELIMITER $$
--
-- Event
--
CREATE DEFINER=`root`@`localhost` EVENT `hapus_tiket_kadaluarsa` ON SCHEDULE EVERY 1 DAY STARTS '2026-05-05 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM tiket 
  WHERE status = 'Belum Check-in' 
  AND tanggal_kunjungan < CURDATE()$$

CREATE DEFINER=`root`@`localhost` EVENT `auto_moderasi_ulasan` ON SCHEDULE EVERY 1 DAY STARTS '2026-05-07 21:29:08' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Hapus ulasan tolak yang umurnya lebih dari 1 tahun
    DELETE FROM `ulasan` WHERE `status` = 'tolak' AND `tanggal` < DATE_SUB(NOW(), INTERVAL 1 YEAR);
    -- Ubah status pending menjadi tolak jika umurnya lebih dari 1 minggu
    UPDATE `ulasan` SET `status` = 'tolak' WHERE `status` = 'pending' AND `tanggal` < DATE_SUB(NOW(), INTERVAL 1 WEEK);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
