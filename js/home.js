document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Efek pergerakan halus pada latar belakang Section 1 saat digulir ke bawah (Parallax)
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const bg = document.querySelector('.absolute.inset-0.w-full.h-full.object-cover');
        if(bg && scrolled < window.innerHeight) {
            bg.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
    });

    // 2. Efek memunculkan elemen (Reveal Up) saat di-scroll (Intersection Observer)
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.10
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target); 
            }
        });
    }, observerOptions);

    // Ambil semua elemen dengan class 'reveal-up' dan jalankan observer
    const revealElements = document.querySelectorAll('.reveal-up');
    revealElements.forEach(el => {
        observer.observe(el);
    });

    // 3. Observer terpisah untuk animasi ZOOM di Galeri
    const observerZoomOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.10
    };

    const observerZoom = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target); 
            }
        });
    }, observerZoomOptions);

    // Ambil semua elemen dengan class 'reveal-zoom' (foto galeri) dan jalankan
    const revealZoomElements = document.querySelectorAll('.reveal-zoom');
    revealZoomElements.forEach(el => {
        observerZoom.observe(el);
    });

});