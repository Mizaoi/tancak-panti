<?php
// Konfigurasi Database XAMPP Default
$host = "localhost";
$user = "root";       // Username bawaan XAMPP
$pass = "";           // Password bawaan XAMPP (dikosongkan saja)\
$db   = "tancak_panti";  // Pastikan nama ini SAMA PERSIS dengan yang kamu buat di phpMyAdmin

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Aduh Cak, Koneksi database gagal: " . mysqli_connect_error());
}

if (!function_exists('uploadKeImgBB')) {
    function uploadKeImgBB($file_path, $label) {
        // KITA TEMBAK LANGSUNG PAKAI API KEY IMGBB ASLI (BUKAN FONNTE)
        $api_key = '5a2972d7d256ff18ae2bfe4c6000ed3b'; 
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Anti blokir XAMPP
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'image' => base64_encode(file_get_contents($file_path)),
            'name' => $label . '_' . time()
        ]);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $json = json_decode($response, true);
        
        // Kalau sukses, kembalikan URL gambar
        if (isset($json['data']['url'])) {
            return $json['data']['url'];
        } else {
            // KALAU GAGAL, KEMBALIKAN PESAN ERROR ASLINYA BIAR KITA TAHU
            $pesan = isset($json['error']['message']) ? $json['error']['message'] : 'Gagal koneksi ke API';
            return "API_ERROR: " . $pesan;
        }
    }
}
?>