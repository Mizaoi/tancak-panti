<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - SI-TANCAK PANTI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/profile.css"> <style>
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

    <div class="bg-[#eff3f0] min-h-screen pb-20">
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 text-[13px] text-gray-500 reveal-up">

        </div>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 mb-10">
            <div class="relative w-full h-[400px] md:h-[480px] rounded-[32px] overflow-hidden shadow-xl reveal-up group" style="transition-delay: 0.1s;">
                
                <div id="slider" class="relative w-full h-full">
                    
                    <div class="slide absolute inset-0 transition-transform duration-700 ease-in-out translate-x-0">
                        <img src="../assets/images/air-terjun-samping.png" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                    </div>
                    
                    <div class="slide absolute inset-0 transition-transform duration-700 ease-in-out translate-x-full">
                        <img src="../assets/images/air-terjun-depan.png" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                    </div>
                    
                    <div class="slide absolute inset-0 transition-transform duration-700 ease-in-out translate-x-full">
                        <img src="../assets/images/air.png" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                    </div>

                </div>

                <div class="absolute bottom-10 left-8 md:left-12 z-10 text-white pointer-events-none">
                    <h1 class="text-3xl md:text-[40px] font-bold mb-2 tracking-tight">Air Terjun Tancak</h1>
                    <p class="flex items-center text-sm md:text-[15px] text-white/80">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Desa Suci, Kecamatan Panti, Jember
                    </p>
                </div>

                <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/20 hover:bg-black/50 text-white rounded-full flex items-center justify-center backdrop-blur-md opacity-0 group-hover:opacity-100 transition-all duration-300 z-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-black/20 hover:bg-black/50 text-white rounded-full flex items-center justify-center backdrop-blur-md opacity-0 group-hover:opacity-100 transition-all duration-300 z-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </button>

                <div class="absolute bottom-10 right-8 md:right-12 flex space-x-2 z-20" id="dots-container">
                    <div class="dot w-6 h-2 bg-white rounded-full transition-all duration-300"></div>
                    <div class="dot w-2 h-2 bg-white/50 rounded-full transition-all duration-300"></div>
                    <div class="dot w-2 h-2 bg-white/50 rounded-full transition-all duration-300"></div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 mb-10">
            <div class="bg-white rounded-[32px] p-8 md:p-12 shadow-sm flex flex-col md:flex-row gap-8 lg:gap-12 reveal-up" style="transition-delay: 0.2s;">
                
                <div class="flex-1">
                    <h2 class="text-[22px] font-bold text-[#1a3326] mb-6 flex items-center">
                        <span class="w-[6px] h-6 bg-[#2d6a4f] rounded-full mr-3 block"></span>
                        Profil Singkat
                    </h2>
                    <p class="text-gray-500 leading-relaxed mb-4 text-[15px] text-justify">
                        Air Terjun Tancak adalah sebuah lokasi air terjun yang berada di sisi selatan Gunung Argopuro, tepatnya di Desa Suci, Kecamatan Panti, Kabupaten Jember, Jawa Timur. Dari pusat Kota Jember menempuh jarak 16 km menuju Desa Suci. Dalam perjalanannya akan melewati area perkebunan kopi, jalanan berbatu, hutan, serta sungai-sungai dengan tebing tinggi yang ditumbuhi tanaman semak belukar yang masih alami.
                    </p>
                    <p class="text-gray-500 leading-relaxed text-[15px] text-justify">
                        Percikan air yang terjun bebas dari tebing, memberi rasa segar dan sejuk. Air Terjun Tancak sangatlah jernih, dingin, dan menyegarkan.
                    </p>
                </div>

                    <div class="md:w-[320px] w-full rounded-[24px] overflow-hidden min-h-[250px] shadow-sm relative group bg-[#e3efe8]">
                
                   <iframe src="https://maps.google.com/maps?q=Air%20Terjun%20Tancak,%20Panti,%20Jember&t=&z=14&ie=UTF8&iwloc=&output=embed"
                    class="absolute w-[calc(100%+300px)] h-[calc(100%+250px)] -top-[155px] -left-[150px] pointer-events-none" 
                    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    <a href="https://www.google.com/maps/place/Air+Terjun+Tancak/@-8.0740512,113.6208863,14z/data=!4m6!3m5!1s0x2dd6edaa995f359d:0x7f2c804aeecf2dda!8m2!3d-8.0648772!4d113.6189503!16s%2Fg%2F11bvvx4n9j?entry=ttu&g_ep=EgoyMDI2MDQxNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="absolute inset-0 z-10 bg-black/0 group-hover:bg-black/20 flex items-center justify-center transition-all duration-300">
                    <span class="bg-white text-[#1a3326] font-bold text-[13px] py-2 px-5 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                        Lihat Rute Asli
                    </span>
                </a>

            </div>

            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 overflow-hidden pt-10 -mt-10 pb-10 -mb-10">
                
                <div class="bg-[#1e3a29] rounded-[32px] p-10 flex flex-col items-center justify-center text-white text-center shadow-lg reveal-up" style="transition-delay: 0.1s;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-5 opacity-90"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <h3 class="text-[26px] font-bold mb-2">24/Hours</h3>
                    <p class="text-[14px] text-white/70">Buka Setiap Hari</p>
                </div>

                <div class="bg-[#1e3a29] rounded-[32px] p-10 flex flex-col items-center justify-center text-white text-center shadow-lg reveal-down" style="transition-delay: 0.1s;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#f472b6" stroke-width="2" class="mb-5"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
                    <h3 class="text-[26px] font-bold mb-2">Rp 7.500</h3>
                    <p class="text-[14px] text-white/70">Tiket Masuk / Orang</p>
                </div>

                <div class="bg-[#1e3a29] rounded-[32px] p-8 flex flex-col justify-center text-white shadow-lg reveal-up" style="transition-delay: 0.1s;">
                    <h3 class="text-center font-bold text-[15px] mb-6">Tarif Parkir</h3>
                    <div class="space-y-3">
                        <div class="bg-white/10 hover:bg-white/20 transition-colors rounded-[16px] py-4 px-5 flex justify-between items-center">
                            <span class="flex items-center text-[14px] text-white/90">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-3 opacity-80"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                                Mobil
                            </span>
                            <span class="font-bold text-[15px]">Rp 10.000</span>
                        </div>
                        <div class="bg-white/10 hover:bg-white/20 transition-colors rounded-[16px] py-4 px-5 flex justify-between items-center">
                            <span class="flex items-center text-[14px] text-white/90">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-3 opacity-80"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a3.5 3.5 0 1 0-7 0"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/></svg>
                                Motor
                            </span>
                            <span class="font-bold text-[15px]">Rp 5.000</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 text-center reveal-up" style="transition-delay: 0.6s;">
            <a href="beli-tiket.php" class="inline-block bg-[#2d6a4f] hover:bg-[#1a3326] text-white font-semibold py-4 px-10 rounded-full transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                Pesan Tiket Sekarang
            </a>
        </section>

    </div>

    <?php include '../components/footer.php'; ?>

    <script src="../js/navbar.js"></script>
    <script src="../js/profile.js"></script>

</body>
</html>