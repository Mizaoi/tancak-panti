<?php
session_start();
include '../config/koneksi.php';
include '../config/wa.php'; // Di sini harus ada TOKEN_FONNTE dan TOKEN_IMGBB

// 1. Deklarasi awal
$show_ticket = false;
$data_tiket = null;
$data_sampah = [];
$total_item_sampah = 0;
    
// 2. LOGIKA DATABASE (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_tiket'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $orang = (int)$_POST['jumlah_orang'];
    $telepon_1 = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $telepon_2 = mysqli_real_escape_string($koneksi, $_POST['no_darurat']);
    
    $kode_tiket = "TCK-" . strtoupper(substr(md5(time()), 0, 7));

    // Upload ke ImgBB
    $link_gambar = "";
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] === 0) {
        $link_gambar = uploadKeImgBB($_FILES['bukti_transfer']['tmp_name'], 'BUKTI_TF');
    }

    // Validasi link dari ImgBB
    if(!$link_gambar || strpos($link_gambar, 'http') === false) {
        $err_msg = addslashes($link_gambar);
        echo "<script>alert('Gagal upload! Cek internet & API Key ImgBB. Error: $err_msg'); window.history.back();</script>";
        exit;
    }

    // Insert Data
    $query = "INSERT INTO tiket (kode_tiket, nama, orang, alamat, telepon_1, telepon_2, bukti_transfer, status, tanggal_kunjungan) 
              VALUES ('$kode_tiket', '$nama', $orang, '$alamat', '$telepon_1', '$telepon_2', '$link_gambar', 'Belum Check-in', CURDATE())";
    
    if (mysqli_query($koneksi, $query)) {
        $id_baru = mysqli_insert_id($koneksi);

        if (isset($_POST['nama_sampah'])) {
            foreach ($_POST['nama_sampah'] as $i => $nm) {
                $qty = (int)$_POST['jumlah_sampah'][$i];
                if ($qty > 0) {
                    $item_c = mysqli_real_escape_string($koneksi, $nm);
                    mysqli_query($koneksi, "INSERT INTO sampah (id_tiket, nama_sampah, jumlah) VALUES ($id_baru, '$item_c', $qty)");
                }
            }
        }

        // KIRIM WA PAKAI TOKEN_FONNTE
        $link_cek = "http://localhost/tancak-panti/pages/wisatawan/cek_tiket.php"; 
            $pesan_wa = "✨ *YEAY! TIKETMU SUDAH SIAP* ✨\n\n";
            $pesan_wa .= "Halo, *" . $nama . "*! Terima kasih sudah mampir ke SI-TANCAK PANTI. Tiketmu sudah berhasil kami amankan, nih! 🎫🌿\n\n";
            $pesan_wa .= "━━━━━━━━━━━━━━\n";
            $pesan_wa .= "📌 *DETAIL PESANAN:*\n";
            $pesan_wa .= "━━━━━━━━━━━━━━\n";
            $pesan_wa .= "🏷️ *KODE:* `" . $kode_tiket . "`\n";
            $pesan_wa .= "👤 *NAMA:* " . $nama . "\n";
            $pesan_wa .= "👥 *JUMLAH:* " . $orang . " Orang\n";
            $pesan_wa .= "📍 *ALAMAT:* " . $alamat . "\n";
            $pesan_wa .= "━━━━━━━━━━━━━━\n\n";
            $pesan_wa .= "👇 *CEK E-TIKET:* \n";
            $pesan_wa .= "🔗 " . $link_cek . "\n\n";
            $pesan_wa .= "Sampai jumpa di Air Terjun Tancak! Jangan lupa bawa pulang sampahmu dan jaga alam kita, ya! 🙌💚";
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('target' => $telepon_1, 'message' => $pesan_wa, 'countryCode' => '62'),
            CURLOPT_HTTPHEADER => array('Authorization: ' . TOKEN_FONNTE),
        ));
        curl_exec($curl);
        curl_close($curl);

        $_SESSION['beli_sukses_trigger'] = true;
        header("Location: tiket.php");
        exit;
    }
}

// 3. LOGIKA TAMPILKAN TIKET
if (isset($_SESSION['beli_sukses_trigger'])) {
    $show_ticket = true;
    
    // Ambil data terbaru dari database
    $q_ambil = mysqli_query($koneksi, "SELECT * FROM tiket ORDER BY id_tiket DESC LIMIT 1");
    $data_tiket = mysqli_fetch_assoc($q_ambil);
    
    if ($data_tiket) {
        $id_tk = $data_tiket['id_tiket'];
        $data_tiket['jumlah_orang'] = $data_tiket['orang'];
        
        // --- TAMBAHKAN BARIS INI BIAR TIDAK ERROR ---
        // Kita set default denda 0 kalau memang di database belum ada kolom denda
        if (!isset($data_tiket['denda'])) {
            $data_tiket['denda'] = 0; 
        }

        $q_sampah = mysqli_query($koneksi, "SELECT * FROM sampah WHERE id_tiket = $id_tk");
        while($row = mysqli_fetch_assoc($q_sampah)) {
            $row['nama_item'] = $row['nama_sampah']; 
            $data_sampah[] = $row;
            $total_item_sampah += $row['jumlah'];
        }
    }
    unset($_SESSION['beli_sukses_trigger']);
    echo "<script>sessionStorage.setItem('beli_sukses', 'true');</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beli Tiket - SI-TANCAK PANTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/navbar.css">
    <style>
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] { -moz-appearance: textfield; }
</style>
</head>
<body class="bg-[#eff3f0] font-[Poppins] flex flex-col min-h-screen">

    <?php include '../components/navbar.php'; ?>
    </nav> 

    <?php
        $notif_file = 'config/status_darurat.json'; 
        $darurat_aktif = false;
        $pesan_darurat = '';
        
        if (file_exists($notif_file)) {
            $data_json = json_decode(file_get_contents($notif_file), true);
            if (isset($data_json['aktif']) && $data_json['aktif'] === true) {
                $darurat_aktif = true;
                $pesan_darurat = $data_json['pesan'];
            }
        }
    ?>

    <?php if ($darurat_aktif): ?>
    <div class="bg-[#ef4444] text-white w-full px-6 py-3 shadow-md z-40 relative">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row items-center justify-center gap-3 text-center md:text-left">
            <div class="flex items-center gap-2 font-extrabold text-[13px] md:text-[14px] tracking-wide shrink-0">
                <span class="w-3 h-3 rounded-full bg-red-200 animate-pulse"></span>
                ⚠️ PERINGATAN DARURAT: 
            </div>
            <div class="text-[13px] md:text-[13.5px] font-medium leading-snug">
                <?= htmlspecialchars($pesan_darurat); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <main class="flex-1 pt-24 pb-16 px-4">
        <div id="tiket-card" class="max-w-[620px] mx-auto bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="relative flex border-b border-gray-100 bg-white">
                <div id="main-tab-indicator" class="absolute top-0 bottom-0 left-0 w-1/2 bg-[#1a3326] transition-transform duration-[350ms] ease-in-out transform translate-x-0"></div>

                <a href="tiket.php" class="flex-1 py-4 flex justify-center items-center gap-2 font-bold text-[14px] relative z-10 text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Pembelian Tiket
                </a>
                
                <a href="cek_tiket.php" id="link-to-cek" class="flex-1 py-4 flex justify-center items-center gap-2 font-semibold text-[14px] relative z-10 text-gray-500 hover:text-[#1a3326] transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Cek Tiket
                </a>
            </div>

            <?php if($show_ticket && $data_tiket): ?>
                
                <div class="p-8 lg:p-10 bg-[#f8faf9]">
                    <div class="flex justify-center mb-5">
                        <div class="w-[60px] h-[60px] bg-[#d1fae5] rounded-full flex items-center justify-center text-[#10b981] shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <h2 class="text-[20px] font-extrabold text-[#1a3326] text-center mb-8">Tiket Berhasil Dipesan!</h2>

                    <div class="border-[2px] border-[#1a3326] rounded-[16px] overflow-hidden bg-white mx-auto max-w-[500px]">
                        <div class="bg-[#1a3326] p-5 text-white flex justify-between items-center relative">
                            <div>
                                <p class="text-[11px] text-gray-300 font-medium mb-0.5">Air Terjun Tancak Panti</p>
                                <h3 class="text-[16px] font-extrabold tracking-wide uppercase">E-TIKET MASUK</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] text-gray-300 font-medium mb-0.5">ID Tiket</p>
                                <h3 class="text-[19px] font-extrabold text-[#a7f3d0] tracking-wider"><?= $data_tiket['kode_tiket'] ?></h3>
                            </div>
                            <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-white rounded-full"></div>
                            <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-white rounded-full"></div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-8">
                                <div>
                                    <p class="text-[11px] text-gray-400 font-medium mb-0.5">Nama</p>
                                    <p class="text-[14px] font-bold text-[#1a3326]"><?= $data_tiket['nama'] ?></p>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-400 font-medium mb-0.5">Jumlah Orang</p>
                                    <p class="text-[14px] font-bold text-[#1a3326]"><?= $data_tiket['jumlah_orang'] ?> orang</p>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-400 font-medium mb-0.5">Alamat</p>
                                    <p class="text-[14px] font-bold text-[#1a3326]"><?= $data_tiket['alamat'] ?></p>
                                </div>
                                <div>
                                    <p class="text-[11px] text-gray-400 font-medium mb-0.5">Total Bayar</p>
                                    <p class="text-[14px] font-extrabold text-[#1a3326]">Rp <?= number_format($data_tiket['jumlah_orang'] * 6500, 0, ',', '.') ?></p>
                                </div>
                            </div>

                            <!-- PERBAIKAN PEMANGGILAN GAMBAR DARI IMGBB -->
                           <div class="mb-8">
                            <p class="text-[12px] text-gray-400 font-medium mb-2 uppercase">Bukti Pembayaran</p>
                            <div class="border border-gray-200 rounded-[12px] p-2 bg-gray-50 flex justify-center w-full">
                                <?php if(!empty($data_tiket['bukti_transfer']) && strpos($data_tiket['bukti_transfer'], 'http') === 0): 
                                    // Pakai Proxy biar gambar ImgBB lancar dibuka di mana saja
                                    $link_bersih = str_replace('https://', '', $data_tiket['bukti_transfer']);
                                    $link_proxy = 'https://wsrv.nl/?url=' . $link_bersih;
                                ?>
                                    <img src="<?= htmlspecialchars($link_proxy) ?>" class="w-full max-h-[200px] object-contain rounded-lg shadow-sm">
                                <?php else: ?>
                                    <span class="text-xs text-red-500 font-bold p-4">Gambar gagal dimuat. Cek apakah link ImgBB benar.</span>
                                <?php endif; ?>
                            </div>
                        </div>

                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-[12px] font-bold text-[#1a3326] uppercase">LIST SAMPAH BAWAAN</p>
                                    <span class="text-[11px] text-gray-400 flex items-center gap-1 font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Terkunci
                                    </span>
                                </div>
                                <div class="border border-gray-200 rounded-[12px] overflow-hidden shadow-sm">
                                    <?php if($total_item_sampah > 0): ?>
                                        <?php foreach($data_sampah as $s): ?>
                                        <div class="flex justify-between px-5 py-3.5 border-b border-gray-100 text-[13px] bg-white">
                                            <span class="text-gray-600 font-medium"><?= $s['nama_item'] ?></span>
                                            <span class="font-bold text-gray-800"><?= $s['jumlah'] ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                        <div class="bg-[#f8faf9] px-5 py-3 flex justify-between text-[12px] font-bold text-[#1a3326]">
                                            <span>Total item</span>
                                            <span><?= $total_item_sampah ?> item</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="px-5 py-6 text-center text-[12.5px] text-gray-400 font-medium bg-[#f8faf9]">
                                            Tidak ada sampah yang dicatat
                                        </div>
                                        <div class="bg-white px-5 py-3 flex justify-between text-[12px] font-bold text-[#1a3326] border-t border-gray-100">
                                            <span>Total item</span>
                                            <span>0 item</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <p class="text-[12px] font-bold text-[#1a3326] uppercase mb-2">Informasi Denda</p>
                                    <?php if($data_tiket['denda'] > 0): ?>
                                        <div class="border border-red-100 rounded-[12px] px-5 py-4 bg-red-50 flex justify-between items-center text-[13px] shadow-sm">
                                            <span class="text-red-700 font-medium">Tagihan Denda Kehilangan:</span>
                                            <span class="font-extrabold text-red-600 text-[15px]">Rp <?= number_format($data_tiket['denda'], 0, ',', '.') ?></span>
                                        </div>
                                    <?php else: ?>
                                    <div class="border border-gray-200 rounded-[12px] px-5 py-4 bg-white flex justify-between items-center text-[13px] shadow-sm">
                                        <span class="text-gray-600 font-medium">Tagihan Denda:</span>
                                        <span class="font-bold text-green-500 flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            Tidak ada denda
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            
            <?php else: ?>

            <div class="p-8 lg:p-10">
                <h2 class="text-[22px] font-bold text-[#1a3326] text-center mb-10 tracking-tight">Pembelian Tiket Air Terjun Tancak Panti</h2>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="space-y-5 mb-10">
                        <div class="grid grid-cols-3 items-center gap-4">
                            <label class="font-bold text-[#1a3326] text-[14px]">Nama <span class="text-red-500 font-bold">*</span></label>
                            <input type="text" name="nama" required placeholder="Nama Panggilan" class="col-span-2 bg-[#f8faf9] border border-gray-200 rounded-[12px] px-4 py-3 text-[14px] outline-none focus:border-[#2d6a4f] transition-all">
                        </div>
                        <div class="grid grid-cols-3 items-center gap-4">
                            <label class="font-bold text-[#1a3326] text-[14px]">Email <span class="text-red-500 font-bold">*</span></label>
                            <input type="email" name="email" required placeholder="Email Aktif" class="col-span-2 bg-[#f8faf9] border border-gray-200 rounded-[12px] px-4 py-3 text-[14px] outline-none focus:border-[#2d6a4f] transition-all">
                        </div>
                        <div class="grid grid-cols-3 items-center gap-4">
                            <label class="font-bold text-[#1a3326] text-[14px]">Alamat <span class="text-red-500 font-bold">*</span></label>
                            <input type="text" name="alamat" required placeholder="Kecamatan / Desa" class="col-span-2 bg-[#f8faf9] border border-gray-200 rounded-[12px] px-4 py-3 text-[14px] outline-none focus:border-[#2d6a4f] transition-all">
                        </div>
                        <div class="grid grid-cols-3 items-start gap-4">
                            <label class="font-bold text-[#1a3326] text-[14px] mt-3">Orang <span class="text-red-500 font-bold">*</span></label>
                            <div class="col-span-2">
                                <input type="number" id="input-orang" name="jumlah_orang" min="1" required placeholder="Berapa Orang" class="w-full bg-[#f8faf9] border border-gray-200 rounded-[12px] px-4 py-3 text-[14px] outline-none focus:border-[#2d6a4f]">
                                <div class="flex justify-between items-center mt-2 px-1">
                                    <span class="text-[11px] text-gray-400">Rp 6.500 / orang</span>
                                    <span id="teks-total" class="text-[13px] font-bold text-[#006A6A]">Total: Rp 0</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-start gap-4">
                            <label class="font-bold text-[#1a3326] text-[14px] mt-3">No. Telepon <span class="text-red-500 font-bold">*</span></label>
                            <div class="col-span-2 relative">
                                <input type="text" id="input-telp1" name="no_telp" required placeholder="No. WA Aktif (min. 11 digit)" class="w-full bg-[#f8faf9] border border-gray-200 rounded-[12px] px-4 py-3 text-[14px] outline-none pr-14 transition-all">
                                <span id="counter-telp1" class="absolute right-4 top-4 text-[11px] text-gray-400 font-bold transition-colors">0/11</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 items-start gap-4">
                            <label class="font-bold text-[#1a3326] text-[14px] mt-3">No. Darurat <span class="text-red-500 font-bold">*</span>  </label>
                            <div class="col-span-2 relative">
                                <input type="text" id="input-telp2" name="no_darurat" required placeholder="No. Orang Terdekat" class="w-full bg-[#f8faf9] border border-gray-200 rounded-[12px] px-4 py-3 text-[14px] outline-none pr-14 transition-all">
                                <span id="counter-telp2" class="absolute right-4 top-4 text-[11px] text-gray-400 font-bold transition-colors">0/11</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-1.5 h-6 bg-[#1a3326] rounded-full"></div>
                            <h3 class="font-bold text-[#1a3326] text-[16px]">Bukti Pembayaran</h3>
                        </div>
                        <p class="text-[12.5px] text-gray-500 mb-4 ml-3.5">Transfer ke salah satu rekening berikut:</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ml-3.5 mb-6">
                        <div class="bg-[#0B5ED7] rounded-[24px] p-5 text-white shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[100px]">
                            <div>
                                <div class="flex justify-between items-center mb-4 relative z-10">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M2 10h20v2H2v-2zm1 3h18v2H3v-2zm1 3h16v2H4v-2z"/></svg>
                                        <span class="font-bold text-[14px] tracking-widest uppercase">BRI</span>
                                    </div>
                                    <button type="button" class="btn-copy text-white/50 hover:text-white transition" data-rek="025701123456504">
                                        <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                                <div class="text-[13px] font-bold tracking-[0.1em] mb-1.5 relative z-10">0257-01-123456-50-4</div>
                            </div>
                            <div class="text-[11px] text-white/80 font-medium relative z-10 mt-auto">a.n. Pengelola Wisata Tancak</div>
                            <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-white/10 rounded-full blur-2xl"></div>
                        </div>

                        <div class="bg-[#002D8B] rounded-[24px] p-5 text-white shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[100px]">
                            <div>
                                <div class="flex justify-between items-center mb-4 relative z-10">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7v10l10 5 10-5V7L12 2z"/></svg>
                                        <span class="font-bold text-[14px] tracking-widest uppercase">BCA</span>
                                    </div>
                                    <button type="button" class="btn-copy text-white/50 hover:text-white transition" data-rek="1234567890">
                                        <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                                <div class="text-[13px] font-bold tracking-[0.1em] mb-1.5 relative z-10">1234567890</div>
                            </div>
                            <div class="text-[11px] text-white/80 font-medium relative z-10 mt-auto">a.n. Pengelola Wisata Tancak</div>
                            <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-white/10 rounded-full blur-2xl"></div>
                        </div>
                    </div>
                        </div>

                        <div class="mt-4 ml-3.5">
                            <p class="text-[12.5px] text-gray-500 mb-3">Upload foto bukti transfer: <span class="text-red-500 font-bold">*</span></p>
                            <label for="bukti-input" class="group relative w-full min-h-[144px] border-2 border-dashed border-gray-200 hover:border-[#2d6a4f] rounded-[24px] flex flex-col items-center justify-center cursor-pointer bg-[#f8faf9] transition-all overflow-hidden block p-4">
                                <div id="upload-placeholder" class="flex flex-col items-center justify-center pointer-events-none text-center transition-opacity">
                                    <svg class="w-10 h-10 mb-3 text-gray-300 group-hover:text-[#2d6a4f] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span class="text-gray-500 text-[13px] font-bold">Klik untuk upload foto bukti transfer</span>
                                    <span class="text-gray-400 text-[11px] mt-1 uppercase">JPG, PNG, HEIC</span>
                                </div>
                                <img id="upload-preview" class="hidden absolute inset-0 w-full h-full object-contain bg-gray-50 z-10">
                            </label>
                            <input type="file" class="hidden" name="bukti_transfer" id="bukti-input" accept="image/*" required>
                        </div>
                    </div>

                    <div class="mb-10">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-2 ml-9">
                                <div class="w-1.5 h-6 bg-[#1a3326] rounded-full"></div>
                                <h3 class="font-bold text-[#1a3326] text-[16px]">List Sampah Bawaan</h3>
                            </div>
                        </div>

                        <div class="px-2 md:px-3">
                            <div class="border border-gray-200 rounded-[16px] overflow-hidden bg-white shadow-sm">
                                <div class="bg-[#f4f9f6] py-3.5 px-6 flex justify-between items-center border-b border-gray-200">
                                    <span class="text-[13px] font-semibold text-[#8b9e94]">Nama Item</span>
                                    <span class="text-[13px] font-semibold text-[#8b9e94] pr-[54px]">Jumlah</span>
                                </div>
                                
                                <div id="sampah-list-container">
                                    <?php $items = ['Botol Plastik', 'Bungkus Makanan', 'Cup Plastik / Cup Mie', 'Kantong Plastik', 'Tisu'];
                                    foreach($items as $it): ?>
                                    <div class="sampah-item flex justify-between items-center py-3.5 px-6 border-b border-gray-100 last:border-b-0 bg-white">
                                        <span class="text-[14px] font-medium text-black item-name"><?= $it ?></span>
                                        <div class="flex items-center gap-2">
                                            <input type="hidden" name="nama_sampah[]" value="<?= $it ?>">
                                            <button type="button" class="btn-minus w-7 h-7 rounded-full bg-[#f1f5f9] flex items-center justify-center font-bold text-gray-500 hover:bg-gray-200 transition-colors">-</button>
                                            <input type="number" name="jumlah_sampah[]" value="0" min="0" class="qty-input w-8 text-center text-[14px] font-bold text-black outline-none bg-transparent">
                                            <button type="button" class="btn-plus w-7 h-7 rounded-full bg-[#f1f5f9] flex items-center justify-center font-bold text-gray-500 hover:bg-gray-200 transition-colors">+</button>
                                            <button type="button" class="m-del text-gray-300 hover:text-red-500 transition-colors ml-2 cursor-pointer">
                                                <svg class="w-[18px] h-[18px] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="p-9 border-t border-dashed border-gray-300 flex gap-3 bg-white">
                                    <input type="text" id="input-sampah-baru" placeholder="+ Tambah item sampah lainnya..." class="flex-1 border border-gray-200 rounded-lg px-4 py-2.5 text-[13px] text-black outline-none focus:border-[#2d6a4f] transition-colors">
                                    <button type="button" id="btn-tambah-sampah" class="bg-[#1a3326] text-white px-6 rounded-lg text-[13px] font-bold hover:bg-[#12241b] transition-colors">Tambah</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 ml-4 flex items-center gap-2 text-[13.5px] font-bold text-[#1a3326]">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <span id="sampah-summary">0 jenis 0 item total</span>
                        </div>
                    </div>

                    <div class="bg-[#FFFBEB] border border-[#FDE68A] rounded-[16px] p-5 flex gap-3 mb-4 -mt-2 items-start shadow-sm mx-1">
                        <svg class="w-5 h-5 text-[#D97706] shrink-0 mt-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p class="text-[12px] text-[#92400E] leading-relaxed">
                            List sampah ini tercatat di tiket Anda. Pastikan seluruh sampah dibawa pulang. Denda <strong class="font-extrabold text-[#D97706]">Rp 10.000</strong> per item yang hilang.
                        </p>
                    </div>

                    <button type="submit" name="submit_tiket" class="w-full bg-[#1b3d2f] text-white font-semibold text-[15px] py-4 rounded-[12px] flex items-center justify-center gap-2 hover:bg-[#122b21] transition-all shadow-sm active:scale-[0.98]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Beli Tiket
                    </button>
                </form>
            </div>
            
            <?php endif; ?>

        </div>
    </main>

    <script src="../js/tiket.js"></script>
<!-- MODAL CUSTOM SUKSES BELI TIKET -->
    <div id="modal-sukses-beli" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 hidden backdrop-blur-sm transition-all duration-300">
        <div class="bg-white rounded-[24px] p-8 max-w-[380px] w-full text-center shadow-2xl transform scale-95 transition-transform duration-300" id="modal-card">
            <!-- Ikon Centang Animasi -->
            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-5 border-[4px] border-green-100">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h2 class="text-[22px] font-extrabold text-[#1a3326] mb-2 tracking-tight">Pemesanan Berhasil!</h2>
            <p class="text-[13.5px] text-gray-500 mb-8 leading-relaxed">
                Tiket wisata Anda sedang diproses. Detail pesanan beserta link E-Tiket telah <strong>dikirimkan ke WhatsApp Anda</strong>.
            </p>
            
            <div class="flex flex-col gap-3">
                <a href="cek_tiket.php" class="w-full bg-[#1a3326] hover:bg-[#12241b] text-white py-3.5 rounded-[14px] text-[14px] font-bold shadow-md transition-all flex items-center justify-center gap-2">
                    Cek E-Tiket Sekarang
                </a>
                <button onclick="tutupModalSukses()" class="w-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 py-3.5 rounded-[14px] text-[14px] font-bold transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

  <script>
        // Preview File Bukti
        const buktiInput = document.getElementById('bukti-input');
        if(buktiInput) {
            buktiInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('upload-preview').src = e.target.result;
                        document.getElementById('upload-preview').classList.remove('hidden');
                        document.getElementById('upload-placeholder').classList.add('hidden');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Counter Nomor Telepon (Fitur Asli)
        function setupTelp(idInput, idCounter) {
            const input = document.getElementById(idInput);
            const counter = document.getElementById(idCounter);
            if(input && counter) {
                input.addEventListener('input', () => {
                    counter.innerText = `${input.value.length}/11`;
                    counter.style.color = input.value.length >= 11 ? '#10b981' : '#9ca3af';
                });
            }
        }
        setupTelp('input-telp1', 'counter-telp1');
        setupTelp('input-telp2', 'counter-telp2');

        // Loading Animasi Tombol (Fitur Asli)
        const form = document.getElementById('form-beli-tiket');
        if(form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('btn-submit-tiket');
                btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;
                btn.classList.add('opacity-80', 'cursor-not-allowed');
                btn.style.pointerEvents = 'none';
            });
        }

        // Trigger Modal Sukses
        if(sessionStorage.getItem('beli_sukses')) {
            const modal = document.getElementById('modal-sukses-beli');
            const card = document.getElementById('modal-card');
            modal.classList.remove('hidden');
            setTimeout(() => card.classList.remove('scale-95'), 10);
            sessionStorage.removeItem('beli_sukses');
        }

        function tutupModalSukses() {
            document.getElementById('modal-sukses-beli').classList.add('hidden');
        }

        // Kalkulasi Total Harga (Realtime)
        const inpOrang = document.getElementById('input-orang');
        if(inpOrang) {
            inpOrang.addEventListener('input', (e) => {
                const total = e.target.value * 6500;
                document.getElementById('teks-total').innerText = `Total: Rp ${total.toLocaleString('id-ID')}`;
            });
        }
    </script>

</body>
</html>