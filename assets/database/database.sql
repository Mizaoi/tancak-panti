-- ========================================================
-- FILE DATABASE: SI-TANCAK PANTI
-- Deskripsi: Struktur database untuk sistem tiket & ulasan
-- ========================================================

-- 1. Membuat Database
CREATE DATABASE IF NOT EXISTS `tancak_panti`;
USE `tancak_panti`;

-- --------------------------------------------------------

-- 2. Struktur Tabel `tb_admin`
-- Digunakan untuk login portal admin
CREATE TABLE IF NOT EXISTS `tb_admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL, -- Format MD5
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data untuk tabel `tb_admin`
-- Default: Username (admin), Password (admin123)
INSERT INTO `tb_admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

-- 3. Struktur Tabel `tb_tiket`
-- Digunakan untuk menyimpan data transaksi tiket
CREATE TABLE IF NOT EXISTS `tb_tiket` (
  `id_tiket` int(11) NOT NULL AUTO_INCREMENT,
  `kode_tiket` varchar(15) DEFAULT NULL, -- Format: TCK-XXXXXX
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `no_darurat` varchar(20) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0, -- 0: Pending, 1: Berhasil
  `denda` int(11) DEFAULT 0,
  `admin_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_tiket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- 4. Struktur Tabel `tb_ulasan`
-- Digunakan untuk menyimpan testimoni & laporan sampah
CREATE TABLE IF NOT EXISTS `tb_ulasan` (
  `id_ulasan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `rating` tinyint(1) NOT NULL DEFAULT 5,
  `isi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'disetujui',
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_ulasan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- 5. Struktur Tabel `tb_sampah`
-- Digunakan untuk kategori sampah atau log pelaporan kebersihan khusus
CREATE TABLE IF NOT EXISTS `tb_sampah` (
  `id_sampah` int(11) NOT NULL AUTO_INCREMENT,
  `id_ulasan` int(11) DEFAULT NULL, -- Relasi ke tb_ulasan jika laporan berasal dari ulasan
  `jenis_sampah` varchar(50) NOT NULL, -- Contoh: Plastik, Organik, B3
  `lokasi_temuan` varchar(100) DEFAULT NULL, -- Titik lokasi sampah ditemukan
  `status_kebersihan` enum('perlu_diangkut','sedang_dibersihkan','selesai') DEFAULT 'perlu_diangkut',
  `tanggal_lapor` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sampah`),
  -- Opsional: Menghubungkan ke tb_ulasan agar datanya sinkron
  CONSTRAINT `fk_ulasan_sampah` FOREIGN KEY (`id_ulasan`) REFERENCES `tb_ulasan`(`id_ulasan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================================
-- SELESAI
-- ========================================================
