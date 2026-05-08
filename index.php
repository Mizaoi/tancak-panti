<?php
// Mulai session di file paling awal
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Tangkap URL dan bersihkan dari karakter '/'
$request_uri = isset($_GET['url']) ? $_GET['url'] : '';
$request_uri = rtrim($request_uri, '/');
$request_uri = ltrim($request_uri, '/');

// JURUS ANTI GAGAL: Kalau XAMPP iseng masukin nama folder 'tancak-panti' ke URL, kita potong!
if (strpos($request_uri, 'tancak-panti/') === 0) {
    $request_uri = substr($request_uri, strlen('tancak-panti/'));
}

// 2. DAFTAR ROUTES (Jalur Lalu Lintas)
$routes = [
    ''          => 'pages/home.php',
    'home'      => 'pages/home.php',
    'login'     => 'pages/login.php',
    'facility' => 'pages/facility.php',
    'tiket'     => 'pages/tiket.php',
    'cek_tiket' => 'pages/cek_tiket.php',
    'rating'    => 'pages/rating.php',
    'contact'    => 'pages/contact.php',
    'profile'    => 'pages/profile.php',
    
    'admin/dashboard' => 'pages/admin/dashboard.php',
    'admin/cetak'     => 'pages/admin/cetak_rekap.php',
    'admin/logout'    => 'pages/admin/logout.php',
];

// 3. MESIN ROUTER
if (array_key_exists($request_uri, $routes)) {
    $file_to_include = $routes[$request_uri];
    
    // Keamanan ekstra: Pastikan filenya beneran ada di server
    if (file_exists($file_to_include)) {
        require_once $file_to_include;
    } else {
        tampilkan_404("Waduh, file asli <b>$file_to_include</b> tidak ditemukan di dalam folder server!");
    }
} else {
    // Pesan error ini sekarang akan ngasih tahu URL apa yang bikin dia bingung
    tampilkan_404("Router tidak mengenali URL yang kamu ketik: <b>/" . htmlspecialchars($request_uri) . "</b>");
}

// Fungsi halaman Error 404
function tampilkan_404($pesan) {
    http_response_code(404);
    echo "<div style='text-align:center; padding: 50px; font-family: sans-serif;'>";
    echo "<h1>404 - Not Found!</h1>";
    echo "<p>$pesan</p>";
    echo "<br><a href='/tancak-panti/home' style='background:#1b3d2f; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Kembali ke Home</a>";
    echo "</div>";
    exit;
}
?>