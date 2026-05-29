<?php
// Gunakan Document Root agar tidak pusing dengan folder '../'
include $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

header('Content-Type: application/json');

// Jika file ini juga bertugas membaca status darurat:
$notif_file = dirname(dirname(__DIR__)) . '/tancak-panti/config/status_darurat.json';

// Query tetap sama
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