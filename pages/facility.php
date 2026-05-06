<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facility - SI-TANCAK PANTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/facility.css"> 
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: #eff3f0; overflow-x: hidden; }
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

    <div class="bg-[#eff3f0] min-h-screen pb-20">
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 text-[13px] text-gray-500 reveal-up" style="transition-delay: 0s;">
        </div>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 mb-12">
            <div class="relative w-full h-[280px] bg-[#1a3326] rounded-[32px] overflow-hidden shadow-lg reveal-up flex items-center justify-center text-center px-6" style="transition-delay: 0.1s;">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                <div class="relative z-10 max-w-2xl">
                    <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">Kenyamanan Anda,<br><span class="text-[#a8d5a2]">Prioritas Kami</span></h1>
                    <p class="text-white/70 text-[15px]">Fasilitas lengkap untuk memastikan petualangan Anda di Air Terjun Tancak berjalan aman, nyaman, dan berkesan.</p>
                </div>
            </div>
        </section>

<section class="max-w-7xl mx-auto px-6 lg:px-8 mb-16 tracking-section reveal-up" style="transition-delay: 0.2s;">
            
            <!-- CSS Animasi -->
            <style>
                @keyframes drawRoute {
                    from { stroke-dashoffset: 2000; }
                    to { stroke-dashoffset: 0; }
                }
                .animate-route {
                    stroke-dasharray: 2000;
                    stroke-dashoffset: 2000;
                    animation: drawRoute 6s ease-in-out forwards;
                }
                
                @keyframes popIn {
                    0% { transform: scale(0); opacity: 0; }
                    70% { transform: scale(1.2); opacity: 1; }
                    100% { transform: scale(1); opacity: 1; }
                }
                .anim-pop {
                    transform: scale(0);
                    animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
                }
            </style>

            <div class="bg-[#14281e] rounded-[32px] overflow-hidden shadow-xl flex flex-col md:flex-row relative">
                
                <!-- Kiri: Teks Penjelasan -->
                <div class="p-10 md:w-1/3 flex flex-col justify-center text-white z-10 relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#14281e] to-transparent z-0 md:hidden"></div>
                    <div class="relative z-10">
                        <span class="text-[#fc4c02] font-bold text-xs uppercase tracking-widest mb-2 block">Trek & Rute</span>
                        <h2 class="text-3xl font-bold mb-6">Jalur Pendakian Tancak</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 bg-white/5 p-4 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#a8d5a2" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <div><p class="text-xs text-white/50">Jarak Tempuh</p><p class="font-bold">± 2.5 KM</p></div>
                            </div>
                            <div class="flex items-center space-x-4 bg-white/5 p-4 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#a8d5a2" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                <div><p class="text-xs text-white/50">Estimasi Waktu</p><p class="font-bold">45 - 90 Menit</p></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Area Peta (Kotak tetap memanjang, tapi SVG-nya berdiri Portrait) -->
               <!-- Kanan: Area Peta -->
                <div class="md:w-2/3 relative bg-[#1a3326] flex items-center justify-center p-6 md:p-8 overflow-hidden min-h-[450px] md:min-h-[550px]">
                    
                    <div class="absolute inset-0 opacity-5" style="background-image: repeating-radial-gradient( circle at 0 0, transparent 0, #1a3326 10px, white 10px, white 11px );"></div>
                    
                    <!-- SVG PORTRAIT (ViewBox diperbesar agar teks pinggir tidak kepotong) -->
                    <svg viewBox="40 40 360 800" class="h-full w-full max-h-[600px] relative z-10 drop-shadow-2xl">
                        
                        <!-- 1. Garis Putih Putus-putus (Background/Jejak) -->
                        <path d="M 215,770 L 210,740 L 205,710 L 198,680 L 198,650 L 205,630 L 215,600 L 230,570 L 245,540 L 255,510 L 275,480 L 285,460 L 285,440 L 265,410 L 250,405 L 255,385 L 245,360 L 255,340 L 240,310 L 225,280 L 210,250 L 190,220 L 175,200 L 155,170 L 140,150 L 125,140 L 100,125 L 80,115 L 95,100 L 85,80" 
                              fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="8" stroke-dasharray="8 8" stroke-linecap="round" stroke-linejoin="round" />
                        
                        <!-- 2. Garis Oren Animasi -->
                        <path class="animate-route" d="M 215,770 L 210,740 L 205,710 L 198,680 L 198,650 L 205,630 L 215,600 L 230,570 L 245,540 L 255,510 L 275,480 L 285,460 L 285,440 L 265,410 L 250,405 L 255,385 L 245,360 L 255,340 L 240,310 L 225,280 L 210,250 L 190,220 L 175,200 L 155,170 L 140,150 L 125,140 L 100,125 L 80,115 L 95,100 L 85,80" 
                              fill="none" stroke="#fc4c02" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />

                        <!-- Titik Awal (Pos Tiket) -->
                        <g class="anim-pop" style="transform-origin: 215px 770px; animation-delay: 0s;">
                            <circle cx="215" cy="770" r="10" fill="white" stroke="#1a3326" stroke-width="4" />
                            <text x="215" y="805" fill="white" font-size="18" font-family="Poppins" font-weight="600" text-anchor="middle">Pos Tiket</text>
                        </g>

                        <!-- Titik Akhir (Air Terjun) -->
                        <g class="anim-pop" style="transform-origin: 85px 80px; animation-delay: 2.6s;">
                            <circle cx="85" cy="80" r="14" fill="#fc4c02" stroke="white" stroke-width="4" />
                            <path d="M 82 72 L 82 88 M 82 72 L 90 76 L 82 80" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <text x="85" y="115" fill="white" font-size="18" font-family="Poppins" font-weight="800" text-anchor="middle">Air Terjun</text>
                        </g>

                    </svg>

                    <!-- TEKS DISCLAIMER (Ditambah background tipis agar tidak tabrakan dengan garis) -->
                    <div class="absolute bottom-4 right-4 md:bottom-6 md:right-6 text-[10px] md:text-[11px] text-white/50 italic text-right max-w-[280px] leading-snug z-20 bg-[#14281e]/40 p-2 rounded-lg backdrop-blur-sm border border-white/5">
                        *Ilustrasi rute ini mungkin tidak 100% akurat menyesuaikan dengan kondisi medan lapangan.
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 mb-16 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <div class="facility-card bg-white rounded-[24px] border border-gray-100 reveal-up flex flex-col" style="transition-delay: 0.1s;">
                    <div class="facility-img-wrapper">
                        <img src="../assets/images/parkir.jpeg" class="facility-img" alt="Area Parkir">
                        <div class="w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="22" height="13" rx="2"/><path d="M7 21h10"/></svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="text-[#1a3326] text-[18px] font-bold mb-3">Area Parkir Luas</h3>
                        <p class="text-gray-500 text-[14px] leading-relaxed">Tersedia area parkir yang aman dan tertata rapi untuk kendaraan roda dua maupun roda empat, dijaga ketat oleh petugas.</p>
                    </div>
                </div>

                <div class="facility-card bg-white rounded-[24px] border border-gray-100 reveal-up flex flex-col" style="transition-delay: 0.2s;">
                    <div class="facility-img-wrapper">
                        <img src="../assets/images/Taman.jpeg" class="facility-img" alt="taman">
                        <div class="w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="text-[#1a3326] text-[18px] font-bold mb-3">Taman</h3>
                        <p class="text-gray-500 text-[14px] leading-relaxed">Ada beberapa spot taman yang tersedia. Tempat yang sempurna untuk bersantai dan menyantap bekal bersama keluarga.</p>
                    </div>
                </div>

                <div class="facility-card bg-white rounded-[24px] border border-gray-100 reveal-up flex flex-col" style="transition-delay: 0.3s;">
                    <div class="facility-img-wrapper">
                        <img src="../assets/images/wc.jpeg" class="facility-img" alt="Toilet">
                        <div class="w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21V10"/><path d="M15 21V10"/><path d="M12 3a2 2 0 0 0-2 2v2h4V5a2 2 0 0 0-2-2Z"/><path d="M6 10h12"/><path d="M4 14h2"/><path d="M18 14h2"/></svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="text-[#1a3326] text-[18px] font-bold mb-3">Toilet & Ruang Ganti</h3>
                        <p class="text-gray-500 text-[14px] leading-relaxed">Fasilitas MCK yang bersih dengan pasokan air pegunungan alami. Tersedia juga bilik khusus untuk ganti pakaian.</p>
                    </div>
                </div>

        </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 text-center reveal-up mb-10" style="transition-delay: 0.2s;">
            <div class="bg-gradient-to-r from-[#1a3326] to-[#244533] rounded-[32px] p-12 shadow-lg">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Sudah Yakin Ingin Berkunjung?</h2>
                <p class="text-white/80 text-[15px] mb-8 max-w-xl mx-auto">
                    Nikmati seluruh fasilitas di atas hanya dengan membeli tiket masuk resmi melalui sistem online kami.
                </p>
                <a href="tiket.php" class="inline-block bg-white hover:bg-gray-100 text-[#1a3326] font-bold py-4 px-10 rounded-full transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    Pesan Tiket Sekarang
                </a>
            </div>
        </section>

    </div>

    <?php include '../components/footer.php'; ?>
    <script src="../js/facility.js"></script>
    <script src="../js/navbar.js"></script>
</body>
</html>