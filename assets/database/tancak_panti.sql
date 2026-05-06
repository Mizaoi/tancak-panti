-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Bulan Mei 2026 pada 16.45
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
(9, 5, 'Lukman', 'Bungkus Makanan', 1, 10000);

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
(44, 20, 'Cup Plastik / Cup Mie', 1),
(45, 20, 'Kantong Plastik', 1),
(46, 20, 'Tisu', 1),
(47, 21, 'Cup Plastik / Cup Mie', 1),
(48, 21, 'Kantong Plastik', 1),
(49, 21, 'Tisu', 1),
(50, 22, 'Cup Plastik / Cup Mie', 1),
(51, 22, 'Kantong Plastik', 1),
(52, 22, 'Tisu', 1),
(53, 23, 'Cup Plastik / Cup Mie', 1),
(54, 23, 'Kantong Plastik', 1),
(55, 23, 'Tisu', 1);

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
(23, 'TCK-8575657', 'sendi', 'seruji', 15, '2026-05-04', '085855819394', '2867546345678', 'https://i.ibb.co/FLMc3b0R/BUKTI-TF-1777905580.png', 'Masih di Wisata');

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
  `status` enum('pending','tolak','setuju') DEFAULT 'setuju'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `nama`, `rating`, `teks`, `gambar`, `status`) VALUES
(7, 'Lukman', 5, 'semoga ini berhasil', 'https://i.ibb.co/GvJrYY4D/ULASAN-1777892630-56.png', 'setuju'),
(8, 'rating', 1, 'rating gua plis', 'https://i.ibb.co/JWXHnfMV/BUKTI-TF-1777892495-48.png', 'setuju');

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
  MODIFY `id_denda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `rekap_laporan`
--
ALTER TABLE `rekap_laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sampah`
--
ALTER TABLE `sampah`
  MODIFY `id_sampah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
