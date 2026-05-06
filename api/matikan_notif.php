<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['status' => 'error']); exit;
}

// Ubah status JSON menjadi FALSE (Mati)
$notif_data = ['aktif' => false, 'waktu' => '', 'pesan' => ''];
file_put_contents('../config/status_darurat.json', json_encode($notif_data));

echo json_encode(['status' => 'success']);
?>