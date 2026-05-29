<?php

include 'config/koneksi.php';



$tiket_found = false;

$data_tiket = null;

$data_sampah = [];

$total_item_sampah = 0;

$error_msg = "";



    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cari_tiket'])) {

    $mode = $_POST['search_mode'];



    if ($mode == 'wa_id') {

        $kunci = mysqli_real_escape_string($koneksi, trim($_POST['kunci_utama']));

        // KUNCI HARI INI: Tambahkan tanda kurung () pada OR, lalu hubungkan dengan AND tanggal_kunjungan = CURDATE()

        $q_tiket = mysqli_query($koneksi, "SELECT * FROM tiket WHERE (telepon_1 = '$kunci' OR kode_tiket = '$kunci') AND tanggal_kunjungan = CURDATE() ORDER BY id_tiket DESC LIMIT 1");

    } else if ($mode == 'nama_alamat') {

        $nama = mysqli_real_escape_string($koneksi, trim($_POST['nama_wisatawan']));

        $alamat = mysqli_real_escape_string($koneksi, trim($_POST['alamat_wisatawan']));

        // KUNCI HARI INI: Tambahkan AND tanggal_kunjungan = CURDATE()

        $q_tiket = mysqli_query($koneksi, "SELECT * FROM tiket WHERE nama LIKE '%$nama%' AND alamat LIKE '%$alamat%' AND tanggal_kunjungan = CURDATE() ORDER BY id_tiket DESC LIMIT 1");

    }



    if (isset($q_tiket) && mysqli_num_rows($q_tiket) > 0) {

        $tiket_found = true;

        $data_tiket = mysqli_fetch_assoc($q_tiket);

        $id_tk = $data_tiket['id_tiket'];



        // --- SUNTIKAN FRONTEND BIAR HTML AMAN ---

        $data_tiket['no_telp'] = $data_tiket['telepon_1'];

        $data_tiket['jumlah_orang'] = $data_tiket['orang'];



        // FITUR BARU: AMBIL DATA ANGGOTA DARI TABEL `anggota`

        $q_anggota = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_tiket = $id_tk");

        $data_anggota = [];

        while($ang = mysqli_fetch_assoc($q_anggota)){

            $data_anggota[] = $ang['nama_anggota'];

        }

        $data_tiket['data_anggota'] = $data_anggota;



        // MATCH DB ERD: Ambil denda dari tabel 'denda'

        $q_denda = mysqli_query($koneksi, "SELECT SUM(total_denda) AS denda_total FROM denda WHERE id_tiket = $id_tk");

        $res_denda = mysqli_fetch_assoc($q_denda);

        $data_tiket['denda'] = $res_denda['denda_total'] ?? 0;



        // MATCH DB ERD: tb_sampah_bawaan -> sampah

        $q_sampah = mysqli_query($koneksi, "SELECT * FROM sampah WHERE id_tiket = $id_tk");

        while($row = mysqli_fetch_assoc($q_sampah)) {

            $row['nama_item'] = $row['nama_sampah']; // Suntikan frontend

            $data_sampah[] = $row;

            $total_item_sampah += $row['jumlah'];

        }

    } else {

        $error_msg = "Waduh, data tiket tidak ditemukan Cak! Coba periksa lagi ketikanmu atau gunakan mode pencarian lain.";

    }

}

?>



<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    
    <title>Beli Tiket - SI-TANCAK PANTI</title>
    <link href="/style/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style/navbar.css">
    <link rel="stylesheet" href="/style/tiket.css"> 
</head>

<body class="bg-[#eff3f0] font-[Poppins] flex flex-col min-h-screen">



    <?php include 'components/navbar.php'; ?>

    </nav> 



    <?php

        // Cek Status Darurat

        // Banner sekarang di-handle oleh navbar.php

    ?>



    <!-- Banner notif darurat sudah di-handle oleh navbar.php -->

    <main class="flex-1 pb-16 px-4" style="padding-top: var(--header-height);">

        <div id="tiket-card" class="max-w-[620px] mx-auto bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">

            

            <div class="relative flex border-b border-gray-100 bg-white">

                <div id="main-tab-indicator" class="absolute top-0 bottom-0 left-0 w-1/2 bg-[#1a3326] transition-transform duration-[350ms] ease-in-out transform translate-x-full"></div>



                <a href="/tiket" id="link-to-beli" class="flex-1 py-4 flex justify-center items-center gap-2 font-semibold text-[14px] relative z-10 text-gray-500 hover:text-[#1a3326] transition-colors duration-300">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>

                    Pembelian Tiket

                </a>

                

                <a href="/cek_tiket" class="flex-1 py-4 flex justify-center items-center gap-2 font-bold text-[14px] relative z-10 text-white transition-colors duration-300">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>

                    Cek Tiket

                </a>

            </div>



            <?php if(!$tiket_found): ?>

            <div class="p-8 lg:p-10">

                <div class="text-center mb-6">

                    <h2 class="text-[22px] font-bold text-[#1a3326] tracking-tight mb-2">Cari Tiket Anda</h2>

                    <p class="text-[13px] text-gray-500 leading-relaxed px-4">Pilih metode pencarian di bawah ini untuk menemukan tiket wisata Anda.</p>

                </div>



                <div class="flex bg-[#f1f5f9] p-1.5 rounded-[14px] mb-8 max-w-[400px] mx-auto relative z-10">

                    <div id="slide-indicator" class="absolute top-1.5 bottom-1.5 left-1.5 w-[calc(50%-6px)] bg-white rounded-[10px] shadow-sm transition-transform duration-300 ease-out transform translate-x-0 pointer-events-none"></div>



                    <button type="button" id="btn-mode-wa" class="flex-1 py-2.5 text-[13px] font-bold text-[#1a3326] relative z-10 transition-colors duration-300">No. WA / ID</button>

                    <button type="button" id="btn-mode-nama" class="flex-1 py-2.5 text-[13px] font-bold text-gray-400 hover:text-gray-600 relative z-10 transition-colors duration-300">Nama & Alamat</button>

                </div>



                <?php if($error_msg): ?>

                <div class="bg-red-50 border border-red-100 text-red-600 text-[12.5px] p-4 rounded-[12px] text-center mb-6 font-medium flex items-center justify-center gap-2 error-shake">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>

                    <?= $error_msg; ?>

                </div>

                <?php endif; ?>



                <form action="" method="POST" id="form-cari">

                    <input type="hidden" name="search_mode" id="search_mode" value="wa_id">



                    <div id="form-wa-id" class="mb-8 block reveal-up">

                        <label class="block font-bold text-[#1a3326] text-[13px] mb-2 ml-1">Kunci Tiket <span class="text-red-500">*</span></label>

                        <input type="text" name="kunci_utama" id="input-kunci" required placeholder="Masukkan No. WA atau ID Tiket" class="w-full bg-[#f8faf9] border border-gray-200 rounded-[16px] px-5 py-4 text-[14px] text-[#1a3326] outline-none focus:border-[#2d6a4f] transition-all shadow-sm">

                    </div>



                    <div id="form-nama-alamat" class="mb-8 hidden space-y-4">

                        <div>

                            <label class="block font-bold text-[#1a3326] text-[13px] mb-2 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>

                            <input type="text" name="nama_wisatawan" id="input-nama" placeholder="Nama saat pemesanan" class="w-full bg-[#f8faf9] border border-gray-200 rounded-[16px] px-5 py-3.5 text-[14px] text-[#1a3326] outline-none focus:border-[#2d6a4f] transition-all shadow-sm">

                        </div>

                        <div>

                            <label class="block font-bold text-[#1a3326] text-[13px] mb-2 ml-1">Alamat / Desa <span class="text-red-500">*</span></label>

                            <input type="text" name="alamat_wisatawan" id="input-alamat" placeholder="Alamat saat pemesanan" class="w-full bg-[#f8faf9] border border-gray-200 rounded-[16px] px-5 py-3.5 text-[14px] text-[#1a3326] outline-none focus:border-[#2d6a4f] transition-all shadow-sm">

                        </div>

                    </div>



                    <button type="submit" name="cari_tiket" class="w-full bg-[#1b3d2f] text-white font-semibold text-[15px] py-4 rounded-[12px] flex items-center justify-center gap-2 hover:bg-[#122b21] transition-all shadow-sm active:scale-[0.98]">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>

                        Temukan Tiket

                    </button>

                </form>

            </div>



            <?php else: ?>



            <div class="p-8 lg:p-10 bg-[#f8faf9]">

                <div class="flex justify-center mb-5">

                    <div class="w-[60px] h-[60px] bg-[#1a3326] rounded-full flex items-center justify-center text-white shadow-sm">

                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>

                    </div>

                </div>

                <h2 class="text-[20px] font-extrabold text-[#1a3326] text-center mb-8">Tiket Ditemukan!</h2>



                <div class="border-[2px] border-[#1a3326] rounded-[16px] overflow-hidden bg-white mx-auto max-w-[500px] mb-8">

                    <div class="bg-[#1a3326] p-5 text-white flex justify-between items-center relative">

                        <div>

                            <p class="text-[11px] text-gray-300 font-medium mb-0.5">Air Terjun Tancak Panti</p>

                            <h3 class="text-[16px] font-extrabold tracking-wide uppercase">E-TIKET MASUK</h3>

                        </div>

                        <div class="text-right">

                            <p class="text-[11px] text-gray-300 font-medium mb-0.5">ID Tiket</p>

                            <h3 class="text-[19px] font-extrabold text-[#a7f3d0] tracking-wider"><?= $data_tiket['kode_tiket'] ?></h3>

                        </div>

                        <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-[#f8faf9] rounded-full"></div>

                        <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-[#f8faf9] rounded-full"></div>

                    </div>



                    <div class="p-6">

                        <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-6">

                            <div>

                                <p class="text-[11px] text-gray-400 font-medium mb-0.5">Kepala Rombongan</p>

                                <p class="text-[14px] font-bold text-[#1a3326] capitalize"><?= $data_tiket['nama'] ?></p>

                            </div>

                            <div>

                                <p class="text-[11px] text-gray-400 font-medium mb-0.5">Jumlah Orang</p>

                                <p class="text-[14px] font-bold text-[#1a3326]"><?= $data_tiket['jumlah_orang'] ?> orang</p>

                            </div>

                            <div>

                                <p class="text-[11px] text-gray-400 font-medium mb-0.5">Alamat</p>

                                <p class="text-[14px] font-bold text-[#1a3326] capitalize"><?= $data_tiket['alamat'] ?></p>

                            </div>

                            <div>

                                <p class="text-[11px] text-gray-400 font-medium mb-0.5">Total Bayar</p>

                                <p class="text-[14px] font-extrabold text-[#1a3326]">Rp <?= number_format($data_tiket['jumlah_orang'] * 10000, 0, ',', '.') ?></p>

                            </div>

                        </div>



                        <div class="mb-8">

                            <p class="text-[12px] font-bold text-[#1a3326] uppercase mb-2">Daftar Rombongan (<?= $data_tiket['jumlah_orang'] ?> Orang)</p>

                            <div class="bg-gray-50 border border-gray-200 rounded-[12px] p-3 text-[13.5px] text-[#1a3326]">

                                <div class="font-bold mb-1 border-b border-gray-200 pb-1">1. <?= $data_tiket['nama'] ?> <span class="text-gray-400 text-[11px] font-normal">(Kepala Rombongan)</span></div>

                                <?php 

                                if(!empty($data_tiket['data_anggota'])) {

                                    $no = 2;
                                    foreach($data_tiket['data_anggota'] as $ang): ?>

                                        <div class="ml-1 mb-1 font-medium"><?= $no++ ?>. <?= htmlspecialchars(ucwords($ang)) ?></div>

                                    <?php endforeach; 

                                } ?>

                            </div>

                        </div>

                        

                        <div class="mb-8">

                            <p class="text-[12px] text-gray-400 font-medium mb-2">Bukti Pembayaran</p>

                            <div class="border border-gray-200 rounded-[12px] p-2 bg-gray-50 flex justify-center w-full">

                                <?php if(!empty($data_tiket['bukti_transfer']) && strpos($data_tiket['bukti_transfer'], 'http') === 0): 

                                    $link_bersih = str_replace('https://', '', $data_tiket['bukti_transfer']);

                                    $link_proxy = 'https://wsrv.nl/?url=' . $link_bersih;

                                ?>

                                    <img src="<?= htmlspecialchars($link_proxy) ?>" class="w-full max-h-[200px] object-contain rounded-lg shadow-sm">

                                <?php else: ?>

                                    <span class="text-xs text-red-500 font-bold p-4">Gambar gagal dimuat atau belum tersedia.</span>

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

            <?php endif; ?>



        </div>

    </main>



    <script src="/js/cek_tiket.js"></script>

</body>

</html>