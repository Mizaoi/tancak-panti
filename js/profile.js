document.addEventListener('DOMContentLoaded', function() {
    
    // 1. ANIMASI SCROLL REVEAL 
    const observerOptions = { root: null, rootMargin: '0px', threshold: 0.15 };
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target); 
            }
        });
    }, observerOptions);

    const revealElements = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right');
    revealElements.forEach(el => observer.observe(el));


    // 2. LOGIKA CAROUSEL (TRUE INFINITE LOOP - NO ROLLBACK)
    const track = document.querySelector('.carousel-track'); 
    
    if (track) {
        const slides = Array.from(track.querySelectorAll('.carousel-slide'));
        const nextButton = document.querySelector('.carousel-next'); 
        const prevButton = document.querySelector('.carousel-prev'); 
        const dots = Array.from(document.querySelectorAll('.carousel-dot')); 

        if (slides.length > 0) {
            let currentIndex = 0;
            let isAnimating = false;

            // SETUP AWAL: Taruh gambar pertama di tengah, sisanya lempar ke luar layar kanan
            slides.forEach((slide, index) => {
                slide.style.transition = 'none';
                if (index === 0) {
                    slide.style.transform = 'translateX(0)';
                    slide.style.zIndex = '10';
                } else {
                    slide.style.transform = 'translateX(100%)';
                    slide.style.zIndex = '0';
                }
            });

            const updateDots = (index) => {
                if(dots.length > 0) {
                    dots.forEach(dot => {
                        dot.classList.remove('bg-white', 'w-6');
                        dot.classList.add('bg-white/50', 'w-2');
                    });
                    dots[index].classList.remove('bg-white/50', 'w-2');
                    dots[index].classList.add('bg-white', 'w-6');
                }
            };

            // FUNGSI SAKTI: GESER KE ARAH MANAPUN TANPA PUTUS
            const moveToSlide = (targetIndex, direction) => {
                if (isAnimating || targetIndex === currentIndex) return;
                isAnimating = true;

                const currentSlide = slides[currentIndex];
                const targetSlide = slides[targetIndex];

                // 1. Siapkan posisi slide baru secara diam-diam (Tanpa Animasi)
                targetSlide.style.transition = 'none';
                if (direction === 'right') {
                    targetSlide.style.transform = 'translateX(100%)'; // Datang dari Kanan
                } else {
                    targetSlide.style.transform = 'translateX(-100%)'; // Datang dari Kiri
                }
                targetSlide.style.zIndex = '10';
                currentSlide.style.zIndex = '10';

                // 2. Paksa browser ngebaca posisi barunya (Wajib biar animasinya gak error)
                void targetSlide.offsetWidth;

                // 3. Hidupkan efek transisi untuk menggeser keduanya bersamaan
                const animSpeed = 'transform 0.5s ease-in-out';
                currentSlide.style.transition = animSpeed;
                targetSlide.style.transition = animSpeed;

                // 4. Lakukan Eksekusi Geser!
                if (direction === 'right') {
                    currentSlide.style.transform = 'translateX(-100%)'; // Gambar lama buang ke kiri
                } else {
                    currentSlide.style.transform = 'translateX(100%)'; // Gambar lama buang ke kanan
                }
                targetSlide.style.transform = 'translateX(0)'; // Gambar baru panggil ke tengah

                // 5. Update state
                currentIndex = targetIndex;
                updateDots(currentIndex);

                // 6. Bersihkan kekacauan setelah animasi selesai (0.5 detik)
                setTimeout(() => {
                    slides.forEach((slide, idx) => {
                        if (idx !== currentIndex) {
                            slide.style.zIndex = '0';
                            slide.style.transition = 'none';
                            slide.style.transform = 'translateX(100%)'; // Sembunyikan semua di kanan biar rapi
                        }
                    });
                    isAnimating = false;
                }, 500);
            };

            // KLIK NEXT (Geser Kanan Terus)
            if (nextButton) {
                nextButton.addEventListener('click', () => {
                    let nextIndex = (currentIndex === slides.length - 1) ? 0 : currentIndex + 1;
                    moveToSlide(nextIndex, 'right');
                });
            }

            // KLIK PREV (Geser Kiri Terus)
            if (prevButton) {
                prevButton.addEventListener('click', () => {
                    let prevIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1;
                    moveToSlide(prevIndex, 'left');
                });
            }

            // KLIK DOTS BAWAH
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    if (index > currentIndex) moveToSlide(index, 'right');
                    else if (index < currentIndex) moveToSlide(index, 'left');
                });
            });

            // MUTER OTOMATIS TIAP 4 DETIK
            let autoSlide = setInterval(() => {
                let nextIndex = (currentIndex === slides.length - 1) ? 0 : currentIndex + 1;
                moveToSlide(nextIndex, 'right');
            }, 4000);

            // JANGAN MUTER KALAU KURSOR DI ATAS GAMBAR
            track.parentElement.addEventListener('mouseenter', () => clearInterval(autoSlide));
            track.parentElement.addEventListener('mouseleave', () => {
                autoSlide = setInterval(() => {
                    let nextIndex = (currentIndex === slides.length - 1) ? 0 : currentIndex + 1;
                    moveToSlide(nextIndex, 'right');
                }, 4000);
            });
            track.parentElement.addEventListener('touchstart', () => clearInterval(autoSlide));
        }
    }
});