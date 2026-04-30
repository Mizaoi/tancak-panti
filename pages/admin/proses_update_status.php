<?php
session_start();
include '../../config/koneksi.php';

// Pastikan yang akses sudah login
if(isset($_SESSION['admin']) && isset($_POST['id_tiket']) && isset($_POST['status'])) {
    
    $id = (int)$_POST['id_tiket'];
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    
    // Eksekusi Update ke Database
    $update = mysqli_query($koneksi, "UPDATE tiket SET status = '$status' WHERE id_tiket = $id");
    
    if($update) {
        echo "Status berhasil diupdate jadi $status";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
} else {
    echo "Permintaan tidak sah!";
}
?>