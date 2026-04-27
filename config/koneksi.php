<?php
// Konfigurasi Database XAMPP Default
$host = "localhost";
$user = "root";       // Username bawaan XAMPP
$pass = "";           // Password bawaan XAMPP (dikosongkan saja)
$db   = "db_tancak";  // Pastikan nama ini SAMA PERSIS dengan yang kamu buat di phpMyAdmin

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Aduh Cak, Koneksi database gagal: " . mysqli_connect_error());
}
?>