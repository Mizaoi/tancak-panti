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

    const revealElements = document.querySelectorAll('.reveal-up, .reveal-zoom');
    revealElements.forEach(el => observer.observe(el));

    // 2. INTERAKSI BINTANG DI FORM ULASAN
    const stars = document.querySelectorAll('.star-input');
    const ratingInput = document.getElementById('rating-val');

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            ratingInput.value = index + 1; // Masukkan nilai ke input hidden

            stars.forEach(s => {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-gray-300');
                s.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>';
            });
            for (let i = 0; i <= index; i++) {
                stars[i].classList.remove('text-gray-300');
                stars[i].classList.add('text-yellow-400');
                stars[i].innerHTML = '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>';
            }
        });
    });

    // 3. LOGIKA LOAD MORE (Database)
    const btnLoadMore = document.getElementById('btn-load-more');
    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memuat Ulasan...';
            this.disabled = true;
            this.classList.add('opacity-70', 'cursor-not-allowed');

            setTimeout(() => {
                const hiddenReviews = document.querySelectorAll('.review-hidden');
                let count = 0;

                hiddenReviews.forEach(item => {
                    if (count < 3) {
                        item.classList.remove('hidden', 'review-hidden');
                        item.classList.add('reveal-up');
                        setTimeout(() => item.classList.add('active'), 50);
                        count++;
                    }
                });

                const remainingReviews = document.querySelectorAll('.review-hidden');
                if (remainingReviews.length === 0) {
                    btnLoadMore.style.display = 'none'; 
                } else {
                    btnLoadMore.innerHTML = originalText;
                    btnLoadMore.disabled = false;
                    btnLoadMore.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            }, 800); 
        });
    }

    // 4. PREVIEW FOTO SAAT UPLOAD
    const fotoInput = document.getElementById('foto-input');
    const uploadPreview = document.getElementById('upload-preview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const uploadRemove = document.getElementById('upload-remove');

    if (fotoInput && uploadPreview) {
        fotoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                uploadPreview.src = URL.createObjectURL(file);
                
                uploadPreview.classList.remove('hidden');
                uploadRemove.classList.remove('hidden');
                uploadPlaceholder.classList.add('hidden');
            }
        });

        uploadRemove.addEventListener('click', function(e) {
            e.preventDefault(); 
            fotoInput.value = ''; 
            uploadPreview.src = '';
            
            uploadPreview.classList.add('hidden');
            uploadRemove.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
        });
    }

    const stars = document.querySelectorAll('.star-input');
    const ratingInput = document.getElementById('rating-val');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            // Ambil nilai dari bintang yang diklik (misal klik bintang 3)
            const ratingValue = parseInt(this.getAttribute('data-val'));
            
            // Masukkan nilainya ke hidden input untuk dikirim ke database
            ratingInput.value = ratingValue;

            // Warnai ulang semua bintang
            stars.forEach(s => {
                const val = parseInt(s.getAttribute('data-val'));
                
                if (val <= ratingValue) {
                    // Jadikan kuning untuk bintang yang <= nilai klik
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    // Jadikan abu-abu untuk sisanya
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
});

function ubahBintang(nilai) {
    // 1. Simpan angka ke input tersembunyi
    document.getElementById('rating-val').value = nilai;
    
    // 2. Ubah warna bintang 1 sampai 5
    for (let i = 1; i <= 5; i++) {
        let bintang = document.getElementById('bintang-' + i);
        if (i <= nilai) {
            // Nyalakan Kuning
            bintang.classList.remove('text-gray-300');
            bintang.classList.add('text-yellow-400');
        } else {
            // Matikan jadi Abu-abu
            bintang.classList.remove('text-yellow-400');
            bintang.classList.add('text-gray-300');
        }
    }
}