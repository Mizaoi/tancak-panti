<?php
// AMBIL RATA-RATA RATING DARI DATABASE
include_once 'config/koneksi.php'; 

$avg_rating = 0;
$total_ulasan = 0;

if (isset($koneksi)) {
    $q_rating = mysqli_query($koneksi, "SELECT AVG(rating) as rata_rata, COUNT(*) as total FROM ulasan WHERE status = 'setuju'");
    
    if ($q_rating && mysqli_num_rows($q_rating) > 0) {
        $row_rating = mysqli_fetch_assoc($q_rating);
        $avg_rating = $row_rating['rata_rata'] ? round($row_rating['rata_rata'], 1) : 0;
        $total_ulasan = $row_rating['total'];
    }
}

if ($avg_rating == 0) {
    $avg_rating = "0.0";
}
?>

<footer class="bg-[#14281e] text-white pt-20 pb-8 overflow-hidden relative">

    <style>
        @media (max-width: 768px) {
            .spasi-hp {
                margin-top: 1.5rem !important;
                padding-top: 2rem !important;
                border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            }
        }
    </style>

    <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[#2d6a4f] to-transparent opacity-50"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            <div class="reveal-up" style="transition-delay: 0.1s; padding-right: 1.5rem;">
                <a href="/tancak-panti/home" class="flex items-center gap-4 mb-5 hover:opacity-80 transition-opacity w-fit">
                    <div class="border border-white/30 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 6c.6.5 1.2 1 2.5 1C5.8 7 7 6 7 6s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 1.3 0 2.5-1 2.5-1s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 1.3 0 2.5-1 2.5-1s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-[18px] tracking-tight leading-none uppercase">Air Terjun Tancak</h3>
                        <p class="text-[11px] text-[#a8d5a2] uppercase tracking-widest mt-1">Panti, Jember</p>
                    </div>
                </a>
                
                <p class="text-white/60 text-[14px] leading-relaxed mb-6 text-justify">
                    Lepas penatmu di air terjun tertinggi Jember. Destinasi wisata alam yang sempurna di kaki Gunung Argopuro untuk keluarga dan petualangan.
                </p>
                
                <a href="/tancak-panti/rating" class="flex items-center space-x-1 text-yellow-500 hover:opacity-80 transition-opacity w-fit" title="Lihat Ulasan">
                    <?php 
                    $rating_bulat = round($avg_rating);
                    for($i = 1; $i <= 5; $i++): 
                        if ($i <= $rating_bulat): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <?php endif; 
                    endfor; 
                    ?>
                    <span class="text-white/60 text-xs ml-2 hover:text-white">(<?= $avg_rating ?>/5) dari <?= $total_ulasan ?> ulasan</span>
                </a>
            </div>

            <div class="reveal-up spasi-hp" style="transition-delay: 0.2s;">
                <h4 class="font-bold mb-6 flex items-center text-[16px]">
                    <span class="w-[3px] h-4 bg-[#a8d5a2] rounded-full mr-3 block"></span>
                    Quick Links
                </h4>
                <div class="space-y-4 text-[14px]">
                    <a href="/tancak-panti/home" class="flex items-center text-white/60 hover:text-[#a8d5a2] transition-all group">
                        <span class="w-[3px] h-3 bg-white/20 rounded-full mr-3 group-hover:bg-[#a8d5a2] group-hover:h-4 transition-all duration-300"></span>
                        Beranda
                    </a>
                    <a href="/tancak-panti/tiket" class="flex items-center text-white/60 hover:text-[#a8d5a2] transition-all group">
                        <span class="w-[3px] h-3 bg-white/20 rounded-full mr-3 group-hover:bg-[#a8d5a2] group-hover:h-4 transition-all duration-300"></span>
                        Pesan Tiket
                    </a>
                    <a href="/tancak-panti/profile" class="flex items-center text-white/60 hover:text-[#a8d5a2] transition-all group">
                        <span class="w-[3px] h-3 bg-white/20 rounded-full mr-3 group-hover:bg-[#a8d5a2] group-hover:h-4 transition-all duration-300"></span>
                        Profil
                    </a>
                    <a href="/tancak-panti/facility" class="flex items-center text-white/60 hover:text-[#a8d5a2] transition-all group">
                        <span class="w-[3px] h-3 bg-white/20 rounded-full mr-3 group-hover:bg-[#a8d5a2] group-hover:h-4 transition-all duration-300"></span>
                        Fasilitas
                    </a>
                    <a href="/tancak-panti/contact" class="flex items-center text-white/60 hover:text-[#a8d5a2] transition-all group">
                        <span class="w-[3px] h-3 bg-white/20 rounded-full mr-3 group-hover:bg-[#a8d5a2] group-hover:h-4 transition-all duration-300"></span>
                        Narahubung
                    </a>
                    <a href="/tancak-panti/rating" class="flex items-center text-white/60 hover:text-[#a8d5a2] transition-all group">
                        <span class="w-[3px] h-3 bg-white/20 rounded-full mr-3 group-hover:bg-[#a8d5a2] group-hover:h-4 transition-all duration-300"></span>
                        Ulasan Pengunjung
                    </a>
                </div>
            </div>

            <div class="reveal-up spasi-hp lg:pr-8" style="transition-delay: 0.3s;">
                <h4 class="font-bold mb-5 flex items-center text-[16px]">
                    <span class="w-[3px] h-4 bg-[#a8d5a2] rounded-full mr-3 block"></span>
                    Informasi Kontak
                </h4>
                <div class="space-y-4 text-[14px]">
                    <a href="https://maps.google.com/?q=Air+Terjun+Tancak+Panti+Jember" target="_blank" class="flex items-start gap-3 text-white/60 hover:text-[#a8d5a2] transition-colors group">
                        <svg class="w-5 h-5 shrink-0 text-[#a8d5a2] mt-0.5 group-hover:scale-110 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <p class="leading-relaxed text-justify">Dusun Tancak, Desa Suci, <br> Kec. Panti, Kab. Jember, <br> Jawa Timur 68153</p>
                    </a>
                    
                    <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-3 text-white/60 hover:text-[#a8d5a2] transition-colors group">
                        <svg class="w-5 h-5 shrink-0 text-[#a8d5a2] group-hover:scale-110 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <p>+62 812-3456-7890</p>
                    </a>
                    
                    <a href="mailto:info@tancakpanti.com" class="flex items-center gap-3 text-white/60 hover:text-[#a8d5a2] transition-colors group">
                        <svg class="w-5 h-5 shrink-0 text-[#a8d5a2] group-hover:scale-110 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <p>info@tancakpanti.com</p>
                    </a>
                </div>
            </div>

            <div class="reveal-up spasi-hp" style="transition-delay: 0.4s;">
                <h4 class="font-bold mb-6 flex items-center text-[16px]">
                    <span class="w-[3px] h-4 bg-[#a8d5a2] rounded-full mr-3 block"></span>
                    Jam Operasional
                </h4>
                <div class="bg-white/5 rounded-2xl p-5 border border-white/5">
                    <p class="font-bold text-[15px] mb-1">Setiap hari (Senin - Minggu)</p>
                    <p class="text-white/70 text-[14px]">07:00 - 17:00 WIB</p>
                    <p class="text-white/40 text-[11px] mt-2 italic">*Tetap buka di hari libur nasional</p>
                </div>
                
                <div class="flex items-center space-x-3 mt-6">
                    <a href="https://www.instagram.com/tancakpanti/" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-[#2d6a4f] transition-all duration-300 text-white/70 hover:text-white" title="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                </div>
            </div>

        </div>

        <div class="border-t border-white/5 pt-6 flex flex-col md:flex-row justify-between items-center text-[12px] text-white/30">
            <p>&copy; 2026 SI-TANCAK PANTI. Hak Cipta Dilindungi.</p>
            
            <div class="flex items-center flex-wrap justify-center gap-3 mt-4 md:mt-0">
                <p>Dibuat dengan <span class="text-red-500/50">&#10084;</span> di Jember</p>
                <span class="text-white/10 cursor-default hidden sm:inline">•</span>
                <span class="cursor-default">Kebijakan Privasi</span>
                <span class="text-white/10 cursor-default hidden sm:inline">•</span>
                <span class="cursor-default">Syarat & Ketentuan</span>
                
                <a href="/tancak-panti/login" class="text-white/5 hover:text-[#a8d5a2] transition-colors ml-2" title="Area Admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>