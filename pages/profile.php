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

       <section class="max-w-7xl mx-auto px-6 lg:px-8 mt-6 mb-12">
            <div class="relative w-full h-[400px] md:h-[500px] rounded-[32px] overflow-hidden group">
                
                <div class="carousel-track relative w-full h-full bg-[#1a3326]">
                    
                    <div class="carousel-slide absolute inset-0 w-full h-full">
                        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover" alt="Air Terjun Tancak">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-10">
                            <h2 class="text-white text-3xl md:text-4xl font-bold mb-2">Air Terjun Tancak</h2>
                            <p class="text-white/80 flex items-center text-sm md:text-base">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> 
                                Desa Suci, Kecamatan Panti, Jember
                            </p>
                        </div>
                    </div>
                    
                    <div class="carousel-slide absolute inset-0 w-full h-full">
                        <img src="https://images.unsplash.com/photo-1542318882-749e77242d59?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover" alt="Suasana Tancak">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-10">
                            <h2 class="text-white text-3xl md:text-4xl font-bold mb-2">Keindahan Alam Alami</h2>
                            <p class="text-white/80 text-sm md:text-base">Udara sejuk di kaki Gunung Argopuro</p>
                        </div>
                    </div>

                    <div class="carousel-slide absolute inset-0 w-full h-full">
                        <img src="https://images.unsplash.com/photo-1433086966358-54859d0ed716?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover" alt="Air Jernih Tancak">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-10">
                            <h2 class="text-white text-3xl md:text-4xl font-bold mb-2">Mata Air Pegunungan</h2>
                            <p class="text-white/80 text-sm md:text-base">Kesegaran air murni yang menenangkan jiwa</p>
                        </div>
                    </div>

                </div>

                <button class="carousel-prev absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button class="carousel-next absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <div class="absolute bottom-6 right-10 flex space-x-2 z-20">
                    <button class="carousel-dot w-6 h-2 rounded-full bg-white transition-all"></button>
                    <button class="carousel-dot w-2 h-2 rounded-full bg-white/50 transition-all"></button>
                    <button class="carousel-dot w-2 h-2 rounded-full bg-white/50 transition-all"></button>
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

<section class="max-w-7xl mx-auto px-6 lg:px-8 mb-12 reveal-up">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-[#1e3a29] rounded-[24px] p-6 py-8 flex flex-col items-center justify-center text-white text-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-4 opacity-90"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <h3 class="text-[22px] font-bold mb-1.5">24/Hours</h3>
                    <p class="text-[13px] text-white/70">Buka Setiap Hari</p>
                </div>

                <div class="bg-[#1e3a29] rounded-[24px] p-6 py-8 flex flex-col items-center justify-center text-white text-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#f472b6" stroke-width="2" class="mb-4"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
                    <h3 class="text-[22px] font-bold mb-1.5">Rp 6.500</h3>
                    <p class="text-[13px] text-white/70">Tiket Masuk / Orang</p>
                </div>

                <div class="bg-[#1e3a29] rounded-[24px] p-6 py-8 flex flex-col justify-center text-white shadow-lg">
                    <h3 class="text-center font-bold text-[14px] mb-4">Tarif Parkir</h3>
                    <div class="space-y-3">
                        <div class="bg-white/10 hover:bg-white/20 transition-colors rounded-[14px] py-3 px-4 flex justify-between items-center">
                            <span class="flex items-center text-[13px] text-white/90">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2.5 opacity-80"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>
                                Mobil
                            </span>
                            <span class="font-bold text-[14px]">Rp 10.000</span>
                        </div>
                        <div class="bg-white/10 hover:bg-white/20 transition-colors rounded-[14px] py-3 px-4 flex justify-between items-center">
                            <span class="flex items-center text-[13px] text-white/90">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2.5 opacity-80"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a3.5 3.5 0 1 0-7 0"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/></svg>
                                Motor
                            </span>
                            <span class="font-bold text-[14px]">Rp 5.000</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex justify-center">
                <a href="beli-tiket.php" class="bg-[#2d6a4f] hover:bg-[#1a3326] text-white font-bold py-3 px-8 text-[14px] rounded-full transition-colors shadow-md hover:shadow-lg">
                    Pesan Tiket Sekarang
                </a>
            </div>
        </section>

    </div>

    <?php include '../components/footer.php'; ?>

    <script src="../js/navbar.js"></script>
    <script src="../js/profile.js"></script>

</body>
</html>