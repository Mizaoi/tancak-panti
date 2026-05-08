<?php
include 'config/koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_ulasan'])) {
    
    // FITUR ANTI-SPAM / ANTI-LAG (COOLDOWN 10 DETIK)
    if (isset($_SESSION['last_submit']) && (time() - $_SESSION['last_submit'] < 10)) {
        header("Location: /tancak-panti/rating"); 
        exit;
    }
    $_SESSION['last_submit'] = time(); 

    $nama   = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $rating = (int)$_POST['rating'];
    $isi    = trim(mysqli_real_escape_string($koneksi, $_POST['isi']));
    
    $link_gambar = ""; 

    // Tembak ke ImgBB dengan label 'ULASAN'
    if (isset($_FILES['foto_ulasan']) && $_FILES['foto_ulasan']['error'] === 0) {
        $file_tmp  = $_FILES['foto_ulasan']['tmp_name'];
        $link_gambar = uploadKeImgBB($file_tmp, 'ULASAN');
    }

    $query_insert = "INSERT INTO ulasan (nama, rating, teks, gambar) VALUES ('$nama', '$rating', '$isi', '$link_gambar')";
    mysqli_query($koneksi, $query_insert);
    
    $_SESSION['alert'] = ['type' => 'success', 'msg' => 'Ulasanmu terkirim! 🎉 Menunggu persetujuan admin ⏳'];
    header("Location: rating");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan - SI-TANCAK PANTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/rating.css"> 
    <style>body { font-family: 'Poppins', sans-serif; background-color: #eff3f0; overflow-x: hidden; }</style>
</head>
<body class="flex flex-col min-h-screen relative">

    <?php include 'components/navbar.php'; ?>
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

    <?php if(isset($_SESSION['alert'])): ?>
        <div id="custom-alert" class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-full shadow-lg text-white text-[14px] font-semibold transition-all duration-500 <?php echo ($_SESSION['alert']['type'] == 'success') ? 'bg-[#2d6a4f]' : 'bg-red-500'; ?>">
            <?php echo $_SESSION['alert']['msg']; ?>
        </div>
        <script>
            setTimeout(() => {
                const alertBox = document.getElementById('custom-alert');
                if(alertBox) {
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translate(-50%, -20px)';
                    setTimeout(() => alertBox.remove(), 500);
                }
            }, 3000);
        </script>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <main class="flex-1 pt-[30px] pb-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-5 bg-white p-8 rounded-2xl shadow-sm border border-gray-100 animate-pop-in">
                    <h2 class="text-[#1a3326] text-[20px] font-bold mb-1">Tulis Ulasan Anda</h2>
                    <p class="text-gray-400 text-[13px] mb-6">Ulasan Anda akan membantu pengunjung lainnya.</p>

                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-4">
                            <input type="text" name="nama" required placeholder="Nama Anda" class="w-full bg-[#f8faf9] border border-gray-100 rounded-[12px] px-4 py-3.5 text-[14px] text-gray-700 outline-none focus:border-[#2d6a4f] transition-colors">
                        </div>

                            <div class="mb-4">
                                <p class="text-gray-500 text-[13px] mb-2">Rating Anda</p>
                                <!-- Hidden input untuk nyimpen nilai ke database -->
                                <input type="hidden" name="rating" id="rating-val" value="5">
                                
                                <div class="flex gap-1">
                                    <!-- Bintang 1 -->
                                    <svg onclick="ubahBintang(1)" id="bintang-1" class="w-7 h-7 text-yellow-400 cursor-pointer transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20"><path pointer-events="none" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <!-- Bintang 2 -->
                                    <svg onclick="ubahBintang(2)" id="bintang-2" class="w-7 h-7 text-yellow-400 cursor-pointer transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20"><path pointer-events="none" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <!-- Bintang 3 -->
                                    <svg onclick="ubahBintang(3)" id="bintang-3" class="w-7 h-7 text-yellow-400 cursor-pointer transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20"><path pointer-events="none" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <!-- Bintang 4 -->
                                    <svg onclick="ubahBintang(4)" id="bintang-4" class="w-7 h-7 text-yellow-400 cursor-pointer transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20"><path pointer-events="none" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <!-- Bintang 5 -->
                                    <svg onclick="ubahBintang(5)" id="bintang-5" class="w-7 h-7 text-yellow-400 cursor-pointer transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20"><path pointer-events="none" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                            </div>

                        <div class="mb-4">
                            <textarea name="isi" required rows="4" placeholder="Bagikan pengalaman Anda di Air Terjun Tancak..." class="w-full bg-[#f8faf9] border border-gray-100 rounded-[12px] px-4 py-3.5 text-[14px] text-gray-700 outline-none focus:border-[#2d6a4f] transition-colors resize-none"></textarea>
                        </div>

                        <div class="mb-6">
                            <p class="text-gray-500 text-[12px] mb-2">Foto (opsional — bisa digunakan untuk melaporkan kondisi sampah di area wisata)</p>
                            
                            <label for="foto-input" class="group relative w-full h-32 border-2 border-dashed border-gray-300 hover:border-[#2d6a4f] rounded-[12px] flex flex-col items-center justify-center cursor-pointer bg-white hover:bg-[#f8faf9] transition-all duration-300 overflow-hidden block">
                                <div id="upload-placeholder" class="flex flex-col items-center justify-center pointer-events-none w-full h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-gray-400 group-hover:text-[#2d6a4f] transition-colors duration-300">
                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><line x1="16" x2="22" y1="5" y2="5"/><line x1="19" x2="19" y1="2" y2="8"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                    </svg>
                                    <span class="text-gray-400 group-hover:text-[#2d6a4f] text-[13px] font-medium transition-colors duration-300">
                                        Klik untuk upload foto
                                    </span>
                                </div>
                                <img id="upload-preview" class="hidden absolute inset-0 w-full h-full object-cover z-10" alt="Preview">
                            </label>
                            
                            <input type="file" class="hidden" name="foto_ulasan" id="foto-input" accept="image/png, image/jpeg, image/jpg">

                            <button type="button" id="upload-remove" class="hidden mt-3 w-full py-2 bg-red-50 hover:bg-red-100 text-red-500 rounded-[8px] text-[13px] font-semibold flex items-center justify-center transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                Batal Upload Foto
                            </button>
                        </div>

                        <button type="submit" name="submit_ulasan" class="w-full bg-[#1a3326] text-white font-semibold text-[14px] py-3.5 rounded-[12px] flex items-center justify-center hover:bg-[#12241b] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            Kirim Ulasan
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-7 pr-2 pb-8 custom-scrollbar overflow-y-auto relative" style="max-height: 600px;">
                    <div class="flex flex-col gap-4" id="review-container">
                        
                       <?php
                        // Query ini hanya mengambil ulasan yang sudah di-SETUJU-i oleh Admin
                        $query_db = mysqli_query($koneksi, "SELECT * FROM ulasan WHERE status = 'setuju' ORDER BY id_ulasan DESC");
                        
                        $count = 0;
                        $delay = 100; // Inisiasi delay awal
                        while($row = mysqli_fetch_assoc($query_db)) {
                            
                            $row['isi'] = $row['teks'];
                            $row['foto'] = $row['gambar'];
                            $row['is_pinned'] = isset($row['is_pinned']) ? $row['is_pinned'] : 0; 
                            $row['tanggal'] = isset($row['tanggal']) ? $row['tanggal'] : date('Y-m-d H:i:s'); 
                            
                            $inisial = strtoupper(substr($row['nama'], 0, 1));
                            $tanggal = date('d M Y', strtotime($row['tanggal']));
                            $bintang = $row['rating'];
                            
                            $hide_class = ($count >= 4) ? 'hidden review-hidden' : '';
                            
                            // Batasi maksimal delay biar gak kelamaan nunggu kalau data banyak
                            if($delay > 500) $delay = 500; 
                        ?>

                        <div class="bg-white rounded-[16px] p-6 shadow-sm border <?php echo ($row['is_pinned'] == 1) ? 'border-[#2d6a4f]/20' : 'border-gray-50'; ?> relative animate-slide-left delay-<?php echo $delay; ?> <?php echo $hide_class; ?>" style="opacity: 0;">
                            
                            <?php if($row['is_pinned'] == 1): ?>
                            <div class="absolute top-4 right-4 bg-[#e3efe8] text-[#2d6a4f] text-[10px] font-bold px-2 py-1 rounded-md flex items-center border border-[#2d6a4f]/30">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor" class="mr-1"><path d="M21.1 2.9a1.5 1.5 0 0 0-2.1 0l-3.3 3.3a10 10 0 0 0-4.2-1.2L10 6.5l-4 4 1.5 1.5a10 10 0 0 0 1.2 4.2l-3.3 3.3a1.5 1.5 0 0 0 0 2.1 1.5 1.5 0 0 0 2.1 0l3.3-3.3a10 10 0 0 0 4.2 1.2L16.5 18l4-4-1.5-1.5a10 10 0 0 0-1.2-4.2l3.3-3.3a1.5 1.5 0 0 0 0-2.1z"/></svg>
                                Disematkan
                            </div>
                            <?php endif; ?>

                            <div class="flex justify-between items-start mb-3 <?php echo ($row['is_pinned'] == 1) ? 'mt-4' : ''; ?>">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#1a3326] text-white flex items-center justify-center font-bold text-[15px]">
                                        <?php echo htmlspecialchars($inisial); ?>
                                    </div>
                                    <div>
                                        <h3 class="text-[#1a3326] font-bold text-[14px]"><?php echo htmlspecialchars($row['nama']); ?></h3>
                                        <p class="text-gray-400 text-[12px]"><?php echo $tanggal; ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex text-yellow-400 mb-2">
                                <?php 
                                for($i=1; $i<=5; $i++){
                                    if($i <= $bintang){
                                        echo '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
                                    }else{
                                        echo '<svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>';
                                    }
                                }
                                ?>
                            </div>
                            
                            <p class="text-gray-600 text-[13px] leading-relaxed <?php echo (!empty($row['foto']) && strpos($row['foto'], 'http') === 0) ? 'mb-3' : ''; ?>">
                                <?php echo htmlspecialchars($row['isi']); ?>
                            </p>
                            
                            <?php if(!empty($row['foto']) && strpos($row['foto'], 'http') === 0): 
                                // JURUS ANTI BLOKIR KOMINFO & PROVIDER
                                $link_bersih = str_replace(['https://', 'http://'], '', $row['foto']);
                                $link_proxy = 'https://wsrv.nl/?url=' . $link_bersih;
                            ?>
                            <div class="mt-2">
                                <img src="<?php echo htmlspecialchars($link_proxy); ?>" alt="Foto Ulasan" class="h-20 w-32 object-cover rounded-[8px] cursor-pointer hover:opacity-80 transition-opacity border border-gray-200">
                            </div>
                            <?php endif; ?>
                        </div>                        
                        <?php 
                            $count++; 
                            $delay += 100; // Tambahkan delay untuk kartu berikutnya
                        } 
                        ?>
                    </div>

                    <?php if($count > 4): ?>
                    <div class="mt-4 mb-4">
                        <button id="btn-load-more" class="w-full bg-transparent border-2 border-[#2d6a4f] text-[#2d6a4f] hover:bg-[#2d6a4f] hover:text-white font-semibold text-[13px] py-3 rounded-[12px] transition-colors">
                            Lihat Ulasan Lainnya
                        </button>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>
    
    <script src="/tancak-panti/js/navbar.js"></script>
    <script src="/tancak-panti/js/rating.js"></script>
    <script>
    const formTiket = document.querySelector('form');
    
    if (formTiket) {
        formTiket.addEventListener('submit', function(e) {
            const btnSubmit = this.querySelector('button[type="submit"]');
            if (btnSubmit) {
                btnSubmit.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;
                btnSubmit.style.pointerEvents = 'none'; 
                btnSubmit.style.opacity = '0.7';
            }
        });
    }
    </script>
</body>
</html>