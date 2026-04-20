<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Narahubung - SI-TANCAK PANTI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/contact.css"> 
    
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
<body>

    <?php include '../components/navbar.php'; ?>

    <div class="bg-[#eff3f0] min-h-screen pb-20 pt-20">

        <section class="max-w-3xl mx-auto px-6 lg:px-8 text-center mt-2 mb-12 reveal-up" style="transition-delay: 0.1s;">
            <span class="inline-block bg-[#dbe7dd] text-[#2d6a4f] text-[13px] font-semibold px-5 py-2 rounded-full mb-6">
                Hubungi Kami
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-[#1a3326] mb-4">Narahubung</h1>
            <p class="text-gray-500 text-[15px] md:text-[16px]">
                Butuh informasi lebih lanjut? Jangan ragu untuk menghubungi kami
            </p>
        </section>

        <section class="max-w-5xl mx-auto px-6 lg:px-8 mb-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 overflow-hidden py-4">
                
                <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 flex flex-col hover:-translate-y-2 hover:shadow-xl transition-all duration-300 reveal-left" style="transition-delay: 0.1s;">
                    <div class="w-14 h-14 shrink-0 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <h3 class="text-[#1a3326] text-[18px] font-bold mb-2">Telepon / WhatsApp</h3>
                    <p class="font-semibold text-gray-800 text-[15px] mb-1">+62 812-3456-7890</p>
                    <p class="text-gray-400 text-[13px] mb-6">Senin – Minggu, 08.00 – 20.00</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="mt-auto text-[#2d6a4f] hover:text-[#1a3326] font-semibold text-[14px] flex items-center transition-colors">
                        Chat WhatsApp <span class="ml-2">→</span>
                    </a>
                </div>

                <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 flex flex-col hover:-translate-y-2 hover:shadow-xl transition-all duration-300 reveal-right" style="transition-delay: 0.2s;">
                    <div class="w-14 h-14 shrink-0 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <h3 class="text-[#1a3326] text-[18px] font-bold mb-2">Email</h3>
                    <p class="font-semibold text-gray-800 text-[15px] mb-1">info@tancakpanti.id</p>
                    <p class="text-gray-400 text-[13px] mb-6">Balasan dalam 1x24 jam</p>
                    <a href="mailto:info@tancakpanti.id" class="mt-auto text-[#2d6a4f] hover:text-[#1a3326] font-semibold text-[14px] flex items-center transition-colors">
                        Kirim Email <span class="ml-2">→</span>
                    </a>
                </div>

                <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 flex flex-col hover:-translate-y-2 hover:shadow-xl transition-all duration-300 reveal-left" style="transition-delay: 0.3s;">
                    <div class="w-14 h-14 shrink-0 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </div>
                    <h3 class="text-[#1a3326] text-[18px] font-bold mb-2">Instagram</h3>
                    <p class="font-semibold text-gray-800 text-[15px] mb-1">@airterjuntancak</p>
                    <p class="text-gray-400 text-[13px] mb-6">Ikuti untuk info terbaru</p>
                    <a href="https://instagram.com/airterjuntancak" target="_blank" class="mt-auto text-[#2d6a4f] hover:text-[#1a3326] font-semibold text-[14px] flex items-center transition-colors">
                        Buka Instagram <span class="ml-2">→</span>
                    </a>
                </div>

                <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 flex flex-col hover:-translate-y-2 hover:shadow-xl transition-all duration-300 reveal-right" style="transition-delay: 0.4s;">
                    <div class="w-14 h-14 shrink-0 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <h3 class="text-[#1a3326] text-[18px] font-bold mb-2">Alamat</h3>
                    <p class="font-semibold text-gray-800 text-[15px] mb-1">Desa Suci, Kec. Panti</p>
                    <p class="text-gray-400 text-[13px] mb-6">Kabupaten Jember, Jawa Timur</p>
                    <a href="https://www.google.com/maps/place/Air+Terjun+Tancak,+Suci,+Kec.+Panti,+Kabupaten+Jember" target="_blank" class="mt-auto text-[#2d6a4f] hover:text-[#1a3326] font-semibold text-[14px] flex items-center transition-colors">
                        Lihat di Maps <span class="ml-2">→</span>
                    </a>
                </div>

            </div>
        </section>

    </div>

    <?php include '../components/footer.php'; ?>

    <script src="../js/navbar.js"></script>
    <script src="../js/contact.js"></script>

</body>
</html>