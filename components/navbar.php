<?php
// =========== LOGIKA BANNER NOTIF DARURAT ===========
$notif_file = dirname(dirname(__FILE__)) . '/config/status_darurat.json';
$darurat_aktif = false;
$pesan_darurat = '';

if (file_exists($notif_file)) {
    $file_content = file_get_contents($notif_file);
    $data_json = json_decode($file_content, true);
    
    if (isset($data_json['aktif']) && $data_json['aktif'] === true) {
        $darurat_aktif = true;
        $pesan_darurat = $data_json['pesan'];
    }
}
// ==================================================
?>

<style>
    :root {
        --header-height: <?= $darurat_aktif ? '120px' : '70px' ?>;
    }
    @media (min-width: 769px) {
        #menu-desktop { display: flex !important; }
        #btn-hamburger { display: none !important; }
    }
    @media (max-width: 768px) {
        #menu-desktop { display: none !important; }
        #btn-hamburger { display: flex !important; }
    }
    
    /* Z-INDEX BARBAR BIAR GAK KETUTUP FORM / FOTO */
    .z-navbar { z-index: 999990 !important; }
    .z-overlay { z-index: 999998 !important; }
    .z-sidebar { z-index: 999999 !important; }
</style>

<div id="main-header" class="fixed top-0 left-0 w-full z-navbar shadow-md transition-all duration-300 flex flex-col">
    <nav class="bg-[#1a3326] py-3 px-4 md:px-12 flex justify-between w-full">
        <div class="max-w-10xl mx-auto px-2 lg:px-8 flex justify-between items-center w-full">
            
            <div class="flex items-center">
                <a href="/tancak-panti/home" class="flex items-center space-x-3 group cursor-pointer no-underline">
                    <div class="border-2 border-white/50 rounded-full p-2 group-hover:border-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 6c.6.5 1.2 1 2.5 1C5.8 7 7 6 7 6s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/>
                            <path d="M2 12c.6.5 1.2 1 2.5 1 1.3 0 2.5-1 2.5-1s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/>
                            <path d="M2 18c.6.5 1.2 1 2.5 1 1.3 0 2.5-1 2.5-1s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/>
                        </svg>
                    </div>  
                    <div class="flex flex-col text-white">
                        <span class="text-[13px] tracking-wide leading-none opacity-80 uppercase">Air Terjun</span>
                        <span class="text-[15px] font-bold tracking-tighter leading-none uppercase">TANCAK</span>
                    </div>
                </a>
            </div>

            <div id="menu-desktop" class="items-center space-x-2">
                <a href="/tancak-panti/home" class="nav-item">Home</a>
                <a href="/tancak-panti/profile" class="nav-item">Profile</a>
                <a href="/tancak-panti/facility" class="nav-item">Facility</a>
                <a href="/tancak-panti/contact" class="nav-item">Contact</a>
                <a href="/tancak-panti/rating" class="nav-item">Rating</a>
            </div>

            <button id="btn-hamburger" class="text-white items-center p-2" onclick="bukaSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

        </div>
    </nav>

    <!-- BANNER NOTIF DARURAT -->
    <div id="emergency-banner" class="bg-[#ef4444] text-white w-full px-6 py-3 shadow-inner relative z-50 <?= $darurat_aktif ? '' : 'hidden' ?>">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row items-center justify-center gap-3 text-center md:text-left">
            <div class="flex items-center gap-2 font-extrabold text-[13px] md:text-[14px] tracking-wide shrink-0">
                <span class="w-3 h-3 rounded-full bg-red-200 animate-pulse"></span>
            </div>
            <div id="emergency-message" class="text-[13px] md:text-[13.5px] font-medium leading-snug">
                <?= htmlspecialchars($pesan_darurat); ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const header = document.getElementById('main-header');
    let adjustHeaderHeight = () => {};

    if (header) {
        adjustHeaderHeight = () => {
            document.documentElement.style.setProperty('--header-height', header.offsetHeight + 'px');
        };
        adjustHeaderHeight();
        window.addEventListener('resize', adjustHeaderHeight);
        if (window.ResizeObserver) {
            new ResizeObserver(adjustHeaderHeight).observe(header);
        }
    }

    <?php
    // Deteksi otomatis base path jika project berjalan di sub-folder
    $base_path = (strpos($_SERVER['REQUEST_URI'], '/tancak-panti') === 0) ? '/tancak-panti' : '';
    ?>
    // Polling untuk update otomatis banner darurat tanpa refresh
    const banner = document.getElementById('emergency-banner');
    const messageEl = document.getElementById('emergency-message');

    if (banner && messageEl) {
        setInterval(() => {
            // Gunakan timestamp untuk mencegah cache
            fetch('<?= $base_path ?>/config/status_darurat.json?t=' + new Date().getTime())
                .then(response => {
                    if (response.ok) return response.json();
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    if (data && data.aktif === true) {
                        banner.classList.remove('hidden');
                        messageEl.textContent = data.pesan || '';
                    } else {
                        banner.classList.add('hidden');
                    }
                    adjustHeaderHeight();
                })
                .catch(error => console.error('Gagal mengambil status darurat:', error));
        }, 10000); // Cek setiap 10 detik
    }
});
</script>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/70 z-overlay" style="display: none;" onclick="tutupSidebar()"></div>

<div id="mobile-sidebar" class="fixed top-0 right-0 h-full w-64 bg-[#1a3326] z-sidebar flex flex-col border-l border-white/10" style="transition: transform 0.3s ease-in-out; transform: translateX(100%);">
    
    <div class="flex justify-between items-center p-6 border-b border-white/10">
        <span class="text-white font-bold tracking-widest">MENU</span>
        <button onclick="tutupSidebar()" class="text-white hover:text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

<?php
        // Mengambil URL saat ini
        $url_sekarang = $_SERVER['REQUEST_URI'];
    ?>

    <div class="flex flex-col p-4 space-y-4 text-white">
        
        <a href="/tancak-panti/home" class="block p-3 rounded-lg transition-all <?= strpos($url_sekarang, 'home') !== false ? 'bg-white/20 font-bold border-l-4 border-[#a8d5a2]' : 'hover:bg-white/10'; ?>">
            Home
        </a>

        <a href="/tancak-panti/profile" class="block p-3 rounded-lg transition-all <?= strpos($url_sekarang, 'profile') !== false ? 'bg-white/20 font-bold border-l-4 border-[#a8d5a2]' : 'hover:bg-white/10'; ?>">
            Profile
        </a>

        <a href="/tancak-panti/facility" class="block p-3 rounded-lg transition-all <?= strpos($url_sekarang, 'facility') !== false ? 'bg-white/20 font-bold border-l-4 border-[#a8d5a2]' : 'hover:bg-white/10'; ?>">
            Facility
        </a>

        <a href="/tancak-panti/contact" class="block p-3 rounded-lg transition-all <?= strpos($url_sekarang, 'contact') !== false ? 'bg-white/20 font-bold border-l-4 border-[#a8d5a2]' : 'hover:bg-white/10'; ?>">
            Contact
        </a>

        <a href="/tancak-panti/rating" class="block p-3 rounded-lg transition-all <?= strpos($url_sekarang, 'rating') !== false ? 'bg-white/20 font-bold border-l-4 border-[#a8d5a2]' : 'hover:bg-white/10'; ?>">
            Rating
        </a>
        
    </div>
</div>

<script>
    function bukaSidebar() {
        document.getElementById('mobile-sidebar').style.transform = 'translateX(0)';
        document.getElementById('sidebar-overlay').style.display = 'block';
    }
    function tutupSidebar() {
        document.getElementById('mobile-sidebar').style.transform = 'translateX(100%)';
        document.getElementById('sidebar-overlay').style.display = 'none';
    }
</script>