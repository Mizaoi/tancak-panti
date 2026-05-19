// File: js/tiket.js

document.addEventListener('DOMContentLoaded', function() {

    const linkToCek = document.getElementById('link-to-cek');
    
    if (linkToCek) {
        linkToCek.addEventListener('click', function(e) {
            e.preventDefault(); // Tahan dulu jangan langsung pindah halaman
            
            const indicator = document.getElementById('main-tab-indicator');
            
            // 1. Ubah tulisan "Cek Tiket" jadi warna Putih & Bold
            this.classList.replace('text-gray-500', 'text-white');
            this.classList.replace('font-semibold', 'font-bold');
            
            // 2. Ubah tulisan "Pembelian Tiket" (sebelah kirinya) jadi Abu-abu
            this.previousElementSibling.classList.replace('text-white', 'text-gray-500');
            this.previousElementSibling.classList.replace('font-bold', 'font-semibold');
            
            // 3. Geser kotak hijau ke KANAN (100%)
            indicator.style.transform = 'translateX(100%)';
            
            // 4. Tunggu 350 milidetik (sampai animasi geser selesai), baru pindah halaman!
            setTimeout(() => {
                window.location.href = this.href;
            }, 350);
        });
    }

    // ==========================================
    // 1. FITUR ANGGOTA ROMBONGAN & TOTAL HARGA
    // ==========================================
    const anggotaListContainer = document.getElementById('anggota-list-container');
    const inputAnggotaBaru = document.getElementById('input-anggota-baru');
    const btnTambahAnggota = document.getElementById('btn-tambah-anggota');
    const teksTotal = document.getElementById('teks-total');
    const teksJumlahOrang = document.getElementById('teks-jumlah-orang');
    const HARGA_TIKET = 10000;

    function updateTotalAnggota() {
        if(!anggotaListContainer) return;
        let jumlahAnggota = anggotaListContainer.querySelectorAll('.anggota-item').length;
        let totalOrang = 1 + jumlahAnggota;
        let totalHarga = totalOrang * HARGA_TIKET;

        teksJumlahOrang.innerText = jumlahAnggota === 0 ? 'Total: 1 Orang (Kepala Saja)' : `Total: ${totalOrang} Orang (Kepala + ${jumlahAnggota} Anggota)`;
        teksTotal.innerText = 'Total: Rp ' + totalHarga.toLocaleString('id-ID');
    }

    function toTitleCase(str) {
        return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
    }

    if(btnTambahAnggota) {
        btnTambahAnggota.addEventListener('click', function() {
            let namaBaru = inputAnggotaBaru.value.trim();
            if (namaBaru !== "") {
                let namaRapi = toTitleCase(namaBaru);
                const div = document.createElement('div');
                div.className = 'anggota-item flex justify-between items-center py-2 px-3 border border-gray-100 rounded-[8px] bg-white shadow-sm';
                div.innerHTML = `
                    <span class="text-[13px] font-bold text-gray-700">${namaRapi}</span>
                    <input type="hidden" name="nama_anggota[]" value="${namaRapi}">
                    <button type="button" class="a-del text-gray-400 hover:text-red-500 cursor-pointer bg-transparent border-none outline-none">
                        <svg class="w-[16px] h-[16px] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                `;
                anggotaListContainer.appendChild(div);
                updateTotalAnggota(); 
                inputAnggotaBaru.value = "";
                inputAnggotaBaru.focus();
            }
        });

        inputAnggotaBaru.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); btnTambahAnggota.click(); }
        });

        anggotaListContainer.addEventListener('click', function(e) {
            const btnDel = e.target.closest('.a-del');
            if (btnDel) { btnDel.closest('.anggota-item').remove(); updateTotalAnggota(); }
        });

        updateTotalAnggota(); // Jalankan pertama kali
    }

    // ==========================================
    // 2. FITUR LIST SAMPAH (+, -, Tambah, Hapus)
    // ==========================================
    const sampahContainer = document.getElementById('sampah-list-container');
    const summarySampah = document.getElementById('sampah-summary');
    const btnTambahSampah = document.getElementById('btn-tambah-sampah');
    const inputSampahBaru = document.getElementById('input-sampah-baru');

    function updateSummarySampah() {
        if(!sampahContainer) return;
        let totalJenis = 0;
        let totalItem = 0;
        const items = sampahContainer.querySelectorAll('.sampah-item');
        
        items.forEach(item => {
            const qty = parseInt(item.querySelector('.qty-input').value) || 0;
            if (qty > 0) {
                totalJenis++;
                totalItem += qty;
            }
        });
        
        if(summarySampah) {
            summarySampah.innerText = `${totalJenis} jenis ${totalItem} item total`;
        }
    }

    if(sampahContainer) {
        sampahContainer.addEventListener('click', function(e) {
            const target = e.target;
            
            // Logika Tombol Plus
            if (target.classList.contains('btn-plus')) {
                const input = target.parentElement.querySelector('.qty-input');
                input.value = parseInt(input.value) + 1;
                updateSummarySampah();
            }
            
            // Logika Tombol Minus
            if (target.classList.contains('btn-minus')) {
                const input = target.parentElement.querySelector('.qty-input');
                if (parseInt(input.value) > 0) {
                    input.value = parseInt(input.value) - 1;
                    updateSummarySampah();
                }
            }
            
            // Logika Tombol Delete (Tong Sampah)
            const btnDel = target.closest('.m-del');
            if (btnDel) {
                btnDel.closest('.sampah-item').remove();
                updateSummarySampah();
            }
        });

        // Cegah ketik manual angka minus
        sampahContainer.addEventListener('input', function(e) {
            if(e.target.classList.contains('qty-input')) {
                if(e.target.value < 0 || e.target.value === '') e.target.value = 0;
                updateSummarySampah();
            }
        });
    }

    if(btnTambahSampah && inputSampahBaru) {
        btnTambahSampah.addEventListener('click', function() {
            let namaItem = inputSampahBaru.value.trim();
            if(namaItem !== "") {
                let itemRapi = toTitleCase(namaItem);
                const div = document.createElement('div');
                div.className = 'sampah-item flex justify-between items-center py-3.5 px-6 border-b border-gray-100 last:border-b-0 bg-white';
                div.innerHTML = `
                    <span class="text-[14px] font-medium text-black item-name">${itemRapi}</span>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="nama_sampah[]" value="${itemRapi}">
                        <button type="button" class="btn-minus w-7 h-7 rounded-full bg-[#f1f5f9] flex items-center justify-center font-bold text-gray-500 hover:bg-gray-200 transition-colors">-</button>
                        <input type="number" name="jumlah_sampah[]" value="0" min="0" class="qty-input w-8 text-center text-[14px] font-bold text-black outline-none bg-transparent">
                        <button type="button" class="btn-plus w-7 h-7 rounded-full bg-[#f1f5f9] flex items-center justify-center font-bold text-gray-500 hover:bg-gray-200 transition-colors">+</button>
                        <button type="button" class="m-del text-gray-300 hover:text-red-500 transition-colors ml-2 cursor-pointer">
                            <svg class="w-[18px] h-[18px] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                `;
                sampahContainer.appendChild(div);
                inputSampahBaru.value = "";
                inputSampahBaru.focus();
            }
        });
        inputSampahBaru.addEventListener('keypress', function(e) {
            if(e.key === 'Enter') { e.preventDefault(); btnTambahSampah.click(); }
        });
    }

    // ==========================================
    // 3. FITUR UI LAINNYA (Preview, Counter, Modal)
    // ==========================================
    
    // Preview File Bukti
    const buktiInput = document.getElementById('bukti-input');
    if(buktiInput) {
        buktiInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('upload-preview').src = e.target.result;
                    document.getElementById('upload-preview').classList.remove('hidden');
                    document.getElementById('upload-placeholder').classList.add('hidden');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Counter Nomor Telepon
    function setupTelp(idInput, idCounter) {
        const input = document.getElementById(idInput);
        const counter = document.getElementById(idCounter);
        if(input && counter) {
            input.addEventListener('input', () => {
                counter.innerText = `${input.value.length}/11`;
                counter.style.color = input.value.length >= 11 ? '#10b981' : '#9ca3af';
            });
        }
    }
    setupTelp('input-telp1', 'counter-telp1');
    setupTelp('input-telp2', 'counter-telp2');

    // Loading Tombol Submit
    const formTiket = document.getElementById('form-beli-tiket');
    const btnSubmit = document.getElementById('btn-submit-tiket');
    if (formTiket && btnSubmit) {
        formTiket.addEventListener('submit', function(e) {
            if (formTiket.checkValidity()) {
                btnSubmit.innerHTML = `
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memproses...</span>
                `;
                btnSubmit.style.pointerEvents = 'none'; 
            }
        });
    }

    // Trigger Notifikasi Modal Sukses
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('sukses')) {
        const modal = document.getElementById('modal-sukses-beli');
        const card = document.getElementById('modal-card');
        if(modal && card) {
            modal.classList.remove('hidden');
            setTimeout(() => card.classList.remove('scale-95'), 10);
        }
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    // Tutup Modal
    const btnTutupModal = document.getElementById('btn-tutup-modal');
    if(btnTutupModal) {
        btnTutupModal.addEventListener('click', function() {
            document.getElementById('modal-sukses-beli').classList.add('hidden');
        });
    }

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

    const linkToCek = document.getElementById('link-to-cek');
    
    if (linkToCek) {
        linkToCek.addEventListener('click', function(e) {
            e.preventDefault(); // Tahan dulu jangan langsung pindah halaman
            
            const indicator = document.getElementById('main-tab-indicator');
            
            // 1. Ubah tulisan "Cek Tiket" jadi warna Putih & Bold
            this.classList.replace('text-gray-500', 'text-white');
            this.classList.replace('font-semibold', 'font-bold');
            
            // 2. Ubah tulisan "Pembelian Tiket" (sebelah kirinya) jadi Abu-abu
            this.previousElementSibling.classList.replace('text-white', 'text-gray-500');
            this.previousElementSibling.classList.replace('font-bold', 'font-semibold');
            
            // 3. Geser kotak hijau ke KANAN (100%)
            indicator.style.transform = 'translateX(100%)';
            
            // 4. Tunggu 350 milidetik (sampai animasi geser selesai), baru pindah halaman!
            setTimeout(() => {
                window.location.href = this.href;
            }, 350);
        });
    }
});

});