document.addEventListener('DOMContentLoaded', function() {
    
    // ANIMASI SCROLL REVEAL UNTUK CONTACT
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15 // Animasi mulai saat elemen 15% terlihat
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target); // Matikan observer setelah animasi selesai
            }
        });
    }, observerOptions);

    // Ambil semua elemen yang punya animasi
    const revealElements = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right');
    revealElements.forEach(el => observer.observe(el));

});