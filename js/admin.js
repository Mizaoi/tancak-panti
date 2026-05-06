document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // 1. POP UP BUKTI TRANSFER
    // ==========================================
    const modalBukti = document.getElementById('modal-bukti');
    const imgFull = document.getElementById('img-bukti-full');

    document.querySelectorAll('.btn-zoom-bukti').forEach(btn => {
        btn.addEventListener('click', function() {
            imgFull.src = this.getAttribute('data-src');
            modalBukti.classList.add('active');
        });
    });

    window.closeBukti = function() {
        modalBukti.classList.remove('active');
        setTimeout(() => { imgFull.src = ""; }, 300); 
    };


    // ==========================================
    // 2. FILTER SEARCH & TANGGAL + REALTIME COUNTER
    // ==========================================
    const searchInput = document.getElementById('main-search');
    const dateInput = document.getElementById('date-filter');
    const tbody = document.getElementById('wisatawan-tbody');
    const rows = tbody.querySelectorAll('.row-tiket');

    function updateRealtimeCounts() {
        let c0 = 0, c1 = 0, c2 = 0;
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const statusBtn = row.querySelector('.status-toggle');
                if (statusBtn) {
                    const state = parseInt(statusBtn.getAttribute('data-state'));
                    if (state === 0) c0++;
                    if (state === 1) c1++;
                    if (state === 2) c2++;
                }
            }
        });
        document.getElementById('count-0').innerText = c0;
        document.getElementById('count-1').innerText = c1;
        document.getElementById('count-2').innerText = c2;
    }

    function filterTable() {
        const keyword = searchInput.value.toLowerCase();
        const selectedDate = dateInput.value;

        rows.forEach(row => {
            const rowText = row.innerText.toLowerCase(); 
            const rowDate = row.querySelector('.data-tgl').getAttribute('data-value'); 

            const matchKeyword = rowText.includes(keyword);
            const matchDate = (selectedDate === '') || (rowDate === selectedDate);

            if (matchKeyword && matchDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateRealtimeCounts();
    }

    searchInput.addEventListener('input', filterTable);
    dateInput.addEventListener('change', filterTable);
    updateRealtimeCounts();


    // ==========================================
    // 3. LOGIKA INFINITY LOOP STATUS TIKET (AJAX)
    // ==========================================
    tbody.addEventListener('click', function(e) {
        const btn = e.target.closest('.status-toggle');
        if(!btn) return;

        const config = {
            0: { class: 'bg-yellow-50 text-yellow-600 border-yellow-200', text: 'Masih di Wisata', enumText: 'Masih di Wisata', next: 1 },
            1: { class: 'bg-green-50 text-green-600 border-green-200', text: 'Sudah Pulang', enumText: 'Sudah Pulang', next: 2 },
            2: { class: 'bg-red-50 text-red-600 border-red-200', text: 'Belum Check-in', enumText: 'Belum Check-in', next: 0 }
        };

        let currentState = parseInt(btn.getAttribute('data-state'));
        let idTiket = btn.getAttribute('data-id');
        let nextData = config[currentState];

        // Ganti UI Seketika
        btn.className = `status-toggle outline-none border px-2 py-1.5 rounded-full text-[10.5px] font-bold flex items-center justify-center gap-1 w-full max-w-[110px] mx-auto transition-colors ${nextData.class}`;
        btn.innerText = nextData.text;
        btn.setAttribute('data-state', nextData.next);
        btn.closest('.data-status-text').setAttribute('data-text-status', nextData.text.toLowerCase());
        
        updateRealtimeCounts(); 

        // Update ke Database Background
        fetch('/tancak-panti/api/proses_update_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_tiket=${idTiket}&status=${encodeURIComponent(nextData.enumText)}`
        })
        .then(response => response.text())
        .then(data => console.log("DB Updated:", data))
        .catch(err => console.error("Error DB:", err));
    });


    // ==========================================
    // 4. LOGIKA MODAL OVERLAY SAMPAH
    // ==========================================
    const modalTrash = document.getElementById('modal-trash');
    const trashList = document.getElementById('m-trash-list');
    const visitorInfo = document.getElementById('m-visitor-info');
    const inputNew = document.getElementById('m-input-new');
    let trashTiketId = null;
    let trashData = []; 
    let currentTrashBtn = null;

    document.querySelectorAll('.btn-kelola-sampah').forEach(btn => {
        btn.addEventListener('click', function() {
            currentTrashBtn = this;
            trashTiketId = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const kode = this.getAttribute('data-kode');
            
            visitorInfo.innerText = `${nama} • ${kode}`;
            modalTrash.classList.add('active');
            trashList.innerHTML = '<div class="text-center py-6 text-gray-400 text-[12px]">Memuat data dari database...</div>';

            fetch(`/tancak-panti/api/sampah.php?action=get&id=${trashTiketId}`)
                .then(res => res.json())
                .then(data => {
                    trashData = data;
                    renderTrashList();
                }).catch(() => {
                    trashList.innerHTML = '<div class="text-center py-6 text-red-400 text-[12px]">Gagal memuat data!</div>';
                });
        });
    });

    window.renderTrashList = function() {
        trashList.innerHTML = '';
        if (trashData.length === 0) {
            trashList.innerHTML = '<div class="text-center py-6 text-gray-400 text-[12px] bg-gray-50 rounded-xl border border-dashed border-gray-200">Tidak ada sampah tercatat.</div>';
            return;
        }

        trashData.forEach((item, index) => {
            trashList.innerHTML += `
                <div class="flex items-center justify-between bg-[#f4fcf7] border border-[#d1f4e0] text-[#1a3326] rounded-[16px] px-4 py-3 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span class="text-[13.5px] font-bold">${item.nama_sampah}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="updateQtySampah(${index}, -1)" class="w-7 h-7 flex items-center justify-center bg-white border border-green-200 rounded-md text-green-700 font-bold hover:bg-green-50 transition-colors">−</button>
                        <span class="w-6 text-center font-extrabold text-[14px]">${item.jumlah}</span>
                        <button onclick="updateQtySampah(${index}, 1)" class="w-7 h-7 flex items-center justify-center bg-white border border-green-200 rounded-md text-green-700 font-bold hover:bg-green-50 transition-colors">+</button>
                        <div class="w-px h-6 bg-green-200 mx-1"></div>
                        <button onclick="deleteItemSampah(${index})" class="text-red-400 hover:text-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>`;
        });
    };

    window.updateQtySampah = function(index, change) {
        if (trashData[index].jumlah + change >= 1) {
            trashData[index].jumlah += change;
            renderTrashList();
        }
    };

    window.deleteItemSampah = function(index) {
        trashData.splice(index, 1);
        renderTrashList();
    };

    // Tombol Tambah Item Baru
    document.getElementById('m-btn-add').addEventListener('click', function() {
        let namaBaru = inputNew.value.trim();
        if (namaBaru !== '') {
            // Auto Kapital (Format Judul)
            namaBaru = namaBaru.toLowerCase().split(' ').map(kata => kata.charAt(0).toUpperCase() + kata.slice(1)).join(' ');
            trashData.push({ nama_sampah: namaBaru, jumlah: 1 });
            inputNew.value = '';
            renderTrashList();
            setTimeout(() => { trashList.scrollTop = trashList.scrollHeight; }, 100);
        }
    });

    // Simpan Sampah Ke DB
    document.getElementById('m-btn-save').addEventListener('click', function() {
        const btnSave = this;
        btnSave.innerHTML = 'Menyimpan...';
        btnSave.disabled = true;

        fetch('/tancak-panti/api/sampah.php?action=save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_tiket: trashTiketId, items: trashData })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                if(currentTrashBtn) { currentTrashBtn.querySelector('.total-item-teks').innerText = res.total_baru; }
                closeModalSampah();
            } else { alert('Gagal menyimpan sampah!'); }
        })
        .finally(() => {
            btnSave.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg> Simpan Daftar';
            btnSave.disabled = false;
        });
    });

    function closeModalSampah() {
        modalTrash.classList.remove('active');
        inputNew.value = '';
    }
    document.getElementById('close-modal-trash').addEventListener('click', closeModalSampah);
    document.getElementById('m-btn-batal').addEventListener('click', closeModalSampah);


    // ==========================================
    // 5. LOGIKA MODAL OVERLAY DENDA
    // ==========================================
    const modalDenda = document.getElementById('modal-denda');
    const dendaList = document.getElementById('d-trash-list');
    const dendaVisitorInfo = document.getElementById('d-visitor-info');
    
    // Elemen Kalkulasi Denda
    const elTotalRp = document.getElementById('d-total-rp');
    const elTotalHilang = document.getElementById('d-total-hilang');
    const elTotalCalc = document.getElementById('d-total-calc');

    let dendaTiketId = null;
    let dendaData = []; 

    // Buka Modal & Fetch Data
    document.querySelectorAll('.btn-kelola-denda').forEach(btn => {
        btn.addEventListener('click', function() {
            dendaTiketId = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const kode = this.getAttribute('data-kode');
            
            dendaVisitorInfo.innerText = `${nama} • ${kode}`;
            modalDenda.classList.add('active');
            dendaList.innerHTML = '<div class="text-center py-6 text-gray-400 text-[12px]">Memuat data dari database...</div>';

            fetch(`/tancak-panti/api/denda.php?action=get&id=${dendaTiketId}`)
                .then(res => res.json())
                .then(data => {
                    dendaData = data;
                    renderDendaList();
                }).catch(() => {
                    dendaList.innerHTML = '<div class="text-center py-6 text-red-400 text-[12px]">Gagal memuat data!</div>';
                });
        });
    });

    // Render List UI & Kalkulasi Total
    window.renderDendaList = function() {
        dendaList.innerHTML = '';
        let totalItemHilang = 0;
        let totalDendaRp = 0;

        if (dendaData.length === 0) {
            dendaList.innerHTML = '<div class="text-center py-6 text-gray-400 text-[12px] bg-red-50 rounded-xl border border-dashed border-red-200">Tidak ada sampah yang dibawa. Aman!</div>';
        }

        dendaData.forEach((item, index) => {
            const dendaItem = item.hilang * 10000;
            totalItemHilang += item.hilang;
            totalDendaRp += dendaItem;

            const minColor = item.hilang > 0 ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-gray-200 text-gray-400 cursor-not-allowed';
            const plusColor = item.hilang < item.bawa ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-gray-100 text-gray-300 cursor-not-allowed';
            const dendaText = dendaItem > 0 ? `-Rp ${dendaItem.toLocaleString('id-ID')}` : 'Rp 0';
            const bgBox = item.hilang > 0 ? 'bg-[#fff5f5] border-red-200' : 'bg-white border-gray-100';

            dendaList.innerHTML += `
                <div class="flex items-center justify-between ${bgBox} border rounded-[16px] px-4 py-3 shadow-sm transition-colors">
                    <div>
                        <span class="text-[13.5px] font-bold text-red-700 block mb-0.5">${item.nama_sampah}</span>
                        <span class="text-[11px] text-gray-500">
                            Total dibawa: ${item.bawa} • Kembali: <strong class="text-green-600">${item.kembali}</strong> • Hilang: <strong class="text-red-500">${item.hilang}</strong>
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="updateHilang(${index}, -1)" class="w-7 h-7 flex items-center justify-center rounded-full font-extrabold text-[15px] transition-colors ${minColor}">−</button>
                        <span class="w-4 text-center font-extrabold text-[14px] text-gray-800">${item.hilang}</span>
                        <button onclick="updateHilang(${index}, 1)" class="w-7 h-7 flex items-center justify-center rounded-full font-extrabold text-[15px] transition-colors ${plusColor}">+</button>
                        <div class="text-red-600 font-bold text-[12px] w-[75px] text-right bg-red-100/50 py-1 px-2 rounded-md ml-1">${dendaText}</div>
                    </div>
                </div>`;
        });

        // Update Box Estimasi
        elTotalRp.innerText = `Rp ${totalDendaRp.toLocaleString('id-ID')}`;
        elTotalHilang.innerText = `${totalItemHilang} item hilang`;
        elTotalCalc.innerText = `${totalItemHilang} × Rp 10.000`;
    };

    // Fungsi Tambah/Kurang Item Hilang
    window.updateHilang = function(index, change) {
        let newHilang = dendaData[index].hilang + change;
        if (newHilang >= 0 && newHilang <= dendaData[index].bawa) {
            dendaData[index].hilang = newHilang;
            dendaData[index].kembali = dendaData[index].bawa - newHilang;
            renderDendaList();
        }
    };

    // Simpan Denda ke Database
    document.getElementById('d-btn-save').addEventListener('click', function() {
        const btnSave = this;
        btnSave.innerHTML = 'Menyimpan...';
        btnSave.disabled = true;

        const infoTeks = dendaVisitorInfo.innerText; 
        const namaSaja = infoTeks.split(' • ')[0]; 
        
        // Hitung Grand Total Denda dari dendaData yang aktif
        let grandTotalRp = 0;
        dendaData.forEach(item => {
            if(item.hilang > 0) grandTotalRp += (item.hilang * 10000);
        });

        fetch('/tancak-panti/api/denda.php?action=save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                id_tiket: dendaTiketId, 
                nama_wisatawan: namaSaja, 
                items: dendaData 
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                
                // Update tombol denda di tabel depan secara realtime
                const currentDendaBtn = document.querySelector(`.btn-kelola-denda[data-id="${dendaTiketId}"]`);
                if(currentDendaBtn) {
                    if(grandTotalRp > 0) {
                        currentDendaBtn.className = "btn-kelola-denda bg-red-100 text-red-600 hover:bg-red-200 border-red-200 border px-3 py-1.5 rounded-md font-bold text-[10.5px] transition-colors whitespace-nowrap w-full max-w-[100px] overflow-hidden text-ellipsis block mx-auto";
                    } else {
                        currentDendaBtn.className = "btn-kelola-denda bg-gray-50 text-gray-600 hover:bg-gray-200 border-gray-200 border px-3 py-1.5 rounded-md font-bold text-[10.5px] transition-colors whitespace-nowrap w-full max-w-[100px] overflow-hidden text-ellipsis block mx-auto";
                    }
                    currentDendaBtn.innerText = "+ Denda";
                }

                closeModalDenda();
            } else { alert('Gagal menyimpan denda!'); }
        })
        .finally(() => {
            btnSave.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg> Simpan Denda';
            btnSave.disabled = false;
        });
    });

    // Fungsi Tutup Modal Denda
    function closeModalDenda() {
        modalDenda.classList.remove('active');
    }
    
    // Pasang tombol tutup (Ini yang tadi kemungkinan putus/terhapus)
    document.getElementById('close-modal-denda').addEventListener('click', closeModalDenda);
    document.getElementById('d-btn-batal').addEventListener('click', closeModalDenda);

    // ==========================================
    // 6. LOGIKA NOTIFIKASI DARURAT & WHATSAPP
    // ==========================================
    const topBanner = document.getElementById('top-banner-notif');
    const btnNotifHeader = document.getElementById('btn-notif-header');
    const textNotifHeader = document.getElementById('text-notif-header');
    
    const modalNotifSetup = document.getElementById('modal-notif-setup');
    const modalNotifDetail = document.getElementById('modal-notif-detail');
    const textAreaPesan = document.getElementById('notif-pesan-teks');
    
   // State Penyimpanan Notif (Membaca kondisi halaman otomatis saat di-refresh)
    let isNotifActive = !topBanner.classList.contains('hidden');
    let activeMessage = isNotifActive ? document.getElementById('banner-text').innerText : "";
    let activeTime = isNotifActive ? document.getElementById('banner-time').innerText : "";
    const totalWisatawanDarurat = parseInt("<?= $count_darurat ?>") || document.getElementById('count-1').innerText; 

    const pesanTemplates = {
        hujan: "⚠️ PEMBERITAHUAN DARURAT: Akan terjadi hujan lebat di area wisata. Seluruh wisatawan yang masih berada di area Air Terjun Tancak dimohon untuk segera turun menuju pintu keluar dengan tertib. Jangan panik, ikuti arahan petugas.",
        badai: "⚠️ PEMBERITAHUAN DARURAT: Peringatan cuaca ekstrem dan badai. Segera jauhi area air terjun dan pepohonan besar. Berlindung di pos terdekat dan segera menuju pintu keluar dengan aman.",
        banjir: "⚠️ PEMBERITAHUAN DARURAT: Potensi banjir bandang atau longsor terdeteksi. SEGERA TINGGALKAN AREA AIR TERJUN dan naik ke dataran tinggi atau ikuti jalur evakuasi menuju pintu keluar sekarang juga!",
        kustom: ""
    };

  // Fungsi Klik Tombol Header (Notif Darurat)
    btnNotifHeader.addEventListener('click', function() {
        if (isNotifActive) {
            // JIKA AKTIF: Matikan Notif sampai ke halaman publik
            if(confirm("Matikan Notifikasi Darurat? Banner akan hilang dari semua halaman pengunjung.")) {
                
                // Panggil API Matikan Notif
                fetch('/tancak-panti/api/matikan_notif.php')
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        isNotifActive = false;
                        topBanner.classList.add('hidden');
                        
                        btnNotifHeader.className = "flex items-center gap-2 px-5 py-2.5 border border-orange-200 text-orange-500 rounded-[14px] text-[13px] font-bold hover:bg-orange-50 transition-colors";
                        textNotifHeader.innerText = "Notif Darurat";
                        alert("Notifikasi Darurat telah dimatikan!");
                    }
                });
            }
        } else {
            // ... (KODE JIKA MATI TETAP BIARKAN SEPERTI SEBELUMNYA) ...
            // JIKA MATI: Buka Modal Setup & Ambil Data Realtime
            const listContainer = document.getElementById('notif-target-list');
            const countText = document.getElementById('notif-target-count');
            const btnAktifkan = document.getElementById('btn-notif-aktifkan');
            
            listContainer.innerHTML = '<p class="text-center text-[11px] text-yellow-600 font-medium py-2">Memuat data dari database...</p>';
            modalNotifSetup.classList.add('active');

fetch('/tancak-panti/api/notif_list.php')
    .then(response => response.json())
    .then(res => {
        const countSpan = document.getElementById('notif-target-count');
        const listContainer = document.getElementById('notif-target-list');
        const btnAktifkan = document.getElementById('btn-notif-aktifkan');
        
        if (res.status === 'success') {
            countSpan.textContent = res.count;
            
            if (res.count > 0) {
                let html = '';
                // Looping data dan bikin desain kartu untuk masing-masing orang
                res.data.forEach(item => {
                    let kode = item.kode_tiket ? item.kode_tiket : '-';
                    
                    html += `
                    <div class="bg-white border border-yellow-200 rounded-[10px] p-3 shadow-sm text-[12px] text-gray-700 mb-2">
                        <div class="flex justify-between font-bold text-gray-800 mb-1.5 border-b border-gray-100 pb-1.5">
                            <span>${item.nama} <span class="text-gray-400 font-medium">(${kode})</span></span>
                            <span class="text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-full text-[10px] uppercase">${item.status}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-1.5 mt-1">
                            <div class="truncate"><span class="text-gray-400">Telp:</span> <span class="font-bold text-green-600">${item.telepon_1}</span></div>
                            <div class="text-right"><span class="text-gray-400">Tgl:</span> <span class="font-medium">${item.tanggal_kunjungan}</span></div>
                            <div class="col-span-2 truncate" title="${item.alamat}"><span class="text-gray-400">Alamat:</span> <span class="font-medium">${item.alamat}</span></div>
                        </div>
                    </div>
                    `;
                });
                
                listContainer.innerHTML = html;
                
                // Nyalakan tombol Aktifkan Notif
                btnAktifkan.disabled = false;
                btnAktifkan.style.opacity = '1';
                btnAktifkan.style.cursor = 'pointer';
            } else {
                listContainer.innerHTML = '<div class="text-center text-gray-500 py-4 font-medium">Tidak ada wisatawan di area.</div>';
            }
        } else {
            listContainer.innerHTML = '<div class="text-red-500 text-center py-4 font-medium">Gagal memuat data dari database!</div>';
        }
    })
    .catch(err => {
        console.error("Error Fetch:", err);
        document.getElementById('notif-target-list').innerHTML = '<div class="text-red-500 text-center py-4 font-medium">Gagal memuat data!</div>';
    });
        }
    });
    // Tombol Pilih Jenis Peringatan
    const btnJenis = document.querySelectorAll('.btn-jenis-notif');
    btnJenis.forEach(btn => {
        btn.addEventListener('click', function() {
            // Reset style semua tombol jenis
            btnJenis.forEach(b => {
                b.className = "btn-jenis-notif border-gray-200 text-gray-600 bg-white hover:bg-gray-50 border rounded-[12px] py-2.5 text-[13px] font-bold transition-all flex justify-center items-center gap-2";
            });
            // Aktifkan tombol yang dipilih
            this.className = "btn-jenis-notif border-red-300 text-red-600 bg-red-50 border rounded-[12px] py-2.5 text-[13px] font-bold transition-all flex justify-center items-center gap-2";
            
            const tipe = this.getAttribute('data-type');
            if (tipe === 'kustom') {
                textAreaPesan.value = "";
                textAreaPesan.removeAttribute('readonly');
                textAreaPesan.focus();
                textAreaPesan.placeholder = "Ketik pesan peringatan darurat Anda di sini...";
            } else {
                textAreaPesan.value = pesanTemplates[tipe];
                textAreaPesan.setAttribute('readonly', 'true');
            }
        });
    });

    // Tutup Modal Setup
    function closeNotifSetup() { modalNotifSetup.classList.remove('active'); }
    document.getElementById('btn-notif-batal').addEventListener('click', closeNotifSetup);
    document.getElementById('close-notif-setup').addEventListener('click', closeNotifSetup);

    // AKTIFKAN NOTIF & KIRIM WA API
    document.getElementById('btn-notif-aktifkan').addEventListener('click', function() {
        const pesanFinal = textAreaPesan.value.trim();
        if(pesanFinal === "") { alert("Pesan tidak boleh kosong!"); return; }

        const btnAktif = this;
        btnAktif.innerHTML = 'Mengirim WA...';
        btnAktif.disabled = true;

        // Kirim request ke backend WA API
        fetch('/tancak-panti/api/wa_darurat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ pesan: pesanFinal })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                // Berhasil kirim, nyalakan Top Banner
                isNotifActive = true;
                activeMessage = pesanFinal;
                
                // Format Jam (HH.MM)
                const now = new Date();
                activeTime = String(now.getHours()).padStart(2, '0') + "." + String(now.getMinutes()).padStart(2, '0');
                
                // Update teks di Banner
                document.getElementById('banner-time').innerText = activeTime;
                document.getElementById('banner-count').innerText = data.dikirim_ke;
                document.getElementById('banner-text').innerText = activeMessage;
                
                // Munculkan Banner & Ganti tombol header (Jadi Merah Solid)
                topBanner.classList.remove('hidden');
                btnNotifHeader.className = "flex items-center gap-2 px-5 py-2.5 bg-[#ef4444] text-white rounded-[14px] text-[13px] font-bold shadow-md hover:bg-[#dc2626] transition-colors";
                textNotifHeader.innerText = "Notif Aktif";

                // Update teks di Modal Detail
                document.getElementById('detail-time').innerText = activeTime;
                document.getElementById('detail-count').innerText = data.dikirim_ke;
                document.getElementById('detail-pesan-teks').innerText = activeMessage;

                closeNotifSetup();
                alert(`Notif aktif! Berhasil mengirim pesan WA darurat ke ${data.dikirim_ke} wisatawan.`);
            } else {
                alert("Gagal mengaktifkan notif: " + data.msg);
            }
        })
        .catch(err => {
            alert("Terjadi kesalahan jaringan saat mengirim WA API.");
            console.error(err);
        })
        .finally(() => {
            btnAktif.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-3.14 8.167-7.221.054-.405.083-.812.083-1.221v0a4 4 0 01-4 4h-2a2 2 0 00-2 2v6a2 2 0 002 2h2a4 4 0 014 4v0c0-.41-.029-.816-.083-1.22-.542-4.08-4.067-7.22-8.167-7.22H7a4.001 4.001 0 01-1.564-.317z"/></svg> Aktifkan Notif';
            btnAktif.disabled = false;
        });
    });

    // FUNGSI BACA SELENGKAPNYA (Buka Modal Detail)
    document.getElementById('btn-baca-selengkapnya').addEventListener('click', function() {
        modalNotifDetail.classList.add('active');
    });

    // TUTUP MODAL DETAIL
    function closeNotifDetail() { modalNotifDetail.classList.remove('active'); }
    document.getElementById('btn-detail-keluar').addEventListener('click', closeNotifDetail);
    document.getElementById('close-notif-detail').addEventListener('click', closeNotifDetail);
});

// Tunggu sampai semua elemen HTML selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // LOGIKA PINDAH TABS DASHBOARD
    // ==========================================
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    if(tabButtons.length > 0) {
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');

                // 1. Hapus class 'active' dari semua tombol
                tabButtons.forEach(btn => btn.classList.remove('active'));
                
                // 2. Sembunyikan semua isi tab
                tabContents.forEach(content => content.classList.remove('active'));

                // 3. Tambahkan class 'active' ke tombol yang ditekan
                this.classList.add('active');

                // 4. Tampilkan isi tab yang sesuai dengan tombol
                const targetContent = document.getElementById(targetId);
                if(targetContent) {
                    targetContent.classList.add('active');
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // 1. RENDER DIAGRAM BATANG (STATUS WISATAWAN)
    // ==========================================
    const canvasStatus = document.getElementById('chartStatusWisatawan');
    if(canvasStatus) {
        const ctxStatus = canvasStatus.getContext('2d');
        new Chart(ctxStatus, {
            type: 'bar',
            data: {
                labels: ['Belum Check-in', 'Masih di Wisata', 'Sudah Pulang'],
                datasets: [{
                label: 'Jumlah Tiket',
                
                // GANTI ANGKA DUMMY DENGAN VARIABEL INI:
                data: [dataStatusBelum, dataStatusMasih, dataStatusPulang], 
                
                backgroundColor: [
                    'rgba(239, 68, 68, 0.85)', // Merah
                    'rgba(234, 179, 8, 0.85)',  // Kuning
                    'rgba(34, 197, 94, 0.85)'   // Hijau
                ],
                borderRadius: 8,
                barThickness: 35
            }]
            },
            options: {
                indexAxis: 'y', // KUNCI: Ini yang mengubah grafik tegak jadi menyamping (kiri ke kanan)
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false } // Sembunyikan tulisan legend karena sudah jelas
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f1f5f9' },
                        ticks: { stepSize: 1 } // Biar angkanya bulat (1, 2, 3 tiket)
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { weight: 'bold' } }
                    }
                }
            }
        });
    }

    // ==========================================
    // 2. RENDER DIAGRAM GARIS (TREN SAMPAH)
    // ==========================================
    const canvasSampah = document.getElementById('chartTrenSampah');
    if(canvasSampah) {
        const ctxSampah = canvasSampah.getContext('2d');
        
        // Bikin tanggal 1 sampai 31 secara otomatis (bisa diganti PHP)
        const labelTanggal = Array.from({length: 31}, (_, i) => i + 1);
        
        // Data jumlah item sampah per tanggal (Data Dummy)
        const dataSampah = [0, 2, 0, 0, 5, 1, 0, 0, 3, 0, 0, 0, 4, 2, 0, 0, 1, 0, 0, 0, 0, 6, 0, 0, 0, 0, 2, 0, 0, 0, 1];

        new Chart(ctxSampah, {
            type: 'line',
            data: {
                labels: labelTanggal,
                datasets: [{
                    label: 'Item Hilang',
                    data: dataSampah,
                    borderColor: '#ef4444', // Garis warna merah
                    backgroundColor: 'rgba(239, 68, 68, 0.1)', // Transparan merah untuk area bawah
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true, // KUNCI: Mewarnai area di bawah garis
                    tension: 0.4 // KUNCI: Membuat garisnya melengkung halus (smooth), tidak kaku/patah-patah
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return 'Tanggal ' + context[0].label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        title: { display: true, text: 'Tanggal di Bulan Ini', font: { size: 11, color: '#94a3b8' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f1f5f9' },
                        ticks: { stepSize: 1 },
                        title: { display: true, text: 'Kuantitas (Item)', font: { size: 11, color: '#94a3b8' } }
                    }
                }
            }
        });
    }

});

});