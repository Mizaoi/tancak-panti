document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Validasi hanya angka untuk No Telp
   // Validasi hanya angka untuk No Telp (HAPUS SAJA BLOK INI)
    const inputCariTelp = document.getElementById('input-cari-telp');
    if (inputCariTelp) {
        inputCariTelp.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    // 2. Efek Animasi Slide Tab Cek Tiket ke Pembelian Tiket
    const linkToBeli = document.getElementById('link-to-beli');
    if (linkToBeli) {
        linkToBeli.addEventListener('click', function(e) {
            e.preventDefault(); 
            const indicator = document.getElementById('main-tab-indicator');
            this.classList.replace('text-gray-500', 'text-white');
            this.classList.replace('font-semibold', 'font-bold');
            this.nextElementSibling.classList.replace('text-white', 'text-gray-500');
            this.nextElementSibling.classList.replace('font-bold', 'font-semibold');
            indicator.style.transform = 'translateX(0)';
            setTimeout(() => {
                window.location.href = this.href;
            }, 350);
        });
    }

    // 3. LOGIKA KLIK TOGGLE SEARCH (WA vs NAMA ALAMAT)
    const btnModeWa = document.getElementById('btn-mode-wa');
    const btnModeNama = document.getElementById('btn-mode-nama');
    const slideIndicator = document.getElementById('slide-indicator');
    
    const formWaId = document.getElementById('form-wa-id');
    const formNamaAlamat = document.getElementById('form-nama-alamat');
    
    const searchMode = document.getElementById('search_mode');
    const inputKunci = document.getElementById('input-kunci');
    const inputNama = document.getElementById('input-nama');
    const inputAlamat = document.getElementById('input-alamat');

    let currentMode = 'wa'; 

    if (btnModeWa && btnModeNama) {
        
        btnModeWa.addEventListener('click', function() {
            if (currentMode === 'wa') return;
            currentMode = 'wa';

            slideIndicator.style.transform = 'translateX(0)';
            
            btnModeWa.classList.add('text-[#1a3326]');
            btnModeWa.classList.remove('text-gray-400', 'hover:text-gray-600');
            
            btnModeNama.classList.add('text-gray-400', 'hover:text-gray-600');
            btnModeNama.classList.remove('text-[#1a3326]');

            formWaId.classList.remove('hidden');
            formNamaAlamat.classList.add('hidden');

            searchMode.value = 'wa_id';
            inputKunci.required = true;
            inputNama.required = false;
            inputAlamat.required = false;
        });

        btnModeNama.addEventListener('click', function() {
            if (currentMode === 'nama') return;
            currentMode = 'nama';

            slideIndicator.style.transform = 'translateX(100%)';
            
            btnModeNama.classList.add('text-[#1a3326]');
            btnModeNama.classList.remove('text-gray-400', 'hover:text-gray-600');
            
            btnModeWa.classList.add('text-gray-400', 'hover:text-gray-600');
            btnModeWa.classList.remove('text-[#1a3326]');

            formNamaAlamat.classList.remove('hidden');
            formWaId.classList.add('hidden');

            searchMode.value = 'nama_alamat';
            inputKunci.required = false;
            inputNama.required = true;
            inputAlamat.required = true;
        });
    }
});