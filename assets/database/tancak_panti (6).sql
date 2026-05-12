-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Bulan Mei 2026 pada 02.50
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
(123, 10101, '', '', 1, 10000),
(124, 10115, '', '', 2, 20000),
(125, 10210, '', '', 1, 10000),
(126, 10220, '', '', 3, 30000),
(127, 10312, '', '', 2, 20000),
(128, 10315, '', '', 1, 10000),
(129, 10415, '', '', 1, 10000),
(130, 10420, '', '', 2, 20000),
(131, 10512, '', '', 1, 10000),
(132, 10520, '', '', 2, 20000),
(133, 10601, '', '', 1, 10000),
(134, 10615, '', '', 2, 20000),
(135, 10710, '', '', 1, 10000),
(136, 10720, '', '', 3, 30000),
(137, 10812, '', '', 2, 20000),
(138, 10815, '', '', 1, 10000),
(139, 10915, '', '', 1, 10000),
(140, 10920, '', '', 2, 20000),
(141, 11012, '', '', 1, 10000),
(142, 11019, '', '', 2, 20000),
(143, 11505, '', '', 1, 10000),
(144, 11525, '', '', 2, 20000),
(145, 11545, '', '', 3, 30000),
(146, 11565, '', '', 1, 10000),
(147, 11585, '', '', 2, 20000),
(148, 11600, '', '', 1, 10000);

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
(128, 10101, 'Botol Plastik', 3),
(129, 10105, 'Bungkus Ciki', 2),
(130, 10115, 'Kresek Hitam', 4),
(131, 10202, 'Gelas Kopi', 4),
(132, 10210, 'Botol Kaca', 2),
(133, 10220, 'Kardus Snack', 3),
(134, 10303, 'Botol Plastik', 5),
(135, 10312, 'Kaleng Soda', 2),
(136, 10315, 'Kresek Putih', 4),
(137, 10404, 'Gelas Plastik', 6),
(138, 10415, 'Bungkus Permen', 5),
(139, 10420, 'Kotak Nasi', 2),
(140, 10505, 'Botol Plastik', 4),
(141, 10512, 'Bungkus Ciki', 3),
(142, 10520, 'Kaleng Minuman', 5),
(143, 10601, 'Botol Air Mineral', 3),
(144, 10605, 'Gelas Kopi', 2),
(145, 10615, 'Kresek Hitam', 4),
(146, 10702, 'Bungkus Makanan', 4),
(147, 10710, 'Botol Kaca', 2),
(148, 10720, 'Kardus Mie', 3),
(149, 10803, 'Plastik Makanan', 5),
(150, 10812, 'Kaleng Soda', 2),
(151, 10815, 'Kresek Putih', 4),
(152, 10904, 'Gelas Plastik', 6),
(153, 10915, 'Bungkus Permen', 5),
(154, 10920, 'Kotak Nasi', 2),
(155, 11005, 'Botol Susu', 4),
(156, 11012, 'Bungkus Roti', 3),
(157, 11019, 'Kaleng Minuman', 5),
(158, 11505, 'Botol Air Mineral', 6),
(159, 11515, 'Kresek Belanja', 4),
(160, 11525, 'Bungkus Snack', 5),
(161, 11535, 'Botol Kaca', 2),
(162, 11545, 'Gelas Kopi Plastik', 7),
(163, 11555, 'Kotak Nasi', 3),
(164, 11565, 'Bungkus Permen', 10),
(165, 11575, 'Kaleng Soda', 4),
(166, 11585, 'Sedotan Plastik', 8),
(167, 11595, 'Kardus Oleh-oleh', 2),
(168, 11600, 'Kresek Hitam', 5);

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
(10101, 'TCK-JAN-01', 'Wisatawan Jan 01', 'Jember', 2, '2026-01-01', '0811101', '', '', 'Sudah Pulang'),
(10102, 'TCK-JAN-02', 'Wisatawan Jan 02', 'Surabaya', 4, '2026-01-02', '0811102', '', '', 'Sudah Pulang'),
(10103, 'TCK-JAN-03', 'Wisatawan Jan 03', 'Malang', 3, '2026-01-04', '0811103', '', '', 'Sudah Pulang'),
(10104, 'TCK-JAN-04', 'Wisatawan Jan 04', 'Banyuwangi', 5, '2026-01-05', '0811104', '', '', 'Sudah Pulang'),
(10105, 'TCK-JAN-05', 'Wisatawan Jan 05', 'Sidoarjo', 2, '2026-01-07', '0811105', '', '', 'Sudah Pulang'),
(10106, 'TCK-JAN-06', 'Wisatawan Jan 06', 'Lumajang', 6, '2026-01-08', '0811106', '', '', 'Sudah Pulang'),
(10107, 'TCK-JAN-07', 'Wisatawan Jan 07', 'Situbondo', 3, '2026-01-10', '0811107', '', '', 'Sudah Pulang'),
(10108, 'TCK-JAN-08', 'Wisatawan Jan 08', 'Probolinggo', 2, '2026-01-12', '0811108', '', '', 'Sudah Pulang'),
(10109, 'TCK-JAN-09', 'Wisatawan Jan 09', 'Jember', 4, '2026-01-14', '0811109', '', '', 'Sudah Pulang'),
(10110, 'TCK-JAN-10', 'Wisatawan Jan 10', 'Malang', 5, '2026-01-15', '0811110', '', '', 'Sudah Pulang'),
(10111, 'TCK-JAN-11', 'Wisatawan Jan 11', 'Surabaya', 3, '2026-01-16', '0811111', '', '', 'Sudah Pulang'),
(10112, 'TCK-JAN-12', 'Wisatawan Jan 12', 'Banyuwangi', 2, '2026-01-18', '0811112', '', '', 'Sudah Pulang'),
(10113, 'TCK-JAN-13', 'Wisatawan Jan 13', 'Sidoarjo', 7, '2026-01-19', '0811113', '', '', 'Sudah Pulang'),
(10114, 'TCK-JAN-14', 'Wisatawan Jan 14', 'Lumajang', 4, '2026-01-20', '0811114', '', '', 'Sudah Pulang'),
(10115, 'TCK-JAN-15', 'Wisatawan Jan 15', 'Situbondo', 2, '2026-01-22', '0811115', '', '', 'Sudah Pulang'),
(10116, 'TCK-JAN-16', 'Wisatawan Jan 16', 'Probolinggo', 5, '2026-01-24', '0811116', '', '', 'Sudah Pulang'),
(10117, 'TCK-JAN-17', 'Wisatawan Jan 17', 'Jember', 3, '2026-01-26', '0811117', '', '', 'Sudah Pulang'),
(10118, 'TCK-JAN-18', 'Wisatawan Jan 18', 'Malang', 4, '2026-01-27', '0811118', '', '', 'Sudah Pulang'),
(10119, 'TCK-JAN-19', 'Wisatawan Jan 19', 'Surabaya', 2, '2026-01-28', '0811119', '', '', 'Sudah Pulang'),
(10120, 'TCK-JAN-20', 'Wisatawan Jan 20', 'Banyuwangi', 6, '2026-01-30', '0811120', '', '', 'Sudah Pulang'),
(10201, 'TCK-FEB-01', 'Wisatawan Feb 01', 'Jember', 2, '2026-02-01', '0822201', '', '', 'Sudah Pulang'),
(10202, 'TCK-FEB-02', 'Wisatawan Feb 02', 'Surabaya', 4, '2026-02-03', '0822202', '', '', 'Sudah Pulang'),
(10203, 'TCK-FEB-03', 'Wisatawan Feb 03', 'Malang', 3, '2026-02-04', '0822203', '', '', 'Sudah Pulang'),
(10204, 'TCK-FEB-04', 'Wisatawan Feb 04', 'Banyuwangi', 5, '2026-02-05', '0822204', '', '', 'Sudah Pulang'),
(10205, 'TCK-FEB-05', 'Wisatawan Feb 05', 'Sidoarjo', 2, '2026-02-07', '0822205', '', '', 'Sudah Pulang'),
(10206, 'TCK-FEB-06', 'Wisatawan Feb 06', 'Lumajang', 6, '2026-02-08', '0822206', '', '', 'Sudah Pulang'),
(10207, 'TCK-FEB-07', 'Wisatawan Feb 07', 'Situbondo', 3, '2026-02-09', '0822207', '', '', 'Sudah Pulang'),
(10208, 'TCK-FEB-08', 'Wisatawan Feb 08', 'Probolinggo', 2, '2026-02-11', '0822208', '', '', 'Sudah Pulang'),
(10209, 'TCK-FEB-09', 'Wisatawan Feb 09', 'Jember', 4, '2026-02-12', '0822209', '', '', 'Sudah Pulang'),
(10210, 'TCK-FEB-10', 'Wisatawan Feb 10', 'Malang', 5, '2026-02-14', '0822210', '', '', 'Sudah Pulang'),
(10211, 'TCK-FEB-11', 'Wisatawan Feb 11', 'Surabaya', 3, '2026-02-15', '0822211', '', '', 'Sudah Pulang'),
(10212, 'TCK-FEB-12', 'Wisatawan Feb 12', 'Banyuwangi', 2, '2026-02-17', '0822212', '', '', 'Sudah Pulang'),
(10213, 'TCK-FEB-13', 'Wisatawan Feb 13', 'Sidoarjo', 7, '2026-02-18', '0822213', '', '', 'Sudah Pulang'),
(10214, 'TCK-FEB-14', 'Wisatawan Feb 14', 'Lumajang', 4, '2026-02-20', '0822214', '', '', 'Sudah Pulang'),
(10215, 'TCK-FEB-15', 'Wisatawan Feb 15', 'Situbondo', 2, '2026-02-21', '0822215', '', '', 'Sudah Pulang'),
(10216, 'TCK-FEB-16', 'Wisatawan Feb 16', 'Probolinggo', 5, '2026-02-23', '0822216', '', '', 'Sudah Pulang'),
(10217, 'TCK-FEB-17', 'Wisatawan Feb 17', 'Jember', 3, '2026-02-24', '0822217', '', '', 'Sudah Pulang'),
(10218, 'TCK-FEB-18', 'Wisatawan Feb 18', 'Malang', 4, '2026-02-26', '0822218', '', '', 'Sudah Pulang'),
(10219, 'TCK-FEB-19', 'Wisatawan Feb 19', 'Surabaya', 2, '2026-02-27', '0822219', '', '', 'Sudah Pulang'),
(10220, 'TCK-FEB-20', 'Wisatawan Feb 20', 'Banyuwangi', 6, '2026-02-28', '0822220', '', '', 'Sudah Pulang'),
(10301, 'TCK-MAR-01', 'Wisatawan Mar 01', 'Jember', 2, '2026-03-01', '0833301', '', '', 'Sudah Pulang'),
(10302, 'TCK-MAR-02', 'Wisatawan Mar 02', 'Surabaya', 4, '2026-03-02', '0833302', '', '', 'Sudah Pulang'),
(10303, 'TCK-MAR-03', 'Wisatawan Mar 03', 'Malang', 3, '2026-03-04', '0833303', '', '', 'Sudah Pulang'),
(10304, 'TCK-MAR-04', 'Wisatawan Mar 04', 'Banyuwangi', 5, '2026-03-05', '0833304', '', '', 'Sudah Pulang'),
(10305, 'TCK-MAR-05', 'Wisatawan Mar 05', 'Sidoarjo', 2, '2026-03-07', '0833305', '', '', 'Sudah Pulang'),
(10306, 'TCK-MAR-06', 'Wisatawan Mar 06', 'Lumajang', 6, '2026-03-08', '0833306', '', '', 'Sudah Pulang'),
(10307, 'TCK-MAR-07', 'Wisatawan Mar 07', 'Situbondo', 3, '2026-03-10', '0833307', '', '', 'Sudah Pulang'),
(10308, 'TCK-MAR-08', 'Wisatawan Mar 08', 'Probolinggo', 2, '2026-03-12', '0833308', '', '', 'Sudah Pulang'),
(10309, 'TCK-MAR-09', 'Wisatawan Mar 09', 'Jember', 4, '2026-03-14', '0833309', '', '', 'Sudah Pulang'),
(10310, 'TCK-MAR-10', 'Wisatawan Mar 10', 'Malang', 5, '2026-03-15', '0833310', '', '', 'Sudah Pulang'),
(10311, 'TCK-MAR-11', 'Wisatawan Mar 11', 'Surabaya', 3, '2026-03-17', '0833311', '', '', 'Sudah Pulang'),
(10312, 'TCK-MAR-12', 'Wisatawan Mar 12', 'Banyuwangi', 2, '2026-03-18', '0833312', '', '', 'Sudah Pulang'),
(10313, 'TCK-MAR-13', 'Wisatawan Mar 13', 'Sidoarjo', 7, '2026-03-20', '0833313', '', '', 'Sudah Pulang'),
(10314, 'TCK-MAR-14', 'Wisatawan Mar 14', 'Lumajang', 4, '2026-03-21', '0833314', '', '', 'Sudah Pulang'),
(10315, 'TCK-MAR-15', 'Wisatawan Mar 15', 'Situbondo', 2, '2026-03-23', '0833315', '', '', 'Sudah Pulang'),
(10316, 'TCK-MAR-16', 'Wisatawan Mar 16', 'Probolinggo', 5, '2026-03-24', '0833316', '', '', 'Sudah Pulang'),
(10317, 'TCK-MAR-17', 'Wisatawan Mar 17', 'Jember', 3, '2026-03-26', '0833317', '', '', 'Sudah Pulang'),
(10318, 'TCK-MAR-18', 'Wisatawan Mar 18', 'Malang', 4, '2026-03-28', '0833318', '', '', 'Sudah Pulang'),
(10319, 'TCK-MAR-19', 'Wisatawan Mar 19', 'Surabaya', 2, '2026-03-29', '0833319', '', '', 'Sudah Pulang'),
(10320, 'TCK-MAR-20', 'Wisatawan Mar 20', 'Banyuwangi', 6, '2026-03-31', '0833320', '', '', 'Sudah Pulang'),
(10401, 'TCK-APR-01', 'Wisatawan Apr 01', 'Jember', 2, '2026-04-01', '0844401', '', '', 'Sudah Pulang'),
(10402, 'TCK-APR-02', 'Wisatawan Apr 02', 'Surabaya', 4, '2026-04-02', '0844402', '', '', 'Sudah Pulang'),
(10403, 'TCK-APR-03', 'Wisatawan Apr 03', 'Malang', 3, '2026-04-04', '0844403', '', '', 'Sudah Pulang'),
(10404, 'TCK-APR-04', 'Wisatawan Apr 04', 'Banyuwangi', 5, '2026-04-05', '0844404', '', '', 'Sudah Pulang'),
(10405, 'TCK-APR-05', 'Wisatawan Apr 05', 'Sidoarjo', 2, '2026-04-07', '0844405', '', '', 'Sudah Pulang'),
(10406, 'TCK-APR-06', 'Wisatawan Apr 06', 'Lumajang', 6, '2026-04-08', '0844406', '', '', 'Sudah Pulang'),
(10407, 'TCK-APR-07', 'Wisatawan Apr 07', 'Situbondo', 3, '2026-04-10', '0844407', '', '', 'Sudah Pulang'),
(10408, 'TCK-APR-08', 'Wisatawan Apr 08', 'Probolinggo', 2, '2026-04-12', '0844408', '', '', 'Sudah Pulang'),
(10409, 'TCK-APR-09', 'Wisatawan Apr 09', 'Jember', 4, '2026-04-14', '0844409', '', '', 'Sudah Pulang'),
(10410, 'TCK-APR-10', 'Wisatawan Apr 10', 'Malang', 5, '2026-04-15', '0844410', '', '', 'Sudah Pulang'),
(10411, 'TCK-APR-11', 'Wisatawan Apr 11', 'Surabaya', 3, '2026-04-16', '0844411', '', '', 'Sudah Pulang'),
(10412, 'TCK-APR-12', 'Wisatawan Apr 12', 'Banyuwangi', 2, '2026-04-18', '0844412', '', '', 'Sudah Pulang'),
(10413, 'TCK-APR-13', 'Wisatawan Apr 13', 'Sidoarjo', 7, '2026-04-19', '0844413', '', '', 'Sudah Pulang'),
(10414, 'TCK-APR-14', 'Wisatawan Apr 14', 'Lumajang', 4, '2026-04-20', '0844414', '', '', 'Sudah Pulang'),
(10415, 'TCK-APR-15', 'Wisatawan Apr 15', 'Situbondo', 2, '2026-04-22', '0844415', '', '', 'Sudah Pulang'),
(10416, 'TCK-APR-16', 'Wisatawan Apr 16', 'Probolinggo', 5, '2026-04-24', '0844416', '', '', 'Sudah Pulang'),
(10417, 'TCK-APR-17', 'Wisatawan Apr 17', 'Jember', 3, '2026-04-26', '0844417', '', '', 'Sudah Pulang'),
(10418, 'TCK-APR-18', 'Wisatawan Apr 18', 'Malang', 4, '2026-04-27', '0844418', '', '', 'Sudah Pulang'),
(10419, 'TCK-APR-19', 'Wisatawan Apr 19', 'Surabaya', 2, '2026-04-28', '0844419', '', '', 'Sudah Pulang'),
(10420, 'TCK-APR-20', 'Wisatawan Apr 20', 'Banyuwangi', 6, '2026-04-30', '0844420', '', '', 'Sudah Pulang'),
(10501, 'TCK-MEI-01', 'Wisatawan Mei 01', 'Jember', 2, '2026-05-01', '0855501', '', '', 'Sudah Pulang'),
(10502, 'TCK-MEI-02', 'Wisatawan Mei 02', 'Surabaya', 4, '2026-05-02', '0855502', '', '', 'Sudah Pulang'),
(10503, 'TCK-MEI-03', 'Wisatawan Mei 03', 'Malang', 3, '2026-05-03', '0855503', '', '', 'Sudah Pulang'),
(10504, 'TCK-MEI-04', 'Wisatawan Mei 04', 'Banyuwangi', 5, '2026-05-05', '0855504', '', '', 'Sudah Pulang'),
(10505, 'TCK-MEI-05', 'Wisatawan Mei 05', 'Sidoarjo', 2, '2026-05-06', '0855505', '', '', 'Sudah Pulang'),
(10506, 'TCK-MEI-06', 'Wisatawan Mei 06', 'Lumajang', 6, '2026-05-07', '0855506', '', '', 'Sudah Pulang'),
(10507, 'TCK-MEI-07', 'Wisatawan Mei 07', 'Situbondo', 3, '2026-05-09', '0855507', '', '', 'Sudah Pulang'),
(10508, 'TCK-MEI-08', 'Wisatawan Mei 08', 'Probolinggo', 2, '2026-05-10', '0855508', '', '', 'Masih di Wisata'),
(10509, 'TCK-MEI-09', 'Wisatawan Mei 09', 'Jember', 4, '2026-05-12', '0855509', '', '', 'Belum Check-in'),
(10510, 'TCK-MEI-10', 'Wisatawan Mei 10', 'Malang', 5, '2026-05-14', '0855510', '', '', 'Masih di Wisata'),
(10511, 'TCK-MEI-11', 'Wisatawan Mei 11', 'Surabaya', 3, '2026-05-15', '0855511', '', '', 'Belum Check-in'),
(10512, 'TCK-MEI-12', 'Wisatawan Mei 12', 'Banyuwangi', 2, '2026-05-17', '0855512', '', '', 'Sudah Pulang'),
(10513, 'TCK-MEI-13', 'Wisatawan Mei 13', 'Sidoarjo', 7, '2026-05-18', '0855513', '', '', 'Belum Check-in'),
(10514, 'TCK-MEI-14', 'Wisatawan Mei 14', 'Lumajang', 4, '2026-05-20', '0855514', '', '', 'Masih di Wisata'),
(10515, 'TCK-MEI-15', 'Wisatawan Mei 15', 'Situbondo', 2, '2026-05-22', '0855515', '', '', 'Sudah Pulang'),
(10516, 'TCK-MEI-16', 'Wisatawan Mei 16', 'Probolinggo', 5, '2026-05-24', '0855516', '', '', 'Masih di Wisata'),
(10517, 'TCK-MEI-17', 'Wisatawan Mei 17', 'Jember', 3, '2026-05-25', '0855517', '', '', 'Belum Check-in'),
(10518, 'TCK-MEI-18', 'Wisatawan Mei 18', 'Malang', 4, '2026-05-27', '0855518', '', '', 'Sudah Pulang'),
(10519, 'TCK-MEI-19', 'Wisatawan Mei 19', 'Surabaya', 2, '2026-05-29', '0855519', '', '', 'Belum Check-in'),
(10520, 'TCK-MEI-20', 'Wisatawan Mei 20', 'Banyuwangi', 6, '2026-05-31', '0855520', '', '', 'Masih di Wisata'),
(10601, 'TCK-JUN-01', 'Wisatawan Jun 01', 'Surabaya', 2, '2026-06-01', '0866601', '', '', 'Sudah Pulang'),
(10602, 'TCK-JUN-02', 'Wisatawan Jun 02', 'Jember', 4, '2026-06-02', '0866602', '', '', 'Sudah Pulang'),
(10603, 'TCK-JUN-03', 'Wisatawan Jun 03', 'Malang', 3, '2026-06-04', '0866603', '', '', 'Sudah Pulang'),
(10604, 'TCK-JUN-04', 'Wisatawan Jun 04', 'Banyuwangi', 5, '2026-06-05', '0866604', '', '', 'Sudah Pulang'),
(10605, 'TCK-JUN-05', 'Wisatawan Jun 05', 'Sidoarjo', 2, '2026-06-07', '0866605', '', '', 'Sudah Pulang'),
(10606, 'TCK-JUN-06', 'Wisatawan Jun 06', 'Lumajang', 6, '2026-06-08', '0866606', '', '', 'Sudah Pulang'),
(10607, 'TCK-JUN-07', 'Wisatawan Jun 07', 'Situbondo', 3, '2026-06-10', '0866607', '', '', 'Sudah Pulang'),
(10608, 'TCK-JUN-08', 'Wisatawan Jun 08', 'Probolinggo', 2, '2026-06-12', '0866608', '', '', 'Sudah Pulang'),
(10609, 'TCK-JUN-09', 'Wisatawan Jun 09', 'Jember', 4, '2026-06-14', '0866609', '', '', 'Sudah Pulang'),
(10610, 'TCK-JUN-10', 'Wisatawan Jun 10', 'Malang', 5, '2026-06-15', '0866610', '', '', 'Sudah Pulang'),
(10611, 'TCK-JUN-11', 'Wisatawan Jun 11', 'Surabaya', 3, '2026-06-16', '0866611', '', '', 'Sudah Pulang'),
(10612, 'TCK-JUN-12', 'Wisatawan Jun 12', 'Banyuwangi', 2, '2026-06-18', '0866612', '', '', 'Sudah Pulang'),
(10613, 'TCK-JUN-13', 'Wisatawan Jun 13', 'Sidoarjo', 7, '2026-06-19', '0866613', '', '', 'Sudah Pulang'),
(10614, 'TCK-JUN-14', 'Wisatawan Jun 14', 'Lumajang', 4, '2026-06-21', '0866614', '', '', 'Sudah Pulang'),
(10615, 'TCK-JUN-15', 'Wisatawan Jun 15', 'Situbondo', 2, '2026-06-22', '0866615', '', '', 'Sudah Pulang'),
(10616, 'TCK-JUN-16', 'Wisatawan Jun 16', 'Probolinggo', 5, '2026-06-24', '0866616', '', '', 'Sudah Pulang'),
(10617, 'TCK-JUN-17', 'Wisatawan Jun 17', 'Jember', 3, '2026-06-25', '0866617', '', '', 'Sudah Pulang'),
(10618, 'TCK-JUN-18', 'Wisatawan Jun 18', 'Malang', 4, '2026-06-27', '0866618', '', '', 'Sudah Pulang'),
(10619, 'TCK-JUN-19', 'Wisatawan Jun 19', 'Surabaya', 2, '2026-06-28', '0866619', '', '', 'Sudah Pulang'),
(10620, 'TCK-JUN-20', 'Wisatawan Jun 20', 'Banyuwangi', 6, '2026-06-30', '0866620', '', '', 'Sudah Pulang'),
(10701, 'TCK-JUL-01', 'Wisatawan Jul 01', 'Jember', 3, '2026-07-02', '0877701', '', '', 'Sudah Pulang'),
(10702, 'TCK-JUL-02', 'Wisatawan Jul 02', 'Surabaya', 2, '2026-07-03', '0877702', '', '', 'Sudah Pulang'),
(10703, 'TCK-JUL-03', 'Wisatawan Jul 03', 'Malang', 5, '2026-07-05', '0877703', '', '', 'Sudah Pulang'),
(10704, 'TCK-JUL-04', 'Wisatawan Jul 04', 'Banyuwangi', 4, '2026-07-06', '0877704', '', '', 'Sudah Pulang'),
(10705, 'TCK-JUL-05', 'Wisatawan Jul 05', 'Sidoarjo', 3, '2026-07-08', '0877705', '', '', 'Sudah Pulang'),
(10706, 'TCK-JUL-06', 'Wisatawan Jul 06', 'Lumajang', 6, '2026-07-09', '0877706', '', '', 'Sudah Pulang'),
(10707, 'TCK-JUL-07', 'Wisatawan Jul 07', 'Situbondo', 2, '2026-07-11', '0877707', '', '', 'Sudah Pulang'),
(10708, 'TCK-JUL-08', 'Wisatawan Jul 08', 'Probolinggo', 5, '2026-07-12', '0877708', '', '', 'Sudah Pulang'),
(10709, 'TCK-JUL-09', 'Wisatawan Jul 09', 'Jember', 4, '2026-07-14', '0877709', '', '', 'Sudah Pulang'),
(10710, 'TCK-JUL-10', 'Wisatawan Jul 10', 'Malang', 2, '2026-07-15', '0877710', '', '', 'Sudah Pulang'),
(10711, 'TCK-JUL-11', 'Wisatawan Jul 11', 'Surabaya', 7, '2026-07-17', '0877711', '', '', 'Sudah Pulang'),
(10712, 'TCK-JUL-12', 'Wisatawan Jul 12', 'Banyuwangi', 3, '2026-07-18', '0877712', '', '', 'Sudah Pulang'),
(10713, 'TCK-JUL-13', 'Wisatawan Jul 13', 'Sidoarjo', 5, '2026-07-20', '0877713', '', '', 'Sudah Pulang'),
(10714, 'TCK-JUL-14', 'Wisatawan Jul 14', 'Lumajang', 2, '2026-07-21', '0877714', '', '', 'Sudah Pulang'),
(10715, 'TCK-JUL-15', 'Wisatawan Jul 15', 'Situbondo', 4, '2026-07-23', '0877715', '', '', 'Sudah Pulang'),
(10716, 'TCK-JUL-16', 'Wisatawan Jul 16', 'Probolinggo', 3, '2026-07-24', '0877716', '', '', 'Sudah Pulang'),
(10717, 'TCK-JUL-17', 'Wisatawan Jul 17', 'Jember', 6, '2026-07-26', '0877717', '', '', 'Sudah Pulang'),
(10718, 'TCK-JUL-18', 'Wisatawan Jul 18', 'Malang', 2, '2026-07-27', '0877718', '', '', 'Sudah Pulang'),
(10719, 'TCK-JUL-19', 'Wisatawan Jul 19', 'Surabaya', 4, '2026-07-29', '0877719', '', '', 'Sudah Pulang'),
(10720, 'TCK-JUL-20', 'Wisatawan Jul 20', 'Banyuwangi', 5, '2026-07-31', '0877720', '', '', 'Sudah Pulang'),
(10801, 'TCK-AGU-01', 'Wisatawan Agu 01', 'Sidoarjo', 2, '2026-08-01', '0888801', '', '', 'Sudah Pulang'),
(10802, 'TCK-AGU-02', 'Wisatawan Agu 02', 'Probolinggo', 4, '2026-08-03', '0888802', '', '', 'Sudah Pulang'),
(10803, 'TCK-AGU-03', 'Wisatawan Agu 03', 'Situbondo', 3, '2026-08-04', '0888803', '', '', 'Sudah Pulang'),
(10804, 'TCK-AGU-04', 'Wisatawan Agu 04', 'Lumajang', 5, '2026-08-06', '0888804', '', '', 'Sudah Pulang'),
(10805, 'TCK-AGU-05', 'Wisatawan Agu 05', 'Jember', 2, '2026-08-07', '0888805', '', '', 'Sudah Pulang'),
(10806, 'TCK-AGU-06', 'Wisatawan Agu 06', 'Malang', 6, '2026-08-09', '0888806', '', '', 'Sudah Pulang'),
(10807, 'TCK-AGU-07', 'Wisatawan Agu 07', 'Surabaya', 3, '2026-08-10', '0888807', '', '', 'Sudah Pulang'),
(10808, 'TCK-AGU-08', 'Wisatawan Agu 08', 'Banyuwangi', 2, '2026-08-12', '0888808', '', '', 'Sudah Pulang'),
(10809, 'TCK-AGU-09', 'Wisatawan Agu 09', 'Sidoarjo', 4, '2026-08-13', '0888809', '', '', 'Sudah Pulang'),
(10810, 'TCK-AGU-10', 'Wisatawan Agu 10', 'Probolinggo', 5, '2026-08-15', '0888810', '', '', 'Sudah Pulang'),
(10811, 'TCK-AGU-11', 'Wisatawan Agu 11', 'Situbondo', 3, '2026-08-16', '0888811', '', '', 'Sudah Pulang'),
(10812, 'TCK-AGU-12', 'Wisatawan Agu 12', 'Lumajang', 2, '2026-08-18', '0888812', '', '', 'Sudah Pulang'),
(10813, 'TCK-AGU-13', 'Wisatawan Agu 13', 'Jember', 7, '2026-08-19', '0888813', '', '', 'Sudah Pulang'),
(10814, 'TCK-AGU-14', 'Wisatawan Agu 14', 'Malang', 4, '2026-08-21', '0888814', '', '', 'Sudah Pulang'),
(10815, 'TCK-AGU-15', 'Wisatawan Agu 15', 'Surabaya', 2, '2026-08-22', '0888815', '', '', 'Sudah Pulang'),
(10816, 'TCK-AGU-16', 'Wisatawan Agu 16', 'Banyuwangi', 5, '2026-08-24', '0888816', '', '', 'Sudah Pulang'),
(10817, 'TCK-AGU-17', 'Wisatawan Agu 17', 'Sidoarjo', 3, '2026-08-25', '0888817', '', '', 'Sudah Pulang'),
(10818, 'TCK-AGU-18', 'Wisatawan Agu 18', 'Probolinggo', 4, '2026-08-27', '0888818', '', '', 'Sudah Pulang'),
(10819, 'TCK-AGU-19', 'Wisatawan Agu 19', 'Situbondo', 2, '2026-08-28', '0888819', '', '', 'Sudah Pulang'),
(10820, 'TCK-AGU-20', 'Wisatawan Agu 20', 'Lumajang', 6, '2026-08-30', '0888820', '', '', 'Sudah Pulang'),
(10901, 'TCK-SEP-01', 'Wisatawan Sep 01', 'Probolinggo', 4, '2026-09-02', '0899901', '', '', 'Sudah Pulang'),
(10902, 'TCK-SEP-02', 'Wisatawan Sep 02', 'Situbondo', 2, '2026-09-03', '0899902', '', '', 'Sudah Pulang'),
(10903, 'TCK-SEP-03', 'Wisatawan Sep 03', 'Lumajang', 5, '2026-09-05', '0899903', '', '', 'Sudah Pulang'),
(10904, 'TCK-SEP-04', 'Wisatawan Sep 04', 'Jember', 3, '2026-09-06', '0899904', '', '', 'Sudah Pulang'),
(10905, 'TCK-SEP-05', 'Wisatawan Sep 05', 'Malang', 6, '2026-09-08', '0899905', '', '', 'Sudah Pulang'),
(10906, 'TCK-SEP-06', 'Wisatawan Sep 06', 'Surabaya', 2, '2026-09-09', '0899906', '', '', 'Sudah Pulang'),
(10907, 'TCK-SEP-07', 'Wisatawan Sep 07', 'Banyuwangi', 4, '2026-09-11', '0899907', '', '', 'Sudah Pulang'),
(10908, 'TCK-SEP-08', 'Wisatawan Sep 08', 'Sidoarjo', 3, '2026-09-12', '0899908', '', '', 'Sudah Pulang'),
(10909, 'TCK-SEP-09', 'Wisatawan Sep 09', 'Probolinggo', 5, '2026-09-14', '0899909', '', '', 'Sudah Pulang'),
(10910, 'TCK-SEP-10', 'Wisatawan Sep 10', 'Situbondo', 2, '2026-09-15', '0899910', '', '', 'Sudah Pulang'),
(10911, 'TCK-SEP-11', 'Wisatawan Sep 11', 'Lumajang', 7, '2026-09-17', '0899911', '', '', 'Sudah Pulang'),
(10912, 'TCK-SEP-12', 'Wisatawan Sep 12', 'Jember', 4, '2026-09-18', '0899912', '', '', 'Sudah Pulang'),
(10913, 'TCK-SEP-13', 'Wisatawan Sep 13', 'Malang', 2, '2026-09-20', '0899913', '', '', 'Sudah Pulang'),
(10914, 'TCK-SEP-14', 'Wisatawan Sep 14', 'Surabaya', 5, '2026-09-21', '0899914', '', '', 'Sudah Pulang'),
(10915, 'TCK-SEP-15', 'Wisatawan Sep 15', 'Banyuwangi', 3, '2026-09-23', '0899915', '', '', 'Sudah Pulang'),
(10916, 'TCK-SEP-16', 'Wisatawan Sep 16', 'Sidoarjo', 2, '2026-09-24', '0899916', '', '', 'Sudah Pulang'),
(10917, 'TCK-SEP-17', 'Wisatawan Sep 17', 'Probolinggo', 6, '2026-09-26', '0899917', '', '', 'Sudah Pulang'),
(10918, 'TCK-SEP-18', 'Wisatawan Sep 18', 'Situbondo', 4, '2026-09-27', '0899918', '', '', 'Sudah Pulang'),
(10919, 'TCK-SEP-19', 'Wisatawan Sep 19', 'Lumajang', 3, '2026-09-29', '0899919', '', '', 'Sudah Pulang'),
(10920, 'TCK-SEP-20', 'Wisatawan Sep 20', 'Jember', 5, '2026-09-30', '0899920', '', '', 'Sudah Pulang'),
(11001, 'TCK-OKT-01', 'Wisatawan Okt 01', 'Banyuwangi', 5, '2026-10-01', '0810101', '', '', 'Sudah Pulang'),
(11002, 'TCK-OKT-02', 'Wisatawan Okt 02', 'Malang', 2, '2026-10-02', '0810102', '', '', 'Sudah Pulang'),
(11003, 'TCK-OKT-03', 'Wisatawan Okt 03', 'Surabaya', 4, '2026-10-04', '0810103', '', '', 'Sudah Pulang'),
(11004, 'TCK-OKT-04', 'Wisatawan Okt 04', 'Jember', 3, '2026-10-05', '0810104', '', '', 'Sudah Pulang'),
(11005, 'TCK-OKT-05', 'Wisatawan Okt 05', 'Lumajang', 6, '2026-10-07', '0810105', '', '', 'Sudah Pulang'),
(11006, 'TCK-OKT-06', 'Wisatawan Okt 06', 'Situbondo', 2, '2026-10-08', '0810106', '', '', 'Sudah Pulang'),
(11007, 'TCK-OKT-07', 'Wisatawan Okt 07', 'Probolinggo', 5, '2026-10-10', '0810107', '', '', 'Sudah Pulang'),
(11008, 'TCK-OKT-08', 'Wisatawan Okt 08', 'Sidoarjo', 3, '2026-10-11', '0810108', '', '', 'Sudah Pulang'),
(11009, 'TCK-OKT-09', 'Wisatawan Okt 09', 'Banyuwangi', 4, '2026-10-13', '0810109', '', '', 'Sudah Pulang'),
(11010, 'TCK-OKT-10', 'Wisatawan Okt 10', 'Malang', 2, '2026-10-14', '0810110', '', '', 'Sudah Pulang'),
(11011, 'TCK-OKT-11', 'Wisatawan Okt 11', 'Surabaya', 7, '2026-10-16', '0810111', '', '', 'Sudah Pulang'),
(11012, 'TCK-OKT-12', 'Wisatawan Okt 12', 'Jember', 4, '2026-10-17', '0810112', '', '', 'Sudah Pulang'),
(11013, 'TCK-OKT-13', 'Wisatawan Okt 13', 'Lumajang', 2, '2026-10-19', '0810113', '', '', 'Sudah Pulang'),
(11014, 'TCK-OKT-14', 'Wisatawan Okt 14', 'Situbondo', 5, '2026-10-20', '0810114', '', '', 'Sudah Pulang'),
(11015, 'TCK-OKT-15', 'Wisatawan Okt 15', 'Probolinggo', 3, '2026-10-22', '0810115', '', '', 'Sudah Pulang'),
(11016, 'TCK-OKT-16', 'Wisatawan Okt 16', 'Sidoarjo', 2, '2026-10-23', '0810116', '', '', 'Sudah Pulang'),
(11017, 'TCK-OKT-17', 'Wisatawan Okt 17', 'Banyuwangi', 6, '2026-10-25', '0810117', '', '', 'Masih di Wisata'),
(11018, 'TCK-OKT-18', 'Wisatawan Okt 18', 'Malang', 4, '2026-10-26', '0810118', '', '', 'Belum Check-in'),
(11019, 'TCK-OKT-19', 'Wisatawan Okt 19', 'Jember', 5, '2026-10-28', '0810119', '', '', 'Masih di Wisata'),
(11020, 'TCK-OKT-20', 'Wisatawan Okt 20', 'Surabaya', 3, '2026-10-31', '0810120', '', '', 'Belum Check-in'),
(11501, 'TCK-MEI-051', 'Wisatawan Ekstra 01', 'Surabaya', 4, '2026-05-01', '0855101', '', '', 'Sudah Pulang'),
(11502, 'TCK-MEI-052', 'Wisatawan Ekstra 02', 'Malang', 2, '2026-05-01', '0855102', '', '', 'Sudah Pulang'),
(11503, 'TCK-MEI-053', 'Wisatawan Ekstra 03', 'Jember', 6, '2026-05-01', '0855103', '', '', 'Sudah Pulang'),
(11504, 'TCK-MEI-054', 'Wisatawan Ekstra 04', 'Banyuwangi', 3, '2026-05-02', '0855104', '', '', 'Sudah Pulang'),
(11505, 'TCK-MEI-055', 'Wisatawan Ekstra 05', 'Sidoarjo', 5, '2026-05-02', '0855105', '', '', 'Sudah Pulang'),
(11506, 'TCK-MEI-056', 'Wisatawan Ekstra 06', 'Lumajang', 2, '2026-05-02', '0855106', '', '', 'Sudah Pulang'),
(11507, 'TCK-MEI-057', 'Wisatawan Ekstra 07', 'Situbondo', 7, '2026-05-03', '0855107', '', '', 'Sudah Pulang'),
(11508, 'TCK-MEI-058', 'Wisatawan Ekstra 08', 'Probolinggo', 4, '2026-05-03', '0855108', '', '', 'Sudah Pulang'),
(11509, 'TCK-MEI-059', 'Wisatawan Ekstra 09', 'Surabaya', 3, '2026-05-04', '0855109', '', '', 'Sudah Pulang'),
(11510, 'TCK-MEI-060', 'Wisatawan Ekstra 10', 'Malang', 5, '2026-05-04', '0855110', '', '', 'Sudah Pulang'),
(11511, 'TCK-MEI-061', 'Wisatawan Ekstra 11', 'Jember', 2, '2026-05-05', '0855111', '', '', 'Sudah Pulang'),
(11512, 'TCK-MEI-062', 'Wisatawan Ekstra 12', 'Banyuwangi', 6, '2026-05-05', '0855112', '', '', 'Sudah Pulang'),
(11513, 'TCK-MEI-063', 'Wisatawan Ekstra 13', 'Sidoarjo', 4, '2026-05-06', '0855113', '', '', 'Sudah Pulang'),
(11514, 'TCK-MEI-064', 'Wisatawan Ekstra 14', 'Lumajang', 3, '2026-05-06', '0855114', '', '', 'Sudah Pulang'),
(11515, 'TCK-MEI-065', 'Wisatawan Ekstra 15', 'Situbondo', 8, '2026-05-07', '0855115', '', '', 'Sudah Pulang'),
(11516, 'TCK-MEI-066', 'Wisatawan Ekstra 16', 'Probolinggo', 2, '2026-05-07', '0855116', '', '', 'Sudah Pulang'),
(11517, 'TCK-MEI-067', 'Wisatawan Ekstra 17', 'Surabaya', 5, '2026-05-08', '0855117', '', '', 'Sudah Pulang'),
(11518, 'TCK-MEI-068', 'Wisatawan Ekstra 18', 'Malang', 4, '2026-05-08', '0855118', '', '', 'Sudah Pulang'),
(11519, 'TCK-MEI-069', 'Wisatawan Ekstra 19', 'Jember', 3, '2026-05-09', '0855119', '', '', 'Sudah Pulang'),
(11520, 'TCK-MEI-070', 'Wisatawan Ekstra 20', 'Banyuwangi', 6, '2026-05-09', '0855120', '', '', 'Sudah Pulang'),
(11521, 'TCK-MEI-071', 'Wisatawan Ekstra 21', 'Sidoarjo', 2, '2026-05-10', '0855121', '', '', 'Sudah Pulang'),
(11522, 'TCK-MEI-072', 'Wisatawan Ekstra 22', 'Lumajang', 7, '2026-05-10', '0855122', '', '', 'Sudah Pulang'),
(11523, 'TCK-MEI-073', 'Wisatawan Ekstra 23', 'Situbondo', 4, '2026-05-11', '0855123', '', '', 'Sudah Pulang'),
(11524, 'TCK-MEI-074', 'Wisatawan Ekstra 24', 'Probolinggo', 3, '2026-05-11', '0855124', '', '', 'Sudah Pulang'),
(11525, 'TCK-MEI-075', 'Wisatawan Ekstra 25', 'Surabaya', 5, '2026-05-12', '0855125', '', '', 'Sudah Pulang'),
(11526, 'TCK-MEI-076', 'Wisatawan Ekstra 26', 'Malang', 2, '2026-05-12', '0855126', '', '', 'Sudah Pulang'),
(11527, 'TCK-MEI-077', 'Wisatawan Ekstra 27', 'Jember', 6, '2026-05-13', '0855127', '', '', 'Sudah Pulang'),
(11528, 'TCK-MEI-078', 'Wisatawan Ekstra 28', 'Banyuwangi', 4, '2026-05-13', '0855128', '', '', 'Sudah Pulang'),
(11529, 'TCK-MEI-079', 'Wisatawan Ekstra 29', 'Sidoarjo', 3, '2026-05-14', '0855129', '', '', 'Sudah Pulang'),
(11530, 'TCK-MEI-080', 'Wisatawan Ekstra 30', 'Lumajang', 5, '2026-05-14', '0855130', '', '', 'Sudah Pulang'),
(11531, 'TCK-MEI-081', 'Wisatawan Ekstra 31', 'Situbondo', 2, '2026-05-15', '0855131', '', '', 'Sudah Pulang'),
(11532, 'TCK-MEI-082', 'Wisatawan Ekstra 32', 'Probolinggo', 8, '2026-05-15', '0855132', '', '', 'Sudah Pulang'),
(11533, 'TCK-MEI-083', 'Wisatawan Ekstra 33', 'Surabaya', 4, '2026-05-16', '0855133', '', '', 'Sudah Pulang'),
(11534, 'TCK-MEI-084', 'Wisatawan Ekstra 34', 'Malang', 3, '2026-05-16', '0855134', '', '', 'Sudah Pulang'),
(11535, 'TCK-MEI-085', 'Wisatawan Ekstra 35', 'Jember', 5, '2026-05-17', '0855135', '', '', 'Sudah Pulang'),
(11536, 'TCK-MEI-086', 'Wisatawan Ekstra 36', 'Banyuwangi', 2, '2026-05-17', '0855136', '', '', 'Sudah Pulang'),
(11537, 'TCK-MEI-087', 'Wisatawan Ekstra 37', 'Sidoarjo', 6, '2026-05-18', '0855137', '', '', 'Sudah Pulang'),
(11538, 'TCK-MEI-088', 'Wisatawan Ekstra 38', 'Lumajang', 4, '2026-05-18', '0855138', '', '', 'Sudah Pulang'),
(11539, 'TCK-MEI-089', 'Wisatawan Ekstra 39', 'Situbondo', 3, '2026-05-19', '0855139', '', '', 'Sudah Pulang'),
(11540, 'TCK-MEI-090', 'Wisatawan Ekstra 40', 'Probolinggo', 5, '2026-05-19', '0855140', '', '', 'Sudah Pulang'),
(11541, 'TCK-MEI-091', 'Wisatawan Ekstra 41', 'Surabaya', 2, '2026-05-20', '0855141', '', '', 'Sudah Pulang'),
(11542, 'TCK-MEI-092', 'Wisatawan Ekstra 42', 'Malang', 7, '2026-05-20', '0855142', '', '', 'Sudah Pulang'),
(11543, 'TCK-MEI-093', 'Wisatawan Ekstra 43', 'Jember', 4, '2026-05-21', '0855143', '', '', 'Sudah Pulang'),
(11544, 'TCK-MEI-094', 'Wisatawan Ekstra 44', 'Banyuwangi', 3, '2026-05-21', '0855144', '', '', 'Sudah Pulang'),
(11545, 'TCK-MEI-095', 'Wisatawan Ekstra 45', 'Sidoarjo', 5, '2026-05-22', '0855145', '', '', 'Sudah Pulang'),
(11546, 'TCK-MEI-096', 'Wisatawan Ekstra 46', 'Lumajang', 2, '2026-05-22', '0855146', '', '', 'Sudah Pulang'),
(11547, 'TCK-MEI-097', 'Wisatawan Ekstra 47', 'Situbondo', 6, '2026-05-23', '0855147', '', '', 'Sudah Pulang'),
(11548, 'TCK-MEI-098', 'Wisatawan Ekstra 48', 'Probolinggo', 4, '2026-05-23', '0855148', '', '', 'Sudah Pulang'),
(11549, 'TCK-MEI-099', 'Wisatawan Ekstra 49', 'Surabaya', 3, '2026-05-24', '0855149', '', '', 'Sudah Pulang'),
(11550, 'TCK-MEI-100', 'Wisatawan Ekstra 50', 'Malang', 5, '2026-05-24', '0855150', '', '', 'Sudah Pulang'),
(11551, 'TCK-MEI-101', 'Wisatawan Ekstra 51', 'Jember', 2, '2026-05-25', '0855151', '', '', 'Sudah Pulang'),
(11552, 'TCK-MEI-102', 'Wisatawan Ekstra 52', 'Banyuwangi', 8, '2026-05-25', '0855152', '', '', 'Sudah Pulang'),
(11553, 'TCK-MEI-103', 'Wisatawan Ekstra 53', 'Sidoarjo', 4, '2026-05-26', '0855153', '', '', 'Sudah Pulang'),
(11554, 'TCK-MEI-104', 'Wisatawan Ekstra 54', 'Lumajang', 3, '2026-05-26', '0855154', '', '', 'Sudah Pulang'),
(11555, 'TCK-MEI-105', 'Wisatawan Ekstra 55', 'Situbondo', 5, '2026-05-27', '0855155', '', '', 'Sudah Pulang'),
(11556, 'TCK-MEI-106', 'Wisatawan Ekstra 56', 'Probolinggo', 2, '2026-05-27', '0855156', '', '', 'Sudah Pulang'),
(11557, 'TCK-MEI-107', 'Wisatawan Ekstra 57', 'Surabaya', 6, '2026-05-28', '0855157', '', '', 'Sudah Pulang'),
(11558, 'TCK-MEI-108', 'Wisatawan Ekstra 58', 'Malang', 4, '2026-05-28', '0855158', '', '', 'Sudah Pulang'),
(11559, 'TCK-MEI-109', 'Wisatawan Ekstra 59', 'Jember', 3, '2026-05-29', '0855159', '', '', 'Sudah Pulang'),
(11560, 'TCK-MEI-110', 'Wisatawan Ekstra 60', 'Banyuwangi', 5, '2026-05-29', '0855160', '', '', 'Sudah Pulang'),
(11561, 'TCK-MEI-111', 'Wisatawan Ekstra 61', 'Sidoarjo', 2, '2026-05-30', '0855161', '', '', 'Sudah Pulang'),
(11562, 'TCK-MEI-112', 'Wisatawan Ekstra 62', 'Lumajang', 7, '2026-05-30', '0855162', '', '', 'Sudah Pulang'),
(11563, 'TCK-MEI-113', 'Wisatawan Ekstra 63', 'Situbondo', 4, '2026-05-31', '0855163', '', '', 'Sudah Pulang'),
(11564, 'TCK-MEI-114', 'Wisatawan Ekstra 64', 'Probolinggo', 3, '2026-05-31', '0855164', '', '', 'Sudah Pulang'),
(11565, 'TCK-MEI-115', 'Wisatawan Ekstra 65', 'Surabaya', 5, '2026-05-01', '0855165', '', '', 'Belum Check-in'),
(11566, 'TCK-MEI-116', 'Wisatawan Ekstra 66', 'Malang', 2, '2026-05-02', '0855166', '', '', 'Masih di Wisata'),
(11567, 'TCK-MEI-117', 'Wisatawan Ekstra 67', 'Jember', 6, '2026-05-03', '0855167', '', '', 'Belum Check-in'),
(11568, 'TCK-MEI-118', 'Wisatawan Ekstra 68', 'Banyuwangi', 4, '2026-05-04', '0855168', '', '', 'Masih di Wisata'),
(11569, 'TCK-MEI-119', 'Wisatawan Ekstra 69', 'Sidoarjo', 3, '2026-05-05', '0855169', '', '', 'Belum Check-in'),
(11570, 'TCK-MEI-120', 'Wisatawan Ekstra 70', 'Lumajang', 5, '2026-05-06', '0855170', '', '', 'Masih di Wisata'),
(11571, 'TCK-MEI-121', 'Wisatawan Ekstra 71', 'Situbondo', 2, '2026-05-07', '0855171', '', '', 'Belum Check-in'),
(11572, 'TCK-MEI-122', 'Wisatawan Ekstra 72', 'Probolinggo', 8, '2026-05-08', '0855172', '', '', 'Masih di Wisata'),
(11573, 'TCK-MEI-123', 'Wisatawan Ekstra 73', 'Surabaya', 4, '2026-05-09', '0855173', '', '', 'Belum Check-in'),
(11574, 'TCK-MEI-124', 'Wisatawan Ekstra 74', 'Malang', 3, '2026-05-10', '0855174', '', '', 'Masih di Wisata'),
(11575, 'TCK-MEI-125', 'Wisatawan Ekstra 75', 'Jember', 5, '2026-05-11', '0855175', '', '', 'Belum Check-in'),
(11576, 'TCK-MEI-126', 'Wisatawan Ekstra 76', 'Banyuwangi', 2, '2026-05-12', '0855176', '', '', 'Masih di Wisata'),
(11577, 'TCK-MEI-127', 'Wisatawan Ekstra 77', 'Sidoarjo', 6, '2026-05-13', '0855177', '', '', 'Belum Check-in'),
(11578, 'TCK-MEI-128', 'Wisatawan Ekstra 78', 'Lumajang', 4, '2026-05-14', '0855178', '', '', 'Masih di Wisata'),
(11579, 'TCK-MEI-129', 'Wisatawan Ekstra 79', 'Situbondo', 3, '2026-05-15', '0855179', '', '', 'Belum Check-in'),
(11580, 'TCK-MEI-130', 'Wisatawan Ekstra 80', 'Probolinggo', 5, '2026-05-16', '0855180', '', '', 'Masih di Wisata'),
(11581, 'TCK-MEI-131', 'Wisatawan Ekstra 81', 'Surabaya', 2, '2026-05-17', '0855181', '', '', 'Belum Check-in'),
(11582, 'TCK-MEI-132', 'Wisatawan Ekstra 82', 'Malang', 7, '2026-05-18', '0855182', '', '', 'Masih di Wisata'),
(11583, 'TCK-MEI-133', 'Wisatawan Ekstra 83', 'Jember', 4, '2026-05-19', '0855183', '', '', 'Belum Check-in'),
(11584, 'TCK-MEI-134', 'Wisatawan Ekstra 84', 'Banyuwangi', 3, '2026-05-20', '0855184', '', '', 'Masih di Wisata'),
(11585, 'TCK-MEI-135', 'Wisatawan Ekstra 85', 'Sidoarjo', 5, '2026-05-21', '0855185', '', '', 'Belum Check-in'),
(11586, 'TCK-MEI-136', 'Wisatawan Ekstra 86', 'Lumajang', 2, '2026-05-22', '0855186', '', '', 'Masih di Wisata'),
(11587, 'TCK-MEI-137', 'Wisatawan Ekstra 87', 'Situbondo', 6, '2026-05-23', '0855187', '', '', 'Belum Check-in'),
(11588, 'TCK-MEI-138', 'Wisatawan Ekstra 88', 'Probolinggo', 4, '2026-05-24', '0855188', '', '', 'Masih di Wisata'),
(11589, 'TCK-MEI-139', 'Wisatawan Ekstra 89', 'Surabaya', 3, '2026-05-25', '0855189', '', '', 'Belum Check-in'),
(11590, 'TCK-MEI-140', 'Wisatawan Ekstra 90', 'Malang', 5, '2026-05-26', '0855190', '', '', 'Masih di Wisata'),
(11591, 'TCK-MEI-141', 'Wisatawan Ekstra 91', 'Jember', 2, '2026-05-27', '0855191', '', '', 'Belum Check-in'),
(11592, 'TCK-MEI-142', 'Wisatawan Ekstra 92', 'Banyuwangi', 8, '2026-05-28', '0855192', '', '', 'Masih di Wisata'),
(11593, 'TCK-MEI-143', 'Wisatawan Ekstra 93', 'Sidoarjo', 4, '2026-05-29', '0855193', '', '', 'Belum Check-in'),
(11594, 'TCK-MEI-144', 'Wisatawan Ekstra 94', 'Lumajang', 3, '2026-05-30', '0855194', '', '', 'Masih di Wisata'),
(11595, 'TCK-MEI-145', 'Wisatawan Ekstra 95', 'Situbondo', 5, '2026-05-31', '0855195', '', '', 'Belum Check-in'),
(11596, 'TCK-MEI-146', 'Wisatawan Ekstra 96', 'Probolinggo', 2, '2026-05-01', '0855196', '', '', 'Masih di Wisata'),
(11597, 'TCK-MEI-147', 'Wisatawan Ekstra 97', 'Surabaya', 6, '2026-05-05', '0855197', '', '', 'Belum Check-in'),
(11598, 'TCK-MEI-148', 'Wisatawan Ekstra 98', 'Malang', 4, '2026-05-10', '0855198', '', '', 'Masih di Wisata'),
(11599, 'TCK-MEI-149', 'Wisatawan Ekstra 99', 'Jember', 3, '2026-05-15', '0855199', '', '', 'Belum Check-in'),
(11600, 'TCK-MEI-150', 'Wisatawan Ekstra 100', 'Banyuwangi', 5, '2026-05-20', '0855200', '', '', 'Masih di Wisata');

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
(20, 'Lukman', 5, 'bagaimana sekarang berhasil tida?', 'https://i.ibb.co/674Nhqhg/ULASAN-1778457283.png', 'tolak', '2026-05-11 06:54:44'),
(21, 'Bagus (April)', 5, 'Bulan April ke sini cuacanya mantap! Air terjunnya jernih.', '', 'setuju', '2026-04-12 00:00:00'),
(22, 'Cita (April)', 4, 'Bagus sih, tapi parkirannya agak sempit pas liburan lebaran kemarin.', '', 'setuju', '2026-04-26 00:00:00'),
(23, 'Dedi (Mei)', 2, 'Waktu ke sini awal Mei antreannya panjang banget, capek.', '', 'tolak', '2026-05-03 00:00:00'),
(24, 'Eka (Mei)', 5, 'Keren! Sistem sampahnya bikin tempat wisata jadi super bersih dan bebas plastik.', '', 'setuju', '2026-05-13 00:00:00'),
(25, 'Hadi (Juni)', 4, 'Juni debit air terjunnya pas, nggak terlalu deras jadi aman buat anak-anak main air.', '', 'tolak', '2026-06-06 00:00:00'),
(26, 'Lia (Juli)', 5, 'Belum ke sana sih, tapi lihat fotonya di web bagus banget. Udah beli tiket buat liburan Juli nanti!', '', 'tolak', '2026-07-01 00:00:00'),
(27, 'Mamat Surahmat', 5, 'Bagus banget tempatnya, Agustus cerah jadi enak buat main air!', '', 'setuju', '2026-08-06 00:00:00'),
(28, 'Nisa Sabyan', 4, 'Seru, tapi jalan trekking-nya lumayan bikin ngos-ngosan.', '', 'tolak', '2026-08-18 00:00:00'),
(29, 'Oki Setiana', 5, 'Pemandangan alam luar biasa, sangat asri.', '', 'setuju', '2026-08-26 00:00:00'),
(30, 'Putri Marino', 3, 'Ramai banget pas awal September, agak susah cari tempat duduk.', '', 'tolak', '2026-09-03 00:00:00'),
(31, 'Qori Akbar', 4, 'Salut banget sama sistem deposit sampahnya, sangat mendidik!', '', 'tolak', '2026-09-13 00:00:00'),
(32, 'Rafi Ahmad', 5, 'Mantap jiwa air terjunnya, seger poll!', '', 'setuju', '2026-09-29 00:00:00'),
(33, 'Sinta Jojo', 2, 'Airnya pas lagi agak keruh karena malamnya habis hujan deras.', '', 'tolak', '2026-10-06 00:00:00'),
(34, 'Tono Hartono', 5, 'Recommended banget buat refreshing bareng keluarga besar.', '', 'setuju', '2026-10-16 00:00:00'),
(35, 'Umar bin Khattab', 4, 'Tiket murah meriah, warung-warung harganya juga wajar nggak getok harga.', '', 'setuju', '2026-10-23 00:00:00'),
(36, 'Vina Panduwinata', 5, 'Fasilitas WC dan mushola sudah lumayan memadai.', '', 'setuju', '2026-10-31 00:00:00'),
(37, 'Wira Santika', 5, 'Suasana November yang syahdu, debit air pas banget!', '', 'setuju', '2026-11-06 00:00:00'),
(38, 'Xena Aprilia', 4, 'Bagus, bersih, tapi toiletnya antre panjang.', '', 'setuju', '2026-11-14 00:00:00'),
(39, 'Yanto Basna', 3, 'Jalannya becek kalau pas habis hujan, mohon diperbaiki.', '', 'tolak', '2026-11-20 00:00:00'),
(40, 'Zainab Nur', 5, 'Sangat memuaskan, cocok buat bawa keluarga besar.', '', 'setuju', '2026-11-26 00:00:00'),
(41, 'Arya Wiguna', 1, 'Tempatnya bagus tapi saya digigit nyamuk banyak.', '', 'tolak', '2026-11-30 00:00:00'),
(42, 'Bima Sakti', 5, 'Liburan akhir tahun yang menyenangkan di Tancak Panti.', '', 'setuju', '2026-12-04 00:00:00'),
(43, 'Citra Kirana', 4, 'Bagus buat foto-foto, instagramable banget pemandangannya.', '', 'setuju', '2026-12-12 00:00:00'),
(44, 'Denis Suherman', 5, 'Udah berkali-kali ke sini nggak pernah bosen.', '', 'setuju', '2026-12-17 00:00:00'),
(45, 'Erna Wati', 4, 'Petugasnya ramah-ramah, denda sampah bikin kapok buang sembarangan.', '', 'setuju', '2026-12-26 00:00:00'),
(46, 'Fikri Haikal', 5, 'Tahun baruan mantap di sini! Hati-hati aja jalannya lumayan nanjak.', '', 'setuju', '2026-12-31 00:00:00'),
(47, 'Tamu Jan 10', 5, 'Luar biasa, sistem sangat rapi!', '', 'setuju', '2026-01-09 00:00:00'),
(48, 'Tamu Feb 15', 4, 'Cukup bagus, tapi air terjunnya dingin banget hehe', '', 'setuju', '2026-02-11 00:00:00'),
(49, 'Tamu Mar 20', 5, 'Rombongan sangat puas. Terima kasih!', '', 'setuju', '2026-03-15 00:00:00'),
(50, 'Tamu Apr 25', 3, 'Waktu itu jalanan lumayan becek', '', 'tolak', '2026-04-18 00:00:00'),
(51, 'Tamu Mei 30', 5, 'Bagus sekali! Pasti akan kembali lagi.', '', 'tolak', '2026-05-20 00:00:00'),
(52, 'Wisatawan Jan 10', 5, 'Luar biasa, wisata ini sangat tertata rapi!', '', 'setuju', '2026-01-16 00:00:00'),
(53, 'Wisatawan Feb 15', 4, 'Airnya segar, tapi akses ke bawah agak licin.', '', 'setuju', '2026-02-22 00:00:00'),
(54, 'Wisatawan Mar 20', 5, 'Keren! Denda sampah bikin area tetap bersih.', '', 'pending', '2026-04-01 00:00:00'),
(55, 'Wisatawan Apr 05', 3, 'Waktu itu warung banyak yang tutup.', '', 'tolak', '2026-04-09 00:00:00'),
(56, 'Wisatawan Mei 12', 5, 'Pemandangan 10/10! Sangat direkomendasikan.', '', 'pending', '2026-05-18 00:00:00'),
(57, 'Wisatawan Jun 10', 5, 'Keren! Airnya mantap banget buat mainan.', '', 'setuju', '2026-06-16 00:00:00'),
(58, 'Wisatawan Jul 15', 4, 'Bagus, sayang pas agak mendung.', '', 'setuju', '2026-07-25 00:00:00'),
(59, 'Wisatawan Agu 20', 5, 'Kebersihannya terjamin karena sistem sampah.', '', 'pending', '2026-08-31 00:00:00'),
(60, 'Wisatawan Sep 05', 3, 'Ramai banget kalau weekend.', '', 'tolak', '2026-09-09 00:00:00'),
(61, 'Wisatawan Okt 12', 5, 'Bakal ajak keluarga besar ke sini lagi!', '', 'pending', '2026-10-18 00:00:00'),
(62, 'Wisatawan Ekstra 25', 5, 'Wah ini baru namanya wisata alam! Top markotop.', '', 'setuju', '2026-05-13 00:00:00'),
(63, 'Wisatawan Ekstra 50', 4, 'Bagus tapi pas libur panjang rame banget.', '', 'setuju', '2026-05-25 00:00:00'),
(64, 'Wisatawan Ekstra 75', 5, 'Fasilitas sangat memadai, harga tiket juga bersahabat.', '', 'pending', '2026-05-12 00:00:00'),
(65, 'Wisatawan Ekstra 100', 5, 'Pastinya bakal mampir lagi kalau ke Jember!', '', 'pending', '2026-05-21 00:00:00'),
(66, 'halo', 5, 'halo', 'https://i.ibb.co/SkLr0zF/ULASAN-1778546993.png', 'setuju', '2026-05-12 07:49:55');

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
  ADD KEY `fk_denda_tiket` (`id_tiket`) USING BTREE;

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
  MODIFY `id_denda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT untuk tabel `sampah`
--
ALTER TABLE `sampah`
  MODIFY `id_sampah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11601;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD CONSTRAINT `denda_ibfk_1` FOREIGN KEY (`id_tiket`) REFERENCES `tiket` (`id_tiket`) ON DELETE CASCADE ON UPDATE CASCADE;

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
