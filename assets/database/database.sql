-- 1. Membuat Database (Jika belum ada)
CREATE DATABASE IF NOT EXISTS db_tancak;

-- 2. Menggunakan Database tersebut
USE db_tancak;

-- ========================================================
-- 3. Membuat Tabel Ulasan (tb_ulasan)
-- ========================================================
CREATE TABLE IF NOT EXISTS tb_ulasan (
    id_ulasan INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    rating INT NOT NULL,
    isi TEXT NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_pinned TINYINT(1) DEFAULT 0,
    status VARCHAR(20) DEFAULT 'disetujui'
);

-- ========================================================
-- 4. Membuat Tabel Admin (tb_admin)
-- ========================================================
CREATE TABLE IF NOT EXISTS tb_admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- ========================================================
-- 5. Memasukkan Data Admin Default (Username: admin, Pass: tancak123)
-- ========================================================
INSERT INTO tb_admin (username, password) 
VALUES ('admin', MD5('tancak123'));