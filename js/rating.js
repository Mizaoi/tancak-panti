document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // 1. LOGIKA ANIMASI SCROLL REVEAL (ZOOM & UP)
    // ==========================================
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

    // ==========================================
    // 2. INTERAKSI BINTANG DI FORM ULASAN
    // ==========================================
    const stars = document.querySelectorAll('.star-input');
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
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

    // ==========================================
    // 3. LOGIKA LOAD MORE (SIMULASI DATABASE)
    // ==========================================
    function getStarsHTML(rating) {
        let starsHTML = '';
        for(let i = 0; i < 5; i++) {
            if(i < rating) {
                starsHTML += '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>';
            } else {
                starsHTML += '<svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>';
            }
        }
        return starsHTML;
    }

    const dummyReviews = [
        { initial: 'S', name: 'Siti Nurhaliza', date: '20 Jan 2025', rating: 4, text: 'Tempatnya bersih, airnya dingin segar. Program list sampah bagus banget.' },
        { initial: 'D', name: 'Dewa Putra', date: '15 Jan 2025', rating: 5, text: 'Pengalaman luar biasa! Air terjunnya tinggi dan deras. Foto-fotonya keren.' },
        { initial: 'F', name: 'Faisal Rahman', date: '10 Jan 2025', rating: 5, text: 'Jalur trackingnya aman buat pemula. Pemandangannya ga ada obat!' },
        { initial: 'C', name: 'Citra Kirana', date: '5 Jan 2025', rating: 4, text: 'Seru banget kemping di sini, fasilitas toilet juga memadai.' },
        { initial: 'B', name: 'Budi Santoso', date: '2 Jan 2025', rating: 5, text: 'Beneran hidden gem Jember. Bakal ngajak temen-temen kantor ke sini.' }
    ];

    let currentIndex = 0;
    const loadLimit = 3; 

    const btnLoadMore = document.getElementById('btn-load-more');
    const reviewContainer = document.getElementById('review-container');

    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', function() {
            
            const originalText = this.innerHTML;
            this.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memuat Ulasan...';
            this.disabled = true;
            this.classList.add('opacity-70', 'cursor-not-allowed');

            setTimeout(() => {
                let htmlToAppend = '';
                
                for (let i = 0; i < loadLimit; i++) {
                    if (currentIndex >= dummyReviews.length) break; 
                    
                    const review = dummyReviews[currentIndex];
                    const starsHtml = getStarsHTML(review.rating);
                    
                    htmlToAppend += `
                        <div class="bg-white rounded-[16px] p-6 shadow-sm border border-gray-50 transform scale-95 opacity-0 transition-all duration-500 ease-out new-review-item">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#1a3326] text-white flex items-center justify-center font-bold text-[15px]">${review.initial}</div>
                                    <div>
                                        <h3 class="text-[#1a3326] font-bold text-[14px]">${review.name}</h3>
                                        <p class="text-gray-400 text-[12px]">${review.date}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex text-yellow-400 mb-2">
                                ${starsHtml}
                            </div>
                            <p class="text-gray-600 text-[13px] leading-relaxed">
                                ${review.text}
                            </p>
                        </div>
                    `;
                    currentIndex++;
                }

                reviewContainer.insertAdjacentHTML('beforeend', htmlToAppend);
                
                setTimeout(() => {
                    const newItems = document.querySelectorAll('.new-review-item');
                    newItems.forEach(item => {
                        item.classList.remove('scale-95', 'opacity-0', 'new-review-item');
                    });
                }, 50);

                if (currentIndex >= dummyReviews.length) {
                    btnLoadMore.style.display = 'none'; 
                } else {
                    btnLoadMore.innerHTML = originalText;
                    btnLoadMore.disabled = false;
                    btnLoadMore.classList.remove('opacity-70', 'cursor-not-allowed');
                }

            }, 1000); 
        });
    }
});