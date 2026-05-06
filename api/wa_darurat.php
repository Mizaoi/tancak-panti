<?php
session_start();
include '../config/koneksi.php';
include '../config/wa.php';
header('Content-Type: application/json');

// Proteksi ringan
if (!isset($_SESSION['admin'])) {
    echo json_encode(['status' => 'error', 'msg' => 'Akses ditolak']);
    exit;
}

// Tangkap pesan dari JavaScript
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$pesan_darurat = $data['pesan'];

// Cari semua wisatawan yang statusnya "Masih di Wisata"
$query = mysqli_query($koneksi, "SELECT nama, telepon_1 FROM tiket WHERE status = 'Masih di Wisata'");
$jumlah_dikirim = 0;
$target_nomor = [];

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        // Hanya ambil yang ada nomor teleponnya
        if (!empty($row['telepon_1'])) {
            // Bersihkan format nomor ke format WA (628...)
            $nomor = preg_replace('/[^0-9]/', '', $row['telepon_1']);
            if (substr($nomor, 0, 1) == '0') {
                $nomor = '62' . substr($nomor, 1);
            } elseif (substr($nomor, 0, 1) == '8') {
                $nomor = '62' . $nomor;
            }
            
            $target_nomor[] = [
                'nama' => $row['nama'],
                'wa' => $nomor
            ];
            $jumlah_dikirim++;
        }
    }

    foreach($target_nomor as $target) {
        $curl = curl_init();
        
        // Desain pesan yang akan diterima wisatawan
        $pesan_kirim = "⚠️ *PERINGATAN DARURAT SI-TANCAK PANTI*\n\n";
        $pesan_kirim .= "Halo *" . $target['nama'] . "*,\n\n";
        $pesan_kirim .= $pesan_darurat; // Ini teks dari inputan form kamu

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'target' => $target['wa'], // Nomor HP tujuan hasil filter
            'message' => $pesan_kirim, 
            'countryCode' => '62',
          ),
          CURLOPT_HTTPHEADER => array(
            'Authorization:' . TOKEN_FONNTE // 👈 GANTI DENGAN TOKEN FONNTE KAMU
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        
        sleep(1); 
    }
    // ==============================================================
    // ==============================================================

    // ... (kode cURL WA API biarkan saja di atas sini) ...

   // [FITUR BARU] Simpan status notif ke file JSON
    date_default_timezone_set('Asia/Jakarta');
    $notif_data = [
        'aktif' => true,
        'waktu' => date('H.i'),
        'dikirim_ke' => $jumlah_dikirim, // <- Tambahan ini biar Admin ingat jumlahnya
        'pesan' => $pesan_darurat
    ];
    // Simpan di folder config
    file_put_contents('../config/status_darurat.json', json_encode($notif_data));

    // Berikan respons ke Frontend bahwa sukses dikirim
    echo json_encode([
        'status' => 'success', 
        'dikirim_ke' => $jumlah_dikirim,
        'msg' => 'Pesan diteruskan ke API WA'
    ]);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Gagal membaca database tiket']);
}
?>