<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['status' => 'error']); exit;
}

// Gunakan relative path dari lokasi file API
$path_file = dirname(__DIR__) . '/config/status_darurat.json';

// Ubah status JSON menjadi FALSE (Mati)
$notif_data = ['aktif' => false, 'waktu' => '', 'pesan' => ''];
file_put_contents($path_file, json_encode($notif_data));

echo json_encode(['status' => 'success']);
?>