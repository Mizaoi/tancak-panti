// ==========================================
// FUNGSI GLOBAL (Taruh di luar DOMContentLoaded)
// ==========================================
function ubahBintang(nilai) {
    // 1. Simpan angka ke input tersembunyi
    const ratingVal = document.getElementById('rating-val');
    if(ratingVal) ratingVal.value = nilai;
    
    // 2. Ubah warna bintang 1 sampai 5
    for (let i = 1; i <= 5; i++) {
        let bintang = document.getElementById('bintang-' + i);
        if (bintang) {
            if (i <= nilai) {
                bintang.classList.remove('text-gray-300');
                bintang.classList.add('text-yellow-400');
            } else {
                bintang.classList.remove('text-yellow-400');
                bintang.classList.add('text-gray-300');
            }
        }
    }
}

// ==========================================
// JALANKAN SAAT HTML SELESAI DIMUAT
// ==========================================
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

    // 2. INTERAKSI BINTANG DI FORM ULASAN (Metode data-val)
    const stars = document.querySelectorAll('.star-input');
    const ratingInput = document.getElementById('rating-val');

    if (stars.length > 0 && ratingInput) {
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const ratingValue = parseInt(this.getAttribute('data-val'));
                
                if (!isNaN(ratingValue)) {
                    ratingInput.value = ratingValue;

                    stars.forEach(s => {
                        const val = parseInt(s.getAttribute('data-val'));
                        if (val <= ratingValue) {
                            s.classList.remove('text-gray-300');
                            s.classList.add('text-yellow-400');
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });
                }
            });
        });
    }

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
                // Buat link sementara untuk preview gambar
                uploadPreview.src = URL.createObjectURL(file);
                
                // Munculkan gambar & tombol hapus, sembunyikan placeholder
                uploadPreview.classList.remove('hidden');
                if (uploadRemove) uploadRemove.classList.remove('hidden');
                if (uploadPlaceholder) uploadPlaceholder.classList.add('hidden');
            }
        });

        if (uploadRemove) {
            uploadRemove.addEventListener('click', function(e) {
                e.preventDefault(); 
                fotoInput.value = ''; 
                uploadPreview.src = '';
                
                // Kembalikan ke tampilan awal
                uploadPreview.classList.add('hidden');
                uploadRemove.classList.add('hidden');
                if (uploadPlaceholder) uploadPlaceholder.classList.remove('hidden');
            });
        }
    }
});