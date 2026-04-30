document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Jalankan Animasi Zoom saat halaman dimuat
    setTimeout(() => {
        const loginCard = document.getElementById('login-card');
        if(loginCard) {
            loginCard.classList.add('active');
        }
    }, 100);

    // 2. Fitur Toggle Intip Password
 document.addEventListener('DOMContentLoaded', function() {
    
    document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // FITUR MATA: TOGGLE PASSWORD VISIBILITY
    // ==========================================
    const toggleBtn = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password-input');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            
            // JIKA SEDANG TITIK-TITIK (Mata Silang), UBAH JADI TEKS JELAS
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'; 
                
                // Ganti HTML di dalam tombol jadi MATA TERBUKA (Warna Hijau)
                toggleBtn.innerHTML = `
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2d6a4f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hover:text-[#1a3326] transition-colors">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                `;
            } 
            // JIKA SEDANG TEKS JELAS (Mata Terbuka), KEMBALIKAN KE TITIK-TITIK
            else {
                passwordInput.type = 'password'; 
                
                // Ganti HTML di dalam tombol jadi MATA DISILANG (Warna Abu-abu)
                toggleBtn.innerHTML = `
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hover:text-[#2d6a4f] transition-colors">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                `;
            }
        });
    }
});

});


document.addEventListener('DOMContentLoaded', function() {
    const errorBox = document.getElementById('error-box');
    
    if (errorBox) {
        // Tunggu 4 detik, trus ilangne kotak error-e
        setTimeout(() => {
            errorBox.style.opacity = '0';
            errorBox.style.transform = 'translateY(-10px)';
            errorBox.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            
            // Hapus elemen soko HTML ben gak menuh-menuhi
            setTimeout(() => errorBox.remove(), 600);
        }, 4000); 
    }
});
});