-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Apr 2026 pada 02.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

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
  `total_denda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(5, 3, 'Botol Plastik', 1);

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
(1, 'TCK-XDZKB9', 'lukman', 'langkap', 21, '2026-04-29', '123123123123', '321321321321', 'bukti_69f22cfac96ce.png', 'Belum Check-in'),
(2, 'TCK-ZRYPI6', 'asdf', 'bangsalsari', 23, '2026-04-29', '123123123123', '321312123123', 'bukti_69f23613c1b61.png', 'Masih di Wisata'),
(3, 'TCK-GD8F51', 'lukman', 'bangsalsari', 1, '2026-04-30', '085123506605', '085855819394', 'bukti_69f24a7eab6bb.png', 'Sudah Pulang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `rating` int(1) NOT NULL,
  `teks` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `nama`, `rating`, `teks`, `gambar`) VALUES
(1, 'Lukman', 5, 'senang sekali rasanya membuat dan merasakan pergi ke tancak itu.', 'tancak_69f22cbb1ec23.png');

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
  ADD PRIMARY KEY (`id_denda`),
  ADD KEY `fk_denda_tiket` (`id_tiket`);

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
  MODIFY `id_denda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekap_laporan`
--
ALTER TABLE `rekap_laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sampah`
--
ALTER TABLE `sampah`
  MODIFY `id_sampah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `fk_denda_tiket` FOREIGN KEY (`id_tiket`) REFERENCES `tiket` (`id_tiket`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
