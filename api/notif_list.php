<?php
include '../config/koneksi.php'; 

header('Content-Type: application/json');

// KITA TARIK SEMUA DATA YANG KAMU MINTA CAK!
$query = mysqli_query($koneksi, "SELECT kode_tiket, nama, alamat, telepon_1, tanggal_kunjungan, status FROM tiket WHERE status = 'Masih di Wisata'");

$data = [];
if($query) {
    while($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    
    echo json_encode([
        'status' => 'success', 
        'count'  => count($data), 
        'data'   => $data
    ]);
    
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($koneksi)]);
}
?>