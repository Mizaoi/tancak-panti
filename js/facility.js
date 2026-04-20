document.addEventListener('DOMContentLoaded', function() {
    
    // 1. ANIMASI SCROLL REVEAL (MUNCULKAN ELEMEN)
    const observerOptions = { root: null, rootMargin: '0px', threshold: 0.15 };
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                observer.unobserve(entry.target); 
            }
        });
    }, observerOptions);

    const revealElements = document.querySelectorAll('.reveal-up');
    revealElements.forEach(el => observer.observe(el));


    // 2. LOGIKA ANIMASI JALUR STRAVA (100% SINKRON & AKURAT)
    const trackingSection = document.querySelector('.tracking-section');
    const stravaLine = document.getElementById('strava-line');
    const titikAwal = document.getElementById('titik-awal');
    const pos2 = document.getElementById('pos-2');
    const posCamping = document.getElementById('pos-camping');
    const pos3 = document.getElementById('pos-3');
    const titikAkhir = document.getElementById('titik-akhir');
    
    if (trackingSection && stravaLine) {
        // Ambil panjang persis dari kelokan garis (karena melengkung, panjangnya tidak linear)
        const pathLength = stravaLine.getTotalLength();
        
        // Sembunyikan garis sepenuhnya di awal
        stravaLine.style.strokeDasharray = pathLength;
        stravaLine.style.strokeDashoffset = pathLength;
        stravaLine.style.transition = 'none'; // Matikan CSS transition biar JS yang ambil alih
        
        // JS menghitung di panjang ke-berapa ujung garis akan menyentuh X=250 (Pos 2), dll
        let lengths = { pos2: 0, camping: 0, pos3: 0 };
        for (let i = 0; i < pathLength; i += 2) {
            let pt = stravaLine.getPointAtLength(i);
            if (!lengths.pos2 && pt.x >= 250) lengths.pos2 = i;
            if (!lengths.camping && pt.x >= 400) lengths.camping = i;
            if (!lengths.pos3 && pt.x >= 550) lengths.pos3 = i;
        }

        const pathObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    
                    // Skenario 1: Munculkan Pos Tiket (Titik Awal)
                    setTimeout(() => {
                        titikAwal.style.transform = 'scale(1)';
                    }, 500); 

                    // Skenario 2: Mulai tarik garis setelah 1.5 detik santai di layar
                    setTimeout(() => {
                        let startTime = null;
                        const duration = 4000; // Total waktu garis berjalan: 4 Detik
                        
                        // Frame-by-frame animasi (Sangat mulus 60fps)
                        function animateLine(timestamp) {
                            if (!startTime) startTime = timestamp;
                            const progress = Math.min((timestamp - startTime) / duration, 1);
                            
                            // Hitung seberapa panjang garis yang sudah tergambar
                            const currentLength = progress * pathLength;
                            stravaLine.style.strokeDashoffset = pathLength - currentLength;
                            
                            // Skenario 3: MUNCULKAN POS TEPAT SAAT TERSENTUH UJUNG GARIS
                            if (currentLength >= lengths.pos2) pos2.style.transform = 'scale(1)';
                            if (currentLength >= lengths.camping) posCamping.style.transform = 'scale(1)';
                            if (currentLength >= lengths.pos3) pos3.style.transform = 'scale(1)';
                            
                            // Kalau sudah 100% sampai, pos terakhir muncul
                            if (progress === 1) titikAkhir.style.transform = 'scale(1)';
                            
                            // Ulangi terus sampai waktu habis
                            if (progress < 1) {
                                requestAnimationFrame(animateLine);
                            }
                        }
                        
                        requestAnimationFrame(animateLine);

                    }, 1500); 

                    pathObserver.unobserve(entry.target); 
                }
            });
        }, { threshold: 0.4 }); 

        pathObserver.observe(trackingSection);
    }
});