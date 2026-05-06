<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SI-TANCAK PANTI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/home.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a3326;
            overflow-x: hidden;
        }
    </style>
</head>
<body>

    <?php include '../components/navbar.php'; ?>
    <!-- Kode Navbar Kamu Berakhir di Sini -->
    </nav> 

    <?php
        // Cek Status Darurat dari file JSON
        $notif_file = 'config/status_darurat.json'; // Sesuaikan path folder config-nya jika file index ini ada di luar
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

    <!-- BANNER DARURAT PUBLIK (Hanya muncul jika $darurat_aktif = true) -->
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

    <section class="relative h-[91vh] min-h-[560px] flex items-center overflow-hidden">
        <img src="../assets/images/home.jpeg" alt="Air Terjun Tancak" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>

        <div class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 w-full">
            <div class="hero-content max-w-2xl">
                <span class="badge-wisata inline-block bg-[#2d6a4f]/80 text-white text-xs px-3 py-1 rounded-full mb-4 backdrop-blur-sm border border-white/20">
                    🌿 Wisata Alam Jember
                </span>
                <h1 class="text-white mb-4" style="font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 800; line-height: 1.1;">
                    Air Terjun<br />
                    <span class="text-[#a8d5a2]">Tancak</span>
                </h1>
                <p class="text-white text-base md:text-[16px] tracking-wide mb-6 max-w-lg leading-relaxed [-webkit-text-stroke:0.2px_black]">
                    Lepas penatmu di air terjun tertinggi Jember. Nikmati kesegaran alam lereng Argopuro dan hamparan kebun kopi hanya dengan 
                    <span class="text-[#a8d5a2] font-semibold">Rp 7.500</span>.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="tiket.php" class="bg-[#2d6a4f] hover:bg-[#245a40] text-white px-8 py-3 rounded-full font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-green-900/40 hover:-translate-y-0.5 active:translate-y-0">
                        Pesan Sekarang
                    </a>
                    <a href="profile.php" class="bg-white/20 hover:bg-white/30 text-white border border-white/50 px-8 py-3 rounded-full font-semibold backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <div class="scroll-indicator absolute bottom-8 left-1/2 -translate-x-1/2 z-20 text-white/70 flex flex-col items-center gap-1 text-xs">
            <span>Scroll</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="m6 9 6 6 6-6"/></svg>
        </div>
    </section>

    <section class="py-[56px] bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto reveal-up" style="transition-delay: 0s;">
                <h2 class="text-xl md:text-xl font-bold text-[#1a3326] mb-4">Mengapa Air Terjun Tancak?</h2>
                <p class="text-[17px] text-gray-500">Temukan keindahan alam yang tiada tara di lereng Gunung Argopuro</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-16">
                <div class="bg-[#f4f9f6] rounded-[24px] p-8 flex flex-col items-center text-center reveal-up transition-all hover:-translate-y-2 hover:shadow-lg duration-50" style="transition-delay: 0.1s;">
                    <div class="w-14 h-14 rounded-2xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3 class="text-[#1a3326] text-[17px] font-bold mb-3">Buka 24 Jam</h3>
                    <p class="text-gray-500 text-[14px] leading-relaxed">Nikmati keindahan air terjun kapan saja, siang atau malam hari.</p>
                </div>
                <div class="bg-[#f4f9f6] rounded-[24px] p-8 flex flex-col items-center text-center reveal-up transition-all hover:-translate-y-2 hover:shadow-lg duration-50" style="transition-delay: 0.2s;">
                    <div class="w-14 h-14 rounded-2xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                    </div>
                    <h3 class="text-[#1a3326] text-[17px] font-bold mb-3">Alam Asri</h3>
                    <p class="text-gray-500 text-[14px] leading-relaxed">Dikelilingi perkebunan kopi dan hutan tropis lereng Argopuro.</p>
                </div>
                <div class="bg-[#f4f9f6] rounded-[24px] p-8 flex flex-col items-center text-center reveal-up transition-all hover:-translate-y-2 hover:shadow-lg duration-50" style="transition-delay: 0.3s;">
                    <div class="w-14 h-14 rounded-2xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="text-[#1a3326] text-[17px] font-bold mb-3">Ramah Keluarga</h3>
                    <p class="text-gray-500 text-[14px] leading-relaxed">Cocok untuk wisata keluarga, pasangan, maupun rombongan.</p>
                </div>
                <div class="bg-[#f4f9f6] rounded-[24px] p-8 flex flex-col items-center text-center reveal-up transition-all hover:-translate-y-2 hover:shadow-lg duration-50" style="transition-delay: 0.4s;">
                    <div class="w-14 h-14 rounded-2xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <h3 class="text-[#1a3326] text-[17px] font-bold mb-3">Rating Tinggi</h3>
                    <p class="text-gray-500 text-[14px] leading-relaxed">Destinasi air terjun terfavorit di Kabupaten Jember.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-[56px] bg-[#eff3f0] overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto reveal-up" style="transition-delay: 0s;">
                <h2 class="text-xl md:text-xl font-bold text-[#1a3326] mb-4">Galeri Keindahan</h2>
                <p class="text-[17px] text-gray-500">Panorama alam yang memukau menanti Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                <div class="relative rounded-[24px] overflow-hidden reveal-zoom group cursor-pointer" style="transition-delay: 0.1s;">
                    <img src="../assets/images/panorama1.jpeg" alt="Galeri 1 - Air Terjun Tancak" class="w-full h-[350px] object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/0 transition-colors duration-500"></div>
                </div>
                <div class="relative rounded-[24px] overflow-hidden reveal-zoom group cursor-pointer" style="transition-delay: 0.2s;">
                    <img src="../assets/images/panorama2.jpeg" alt="Galeri 2" class="w-full h-[350px] object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/0 transition-colors duration-500"></div>
                </div>
                <div class="relative rounded-[24px] overflow-hidden reveal-zoom group cursor-pointer" style="transition-delay: 0.3s;">
                    <img src="../assets/images/panorama3.jpeg" alt="Galeri 3" class="w-full h-[350px] object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/0 transition-colors duration-500"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-[48px] bg-gradient-to-r from-[#1a3326] to-[#244533] overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center reveal-up" style="transition-delay: 0.1s;">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Berpetualang?</h2>
            <p class="text-white/90 text-base md:text-[17px] mb-8">
                Pesan tiket sekarang dan nikmati keindahan Air Terjun Tancak bersama orang-orang tersayang
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="tiket.php" class="bg-white text-[#1a3326] hover:bg-gray-100 px-8 py-3 rounded-full font-semibold transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    Beli Tiket Sekarang
                </a>
                <a href="rating.php" class="bg-transparent text-white border border-white/70 hover:bg-white/10 px-8 py-3 rounded-full font-semibold transition-all duration-300 hover:-translate-y-0.5">
                    Lihat Ulasan
                </a>
            </div>
        </div>
    </section>

    <?php include '../components/footer.php'; ?>

    <script src="../js/navbar.js"></script>
    <script src="../js/home.js"></script>

</body>
</html>