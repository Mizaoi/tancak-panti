// Proses tambahan saat halaman utama dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Efek pergerakan halus pada latar belakang saat digulir ke bawah
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const bg = document.querySelector('.absolute.inset-0.w-full.h-full.object-cover');
        if(bg) {
            bg.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
    });
});