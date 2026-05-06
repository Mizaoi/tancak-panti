<?php
session_start();
include '../config/koneksi.php';

error_reporting(0); ini_set('display_errors', 0);
header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['status' => 'error', 'msg' => 'Akses ditolak']); exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. GET DATA (GABUNGAN SAMPAH & DENDA)
if ($action == 'get') {
    $id_tiket = (int)$_GET['id'];
    $data = [];
    
    // Teknik LEFT JOIN: Ambil bawaan dari tabel sampah, dan cari jumlah hilangnya di tabel denda
    $query = mysqli_query($koneksi, "
        SELECT s.nama_sampah, s.jumlah as bawa, COALESCE(d.jumlah_hilang, 0) as hilang 
        FROM sampah s 
        LEFT JOIN denda d ON s.id_tiket = d.id_tiket AND s.nama_sampah = d.nama_sampah 
        WHERE s.id_tiket = $id_tiket 
        ORDER BY s.id_sampah ASC
    ");
    
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $bawa = (int)$row['bawa'];
            $hilang = (int)$row['hilang'];
            $kembali = $bawa - $hilang;
            
            $data[] = [
                'nama_sampah' => $row['nama_sampah'],
                'bawa'        => $bawa,
                'kembali'     => $kembali,
                'hilang'      => $hilang
            ];
        }
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Gagal baca database']);
    }
    exit;
}

// 2. SIMPAN DATA MURNI KE TABEL DENDA
if ($action == 'save') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    $id_tiket = (int)$data['id_tiket'];
    $nama_wisatawan = mysqli_real_escape_string($koneksi, trim($data['nama_wisatawan']));
    $items = $data['items'];
    
    // Hapus histori denda lama untuk tiket ini biar bersih
    mysqli_query($koneksi, "DELETE FROM denda WHERE id_tiket = $id_tiket");
    
    // Insert denda yang baru per item sampah
    foreach ($items as $item) {
        $nama = mysqli_real_escape_string($koneksi, trim($item['nama_sampah']));
        $hilang = (int)$item['hilang'];
        $total_denda_item = $hilang * 10000; // Rp 10.000 per item
        
        if ($hilang > 0) {
            mysqli_query($koneksi, "INSERT INTO denda (id_tiket, nama_wisatawan, nama_sampah, jumlah_hilang, total_denda) VALUES ($id_tiket, '$nama_wisatawan', '$nama', $hilang, $total_denda_item)");
        }
    }
    
    echo json_encode(['status' => 'success']);
    exit;
}
echo json_encode(['status' => 'error', 'msg' => 'Aksi tidak dikenali']);
?>