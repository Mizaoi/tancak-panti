document.addEventListener('DOMContentLoaded', function() {
    
    if (!document.getElementById('input-orang')) return;
    
    // ==========================================
    // 1. TOTAL HARGA OTOMATIS (Rp 6.500/orang)
    // ==========================================
    const inputOrang = document.getElementById('input-orang');
    const teksTotal = document.getElementById('teks-total');
    const HARGA_TIKET = 6500;

    inputOrang.addEventListener('input', function() {
        let jumlah = parseInt(this.value) || 0;
        let total = jumlah * HARGA_TIKET;
        teksTotal.innerText = 'Total: Rp ' + total.toLocaleString('id-ID');
    });

    // ==========================================
    // 2. VALIDASI NO HP (Hanya Angka & Indikator Warna)
    // ==========================================
    function setupPhoneValidation(inputId, counterId) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);

        input.addEventListener('input', function() {
            // Hapus karakter selain angka
            this.value = this.value.replace(/[^0-9]/g, '');
            
            let len = this.value.length;
            counter.innerText = len + '/11';

            if (len === 0) {
                // Default abu-abu
                counter.classList.add('text-gray-400');
                counter.classList.remove('text-red-500', 'text-green-500');
            } else if (len < 11) {
                // Kurang dari 11 -> Merah
                counter.classList.add('text-red-500');
                counter.classList.remove('text-green-500', 'text-gray-400');
            } else {
                // 11 ke atas -> Hijau
                counter.classList.add('text-green-500');
                counter.classList.remove('text-red-500', 'text-gray-400');
            }
        });
    }
    setupPhoneValidation('input-telp1', 'counter-telp1');
    setupPhoneValidation('input-telp2', 'counter-telp2');

    // ==========================================
    // 3. PREVIEW FOTO BUKTI TRANSFER
    // ==========================================
    const buktiInput = document.getElementById('bukti-input');
    const uploadPreview = document.getElementById('upload-preview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');

    buktiInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadPreview.src = e.target.result;
                uploadPreview.classList.remove('hidden');    // Munculkan Foto
                uploadPlaceholder.classList.add('hidden'); // Sembunyikan Teks
            }
            reader.readAsDataURL(file);
        } else {
            uploadPreview.src = "";
            uploadPreview.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
        }
    });

   // ==========================================
    // 4. KELOLA LIST SAMPAH (KETIK LANGSUNG, +/-, HAPUS & REKAP)
    // ==========================================
    const sampahListContainer = document.getElementById('sampah-list-container');
    const sampahSummary = document.getElementById('sampah-summary');

    // Fungsi update teks "X jenis X item total"
    function updateSampahSummary() {
        let totalJenis = 0;
        let totalItem = 0;
        const inputs = sampahListContainer.querySelectorAll('.qty-input');
        
        inputs.forEach(input => {
            let val = parseInt(input.value) || 0;
            if (val > 0) {
                totalJenis++;     // Dihitung 1 jenis kalau jumlahnya lebih dari 0
                totalItem += val; // Menambahkan jumlah itemnya
            }
        });
        
        sampahSummary.innerText = `${totalJenis} jenis ${totalItem} item total`;
    }

    // Event Delegation untuk +, -, dan Hapus (Icon Sampah)
    sampahListContainer.addEventListener('click', function(e) {
        // Tombol Plus
        if (e.target.classList.contains('btn-plus')) {
            const inputQty = e.target.closest('.sampah-item').querySelector('.qty-input');
            inputQty.value = (parseInt(inputQty.value) || 0) + 1;
            updateSampahSummary();
        }
        
        // Tombol Minus
        if (e.target.classList.contains('btn-minus')) {
            const inputQty = e.target.closest('.sampah-item').querySelector('.qty-input');
            let val = parseInt(inputQty.value) || 0;
            if (val > 0) {
                inputQty.value = val - 1;
                updateSampahSummary();
            }
        }

        // Tombol Hapus (Tong Sampah)
        if (e.target.classList.contains('m-del')) {
            e.target.closest('.sampah-item').remove();
            updateSampahSummary();
        }
    });

    // Menangani pengetikan angka langsung di input
    sampahListContainer.addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input')) {
            let val = parseInt(e.target.value);
            // Kalau dikosongin atau diinput minus, balikkan ke 0
            if (isNaN(val) || val < 0) {
                e.target.value = 0;
            }
            updateSampahSummary();
        }
    });


    // ==========================================
    // 5. TAMBAH ITEM SAMPAH BARU (TITLE CASE & UI SAMA PERSIS)
    // ==========================================
    const btnTambahSampah = document.getElementById('btn-tambah-sampah');
    const inputSampahBaru = document.getElementById('input-sampah-baru');

    // Fungsi Capitalize Tiap Kata (Title Case)
    function toTitleCase(str) {
        return str.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    btnTambahSampah.addEventListener('click', function() {
        let namaBaru = inputSampahBaru.value.trim();
        
        if (namaBaru !== "") {
            let namaRapi = toTitleCase(namaBaru);

            // Bikin row persis kayak template di HTML
            const div = document.createElement('div');
            div.className = 'sampah-item flex justify-between items-center py-3.5 px-5 border-b border-gray-100 last:border-b-0 bg-white';
            div.innerHTML = `
                <span class="text-[14px] font-medium text-black item-name">${namaRapi}</span>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="nama_sampah[]" value="${namaRapi}">
                    <button type="button" class="btn-minus w-7 h-7 rounded-full bg-[#f1f5f9] flex items-center justify-center font-bold text-gray-500 hover:bg-gray-200 transition-colors">-</button>
                    <input type="number" name="jumlah_sampah[]" value="1" min="0" class="qty-input w-8 text-center text-[14px] font-bold text-black outline-none bg-transparent">
                    <button type="button" class="btn-plus w-7 h-7 rounded-full bg-[#f1f5f9] flex items-center justify-center font-bold text-gray-500 hover:bg-gray-200 transition-colors">+</button>
                    <button type="button" class="m-del text-gray-300 hover:text-red-500 transition-colors ml-2 cursor-pointer">
                        <svg class="w-[18px] h-[18px] pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            `;
            
            sampahListContainer.appendChild(div);
            updateSampahSummary(); // Hitung ulang rekap setelah item ditambahkan

            // Kosongkan form input
            inputSampahBaru.value = "";
            inputSampahBaru.focus();
        }
    });

    // Fitur Enter buat nambah sampah
    inputSampahBaru.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); 
            btnTambahSampah.click();
        }
    });

    // ==========================================
    // 6. FITUR SALIN NOMOR REKENING (COPY TO CLIPBOARD)
    // ==========================================
    const btnCopies = document.querySelectorAll('.btn-copy');
    
    btnCopies.forEach(btn => {
        btn.addEventListener('click', function() {
            // Ambil nomor rekening dari data-rek
            const rekNumber = this.getAttribute('data-rek');
            const originalHTML = this.innerHTML; // Simpan ikon SVG aslinya

            // Gunakan API Clipboard untuk menyalin
            navigator.clipboard.writeText(rekNumber).then(() => {
                // Ubah ikon jadi Centang Hijau sebagai feedback sukses
                this.innerHTML = `<svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>`;
                
                // Kembalikan ke ikon semula setelah 2 detik
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                }, 2000);
            }).catch(err => {
                alert("Gagal menyalin nomor rekening!");
                console.error("Gagal nyalin Cak:", err);
            });
        });
    });

    // ==========================================
    // 7. EFEK TAB SLIDE KE HALAMAN CEK TIKET
    // ==========================================
    const linkToCek = document.getElementById('link-to-cek');
    if (linkToCek) {
        linkToCek.addEventListener('click', function(e) {
            e.preventDefault(); // Tahan dulu biar gak langsung pindah
            
            const indicator = document.getElementById('main-tab-indicator');
            
            // Beri warna efek aktif seketika
            this.classList.replace('text-gray-500', 'text-white');
            this.classList.replace('font-semibold', 'font-bold');
            this.previousElementSibling.classList.replace('text-white', 'text-gray-500');
            this.previousElementSibling.classList.replace('font-bold', 'font-semibold');

            // Geser kotaknya ke kanan
            indicator.style.transform = 'translateX(100%)';

            // Pindah halaman SETELAH animasi gesernya selesai (350ms)
            setTimeout(() => {
                window.location.href = this.href;
            }, 350);
        });
    }
});