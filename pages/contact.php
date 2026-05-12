<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Narahubung - SI-TANCAK PANTI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/tancak-panti/style/navbar.css">
    <link rel="stylesheet" href="/tancak-panti/style/contact.css"> 
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eff3f0;
            overflow-x: hidden;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <?php include 'components/navbar.php'; ?>
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

    <div class="bg-[#eff3f0] min-h-screen flex-col pt-[30px] pb-15">
        <div class="flex-1 flex flex-col justify-center w-full">
            
            <section class="max-w-3xl mx-auto px-6 lg:px-8 text-center mb-8 reveal-up" style="transition-delay: 0.1s;">
                <span class="inline-block bg-[#dbe7dd] text-[#2d6a4f] text-[13px] font-semibold px-5 py-2 rounded-full mb-4">
                    Hubungi Kami
                </span>
                <h1 class="text-4xl md:text-5xl font-bold text-[#1a3326] mb-3">Narahubung</h1>
                <p class="text-gray-500 text-[15px] md:text-[16px]">
                    Butuh informasi lebih lanjut? Jangan ragu untuk menghubungi kami
                </p>
            </section>

            <section class="max-w-5xl mx-auto px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 overflow-hidden py-2">
                    
                    <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex flex-col hover:-translate-y-2 hover:shadow-xl transition-all duration-300 reveal-left" style="transition-delay: 0.1s;">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </div>
                        <h3 class="text-[#1a3326] text-[17px] font-bold mb-1">Telepon / WhatsApp</h3>
                        <p class="font-semibold text-gray-800 text-[14px] mb-1">+62 851-2350-6605</p>
                        <p class="text-gray-400 text-[12px] mb-5">Senin – Minggu, 08.00 – 20.00</p>
                        <a href="https://wa.me/6285123506605" target="_blank" class="mt-auto text-[#2d6a4f] hover:text-[#1a3326] font-semibold text-[13px] flex items-center transition-colors">
                            Chat WhatsApp <span class="ml-1.5">→</span>
                        </a>
                    </div>

                    <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex flex-col hover:-translate-y-2 hover:shadow-xl transition-all duration-300 reveal-right" style="transition-delay: 0.2s;">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <h3 class="text-[#1a3326] text-[17px] font-bold mb-1">Email</h3>
                        <p class="font-semibold text-gray-800 text-[14px] mb-1">info@tancakpanti.id</p>
                        <p class="text-gray-400 text-[12px] mb-5">Balasan dalam 1x24 jam</p>
                        <a href="mailto:info@tancakpanti.id" class="mt-auto text-[#2d6a4f] hover:text-[#1a3326] font-semibold text-[13px] flex items-center transition-colors">
                            Kirim Email <span class="ml-1.5">→</span>
                        </a>
                    </div>

                    <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex flex-col hover:-translate-y-2 hover:shadow-xl transition-all duration-300 reveal-left" style="transition-delay: 0.3s;">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </div>
                        <h3 class="text-[#1a3326] text-[17px] font-bold mb-1">Instagram</h3>
                        <p class="font-semibold text-gray-800 text-[14px] mb-1">@tancakpanti</p>
                        <p class="text-gray-400 text-[12px] mb-5">Ikuti untuk info terbaru</p>
                        <a href="https://www.instagram.com/tancakpanti/" target="_blank" class="mt-auto text-[#2d6a4f] hover:text-[#1a3326] font-semibold text-[13px] flex items-center transition-colors">
                            Buka Instagram <span class="ml-1.5">→</span>
                        </a>
                    </div>

                    <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex flex-col hover:-translate-y-2 hover:shadow-xl transition-all duration-300 reveal-right" style="transition-delay: 0.4s;">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h3 class="text-[#1a3326] text-[17px] font-bold mb-1">Alamat</h3>
                        <p class="font-semibold text-gray-800 text-[14px] mb-1">Desa Suci, Kec. Panti</p>
                        <p class="text-gray-400 text-[12px] mb-5">Kabupaten Jember, Jawa Timur</p>
                        <a href="https://maps.app.goo.gl/ED73PufCfxLeTvAVA" target="_blank" class="mt-auto text-[#2d6a4f] hover:text-[#1a3326] font-semibold text-[13px] flex items-center transition-colors">
                            Lihat di Maps <span class="ml-1.5">→</span>
                        </a>
                    </div>

                </div>
            </section>
        </div>

    </div>

    <?php include 'components/footer.php'; ?>

    <script src="/tancak-panti/js/navbar.js"></script>
    <script src="/tancak-panti/js/contact.js"></script>

</body>
</html>