-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Bulan Mei 2026 pada 07.40
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
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `id_tiket` int(11) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `id_tiket`, `nama_anggota`) VALUES
(209, 12502, 'Rekan Siti 1'),
(210, 12502, 'Rekan Siti 2'),
(211, 12503, 'Pasangan Agus'),
(212, 12504, 'Keluarga Dina 1'),
(213, 12504, 'Keluarga Dina 2'),
(214, 12504, 'Keluarga Dina 3'),
(215, 12505, 'Kru Eko 1'),
(216, 12505, 'Kru Eko 2'),
(217, 12505, 'Kru Eko 3'),
(218, 12505, 'Kru Eko 4'),
(219, 12507, 'Teman Gilang A'),
(220, 12507, 'Teman Gilang B'),
(221, 12508, 'Sahabat Hani'),
(222, 12509, 'Grup Iwan X'),
(223, 12509, 'Grup Iwan Y'),
(224, 12509, 'Grup Iwan Z'),
(225, 12510, 'Tim Joko 1'),
(226, 12510, 'Tim Joko 2'),
(227, 12510, 'Tim Joko 3'),
(228, 12510, 'Tim Joko 4'),
(229, 12512, 'Adik Lusi'),
(230, 12512, 'Kakak Lusi'),
(231, 12513, 'Suami Mira'),
(232, 12514, 'Saudara Nita A'),
(233, 12514, 'Saudara Nita B'),
(234, 12514, 'Saudara Nita C'),
(235, 12515, 'Famili Oki 1'),
(236, 12515, 'Famili Oki 2'),
(237, 12515, 'Famili Oki 3'),
(238, 12515, 'Famili Oki 4'),
(239, 12517, 'Rekan Qori A'),
(240, 12517, 'Rekan Qori B'),
(241, 12518, 'Partner Rian'),
(242, 12519, 'Bawahan Susi 1'),
(243, 12519, 'Bawahan Susi 2'),
(244, 12519, 'Bawahan Susi 3'),
(245, 12520, 'Geng Toni 1'),
(246, 12520, 'Geng Toni 2'),
(247, 12520, 'Geng Toni 3'),
(248, 12520, 'Geng Toni 4'),
(249, 12522, 'Sobat Vina A'),
(250, 12522, 'Sobat Vina B'),
(251, 12523, 'Kawan Wawan'),
(252, 12524, 'Pengawal Xena 1'),
(253, 12524, 'Pengawal Xena 2'),
(254, 12524, 'Pengawal Xena 3'),
(255, 12525, 'Kerabat Yudi 1'),
(256, 12525, 'Kerabat Yudi 2'),
(257, 12525, 'Kerabat Yudi 3'),
(258, 12525, 'Kerabat Yudi 4'),
(259, 12527, 'Teman Andi 1'),
(260, 12527, 'Teman Andi 2'),
(261, 12528, 'Sopir Bella'),
(262, 12529, 'Manajer Cakra'),
(263, 12529, 'Asisten Cakra 1'),
(264, 12529, 'Asisten Cakra 2'),
(265, 12530, 'Kru Doni 1'),
(266, 12530, 'Kru Doni 2'),
(267, 12530, 'Kru Doni 3'),
(268, 12530, 'Kru Doni 4'),
(269, 12531, 'Suami Endang'),
(270, 12532, 'Rekan Fahmi 1'),
(271, 12532, 'Rekan Fahmi 2'),
(272, 12533, 'Grup Gita 1'),
(273, 12533, 'Grup Gita 2'),
(274, 12533, 'Grup Gita 3'),
(275, 12534, 'Istri Hendra'),
(276, 12535, 'Tim Indah 1'),
(277, 12535, 'Tim Indah 2'),
(278, 12535, 'Tim Indah 3'),
(279, 12535, 'Tim Indah 4'),
(280, 12536, 'Anak Junaedi 1'),
(281, 12536, 'Anak Junaedi 2'),
(282, 12537, 'Sobat Kamilia'),
(283, 12538, 'Kru Lutfi 1'),
(284, 12538, 'Kru Lutfi 2'),
(285, 12538, 'Kru Lutfi 3'),
(286, 12540, 'Famili Nana 1'),
(287, 12540, 'Famili Nana 2'),
(288, 12540, 'Famili Nana 3'),
(289, 12540, 'Famili Nana 4'),
(290, 12541, 'Rekan Oman'),
(291, 12542, 'Teman Puput 1'),
(292, 12542, 'Teman Puput 2'),
(293, 12543, 'Squad Qosim 1'),
(294, 12543, 'Squad Qosim 2'),
(295, 12543, 'Squad Qosim 3'),
(296, 12545, 'Rombong Surya 1'),
(297, 12545, 'Rombong Surya 2'),
(298, 12545, 'Rombong Surya 3'),
(299, 12545, 'Rombong Surya 4'),
(300, 12546, 'Asisten Tukul 1'),
(301, 12546, 'Asisten Tukul 2'),
(302, 12547, 'Sobat Ubay'),
(303, 12548, 'Manajer Vicky'),
(304, 12548, 'Sopir Vicky'),
(305, 12548, 'Ajudan Vicky'),
(306, 12550, 'Tim Yayan 1'),
(307, 12550, 'Tim Yayan 2'),
(308, 12550, 'Tim Yayan 3'),
(309, 12550, 'Tim Yayan 4');

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
(154, 12505, '', '', 2, 20000),
(155, 12510, '', '', 5, 50000),
(156, 12520, '', '', 1, 10000),
(157, 12530, '', '', 4, 40000),
(158, 12540, '', '', 2, 20000),
(159, 12550, '', '', 3, 30000);

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
(184, 12502, 'Botol Plastik', 3),
(185, 12502, 'Bungkus Makanan', 2),
(186, 12505, 'Cup Plastik', 5),
(187, 12505, 'Kantong Plastik', 4),
(188, 12510, 'Tisu', 10),
(189, 12510, 'Botol Plastik', 5),
(190, 12515, 'Bungkus Makanan', 8),
(191, 12520, 'Cup Mie', 6),
(192, 12520, 'Sendok Plastik', 6),
(193, 12525, 'Kantong Plastik', 5),
(194, 12525, 'Botol Kaca', 2),
(195, 12530, 'Botol Plastik', 12),
(196, 12530, 'Tisu', 15),
(197, 12535, 'Bungkus Makanan', 7),
(198, 12540, 'Cup Mie', 8),
(199, 12540, 'Kantong Plastik', 5),
(200, 12545, 'Botol Plastik', 6),
(201, 12550, 'Tisu', 20),
(202, 12550, 'Bungkus Makanan', 10);

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
(12501, 'TCK-MEI-201', 'Budi Santoso', 'Jember', 1, '2026-05-01', '0812345001', '0812345001', '', 'Sudah Pulang'),
(12502, 'TCK-MEI-202', 'Siti Aminah', 'Surabaya', 3, '2026-05-02', '0812345002', '0812345002', '', 'Sudah Pulang'),
(12503, 'TCK-MEI-203', 'Agus Pratama', 'Malang', 2, '2026-05-03', '0812345003', '0812345003', '', 'Sudah Pulang'),
(12504, 'TCK-MEI-204', 'Dina Lestari', 'Banyuwangi', 4, '2026-05-04', '0812345004', '0812345004', '', 'Sudah Pulang'),
(12505, 'TCK-MEI-205', 'Eko Wibowo', 'Lumajang', 5, '2026-05-05', '0812345005', '0812345005', '', 'Sudah Pulang'),
(12506, 'TCK-MEI-206', 'Fina Rahma', 'Situbondo', 1, '2026-05-06', '0812345006', '0812345006', '', 'Sudah Pulang'),
(12507, 'TCK-MEI-207', 'Gilang Dirga', 'Jember', 3, '2026-05-07', '0812345007', '0812345007', '', 'Sudah Pulang'),
(12508, 'TCK-MEI-208', 'Hani Safira', 'Probolinggo', 2, '2026-05-08', '0812345008', '0812345008', '', 'Sudah Pulang'),
(12509, 'TCK-MEI-209', 'Iwan Fals', 'Surabaya', 4, '2026-05-09', '0812345009', '0812345009', '', 'Sudah Pulang'),
(12510, 'TCK-MEI-210', 'Joko Anwar', 'Malang', 5, '2026-05-10', '0812345010', '0812345010', '', 'Sudah Pulang'),
(12511, 'TCK-MEI-211', 'Kiki Amalia', 'Jember', 1, '2026-05-11', '0812345011', '0812345011', '', 'Sudah Pulang'),
(12512, 'TCK-MEI-212', 'Lusi Susanti', 'Banyuwangi', 3, '2026-05-12', '0812345012', '0812345012', '', 'Sudah Pulang'),
(12513, 'TCK-MEI-213', 'Mira Lesmana', 'Lumajang', 2, '2026-05-13', '0812345013', '0812345013', '', 'Sudah Pulang'),
(12514, 'TCK-MEI-214', 'Nita Thalia', 'Situbondo', 4, '2026-05-14', '0812345014', '0812345014', '', 'Sudah Pulang'),
(12515, 'TCK-MEI-215', 'Oki Setiana', 'Surabaya', 5, '2026-05-15', '0812345015', '0812345015', '', 'Sudah Pulang'),
(12516, 'TCK-MEI-216', 'Putra Siregar', 'Jember', 1, '2026-05-16', '0812345016', '0812345016', '', 'Sudah Pulang'),
(12517, 'TCK-MEI-217', 'Qori Akbar', 'Malang', 3, '2026-05-17', '0812345017', '0812345017', '', 'Sudah Pulang'),
(12518, 'TCK-MEI-218', 'Rian Dmasiv', 'Banyuwangi', 2, '2026-05-18', '0812345018', '0812345018', '', 'Sudah Pulang'),
(12519, 'TCK-MEI-219', 'Susi Pudjiastuti', 'Lumajang', 4, '2026-05-19', '0812345019', '0812345019', '', 'Sudah Pulang'),
(12520, 'TCK-MEI-220', 'Toni Blank', 'Situbondo', 5, '2026-05-20', '0812345020', '0812345020', '', 'Sudah Pulang'),
(12521, 'TCK-MEI-221', 'Umar Syarif', 'Jember', 1, '2026-05-21', '0812345021', '0812345021', '', 'Sudah Pulang'),
(12522, 'TCK-MEI-222', 'Vina Pandu', 'Surabaya', 3, '2026-05-22', '0812345022', '0812345022', '', 'Sudah Pulang'),
(12523, 'TCK-MEI-223', 'Wawan Kurnia', 'Malang', 2, '2026-05-23', '0812345023', '0812345023', '', 'Sudah Pulang'),
(12524, 'TCK-MEI-224', 'Xena Aprilia', 'Banyuwangi', 4, '2026-05-24', '0812345024', '0812345024', '', 'Belum Check-in'),
(12525, 'TCK-MEI-225', 'Yudi Latif', 'Lumajang', 5, '2026-05-25', '0812345025', '0812345025', '', 'Masih di Wisata'),
(12526, 'TCK-MEI-226', 'Zara Leola', 'Situbondo', 1, '2026-05-26', '0812345026', '0812345026', '', 'Belum Check-in'),
(12527, 'TCK-MEI-227', 'Andi Arsyil', 'Jember', 3, '2026-05-27', '0812345027', '0812345027', '', 'Masih di Wisata'),
(12528, 'TCK-MEI-228', 'Bella Saphira', 'Probolinggo', 2, '2026-05-28', '0812345028', '0812345028', '', 'Belum Check-in'),
(12529, 'TCK-MEI-229', 'Cakra Khan', 'Surabaya', 4, '2026-05-29', '0812345029', '0812345029', '', 'Masih di Wisata'),
(12530, 'TCK-MEI-230', 'Doni Salmanan', 'Malang', 5, '2026-05-30', '0812345030', '0812345030', '', 'Belum Check-in'),
(12531, 'TCK-MEI-231', 'Endang S', 'Jember', 2, '2026-05-01', '0812345031', '0812345031', '', 'Sudah Pulang'),
(12532, 'TCK-MEI-232', 'Fahmi Reza', 'Surabaya', 3, '2026-05-03', '0812345032', '0812345032', '', 'Sudah Pulang'),
(12533, 'TCK-MEI-233', 'Gita Gutawa', 'Malang', 4, '2026-05-05', '0812345033', '0812345033', '', 'Sudah Pulang'),
(12534, 'TCK-MEI-234', 'Hendra G', 'Banyuwangi', 2, '2026-05-07', '0812345034', '0812345034', '', 'Sudah Pulang'),
(12535, 'TCK-MEI-235', 'Indah Dewi', 'Lumajang', 5, '2026-05-09', '0812345035', '0812345035', '', 'Sudah Pulang'),
(12536, 'TCK-MEI-236', 'Junaedi', 'Situbondo', 3, '2026-05-11', '0812345036', '0812345036', '', 'Sudah Pulang'),
(12537, 'TCK-MEI-237', 'Kamilia', 'Jember', 2, '2026-05-13', '0812345037', '0812345037', '', 'Sudah Pulang'),
(12538, 'TCK-MEI-238', 'Lutfi Agizal', 'Probolinggo', 4, '2026-05-15', '0812345038', '0812345038', '', 'Sudah Pulang'),
(12539, 'TCK-MEI-239', 'Maman S', 'Surabaya', 1, '2026-05-17', '0812345039', '0812345039', '', 'Sudah Pulang'),
(12540, 'TCK-MEI-240', 'Nana Mirdad', 'Malang', 5, '2026-05-19', '0812345040', '0812345040', '', 'Sudah Pulang'),
(12541, 'TCK-MEI-241', 'Oman Rachman', 'Jember', 2, '2026-05-21', '0812345041', '0812345041', '', 'Sudah Pulang'),
(12542, 'TCK-MEI-242', 'Puput Melati', 'Banyuwangi', 3, '2026-05-23', '0812345042', '0812345042', '', 'Sudah Pulang'),
(12543, 'TCK-MEI-243', 'Qosim Ahmad', 'Lumajang', 4, '2026-05-25', '0812345043', '0812345043', '', 'Sudah Pulang'),
(12544, 'TCK-MEI-244', 'Ratna Galih', 'Situbondo', 1, '2026-05-27', '0812345044', '0812345044', '', 'Sudah Pulang'),
(12545, 'TCK-MEI-245', 'Surya Saputra', 'Surabaya', 5, '2026-05-29', '0812345045', '0812345045', '', 'Belum Check-in'),
(12546, 'TCK-MEI-246', 'Tukul Arwana', 'Jember', 3, '2026-05-30', '0812345046', '0812345046', '', 'Masih di Wisata'),
(12547, 'TCK-MEI-247', 'Ubay Dillah', 'Malang', 2, '2026-05-31', '0812345047', '0812345047', '', 'Sudah Pulang'),
(12548, 'TCK-MEI-248', 'Vicky Nitinegoro', 'Banyuwangi', 4, '2026-05-15', '0812345048', '0812345048', '', 'Sudah Pulang'),
(12549, 'TCK-MEI-249', 'Wulan Guritno', 'Lumajang', 1, '2026-05-16', '0812345049', '0812345049', '', 'Sudah Pulang'),
(12550, 'TCK-MEI-250', 'Yayan Ruhian', 'Situbondo', 5, '2026-05-17', '0812345050', '0812345050', '', 'Sudah Pulang');

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
(66, 'halo', 5, 'halo', 'https://i.ibb.co/SkLr0zF/ULASAN-1778546993.png', 'setuju', '2026-05-12 07:49:55'),
(67, 'Eko Wibowo', 5, 'Wisatanya keren banget, bersih dan sejuk. Fasilitas denda sampah bikin orang disiplin!', '', 'setuju', '2026-05-06 00:00:00'),
(68, 'Joko Anwar', 4, 'Air terjunnya mantap, sayangnya saya kena denda gara-gara teman buang cup mie sembarangan.', '', 'setuju', '2026-05-11 00:00:00'),
(69, 'Susi Pudjiastuti', 5, 'Luar biasa pengelolaannya. E-Tiketnya juga sangat canggih dan praktis. Pertahankan!', '', 'pending', '2026-05-20 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `id_tiket` (`id_tiket`);

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
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT untuk tabel `denda`
--
ALTER TABLE `denda`
  MODIFY `id_denda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT untuk tabel `sampah`
--
ALTER TABLE `sampah`
  MODIFY `id_sampah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12551;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_tiket`) REFERENCES `tiket` (`id_tiket`) ON DELETE CASCADE ON UPDATE CASCADE;

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
