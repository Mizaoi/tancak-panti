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
            <div class="bg-[#14281e] rounded-[32px] overflow-hidden shadow-xl flex flex-col md:flex-row relative">
                
                <div class="p-10 md:w-1/3 flex flex-col justify-center text-white z-10 relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#14281e] to-transparent z-0 md:hidden"></div>
                    <div class="relative z-10">
                        <span class="text-[#fc4c02] font-bold text-xs uppercase tracking-widest mb-2 block">Trek & Rute</span>
                        <h2 class="text-3xl font-bold mb-6">Jalur Pendakian Tancak</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4 bg-white/5 p-4 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#a8d5a2" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <div><p class="text-xs text-white/50">Jarak Tempuh</p><p class="font-bold">± 3 KM</p></div>
                            </div>
                            <div class="flex items-center space-x-4 bg-white/5 p-4 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#a8d5a2" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                <div><p class="text-xs text-white/50">Estimasi Waktu</p><p class="font-bold">60 - 120 Menit</p></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:w-2/3 h-[300px] md:h-auto relative bg-[#1a3326] flex items-center justify-center p-6 overflow-hidden">
                    <div class="absolute inset-0 opacity-5" style="background-image: repeating-radial-gradient( circle at 0 0, transparent 0, #1a3326 10px, white 10px, white 11px );"></div>
                    
                    <svg viewBox="0 0 800 400" class="w-full h-full relative z-10 drop-shadow-2xl">
                        <path d="M 100 330 C 175 330, 175 230, 250 230 C 325 230, 325 270, 400 270 C 475 270, 475 160, 550 160 C 625 160, 625 80, 700 80" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="8" stroke-dasharray="10 10" stroke-linecap="round" />
                        
                        <path id="strava-line" d="M 100 330 C 175 330, 175 230, 250 230 C 325 230, 325 270, 400 270 C 475 270, 475 160, 550 160 C 625 160, 625 80, 700 80" fill="none" stroke="#fc4c02" stroke-width="6" stroke-linecap="round" />
                        
                        <g id="titik-awal" style="transform: scale(0); transform-origin: 100px 330px; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                            <circle cx="100" cy="330" r="10" fill="white" stroke="#1a3326" stroke-width="4" />
                            <text x="70" y="365" fill="white" font-size="14" font-family="Poppins" font-weight="600">Pos Tiket</text>
                        </g>

                        <g id="pos-2" style="transform: scale(0); transform-origin: 250px 230px; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                            <circle cx="250" cy="230" r="8" fill="#1a3326" stroke="white" stroke-width="3" />
                            <text x="235" y="260" fill="white" font-size="12" font-family="Poppins" opacity="0.8">Pos 2</text>
                        </g>

                        <g id="pos-camping" style="transform: scale(0); transform-origin: 400px 270px; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                            <circle cx="400" cy="270" r="10" fill="#2d6a4f" stroke="white" stroke-width="3" />
                            <text x="355" y="305" fill="#a8d5a2" font-size="13" font-family="Poppins" font-weight="600">🏕️ Area Camping</text>
                        </g>

                        <g id="pos-3" style="transform: scale(0); transform-origin: 550px 160px; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                            <circle cx="550" cy="160" r="8" fill="#1a3326" stroke="white" stroke-width="3" />
                            <text x="535" y="190" fill="white" font-size="12" font-family="Poppins" opacity="0.8">Pos 3</text>
                        </g>
                        
                        <g id="titik-akhir" style="transform: scale(0); transform-origin: 700px 80px; transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                            <circle cx="700" cy="80" r="14" fill="#fc4c02" stroke="white" stroke-width="4" />
                            <path d="M 696 72 L 696 88 M 696 72 L 706 78 L 696 84" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <text x="640" y="50" fill="white" font-size="18" font-family="Poppins" font-weight="800">Air Terjun</text>
                        </g>
                    </svg>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 mb-16 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <div class="facility-card bg-white rounded-[24px] border border-gray-100 reveal-up flex flex-col" style="transition-delay: 0.1s;">
                    <div class="facility-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1590674899484-131297b1a208?q=80&w=800&auto=format&fit=crop" class="facility-img" alt="Area Parkir">
                        <div class="icon-box icon-overlap w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
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
                        <img src="https://images.unsplash.com/photo-1542318882-749e77242d59?q=80&w=800&auto=format&fit=crop" class="facility-img" alt="Gazebo">
                        <div class="icon-box icon-overlap w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="text-[#1a3326] text-[18px] font-bold mb-3">Gazebo & Taman</h3>
                        <p class="text-gray-500 text-[14px] leading-relaxed">Beberapa gazebo tersebar di sekitar area air terjun. Tempat yang sempurna untuk bersantai dan menyantap bekal bersama keluarga.</p>
                    </div>
                </div>

                <div class="facility-card bg-white rounded-[24px] border border-gray-100 reveal-up flex flex-col" style="transition-delay: 0.3s;">
                    <div class="facility-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1623065176166-419b48fbd607?q=80&w=800&auto=format&fit=crop" class="facility-img" alt="Toilet">
                        <div class="icon-box icon-overlap w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21V10"/><path d="M15 21V10"/><path d="M12 3a2 2 0 0 0-2 2v2h4V5a2 2 0 0 0-2-2Z"/><path d="M6 10h12"/><path d="M4 14h2"/><path d="M18 14h2"/></svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="text-[#1a3326] text-[18px] font-bold mb-3">Toilet & Ruang Ganti</h3>
                        <p class="text-gray-500 text-[14px] leading-relaxed">Fasilitas MCK yang bersih dengan pasokan air pegunungan alami. Tersedia juga bilik khusus untuk ganti pakaian.</p>
                    </div>
                </div>

                <div class="facility-card bg-white rounded-[24px] border border-gray-100 reveal-up flex flex-col" style="transition-delay: 0.1s;">
                    <div class="facility-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?q=80&w=800&auto=format&fit=crop" class="facility-img" alt="Mushola">
                        <div class="icon-box icon-overlap w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21a9 9 0 1 0-9-9c0 1.2.2 2.3.6 3.4L2 22l6.6-1.6c1.1.4 2.2.6 3.4.6Z"/></svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="text-[#1a3326] text-[18px] font-bold mb-3">Mushola Nyaman</h3>
                        <p class="text-gray-500 text-[14px] leading-relaxed">Ruang ibadah yang sejuk dan bersih, dilengkapi dengan perlengkapan sholat serta tempat wudhu yang memadai.</p>
                    </div>
                </div>

                <div class="facility-card bg-white rounded-[24px] border border-gray-100 reveal-up flex flex-col" style="transition-delay: 0.2s;">
                    <div class="facility-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1533777324565-a040eb52facd?q=80&w=800&auto=format&fit=crop" class="facility-img" alt="Kuliner">
                        <div class="icon-box icon-overlap w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="text-[#1a3326] text-[18px] font-bold mb-3">Pusat Kuliner Lokal</h3>
                        <p class="text-gray-500 text-[14px] leading-relaxed">Tersedia penjaja makanan lokal yang menjual aneka camilan, mie hangat, hingga kopi murni khas perkebunan lereng Argopuro.</p>
                    </div>
                </div>

                <div class="facility-card bg-white rounded-[24px] border border-gray-100 reveal-up flex flex-col" style="transition-delay: 0.3s;">
                    <div class="facility-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=800&auto=format&fit=crop" class="facility-img" alt="Tracking">
                        <div class="icon-box icon-overlap w-12 h-12 rounded-xl bg-[#e3efe8] text-[#2d6a4f] flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v3a2 2 0 0 1-2 2H3"/><path d="M21 8h-3a2 2 0 0 1-2-2V3"/><path d="M3 16h3a2 2 0 0 1 2 2v3"/><path d="M16 21v-3a2 2 0 0 1 2-2h3"/></svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="text-[#1a3326] text-[18px] font-bold mb-3">Jalur Tracking Aman</h3>
                        <p class="text-gray-500 text-[14px] leading-relaxed">Akses jalan menuju air terjun berupa setapak yang sudah dikelola oleh pengurus desa agar tetap aman dilewati tanpa merusak alam.</p>
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
                <a href="beli-tiket.php" class="inline-block bg-white hover:bg-gray-100 text-[#1a3326] font-bold py-4 px-10 rounded-full transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
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