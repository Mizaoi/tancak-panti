<?php
// File: api/anggota.php
session_start();
include '../config/koneksi.php';

// Pastikan yang akses cuma admin
if (!isset($_SESSION['admin'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if (isset($_GET['id'])) {
    $id_tiket = (int)$_GET['id'];
    $query = mysqli_query($koneksi, "SELECT nama_anggota FROM anggota WHERE id_tiket = $id_tiket");
    
    $data = [];
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row['nama_anggota'];
        }
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Query gagal']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
}
?>