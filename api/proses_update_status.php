<?php
// Mundur 1 kali karena posisi file ini ada di dalam folder 'api'
include '../config/koneksi.php';

// Pastikan request dari Javascript pakai method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Tangkap data id_tiket dan status yang dikirim dari admin.js
    $id_tiket = isset($_POST['id_tiket']) ? $_POST['id_tiket'] : '';
    $status   = isset($_POST['status']) ? $_POST['status'] : '';

    if (!empty($id_tiket) && !empty($status)) {
        // Bersihkan data dari karakter aneh (Wajib biar gak error SQL)
        $id_tiket_bersih = mysqli_real_escape_string($koneksi, $id_tiket);
        $status_bersih   = mysqli_real_escape_string($koneksi, $status);

        // Update ke database
        $query_update = "UPDATE tiket SET status = '$status_bersih' WHERE id_tiket = '$id_tiket_bersih'";
        $eksekusi = mysqli_query($koneksi, $query_update);

        if ($eksekusi) {
            echo "Sukses: Status diubah jadi " . $status_bersih;
        } else {
            echo "Error DB: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal: Data id_tiket atau status kosong!";
    }
} else {
    echo "Gagal: Request harus pakai POST!";
}
?>