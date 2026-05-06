<?php
session_start();
include '../config/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['status' => 'error', 'msg' => 'Akses ditolak']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// PROSES AMBIL DATA
if ($action == 'get') {
    $id_tiket = (int)$_GET['id'];
    $data = [];
    
    $query = mysqli_query($koneksi, "SELECT * FROM sampah WHERE id_tiket = $id_tiket ORDER BY id_sampah ASC");
    
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'nama_sampah' => $row['nama_sampah'],
            'jumlah' => (int)$row['jumlah']
        ];
    }
    
    echo json_encode($data);
    exit;
}

// PROSES SIMPAN DATA
if ($action == 'save') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    $id_tiket = (int)$data['id_tiket'];
    $items = $data['items'];
    
    // Hapus data lama yang terkait tiket ini
    mysqli_query($koneksi, "DELETE FROM sampah WHERE id_tiket = $id_tiket");
    
    // Insert ulang data yang sudah di-update
    // Insert ulang data yang sudah di-update
    $total_baru = 0;
    foreach ($items as $item) {
        // FITUR BARU: ucwords() untuk huruf awal kapital, strtolower() biar seragam
        $nama = mysqli_real_escape_string($koneksi, ucwords(strtolower(trim($item['nama_sampah']))));
        $jumlah = (int)$item['jumlah'];
        
        if (!empty($nama) && $jumlah > 0) {
            mysqli_query($koneksi, "INSERT INTO sampah (id_tiket, nama_sampah, jumlah) VALUES ($id_tiket, '$nama', $jumlah)");
            $total_baru += $jumlah;
        }
    }
    
    echo json_encode(['status' => 'success', 'total_baru' => $total_baru]);
    exit;
}

echo json_encode(['status' => 'error', 'msg' => 'Aksi tidak dikenali']);
?>