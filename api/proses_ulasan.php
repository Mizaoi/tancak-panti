<?php
session_start();
include '../config/koneksi.php'; // Pastikan path koneksi ini benar

// Terima lemparan data dari Javascript
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_ulasan = isset($_POST['id_ulasan']) ? mysqli_real_escape_string($koneksi, $_POST['id_ulasan']) : '';
    $action = isset($_POST['action']) ? mysqli_real_escape_string($koneksi, $_POST['action']) : '';

    if (empty($id_ulasan) || empty($action)) {
        echo json_encode(['status' => 'error', 'message' => 'Data kosong cak!']);
        exit;
    }

    // Logika 3 Tombol (Hapus, Setuju, Tolak)
    if ($action == 'Hapus') {
        $query = "DELETE FROM ulasan WHERE id_ulasan = '$id_ulasan'";
    } else {
        $status = strtolower($action); 
        $query = "UPDATE ulasan SET status = '$status' WHERE id_ulasan = '$id_ulasan'";
    }

    // Eksekusi ke Database
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
    }
}
?>