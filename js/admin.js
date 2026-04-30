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
        fetch('proses_update_status.php', {
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
    let currentTiketId = null;
    let trashData = []; 
    let currentBtn = null;

    document.querySelectorAll('.btn-kelola-sampah').forEach(btn => {
        btn.addEventListener('click', function() {
            currentBtn = this;
            currentTiketId = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const kode = this.getAttribute('data-kode');
            
            visitorInfo.innerText = `${nama} • ${kode}`;
            modalTrash.classList.add('active');
            trashList.innerHTML = '<div class="text-center py-6 text-gray-400 text-[12px]">Memuat data dari database...</div>';

            fetch(`api_sampah.php?action=get&id=${currentTiketId}`)
                .then(res => res.json())
                .then(data => {
                    trashData = data;
                    renderTrashList();
                }).catch(() => {
                    trashList.innerHTML = '<div class="text-center py-6 text-red-400 text-[12px]">Gagal memuat data!</div>';
                });
        });
    });

    // Tempelkan fungsi render, +/- dan hapus ke window agar bisa dipanggil dari HTML
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
                        <button onclick="updateQty(${index}, -1)" class="w-7 h-7 flex items-center justify-center bg-white border border-green-200 rounded-md text-green-700 font-bold hover:bg-green-50 transition-colors">−</button>
                        <span class="w-6 text-center font-extrabold text-[14px]">${item.jumlah}</span>
                        <button onclick="updateQty(${index}, 1)" class="w-7 h-7 flex items-center justify-center bg-white border border-green-200 rounded-md text-green-700 font-bold hover:bg-green-50 transition-colors">+</button>
                        <div class="w-px h-6 bg-green-200 mx-1"></div>
                        <button onclick="deleteItem(${index})" class="text-red-400 hover:text-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>`;
        });
    };

    window.updateQty = function(index, change) {
        if (trashData[index].jumlah + change >= 1) {
            trashData[index].jumlah += change;
            renderTrashList();
        }
    };

    window.deleteItem = function(index) {
        trashData.splice(index, 1);
        renderTrashList();
    };

    // Tombol Tambah Item Baru
    document.getElementById('m-btn-add').addEventListener('click', function() {
        let namaBaru = inputNew.value.trim();
        
        if (namaBaru !== '') {
            // FITUR BARU: Bikin huruf depan tiap kata jadi KAPITAL
            namaBaru = namaBaru.toLowerCase().split(' ').map(kata => kata.charAt(0).toUpperCase() + kata.slice(1)).join(' ');
            
            trashData.push({ nama_sampah: namaBaru, jumlah: 1 });
            inputNew.value = '';
            renderTrashList();
            setTimeout(() => { trashList.scrollTop = trashList.scrollHeight; }, 100);
        }
    });

    // Tombol Simpan ke Database
    document.getElementById('m-btn-save').addEventListener('click', function() {
        const btnSave = this;
        btnSave.innerHTML = 'Menyimpan...';
        btnSave.disabled = true;

        fetch('api_sampah.php?action=save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_tiket: currentTiketId, items: trashData })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                if(currentBtn) { currentBtn.querySelector('.total-item-teks').innerText = res.total_baru; }
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
    // 5. MODAL DENDA (PERSIAPAN)
    // ==========================================
    const modalDenda = document.getElementById('modal-denda');
    const dendaVisitorInfo = document.getElementById('d-visitor-info');

    document.querySelectorAll('.btn-kelola-denda').forEach(btn => {
        btn.addEventListener('click', function() {
            const nama = this.getAttribute('data-nama');
            const kode = this.getAttribute('data-kode');
            dendaVisitorInfo.innerText = `${nama} • ${kode}`;
            modalDenda.classList.add('active');
        });
    });

    function closeDenda() { modalDenda.classList.remove('active'); }
    document.getElementById('close-modal-denda').addEventListener('click', closeDenda);
    document.getElementById('d-btn-batal').addEventListener('click', closeDenda);

});