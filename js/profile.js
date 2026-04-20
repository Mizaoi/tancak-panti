document.addEventListener('DOMContentLoaded', function() {
    
    // 1. ANIMASI SCROLL REVEAL (UP & DOWN) MUNCUL SAAT DI-SCROLL
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15 
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target); 
            }
        });
    }, observerOptions);

    const revealElements = document.querySelectorAll('.reveal-up, .reveal-down');
    revealElements.forEach(el => observer.observe(el));


    // 2. LOGIKA CAROUSEL: GESER SESUAI ARAH PANAH
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    let currentIndex = 0;
    let isAnimating = false; // Mencegah klik beruntun sebelum animasi selesai

    function goToSlide(newIndex, direction) {
        if (isAnimating || newIndex === currentIndex) return;
        isAnimating = true;

        const currentSlide = slides[currentIndex];
        const nextSlide = slides[newIndex];

        // Jika tombol Kanan (next) ditekan: Gambar baru masuk dari KANAN
        if (direction === 'next') {
            nextSlide.style.transition = 'none'; // Matikan transisi sebentar
            nextSlide.style.transform = 'translateX(100%)'; // Pindahkan ke kanan layar
            
            // Paksa browser membaca posisi baru (reflow)
            void nextSlide.offsetWidth; 
            
            nextSlide.style.transition = 'transform 0.7s ease-in-out';
            currentSlide.style.transform = 'translateX(-100%)'; // Gambar lama geser ke kiri
            nextSlide.style.transform = 'translateX(0)'; // Gambar baru masuk ke tengah
        } 
        // Jika tombol Kiri (prev) ditekan: Gambar baru masuk dari KIRI
        else {
            nextSlide.style.transition = 'none';
            nextSlide.style.transform = 'translateX(-100%)'; // Pindahkan ke kiri layar
            
            void nextSlide.offsetWidth;
            
            nextSlide.style.transition = 'transform 0.7s ease-in-out';
            currentSlide.style.transform = 'translateX(100%)'; // Gambar lama geser ke kanan
            nextSlide.style.transform = 'translateX(0)'; // Gambar baru masuk ke tengah
        }

        // Perbarui bentuk titik (dots) bawah
        dots[currentIndex].className = 'dot w-2 h-2 bg-white/50 rounded-full transition-all duration-300';
        dots[newIndex].className = 'dot w-6 h-2 bg-white rounded-full transition-all duration-300';

        currentIndex = newIndex;

        // Buka kunci animasi setelah selesai (700ms)
        setTimeout(() => {
            isAnimating = false;
        }, 700); 
    }

    // Aksi Tombol Kanan
    nextBtn.addEventListener('click', () => {
        const nextIndex = (currentIndex === slides.length - 1) ? 0 : currentIndex + 1;
        goToSlide(nextIndex, 'next');
    });

    // Aksi Tombol Kiri
    prevBtn.addEventListener('click', () => {
        const nextIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1;
        goToSlide(nextIndex, 'prev');
    });

});