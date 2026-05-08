<?php
include 'config/koneksi.php';
// Proteksi Halaman Admin
if (!isset($_SESSION['admin'])) {
    header("Location: /tancak-panti/admin/login");
    exit;
}

// --- [LOGIKA GRAFIK SAMPAH BULANAN - VERSI FIX] ---
$selected_month = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
$tahun_pilih = date('Y', strtotime($selected_month . "-01"));
$bulan_pilih = date('m', strtotime($selected_month . "-01"));
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_pilih, $tahun_pilih);

// Ambil data bawa dari tabel sampah & data hilang dari tabel denda
$query_tren = mysqli_query($koneksi, "
    SELECT 
        t.tanggal_kunjungan,
        (SELECT IFNULL(SUM(jumlah), 0) FROM sampah s WHERE s.id_tiket IN (SELECT id_tiket FROM tiket WHERE tanggal_kunjungan = t.tanggal_kunjungan)) as total_bawa,
        (SELECT IFNULL(SUM(jumlah_hilang), 0) FROM denda d WHERE d.id_tiket IN (SELECT id_tiket FROM tiket WHERE tanggal_kunjungan = t.tanggal_kunjungan)) as total_hilang
    FROM tiket t
    WHERE t.tanggal_kunjungan LIKE '$selected_month%'
    GROUP BY t.tanggal_kunjungan
");

$data_db = [];
while($row = mysqli_fetch_assoc($query_tren)) {
    $data_db[$row['tanggal_kunjungan']] = $row;
}

$labels_sampah = [];
$data_bawa = [];
$data_hilang = [];

for($d = 1; $d <= $jumlah_hari; $d++) {
    $tgl_cek = $selected_month . "-" . str_pad($d, 2, '0', STR_PAD_LEFT);
    $labels_sampah[] = $d; 
    $data_bawa[] = isset($data_db[$tgl_cek]) ? (int)$data_db[$tgl_cek]['total_bawa'] : 0;
    $data_hilang[] = isset($data_db[$tgl_cek]) ? (int)$data_db[$tgl_cek]['total_hilang'] : 0;
}

// Encode untuk JS
$json_labels_sampah = json_encode($labels_sampah);
$json_data_bawa = json_encode($data_bawa);
$json_data_hilang = json_encode($data_hilang);
$nama_bulan_pilih = date('F Y', strtotime($selected_month.'-01'));

$data_db = [];
while($row = mysqli_fetch_assoc($query_tren)) {
    $data_db[$row['tanggal_kunjungan']] = $row;
}

$labels_sampah = [];
$data_bawa = [];
$data_hilang = [];

for($d = 1; $d <= $jumlah_hari; $d++) {
    $tgl_cek = $selected_month . "-" . str_pad($d, 2, '0', STR_PAD_LEFT);
    $labels_sampah[] = $d; 
    $data_bawa[] = isset($data_db[$tgl_cek]) ? (int)$data_db[$tgl_cek]['total_bawa'] : 0;
    $data_hilang[] = isset($data_db[$tgl_cek]) ? (int)$data_db[$tgl_cek]['total_hilang'] : 0;
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-data';

$username = $_SESSION['admin'];

// Fungsi format nomor WhatsApp
function formatWA($nomor) {
    $nomor = preg_replace('/[^0-9]/', '', $nomor); 
    if (substr($nomor, 0, 1) == '0') {
        $nomor = '62' . substr($nomor, 1);
    } elseif (substr($nomor, 0, 2) == '62') {
        $nomor = $nomor;
    } elseif (substr($nomor, 0, 1) == '8') {
        $nomor = '62' . $nomor;
    }
    return $nomor;
}

// Hitung data untuk kotak indikator
$query_count_0 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tiket WHERE status = 'Belum Check-in'");
$count_0 = $query_count_0 ? mysqli_fetch_assoc($query_count_0)['total'] : 0;

$query_count_1 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tiket WHERE status = 'Masih di Wisata'");
$count_1 = $query_count_1 ? mysqli_fetch_assoc($query_count_1)['total'] : 0;

$query_count_2 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tiket WHERE status = 'Sudah Pulang'");
$count_2 = $query_count_2 ? mysqli_fetch_assoc($query_count_2)['total'] : 0;

// Ambil semua data tiket
$query = mysqli_query($koneksi, "SELECT * FROM tiket ORDER BY id_tiket DESC");

// ==========================================
// [DATA REKAP] 4 KOTAK INDIKATOR KECIL
// ==========================================
// 1. Total Tiket
$q_tot_tiket = mysqli_query($koneksi, "SELECT COUNT(id_tiket) as jml_tiket FROM tiket");
$tot_tiket = ($q_tot_tiket) ? mysqli_fetch_assoc($q_tot_tiket)['jml_tiket'] : 0;

// 2. Total Orang
$q_tot_orang = mysqli_query($koneksi, "SELECT SUM(orang) as jml_orang FROM tiket");
$tot_orang = ($q_tot_orang) ? mysqli_fetch_assoc($q_tot_orang)['jml_orang'] : 0;

// 3. Total Pemasukan (Harga Tiket Rp 6.500 / orang)
$tot_pemasukan = $tot_orang * 6500;

// 4. Total Denda (Total semua denda di tabel denda)
$q_tot_denda = mysqli_query($koneksi, "SELECT SUM(total_denda) as jml_denda FROM denda");
$tot_denda = ($q_tot_denda) ? mysqli_fetch_assoc($q_tot_denda)['jml_denda'] : 0;

// ==========================================
// [FITUR BARU] CEK INGATAN NOTIF DARURAT
// ==========================================
$notif_file = 'config/status_darurat.json';
$darurat_aktif = false;
$pesan_darurat = '';
$waktu_darurat = '00.00';
$dikirim_ke = 0;


$jumlah_hari = date('t'); // Otomatis mendeteksi total hari bulan ini (28-31)[cite: 4]
$label_tgl_array = [];
$data_sampah_array = array_fill(0, $jumlah_hari, 0); // Siapkan array isi 0 sebanyak jumlah hari

for ($i = 1; $i <= $jumlah_hari; $i++) {
    $label_tgl_array[] = $i; // Label tanggal 1, 2, 3, dst[cite: 4]
}

// ==========================================
// [DATA GRAFIK] TREN SAMPAH HARIAN
// ==========================================
// 1. Ambil bulan dari URL (jika ada), kalau tidak pakai bulan ini
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab-data';

// ==========================================
// [FITUR BARU] HITUNG ULASAN PENDING UNTUK NOTIFIKASI
// ==========================================
$q_pending = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM ulasan WHERE status = 'pending'");
$pending_count = $q_pending ? mysqli_fetch_assoc($q_pending)['total'] : 0;

// ==========================================
// KUNCI FILTER BULAN UNTUK SEMUA DATA
// ==========================================
$bulan_filter = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
$bulan_f = date('m', strtotime($bulan_filter));
$tahun_f = date('Y', strtotime($bulan_filter));

// 1. Hitung data untuk 3 Kotak Indikator Status & Tabel Wisatawan
$query_count_0 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tiket WHERE status = 'Belum Check-in' AND MONTH(tanggal_kunjungan) = '$bulan_f' AND YEAR(tanggal_kunjungan) = '$tahun_f'");
$count_0 = $query_count_0 ? mysqli_fetch_assoc($query_count_0)['total'] : 0;

$query_count_1 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tiket WHERE status = 'Masih di Wisata' AND MONTH(tanggal_kunjungan) = '$bulan_f' AND YEAR(tanggal_kunjungan) = '$tahun_f'");
$count_1 = $query_count_1 ? mysqli_fetch_assoc($query_count_1)['total'] : 0;

$query_count_2 = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tiket WHERE status = 'Sudah Pulang' AND MONTH(tanggal_kunjungan) = '$bulan_f' AND YEAR(tanggal_kunjungan) = '$tahun_f'");
$count_2 = $query_count_2 ? mysqli_fetch_assoc($query_count_2)['total'] : 0;

// Tabel Utama Data Wisatawan (Ikut difilter)
$query = mysqli_query($koneksi, "SELECT * FROM tiket WHERE MONTH(tanggal_kunjungan) = '$bulan_f' AND YEAR(tanggal_kunjungan) = '$tahun_f' ORDER BY id_tiket DESC");

// 2. Hitung 4 Kotak Rekap Kecil (Tiket, Orang, Pemasukan, Denda)
$q_tot_tiket = mysqli_query($koneksi, "SELECT COUNT(id_tiket) as jml_tiket FROM tiket WHERE MONTH(tanggal_kunjungan) = '$bulan_f' AND YEAR(tanggal_kunjungan) = '$tahun_f'");
$tot_tiket = ($q_tot_tiket) ? mysqli_fetch_assoc($q_tot_tiket)['jml_tiket'] : 0;

$q_tot_orang = mysqli_query($koneksi, "SELECT SUM(orang) as jml_orang FROM tiket WHERE MONTH(tanggal_kunjungan) = '$bulan_f' AND YEAR(tanggal_kunjungan) = '$tahun_f'");
$tot_orang = ($q_tot_orang) ? mysqli_fetch_assoc($q_tot_orang)['jml_orang'] : 0;

$tot_pemasukan = $tot_orang * 6500;

// Denda dihubungkan ke tiket agar bisa difilter bulannya
$q_tot_denda = mysqli_query($koneksi, "SELECT SUM(d.total_denda) as jml_denda FROM denda d JOIN tiket t ON d.id_tiket = t.id_tiket WHERE MONTH(t.tanggal_kunjungan) = '$bulan_f' AND YEAR(t.tanggal_kunjungan) = '$tahun_f'");
$tot_denda = ($q_tot_denda) ? mysqli_fetch_assoc($q_tot_denda)['jml_denda'] : 0;

// ==========================================
// 3. [DATA GRAFIK] TREN SAMPAH HARIAN
// ==========================================
$jumlah_hari = date('t', strtotime($bulan_filter . '-01')); 
$labels_tgl = [];
$data_sampah_array = array_fill(0, $jumlah_hari, 0); 

for ($i = 1; $i <= $jumlah_hari; $i++) {
    $labels_tgl[] = $i . ' ' . date('M', strtotime($bulan_filter . '-01')); 
}

$q_grafik_sampah = mysqli_query($koneksi, "
    SELECT 
        DAY(t.tanggal_kunjungan) as hari, 
        SUM(s.jumlah) as total_qty 
    FROM tiket t
    JOIN sampah s ON t.id_tiket = s.id_tiket
    WHERE MONTH(t.tanggal_kunjungan) = '$bulan_f' 
      AND YEAR(t.tanggal_kunjungan) = '$tahun_f'
    GROUP BY DAY(t.tanggal_kunjungan)
");

// Ambil data dari database KHUSUS untuk bulan dan tahun saat ini
$q_grafik = mysqli_query($koneksi, "
    SELECT DAY(t.tanggal_kunjungan) as hari, SUM(d.total_denda) as denda_harian
    FROM tiket t
    LEFT JOIN denda d ON t.id_tiket = d.id_tiket
    WHERE MONTH(t.tanggal_kunjungan) = MONTH(CURDATE()) 
      AND YEAR(t.tanggal_kunjungan) = YEAR(CURDATE())
    GROUP BY DAY(t.tanggal_kunjungan)
");

// Cocokkan data dari database ke tanggal di kalender grafik
if ($q_grafik && mysqli_num_rows($q_grafik) > 0) {
    while($rg = mysqli_fetch_assoc($q_grafik)) {
        $hari_kunjungan = (int)$rg['hari']; // Dapat tanggal ke berapa (misal: 15)
        $denda = $rg['denda_harian'] ? $rg['denda_harian'] : 0;
        
        // Masukkan data ke array sesuai index tanggalnya (index array mulai dari 0, jadi hari - 1)
        $data_jml_hilang[$hari_kunjungan - 1] = (int)($denda / 10000); // Rp 10.000 = 1 item sampah
    }
}

// Ubah format menjadi JSON untuk dibaca oleh JavaScript
$json_data_hilang = json_encode($data_jml_hilang);
if (file_exists($notif_file)) {
    $data_json = json_decode(file_get_contents($notif_file), true);
    if (isset($data_json['aktif']) && $data_json['aktif'] === true) {
        $darurat_aktif = true;
        $pesan_darurat = $data_json['pesan'];
        $waktu_darurat = $data_json['waktu'];
        $dikirim_ke = isset($data_json['dikirim_ke']) ? $data_json['dikirim_ke'] : 0;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - SI-TANCAK PANTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/tancak-panti/style/admin.css">
</head>
<body class="flex flex-col min-h-screen text-gray-800">

    <!-- TOP BANNER NOTIF DARURAT -->
    <div id="top-banner-notif" class="<?= $darurat_aktif ? '' : 'hidden' ?> bg-[#ef4444] text-white px-6 py-3 shadow-md relative z-50">
        <div class="max-w-[1440px] mx-auto flex flex-col justify-center">
            <div class="text-[12px] font-bold flex items-center gap-2 mb-1 tracking-wide">
                <span class="w-2.5 h-2.5 rounded-full bg-red-200 animate-pulse"></span>
                NOTIF AKTIF - <span id="banner-time"><?= $waktu_darurat ?></span> - <span id="banner-count"><?= $dikirim_ke ?></span> WISATAWAN DI AREA - 
                <button id="btn-baca-selengkapnya" class="underline hover:text-red-200 transition-colors uppercase cursor-pointer">TEKAN UNTUK BACA SELENGKAPNYA</button>
            </div>
            <div class="text-[13.5px] font-medium truncate w-full" id="banner-text">
                <?= $darurat_aktif ? htmlspecialchars($pesan_darurat) : '⚠️ PEMBERITAHUAN DARURAT: Memuat pesan...' ?>
            </div>
        </div>
    </div>

<main class="flex-1 pt-8 pb-12 px-4 lg:px-6 max-w-[1440px] mx-auto w-full">
        
        <!-- HEADER -->
        <div class="bg-white rounded-[24px] p-6 flex flex-col md:flex-row justify-between items-center shadow-sm mb-6 border border-gray-100">
            <div class="mb-4 md:mb-0 text-center md:text-left">
                <h1 class="text-[26px] font-extrabold text-[#1a3326] tracking-tight">Dashboard Admin</h1>
                <p class="text-gray-400 text-[14px] font-medium mt-0.5">Wisata Air Terjun Tancak Panti</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Logika Tombol Notif -->
                <?php if($darurat_aktif): ?>
                <button type="button" id="btn-notif-header" class="flex items-center gap-2 px-5 py-2.5 bg-[#ef4444] text-white rounded-[14px] text-[13px] font-bold shadow-md hover:bg-[#dc2626] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                    <span id="text-notif-header">Notif Aktif</span>
                </button>
                <?php else: ?>
                <button type="button" id="btn-notif-header" class="flex items-center gap-2 px-5 py-2.5 border border-orange-200 text-orange-500 rounded-[14px] text-[13px] font-bold hover:bg-orange-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                    <span id="text-notif-header">Notif Darurat</span>
                </button>
                <?php endif; ?>
                
                <a href="/tancak-panti/admin/logout" class="flex items-center gap-2 px-5 py-2.5 border border-gray-200 text-gray-500 rounded-[14px] text-[13px] font-bold hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </a>
            </div>
        </div>

        <!-- TAB NAVIGASI -->
        <div class="flex flex-wrap gap-3 mb-8">
            <!-- Tombol Data Wisatawan -->
            <button data-target="tab-data" class="tab-btn <?= $active_tab == 'tab-data' ? 'active' : '' ?> px-5 py-2.5 rounded-[12px] font-semibold flex items-center gap-2 shadow-sm cursor-pointer">
                <!-- SVG Icon -->
                Data Wisatawan
            </button>

            <!-- Tombol Rekap Wisatawan -->
            <button data-target="tab-rekap" class="tab-btn <?= $active_tab == 'tab-rekap' ? 'active' : '' ?> px-5 py-2.5 rounded-[12px] font-semibold flex items-center gap-2 shadow-sm cursor-pointer">
                <!-- SVG Icon -->
                Rekap Wisatawan
            </button>

            <!-- Tombol Moderasi Ulasan -->
            <button data-target="tab-ulasan" class="tab-btn <?= $active_tab == 'tab-ulasan' ? 'active' : '' ?> px-5 py-2.5 rounded-[12px] font-semibold flex items-center gap-2 shadow-sm cursor-pointer relative">
                Moderasi Ulasan
                <span id="badge-pending" class="<?= $pending_count > 0 ? '' : 'hidden' ?> absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full border-2 border-white shadow-sm transition-all"><?= $pending_count ?></span>
            </button>
        </div>
        
        <!-- ========================================== -->
        <!-- ISI TAB 1: DATA WISATAWAN (DEFAULT AKTIF) -->
        <!-- ========================================== -->
        <div id="tab-data" class="tab-content <?= $active_tab == 'tab-data' ? 'active' : '' ?>">
            
            <!-- KOTAK STATUS REALTIME -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-[#fef2f2] rounded-[16px] p-5 text-center shadow-sm">
                    <div class="flex items-center justify-center gap-1.5 text-red-500 font-bold text-[13px] mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Belum Check-in
                    </div>
                    <div id="count-0" class="text-[#dc2626] text-[36px] font-extrabold leading-none mb-1 transition-all"><?= $count_0 ?></div>
                    <div class="text-red-400 text-[12px] font-medium">tiket</div>
                </div>
                
                <div class="bg-[#fffbeb] rounded-[16px] p-5 text-center shadow-sm">
                    <div class="flex items-center justify-center gap-1.5 text-yellow-600 font-bold text-[13px] mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Masih di Wisata
                    </div>
                    <div id="count-1" class="text-[#d97706] text-[36px] font-extrabold leading-none mb-1 transition-all"><?= $count_1 ?></div>
                    <div class="text-yellow-500 text-[12px] font-medium">tiket</div>
                </div>
                
                <div class="bg-[#f0fdf4] rounded-[16px] p-5 text-center shadow-sm">
                    <div class="flex items-center justify-center gap-1.5 text-green-600 font-bold text-[13px] mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Sudah Pulang
                    </div>
                    <div id="count-2" class="text-[#16a34a] text-[36px] font-extrabold leading-none mb-1 transition-all"><?= $count_2 ?></div>
                    <div class="text-green-500 text-[12px] font-medium">tiket</div>
                </div>
            </div>

            <!-- BAR PENCARIAN & FILTER -->
            <div class="bg-white rounded-[16px] py-2.5 px-4 flex items-center shadow-sm mb-6 border border-gray-100 flex-wrap md:flex-nowrap gap-4">
                <div class="flex items-center flex-1 min-w-[250px]">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="main-search" placeholder="Cari tiket, nama, no telp, status..." class="w-full text-[13px] outline-none bg-transparent font-medium text-gray-700 placeholder-gray-400">
                </div>
                <div class="flex items-center gap-2 border-t md:border-t-0 md:border-l border-gray-200 pt-2 md:pt-0 md:pl-4 w-full md:w-auto">
                    <span class="text-[12px] text-gray-600 font-semibold whitespace-nowrap">Filter:</span>
                    <input type="date" id="date-filter" class="bg-gray-50 border border-gray-200 rounded-[8px] px-2 py-1.5 text-[12px] font-medium outline-none focus:border-[#2d6a4f] text-gray-700 w-full md:w-auto cursor-pointer">
                </div>
            </div>

            <!-- TABEL DATA COMPACT -->
            <div class="bg-white rounded-[16px] shadow-sm overflow-hidden border border-gray-50">
                <table class="table-fixed-layout text-left border-collapse w-full">
                    <thead class="bg-[#1a3326] text-white border-b border-[#1a3326]">
                        <tr>
                            <th class="w-[120px] px-3 py-4 text-[12.5px] font-semibold tracking-wide text-center">Tanggal</th>
                            <th class="w-[100px] px-3 py-4 text-[12.5px] font-semibold tracking-wide">ID Tiket</th>
                            <th class="w-[140px] px-3 py-4 text-[12.5px] font-semibold tracking-wide">Nama</th>
                            <th class="w-[130px] px-3 py-4 text-[12.5px] font-semibold tracking-wide">Alamat</th>
                            <th class="w-[60px] px-2 py-4 text-[12.5px] font-semibold tracking-wide text-center">Orang</th>
                            <th class="w-[110px] px-3 py-4 text-[12.5px] font-semibold tracking-wide">Telepon 1</th>
                            <th class="w-[110px] px-3 py-4 text-[12.5px] font-semibold tracking-wide">Telepon 2</th>
                            <th class="w-[100px] px-2 py-4 text-[12.5px] font-semibold tracking-wide text-center">Bukti Transfer</th>
                            <th class="w-[85px] px-2 py-4 text-[12.5px] font-semibold tracking-wide text-center">Sampah</th>
                            <th class="w-[115px] px-2 py-4 text-[12.5px] font-semibold tracking-wide text-center">Denda</th>
                            <th class="w-[120px] px-3 py-4 text-[12.5px] font-semibold tracking-wide text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="wisatawan-tbody">
                        <?php if($query && mysqli_num_rows($query) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($query)): 
                                $id_tk = $row['id_tiket']; 
                                $kode_tampil = !empty($row['kode_tiket']) ? $row['kode_tiket'] : $id_tk;
                                
                                $res_s = mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM sampah WHERE id_tiket = $id_tk");
                                $total_s = ($res_s) ? mysqli_fetch_assoc($res_s)['total'] : 0;
                                if(empty($total_s)) $total_s = 0;
                                
                                $row['jumlah_orang'] = isset($row['orang']) ? $row['orang'] : 0;
                                $telp1 = isset($row['telepon_1']) && !empty($row['telepon_1']) ? $row['telepon_1'] : null;
                                $telp2 = isset($row['telepon_2']) && !empty($row['telepon_2']) ? $row['telepon_2'] : null;
                                $bukti = isset($row['bukti_transfer']) && !empty($row['bukti_transfer']) ? $row['bukti_transfer'] : null;

                                $st_raw = $row['status'];
                                if ($st_raw == 'Belum Check-in') {
                                    $st_num = 0; $st_class = 'bg-red-50 text-red-600 border-red-200';
                                } else if ($st_raw == 'Masih di Wisata') {
                                    $st_num = 1; $st_class = 'bg-yellow-50 text-yellow-600 border-yellow-200';
                                } else if ($st_raw == 'Sudah Pulang') {
                                    $st_num = 2; $st_class = 'bg-green-50 text-green-600 border-green-200';
                                } else {
                                    $st_num = 0; $st_raw = 'Belum Check-in'; $st_class = 'bg-red-50 text-red-600 border-red-200';
                                }
                            ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors row-tiket">
                                <td class="data-tgl px-3 py-3 text-[11.5px] text-gray-500 font-medium text-center" data-value="<?= $row['tanggal_kunjungan']; ?>"><?= date('d M', strtotime($row['tanggal_kunjungan'])); ?></td>
                                <td class="data-id px-3 py-3 text-[11.5px] font-extrabold text-[#1a3326]"><?= $kode_tampil; ?></td>
                                <td class="data-nama px-3 py-3 text-[12px] font-bold text-gray-800 truncate-text" title="<?= $row['nama']; ?>"><?= $row['nama']; ?></td>
                                <td class="data-alamat px-3 py-3 text-[12px] text-gray-500 truncate-text" title="<?= $row['alamat']; ?>"><?= $row['alamat']; ?></td>
                                <td class="px-2 py-3 text-[12px] text-center font-bold text-gray-700"><?= $row['jumlah_orang']; ?></td>
                                
                                <td class="px-3 py-3 text-[11.5px] font-bold">
                                    <?php if($telp1): ?>
                                        <a href="https://wa.me/<?= formatWA($telp1); ?>" target="_blank" class="text-green-600 hover:text-green-800 flex items-center gap-1 transition-colors">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            <span class="truncate-text"><?= $telp1; ?></span>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-3 py-3 text-[11.5px] font-bold">
                                    <?php if($telp2): ?>
                                        <a href="https://wa.me/<?= formatWA($telp2); ?>" target="_blank" class="text-green-600 hover:text-green-800 flex items-center gap-1 transition-colors">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            <span class="truncate-text"><?= $telp2; ?></span>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-2 py-3 text-center">
                                    <?php if($bukti && strpos($bukti, 'http') === 0): 
                                        $link_bersih_bukti = str_replace('https://', '', $bukti);
                                        $link_proxy_bukti = 'https://wsrv.nl/?url=' . $link_bersih_bukti;
                                    ?>
                                        <img src="<?= htmlspecialchars($link_proxy_bukti); ?>" class="w-8 h-8 object-cover rounded-[6px] mx-auto cursor-pointer border border-gray-200 hover:opacity-80 transition-opacity btn-zoom-bukti" data-src="<?= htmlspecialchars($link_proxy_bukti); ?>">
                                    <?php else: ?>
                                        <span class="text-[10px] text-gray-400 font-medium">Kosong</span>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="px-2 py-3 text-center">
                                    <button class="btn-kelola-sampah bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 px-2 py-1 rounded-md font-bold text-[11px] transition-colors whitespace-nowrap" data-id="<?= $id_tk; ?>" data-kode="<?= $kode_tampil; ?>" data-nama="<?= $row['nama']; ?>">
                                        <span class="total-item-teks"><?= $total_s; ?></span> <span class="font-medium text-[9px]">item</span>
                                    </button>
                                </td>

                                <td class="px-2 py-3 text-center">
                                    <?php
                                        $q_denda_tiket = mysqli_query($koneksi, "SELECT SUM(total_denda) as grand_total FROM denda WHERE id_tiket = $id_tk");
                                        $total_denda_rp = ($q_denda_tiket && mysqli_num_rows($q_denda_tiket) > 0) ? (int)mysqli_fetch_assoc($q_denda_tiket)['grand_total'] : 0;
                                        
                                        if ($total_denda_rp > 0) {
                                            $btn_denda_class = "bg-red-100 text-red-600 hover:bg-red-200 border-red-200";
                                        } else {
                                            $btn_denda_class = "bg-gray-50 text-gray-600 hover:bg-gray-200 border-gray-200";
                                        }
                                    ?>
                                    <button class="btn-kelola-denda <?= $btn_denda_class ?> border px-3 py-1.5 rounded-md font-bold text-[10.5px] transition-colors whitespace-nowrap w-full max-w-[100px] overflow-hidden text-ellipsis block mx-auto" data-id="<?= $id_tk; ?>" data-kode="<?= $kode_tampil; ?>" data-nama="<?= $row['nama']; ?>">
                                        + Denda
                                    </button>
                                </td>

                                <td class="px-3 py-3 text-center data-status-text" data-text-status="<?= strtolower($st_raw); ?>">
                                    <button type="button" class="status-toggle outline-none border px-2 py-1.5 rounded-full text-[10.5px] font-bold flex items-center justify-center gap-1 w-full max-w-[110px] mx-auto transition-colors <?= $st_class; ?>" data-state="<?= $st_num; ?>" data-id="<?= $id_tk; ?>">
                                        <?= $st_raw; ?>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="p-10 text-center text-gray-400 font-medium text-[13px]">Belum ada data wisatawan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- ISI TAB 2: REKAP WISATAWAN & DENDA -->
        <!-- ========================================== -->
        <div id="tab-rekap" class="tab-content <?= $active_tab == 'tab-rekap' ? 'active' : '' ?>">
            
            <!-- HEADER REKAP & FILTER -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h2 class="font-bold text-xl text-[#1a3326] mb-1">Rekap Wisatawan & Denda</h2>
                    <p class="text-xs text-gray-400">Data permanen tersimpan otomatis, tidak akan hilang atau reset</p>
                </div>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <!-- Filter Bulan -->
                    <div class="bg-white border border-gray-200 rounded-[10px] px-3 py-2 flex items-center shadow-sm w-full md:w-auto">
                        <input type="month" id="filter-bulan-rekap" value="<?= isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m'); ?>" class="text-[13px] text-gray-600 font-medium outline-none bg-transparent cursor-pointer w-full">
                    </div>
                    <!-- Tombol Cetak -->
                    <button onclick="cetakLaporan()" class="bg-[#1a3326] hover:bg-[#12241b] text-white px-5 py-2.5 rounded-[10px] text-[13px] font-bold flex items-center gap-2 transition-colors shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Rekap
                    </button>

                    <script>
                    function cetakLaporan() {
                        const bulan = document.getElementById('filter-bulan-rekap').value;
                        
                        // Membuka jendela baru dengan ukuran spesifik (kayak di gambar sampeyan)
                        const lebar = 1100;
                        const tinggi = 800;
                        const kiri = (screen.width - lebar) / 2;
                        const atas = (screen.height - tinggi) / 2;
                        
                        window.open(
                            '/tancak-panti/admin/cetak?bulan=' + bulan, 
                            'LaporanKunjungan', 
                            `width=${lebar},height=${tinggi},left=${kiri},top=${atas},scrollbars=yes`
                        );
                    }
                    </script>
                </div>
            </div>

            <!-- 5 KOTAK INDIKATOR KECIL (TOTAL) -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div class="bg-gray-50 rounded-[14px] p-4 border border-gray-100 shadow-sm">
                    <p class="text-[11px] text-gray-500 font-semibold mb-1">Total Tiket</p>
                    <p class="text-[14px] font-bold text-gray-800"><span class="text-[18px] font-extrabold"><?= $tot_tiket ?></span> tiket</p>
                </div>
                <div class="bg-blue-50 rounded-[14px] p-4 border border-blue-100 shadow-sm">
                    <p class="text-[11px] text-blue-500 font-semibold mb-1">Total Orang</p>
                    <p class="text-[14px] font-bold text-blue-600"><span class="text-[18px] font-extrabold"><?= $tot_orang ?></span> orang</p>
                </div>
                <div class="bg-green-50 rounded-[14px] p-4 border border-green-100 shadow-sm">
                    <p class="text-[11px] text-green-600 font-semibold mb-1">Total Pemasukan</p>
                    <p class="text-[16px] font-extrabold text-green-600">Rp <?= number_format($tot_pemasukan, 0, ',', '.') ?></p>
                </div>
                <div class="bg-red-50 rounded-[14px] p-4 border border-red-100 shadow-sm">
                    <p class="text-[11px] text-red-500 font-semibold mb-1">Total Denda</p>
                    <p class="text-[16px] font-extrabold text-red-600">Rp <?= number_format($tot_denda, 0, ',', '.') ?></p>
                </div>
            </div>

            <!-- 3 KOTAK STATUS BESAR -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-[#fef2f2] rounded-[16px] p-6 text-center shadow-sm border border-red-100">
                    <div class="text-[#dc2626] text-[40px] font-black leading-none mb-2"><?= $count_0 ?></div>
                    <div class="text-red-600 text-[12px] font-bold tracking-wide">Belum Check-in</div>
                </div>
                <div class="bg-[#fffbeb] rounded-[16px] p-6 text-center shadow-sm border border-yellow-100">
                    <div class="text-[#d97706] text-[40px] font-black leading-none mb-2"><?= $count_1 ?></div>
                    <div class="text-yellow-600 text-[12px] font-bold tracking-wide">Masih di Wisata</div>
                </div>
                <div class="bg-[#f0fdf4] rounded-[16px] p-6 text-center shadow-sm border border-green-100">
                    <div class="text-[#16a34a] text-[40px] font-black leading-none mb-2"><?= $count_2 ?></div>
                    <div class="text-green-600 text-[12px] font-bold tracking-wide">Sudah Pulang</div>
                </div>
            </div>

            <!-- SEKSI BARU: TABEL SAMPAH/BENDA KETINGGALAN -->
            <div class="bg-[#fff5f5] rounded-[20px] p-6 mb-8 border border-red-100 shadow-sm">
                <div class="flex items-center gap-4 mb-5">
                    <div class="bg-[#ef4444] text-white p-3 rounded-[12px] shadow-sm flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-bold text-gray-800">Daftar Sampah</h3>
                        <p class="text-[13px] text-gray-500 mt-0.5">Total item yang tidak dikembalikan wisatawan bulan ini</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[20px] border border-gray-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-bl-full -z-10 opacity-50"></div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-[13px]">
                            <thead class="bg-gray-50/50 text-gray-500">
                                <tr>
                                    <th class="p-3 font-bold rounded-l-[10px] w-16 text-center">No</th>
                                    <th class="p-3 font-bold">Jenis Item Sampah</th>
                                    <th class="p-3 font-bold rounded-r-[10px] text-center w-36 whitespace-nowrap">Total Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $bulan_filter = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

                                $q_rekap_sampah = mysqli_query($koneksi, "
                                    SELECT s.nama_sampah, SUM(s.jumlah) as total_qty 
                                    FROM sampah s
                                    JOIN tiket t ON s.id_tiket = t.id_tiket
                                    WHERE DATE_FORMAT(t.tanggal_kunjungan, '%Y-%m') = '$bulan_filter'
                                    GROUP BY s.nama_sampah
                                    ORDER BY total_qty DESC
                                ");

                                $no_sampah = 1;
                                if(mysqli_num_rows($q_rekap_sampah) > 0) {
                                    while($sampah = mysqli_fetch_assoc($q_rekap_sampah)): 
                                ?>
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="p-3 text-center text-gray-400 font-medium"><?= $no_sampah++ ?></td>
                                    <td class="p-3 font-bold text-gray-700 capitalize"><?= htmlspecialchars($sampah['nama_sampah']) ?></td>
                                    <td class="p-3 text-center">
                                        <span class="inline-block bg-green-50 text-green-600 px-4 py-1.5 rounded-[8px] font-extrabold text-[12px] whitespace-nowrap shadow-sm">
                                            <?= $sampah['total_qty'] ?> pcs
                                        </span>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile; 
                                } else { 
                                ?>
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-gray-400 border-b border-gray-50">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <span>Belum ada data sampah masuk di bulan ini.</span>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- 1. GRAFIK STATUS WISATAWAN -->
            <!-- ========================================== -->
            <div class="bg-white rounded-[16px] border border-gray-200 p-6 mb-8 shadow-sm">
                <div class="mb-5">
                    <h3 class="font-bold text-[15px] text-gray-800 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-[#10b981]"></i> Distribusi Status Wisatawan</h3>
                    <p class="text-[12px] text-gray-500 mt-0.5">Perbandingan total akumulasi tiket berdasarkan status</p>
                </div>

                    <div class="w-full h-[220px]">
                    <canvas id="chartStatusWisatawan"></canvas>
                </div>
            </div>
            
            <div class="bg-white rounded-[16px] border border-gray-200 p-6 mb-8 shadow-sm">
                <div class="mb-5 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-[15px] text-gray-800 flex items-center gap-2">
                            <i class="fas fa-chart-line text-[#3c8dbc]"></i> Tren Sampah Harian
                        </h3>
                        <p class="text-[12px] text-gray-500 mt-0.5">Fluktuasi jumlah item sampah pada bulan ini</p>
                    </div>
                </div>
                <div class="w-full h-[220px] chart-container">
                    <canvas id="lineChartSampah"></canvas>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- ISI TAB 3: MODERASI ULASAN -->
        <!-- ========================================== -->
<div id="tab-ulasan" class="tab-content <?= $active_tab == 'tab-ulasan' ? 'active' : '' ?>">
            
            <?php
            // ==========================================
            // 1. BAGIAN OTAK FILTER (HANYA SEKALI SAJA)
            // ==========================================
            $filter_status = isset($_GET['status']) ? $_GET['status'] : 'semua';

            // Kueri menyesuaikan tab yang diklik
            if ($filter_status == 'menunggu') {
                $query_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan WHERE status = 'menunggu' ORDER BY id_ulasan DESC");
            } elseif ($filter_status == 'disetujui') {
                $query_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan WHERE status = 'setuju' ORDER BY id_ulasan DESC");
            } elseif ($filter_status == 'ditolak') {
                $query_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan WHERE status = 'tolak' ORDER BY id_ulasan DESC");
            } else {
                $query_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan ORDER BY id_ulasan DESC");
            }
            ?>

            <div class="bg-white border-b border-gray-200 w-full mb-6">
                <nav class="-mb-px flex space-x-4 overflow-x-auto custom-scrollbar" aria-label="Tabs">
                    <a href="/tancak-panti/admin/dashboard?tab=tab-ulasan" 
                       class="<?= ($filter_status == 'semua') ? 'border-[#1b3d2f] text-[#1b3d2f] bg-[#f4f9f6] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 font-medium' ?> whitespace-nowrap px-4 py-2 border-b-2 text-[14px] transition-all duration-200">
                        Semua
                    </a>
                    <a href="/tancak-panti/admin/dashboard?tab=tab-ulasan&status=menunggu" 
                       class="<?= ($filter_status == 'menunggu') ? 'border-[#1b3d2f] text-[#1b3d2f] bg-[#f4f9f6] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 font-medium' ?> whitespace-nowrap px-4 py-2 border-b-2 text-[14px] transition-all duration-200">
                        Menunggu
                    </a>
                    <a href="/tancak-panti/admin/dashboard?tab=tab-ulasan&status=disetujui" 
                       class="<?= ($filter_status == 'disetujui') ? 'border-[#1b3d2f] text-[#1b3d2f] bg-[#f4f9f6] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 font-medium' ?> whitespace-nowrap px-4 py-2 border-b-2 text-[14px] transition-all duration-200">
                        Disetujui
                    </a>
                    <a href="/tancak-panti/admin/dashboard?tab=tab-ulasan&status=ditolak" 
                       class="<?= ($filter_status == 'ditolak') ? 'border-[#1b3d2f] text-[#1b3d2f] bg-[#f4f9f6] font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 font-medium' ?> whitespace-nowrap px-4 py-2 border-b-2 text-[14px] transition-all duration-200">
                        Ditolak
                    </a>
                </nav>
            </div>

            <?php if(mysqli_num_rows($query_ulasan) > 0): ?>
                <div id="ulasan-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php 
                    while($ul = mysqli_fetch_assoc($query_ulasan)):
                        $status_db = strtolower($ul['status']);
                    ?>
                    <div class="ulasan-card bg-white rounded-[20px] shadow-sm overflow-hidden flex flex-col border border-gray-100 transition-all duration-300" data-status="<?= $status_db ?>" data-id="<?= $ul['id_ulasan'] ?>">
                        
                        <div class="status-ribbon px-4 py-2.5 flex items-center justify-between text-[11px] font-extrabold uppercase tracking-widest border-b transition-colors duration-300">
                            </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="avatar-circle w-9 h-9 rounded-full bg-[#1a3326] text-white flex items-center justify-center font-extrabold text-[13px] shrink-0 transition-colors duration-300">
                                        <?= strtoupper(substr($ul['nama'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="text-gray-800 text-[13.5px] font-extrabold leading-tight"><?= htmlspecialchars($ul['nama']) ?></p>
                                        <p class="text-gray-400 text-[11px] font-medium mt-0.5"><?= isset($ul['tanggal']) ? date('d M Y', strtotime($ul['tanggal'])) : 'Baru saja' ?></p>
                                    </div>
                                </div>
                                
                                <div class="flex gap-0.5">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <?php if($i <= (int)$ul['rating']): ?>
                                            <svg class="w-3.5 h-3.5 text-amber-400 fill-amber-400" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <?php else: ?>
                                            <svg class="w-3.5 h-3.5 text-gray-200 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 text-[13px] font-medium leading-relaxed flex-1 mb-5">
                                <?= htmlspecialchars($ul['teks']) ?>
                            </p>
                            
                            <?php 
                            if(!empty($ul['gambar']) && strpos($ul['gambar'], 'http') === 0): 
                                $link_bersih_ulasan = str_replace(['https://', 'http://'], '', $ul['gambar']);
                                $link_proxy_ulasan = 'https://wsrv.nl/?url=' . $link_bersih_ulasan;
                            ?>
                                <div class="mb-4">
                                    <img src="<?= htmlspecialchars($link_proxy_ulasan) ?>" 
                                         class="w-full h-[140px] object-cover rounded-[12px] border border-gray-200 cursor-pointer hover:opacity-80 transition-all shadow-sm" 
                                         onclick="openBuktiUlasan('<?= htmlspecialchars($link_proxy_ulasan) ?>')" 
                                         alt="Foto Ulasan">
                                </div>
                            <?php endif; ?>
                            
                            <div class="action-buttons flex gap-2 mt-auto">
                                </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="flex flex-col items-center justify-center py-10 w-full">
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-10 text-center flex flex-col items-center justify-center w-full max-w-md mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="text-lg font-bold text-gray-700 mb-1">Tidak Ada Ulasan</h3>
                        <p class="text-gray-500 text-sm">Belum ada data ulasan untuk status <strong>"<?= ucfirst($filter_status) ?>"</strong> saat ini.</p>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </main>


<!-- 1. LOAD MESIN CHART -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- 2. JEMBATAN DATA (PASTIKAN NAMA VARIABEL SAMA DENGAN DI PHP ATAS) -->
    <script>
        // Jembatan Data PHP ke JS
        window.labelGrafikSampah = <?= $json_labels_sampah ?>;
        window.dataSampahBawa = <?= $json_data_bawa ?>;
        window.dataSampahHilang = <?= $json_data_hilang ?>;
        window.namaBulanPilih = "<?= $nama_bulan_pilih ?>";
        
        // Data untuk Grafik Status
        const valBelum = <?= (int)$count_0 ?>;
        const valMasih = <?= (int)$count_1 ?>;
        const valPulang = <?= (int)$count_2 ?>;
    </script>
    <script src="/tancak-panti/js/admin.js"></script>

    <!-- SEMUA MODAL DILETAKKAN DI LUAR AREA TAB -->

    <!-- MODAL POP UP BUKTI TF -->
    <div id="modal-bukti" class="overlay-modal" onclick="closeBukti()">
        <div class="relative p-2" onclick="event.stopPropagation()">
            <button onclick="closeBukti()" class="absolute -top-4 -right-4 bg-white text-gray-800 w-8 h-8 rounded-full font-bold shadow-md hover:bg-gray-100 flex items-center justify-center">✕</button>
            <img id="img-bukti-full" src="" class="max-w-[90vw] max-h-[85vh] rounded-[16px] object-contain shadow-2xl bg-white">
        </div>
    </div>

    <!-- MODAL SAMPAH -->
    <div id="modal-trash" class="overlay-modal">
        <div class="modal-card bg-white rounded-[24px] w-full max-w-[500px] shadow-2xl overflow-hidden">
            <div class="bg-[#1a3326] p-6 text-white relative">
                <h3 class="font-extrabold text-[18px] flex items-center gap-2">🌿 Kelola Daftar Sampah</h3>
                <p id="m-visitor-info" class="text-[13px] text-gray-300 font-medium mt-1">Nama Wisatawan • #KODE</p>
                <button id="close-modal-trash" class="absolute top-6 right-6 font-bold text-gray-400 hover:text-white transition-colors">✕</button>
            </div>
            <div class="p-7">
                <p class="text-[12.5px] text-gray-500 mb-5 leading-relaxed">
                    Kelola daftar jenis & jumlah sampah yang dibawa wisatawan.
                </p>
                <div id="m-trash-list" class="space-y-3 mb-6 max-h-[220px] overflow-y-auto pr-2 custom-scrollbar"></div>
                <div class="flex gap-2 mb-8">
                    <input type="text" id="m-input-new" placeholder="Nama item sampah baru..." class="flex-1 bg-white border border-gray-200 rounded-[12px] px-4 py-3 text-[13px] outline-none focus:border-[#2d6a4f] shadow-sm">
                    <button id="m-btn-add" class="bg-[#1a3326] hover:bg-[#12241b] text-white px-5 rounded-[12px] text-[13px] font-bold transition-colors shadow-sm whitespace-nowrap">+ Tambah</button>
                </div>
                <div class="flex gap-3">
                    <button id="m-btn-batal" class="flex-1 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 py-3.5 rounded-[14px] text-[14px] font-bold transition-all">Batal</button>
                    <button id="m-btn-save" class="flex-1 bg-[#1a3326] hover:bg-[#12241b] text-white py-3.5 rounded-[14px] text-[14px] font-bold shadow-md transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Daftar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DENDA -->
    <div id="modal-denda" class="overlay-modal">
        <div class="modal-card bg-white rounded-[24px] w-full max-w-[500px] shadow-2xl overflow-hidden">
            <div class="bg-[#dc2626] p-6 text-white relative">
                <h3 class="font-extrabold text-[18px] flex items-center gap-2">💸 Kelola Denda Sampah</h3>
                <p id="d-visitor-info" class="text-[13px] text-red-100 font-medium mt-1">Nama Wisatawan • #KODE</p>
                <button id="close-modal-denda" class="absolute top-6 right-6 font-bold text-red-200 hover:text-white transition-colors">✕</button>
            </div>
            <div class="p-7">
                <p class="text-[12.5px] text-gray-500 mb-5 leading-relaxed">
                    Atur <strong>jumlah sampah yang HILANG</strong> (tidak dikembalikan) dengan tombol <span class="font-bold">+</span> dan <span class="font-bold">−</span>. Setiap 1 item yang hilang dikenakan denda <strong>Rp 10.000</strong>.
                </p>
                <div id="d-trash-list" class="space-y-3 mb-5 max-h-[200px] overflow-y-auto pr-2 custom-scrollbar">
                    <div class="text-center py-4 text-gray-400 text-[12px]">Memuat data sampah...</div>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-[16px] p-5 mb-8 flex justify-between items-center shadow-sm">
                    <div>
                        <p class="text-gray-500 text-[12px] font-medium mb-1">Estimasi denda</p>
                        <p id="d-total-rp" class="text-red-600 text-[24px] font-extrabold">Rp 0</p>
                    </div>
                    <div class="text-right">
                        <p id="d-total-hilang" class="text-gray-500 text-[12px] font-medium">0 item hilang</p>
                        <p id="d-total-calc" class="text-gray-400 text-[12px] font-medium">0 × Rp 10.000</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button id="d-btn-batal" class="flex-1 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 py-3.5 rounded-[14px] text-[14px] font-bold transition-all">Batal</button>
                    <button id="d-btn-save" class="flex-1 bg-[#dc2626] hover:bg-[#b91c1c] text-white py-3.5 rounded-[14px] text-[14px] font-bold shadow-md transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Denda
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL SETUP NOTIF -->
    <div id="modal-notif-setup" class="overlay-modal">
        <div class="modal-card bg-white rounded-[24px] w-full max-w-[550px] shadow-2xl overflow-hidden">
            <div class="bg-[#ea580c] p-5 text-white relative flex justify-between items-center">
                <h3 class="font-extrabold text-[16px] flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-3.14 8.167-7.221.054-.405.083-.812.083-1.221v0a4 4 0 01-4 4h-2a2 2 0 00-2 2v6a2 2 0 002 2h2a4 4 0 014 4v0c0-.41-.029-.816-.083-1.22-.542-4.08-4.067-7.22-8.167-7.22H7a4.001 4.001 0 01-1.564-.317z"/></svg>
                    Notifikasi Darurat Wisatawan
                </h3>
                <button id="close-notif-setup" class="font-bold text-orange-200 hover:text-white transition-colors">✕</button>
            </div>
            <div class="p-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-[16px] p-4 mb-5">
                    <p class="text-yellow-700 text-[12px] font-bold mb-3 flex items-center gap-1.5">
                        ⚠️ <span id="notif-target-count">0</span> wisatawan di area — pesan WA darurat akan dikirim ke Telepon 1 mereka:
                    </p>
                    <div id="notif-target-list" class="max-h-[100px] overflow-y-auto custom-scrollbar space-y-2">
                        <!-- Data load JS -->
                    </div>
                </div>

                <p class="text-[12px] font-bold text-gray-600 mb-2">Jenis Peringatan</p>
                <div class="grid grid-cols-2 gap-3 mb-5">
                    <button class="btn-jenis-notif border-red-300 text-red-600 bg-red-50 border rounded-[12px] py-2.5 text-[13px] font-bold transition-all flex justify-center items-center gap-2" data-type="hujan">🌧️ Hujan Lebat</button>
                    <button class="btn-jenis-notif border-gray-200 text-gray-600 bg-white hover:bg-gray-50 border rounded-[12px] py-2.5 text-[13px] font-bold transition-all flex justify-center items-center gap-2" data-type="badai">⛈️ Badai</button>
                    <button class="btn-jenis-notif border-gray-200 text-gray-600 bg-white hover:bg-gray-50 border rounded-[12px] py-2.5 text-[13px] font-bold transition-all flex justify-center items-center gap-2" data-type="banjir">🌊 Banjir/Longsor</button>
                    <button class="btn-jenis-notif border-gray-200 text-gray-600 bg-white hover:bg-gray-50 border rounded-[12px] py-2.5 text-[13px] font-bold transition-all flex justify-center items-center gap-2" data-type="kustom">✏️ Pesan Kustom</button>
                </div>

                <p class="text-[12px] font-bold text-gray-600 mb-2">Isi Pesan</p>
                <textarea id="notif-pesan-teks" class="w-full bg-[#fff5f5] border border-red-100 text-[#dc2626] rounded-[16px] p-4 text-[13px] font-medium leading-relaxed outline-none resize-none h-[110px]" readonly>⚠️ PEMBERITAHUAN DARURAT: Akan terjadi hujan lebat di area wisata. Seluruh wisatawan yang masih berada di area Air Terjun Tancak dimohon untuk segera turun menuju pintu keluar dengan tertib. Jangan panik, ikuti arahan petugas.</textarea>

                <div class="flex gap-3 mt-6">
                    <button id="btn-notif-batal" class="flex-1 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 py-3.5 rounded-[14px] text-[14px] font-bold transition-all">Batal</button>
                <button id="btn-notif-aktifkan" class="flex-1 bg-[#e11d48] hover:bg-[#be123c] text-white py-3.5 rounded-[14px] text-[14px] font-bold shadow-md transition-all flex items-center justify-center gap-2" disabled style="opacity: 0.5; cursor: not-allowed;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                    <span id="text-notif-header">Notif Aktif</span>
                </button>                
            </div>
            </div>
        </div>
    </div>

    <!-- MODAL BACA SELENGKAPNYA -->
    <div id="modal-notif-detail" class="overlay-modal">
        <div class="modal-card bg-white rounded-[24px] w-full max-w-[450px] shadow-2xl overflow-hidden">
            <div class="bg-[#ef4444] p-6 text-white relative">
                <h3 class="font-extrabold text-[16px] flex items-center gap-2 tracking-wide uppercase">
                    ⚠️ NOTIFIKASI DARURAT AKTIF
                </h3>
                <p class="text-[12.5px] text-red-100 font-medium mt-1">
                    Aktif sejak pukul <span id="detail-time"><?= $waktu_darurat ?></span> · <span id="detail-count"><?= $dikirim_ke ?></span> wisatawan di area
                </p>
                <button id="close-notif-detail" class="absolute top-6 right-6 font-bold text-red-200 hover:text-white transition-colors">✕</button>
            </div>
            <div class="p-7">
                <div class="bg-[#fff5f5] border border-red-100 text-[#dc2626] rounded-[16px] p-5 text-[13.5px] font-medium leading-relaxed shadow-sm mb-6" id="detail-pesan-teks">
                    <?= $darurat_aktif ? htmlspecialchars($pesan_darurat) : '' ?>
                </div>
                <button id="btn-detail-keluar" class="w-full bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 py-3.5 rounded-[14px] text-[14px] font-bold shadow-sm transition-all">
                    Keluar
                </button>
            </div>
        </div>
    </div>
    
    <div id="modal-bukti" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/90 backdrop-blur-md p-4 transition-all duration-300 opacity-0 pointer-events-none" onclick="closeBukti()">
        <div class="relative w-full h-full flex items-center justify-center">
            <button onclick="closeBukti()" class="absolute top-5 right-5 z-[1000] bg-white/20 hover:bg-red-500 text-white p-3 rounded-full transition-all shadow-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="flex items-center justify-center p-4" onclick="event.stopPropagation()">
                <img id="img-bukti-full" src="" 
                    class="max-w-[95vw] max-h-[90vh] object-contain rounded-lg shadow-2xl border-2 border-white/10 transform scale-95 transition-transform duration-300">
            </div>

            <div class="absolute bottom-6 text-white/50 text-[11px] tracking-widest uppercase">
                Klik di mana saja untuk kembali
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Data Status Wisatawan
        const valBelum = <?= $count_0 ?? 0 ?>;
        const valMasih = <?= $count_1 ?? 0 ?>;
        const valPulang = <?= $count_2 ?? 0 ?>;

        // Data Kalender Sampah

        const labelsKalenderSampah = <?= $json_labels_sampah ?>;
        const dataTrenSampah = <?= $json_data_sampah ?>;
    });
    </script>

    <!-- SCRIPT NAVIGASI TAB (Bebas Cache) -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        
        if(tabButtons.length > 0) {
            tabButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah error bawaan tombol
                    
                    const targetId = this.getAttribute('data-target');
                    
                    // Reload halaman dan ganti URL tab-nya
                    window.location.href = '?tab=' + targetId;
                });
            });
        }
    });
    </script>

    <script>
    function openBuktiUlasan(src) {
        const modalBukti = document.getElementById('modal-bukti');
        const imgFull = document.getElementById('img-bukti-full');
        if (src && src !== "") {
            imgFull.src = src;
            modalBukti.classList.remove('hidden'); 
            setTimeout(() => {
                modalBukti.classList.add('active');
                document.body.style.overflow = 'hidden'; 
            }, 10);
        }
    }
    </script>

</body>
</html>
