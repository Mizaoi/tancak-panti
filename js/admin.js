document.addEventListener('DOMContentLoaded', function() {

    // ==========================================
    // 0. DEKLARASI SEMUA VARIABEL GLOBAL
    // ==========================================
    let prosesMenyimpan = 0; 
    const tbody = document.getElementById('wisatawan-tbody'); 
    
    // Variabel Modal Zoom
    const modalBukti = document.getElementById('modal-bukti');
    const imgFull = document.getElementById('img-bukti-full');

    // Variabel Filter Search
    const searchInput = document.getElementById('main-search');
    const dateInput = document.getElementById('date-filter');

    // Variabel Modal Sampah
    const modalTrash = document.getElementById('modal-trash');
    const trashList = document.getElementById('m-trash-list');
    const visitorInfo = document.getElementById('m-visitor-info');
    const inputNew = document.getElementById('m-input-new');
    let trashTiketId = null;
    let trashData = []; 
    let currentTrashBtn = null;

    // Variabel Modal Denda
    const modalDenda = document.getElementById('modal-denda');
    const dendaList = document.getElementById('d-trash-list');
    const dendaVisitorInfo = document.getElementById('d-visitor-info');
    const elTotalRp = document.getElementById('d-total-rp');
    const elTotalHilang = document.getElementById('d-total-hilang');
    const elTotalCalc = document.getElementById('d-total-calc');
    let dendaTiketId = null;
    let dendaData = []; 

    // Variabel Notif Darurat
    const topBanner = document.getElementById('top-banner-notif');
    const btnNotifHeader = document.getElementById('btn-notif-header');
    const textNotifHeader = document.getElementById('text-notif-header');
    const modalNotifSetup = document.getElementById('modal-notif-setup');
    const modalNotifDetail = document.getElementById('modal-notif-detail');
    const textAreaPesan = document.getElementById('notif-pesan-teks');

    // ==========================================
    // 1. LOGIKA PINDAH TABS (REALTIME VIA URL)
    // ==========================================
    const tabButtons = document.querySelectorAll('.tab-btn');
    if(tabButtons.length > 0) {
        tabButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (prosesMenyimpan > 0) {
                    alert(`⏳ Tunggu sebentar Cak! Masih ada data yang sedang dikirim ke database.`);
                    return; 
                }
                const targetId = this.getAttribute('data-target');
                window.location.href = 'dashboard.php?tab=' + targetId;
            });
        });
    }

    // ==========================================
    // RENDER GRAFIK 1: STATUS WISATAWAN 
    // ==========================================
    const canvasStatus = document.getElementById('chartStatusWisatawan');
    if (canvasStatus && typeof Chart !== 'undefined') {
        window.chartStatusObj = new Chart(canvasStatus, {
            type: 'bar',
            data: {
                labels: ['Belum Check-in', 'Masih di Wisata', 'Sudah Pulang'],
                datasets: [{
                    label: 'Total Tiket',
                    data: [typeof valBelum !== 'undefined' ? valBelum : 0, 
                           typeof valMasih !== 'undefined' ? valMasih : 0, 
                           typeof valPulang !== 'undefined' ? valPulang : 0],
                    backgroundColor: ['#ef4444', '#f59e0b', '#10b981'], 
                    borderRadius: 8,
                    barThickness: 35 // Ketebalan balok pas
                }]
            },
            options: {
                indexAxis: 'y', // KEMBALIKAN GRAFIK JADI REBAHAN (Kiri ke Kanan)
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { 
                        // Sumbu X sekarang jadi Angka (Kiri ke Kanan)
                        grid: { display: false, drawBorder: false }, 
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11 }, color: '#6b7280' } 
                    },
                    y: { 
                        // Sumbu Y sekarang jadi Tulisan Label (Atas ke Bawah)
                        grid: { display: false, drawBorder: false }, 
                        ticks: { font: { weight: 'bold', size: 12 }, color: '#374151' } 
                    }
                },
                // 🚀 INI OBATNYA CAK: Tracking/Tooltip diarahkan ke Sumbu Y (Atas-Bawah)
                interaction: { mode: 'index', axis: 'y', intersect: false }
            }
        });
    }

// ==========================================
    // RENDER GRAFIK 2: AESTHETIC OVERLAP AREA (2 GARIS)
    // ==========================================
    const canvasLine = document.getElementById('lineChartSampah');
    if (canvasLine && typeof Chart !== 'undefined') {
        
        new Chart(canvasLine, {
            type: 'line', 
            data: {
                labels: window.labelGrafikSampah, 
                datasets: [
                    {
                        label: 'Total Sampah Bawa',
                        data: window.dataSampahBawa,
                        borderColor: '#3b82f6', 
                        backgroundColor: 'rgba(59, 130, 246, 0.1)', 
                        fill: true,
                        tension: 0.4, 
                        pointRadius: 0, 
                        borderWidth: 2,
                        order: 2 
                    },
                    {
                        label: 'Sampah Aman (Kembali)',
                        // Rumus anti-minus
                        data: window.dataSampahBawa.map((val, i) => Math.max(0, val - (window.dataSampahHilang[i] || 0))),
                        borderColor: '#10b981', 
                        backgroundColor: 'rgba(16, 185, 129, 0.4)', 
                        fill: true,
                        tension: 0.4, 
                        pointRadius: 4,
                        pointBackgroundColor: '#10b981',
                        borderWidth: 3,
                        order: 1 
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { 
                        position: 'top',
                        labels: { usePointStyle: true, font: { weight: 'bold', size: 12 } }
                    },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { 
                        grid: { display: false },
                        title: { display: true, text: 'Tanggal di Bulan ' + (typeof window.namaBulanPilih !== 'undefined' ? window.namaBulanPilih : '') }
                    },
                    y: { 
                        beginAtZero: true,
                        stacked: false, 
                        ticks: { stepSize: 1 }
                    }
                },
                interaction: { mode: 'nearest', axis: 'x', intersect: false }
            }
        });
    }

    // ==========================================
    // FILTER SEARCH & REALTIME COUNTER
    // ==========================================
    if(tbody && searchInput && dateInput) {
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
            
            if(document.getElementById('count-0')) document.getElementById('count-0').innerText = c0;
            if(document.getElementById('count-1')) document.getElementById('count-1').innerText = c1;
            if(document.getElementById('count-2')) document.getElementById('count-2').innerText = c2;

            // KUNCI 2: Perintahkan grafik untuk memuat data hasil filter yang baru
            if(window.chartStatusObj) {
                window.chartStatusObj.data.datasets[0].data = [c0, c1, c2];
                window.chartStatusObj.update(); // <-- Ini yang bikin grafik bergerak
            }
        }

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const selectedDate = dateInput.value;

            rows.forEach(row => {
                const rowText = row.innerText.toLowerCase(); 
                const rowDateEl = row.querySelector('.data-tgl');
                // Pakai .trim() untuk membuang spasi gaib
                const rowDate = rowDateEl ? rowDateEl.getAttribute('data-value').trim() : "";
                
                const matchKeyword = rowText.includes(keyword);
                // Karena tipe DATE, kita langsung pakai sama dengan (===)
                const matchDate = (selectedDate === '') || (rowDate === selectedDate);
                
                row.style.display = (matchKeyword && matchDate) ? '' : 'none';
            });
            updateRealtimeCounts(); // Panggil saat ngetik/pilih tanggal
        }

        searchInput.addEventListener('input', filterTable);
        dateInput.addEventListener('change', filterTable);
    }

    // ==========================================
    // 4. LOGIKA KLIK STATUS TIKET (AJAX)
    // ==========================================
    if(tbody) {
        tbody.addEventListener('click', async function(e) {
            const btn = e.target.closest('.status-toggle');
            if(!btn || btn.classList.contains('is-processing')) return;

            const config = {
                0: { class: 'bg-yellow-50 text-yellow-600 border-yellow-200', text: 'Masih di Wisata', enumText: 'Masih di Wisata', next: 1 },
                1: { class: 'bg-green-50 text-green-600 border-green-200', text: 'Sudah Pulang', enumText: 'Sudah Pulang', next: 2 },
                2: { class: 'bg-red-50 text-red-600 border-red-200', text: 'Belum Check-in', enumText: 'Belum Check-in', next: 0 }
            };

            let currentState = parseInt(btn.getAttribute('data-state'));
            let idTiket = btn.getAttribute('data-id');
            let nextData = config[currentState];

            btn.className = `status-toggle outline-none border px-2 py-1.5 rounded-full text-[10.5px] font-bold flex items-center justify-center gap-1 w-full max-w-[110px] mx-auto transition-colors is-processing ${nextData.class}`;
            btn.innerText = nextData.text;
            btn.setAttribute('data-state', nextData.next);
            
            const txtStatus = btn.closest('.data-status-text');
            if(txtStatus) txtStatus.setAttribute('data-text-status', nextData.text.toLowerCase());
            
            const countLama = document.getElementById('count-' + currentState);
            const countBaru = document.getElementById('count-' + nextData.next);
            if (countLama && countBaru) {
                countLama.innerText = parseInt(countLama.innerText) - 1;
                countBaru.innerText = parseInt(countBaru.innerText) + 1;
            }

            prosesMenyimpan++;
            try {
                const formData = new URLSearchParams();
                formData.append('id_tiket', idTiket);
                formData.append('status', nextData.enumText);

                await fetch('/tancak-panti/api/proses_update_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                });
            } catch (err) {
                console.error("Error DB:", err);
            } finally {
                prosesMenyimpan--;
                btn.classList.remove('is-processing');
            }
        });
    }

    // ==========================================
    // 5. LOGIKA MODAL OVERLAY SAMPAH
    // ==========================================
    document.querySelectorAll('.btn-kelola-sampah').forEach(btn => {
        btn.addEventListener('click', function() {
            currentTrashBtn = this;
            trashTiketId = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const kode = this.getAttribute('data-kode');
            
            if(visitorInfo) visitorInfo.innerText = `${nama} • ${kode}`;
            if(modalTrash) modalTrash.classList.add('active');
            if(trashList) trashList.innerHTML = '<div class="text-center py-6 text-gray-400 text-[12px]">Memuat data dari database...</div>';

            fetch(`/tancak-panti/api/sampah.php?action=get&id=${trashTiketId}`)
                .then(res => res.json())
                .then(data => { trashData = data; renderTrashList(); })
                .catch(() => { if(trashList) trashList.innerHTML = '<div class="text-center py-6 text-red-400 text-[12px]">Gagal memuat data!</div>'; });
        });
    });

    window.renderTrashList = function() {
        if(!trashList) return;
        trashList.innerHTML = '';
        if (trashData.length === 0) {
            trashList.innerHTML = '<div class="text-center py-6 text-gray-400 text-[12px] bg-gray-50 rounded-xl border border-dashed border-gray-200">Tidak ada sampah tercatat.</div>';
            return;
        }

        trashData.forEach((item, index) => {
            trashList.innerHTML += `
                <div class="flex items-center justify-between bg-[#f4fcf7] border border-[#d1f4e0] text-[#1a3326] rounded-[16px] px-4 py-3 shadow-sm mb-2">
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

    if(document.getElementById('m-btn-add')) {
        document.getElementById('m-btn-add').addEventListener('click', function() {
            let namaBaru = inputNew.value.trim();
            if (namaBaru !== '') {
                namaBaru = namaBaru.toLowerCase().split(' ').map(kata => kata.charAt(0).toUpperCase() + kata.slice(1)).join(' ');
                trashData.push({ nama_sampah: namaBaru, jumlah: 1 });
                inputNew.value = '';
                renderTrashList();
                setTimeout(() => { trashList.scrollTop = trashList.scrollHeight; }, 100);
            }
        });
    }

    if(document.getElementById('m-btn-save')) {
        document.getElementById('m-btn-save').addEventListener('click', function() {
            const btnSave = this;
            btnSave.innerHTML = 'Menyimpan...';
            btnSave.disabled = true;

            fetch('/tancak-panti/api/sampah.php?action=save', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
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
    }

    function closeModalSampah() {
        if(modalTrash) modalTrash.classList.remove('active');
        if(inputNew) inputNew.value = '';
    }
    if(document.getElementById('close-modal-trash')) document.getElementById('close-modal-trash').addEventListener('click', closeModalSampah);
    if(document.getElementById('m-btn-batal')) document.getElementById('m-btn-batal').addEventListener('click', closeModalSampah);

    // ==========================================
    // 6. LOGIKA MODAL OVERLAY DENDA
    // ==========================================
    document.querySelectorAll('.btn-kelola-denda').forEach(btn => {
        btn.addEventListener('click', function() {
            dendaTiketId = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const kode = this.getAttribute('data-kode');
            
            if(dendaVisitorInfo) dendaVisitorInfo.innerText = `${nama} • ${kode}`;
            if(modalDenda) modalDenda.classList.add('active');
            if(dendaList) dendaList.innerHTML = '<div class="text-center py-6 text-gray-400 text-[12px]">Memuat data dari database...</div>';

            fetch(`/tancak-panti/api/denda.php?action=get&id=${dendaTiketId}`)
                .then(res => res.json())
                .then(data => { dendaData = data; renderDendaList(); })
                .catch(() => { if(dendaList) dendaList.innerHTML = '<div class="text-center py-6 text-red-400 text-[12px]">Gagal memuat data!</div>'; });
        });
    });

    window.renderDendaList = function() {
        if(!dendaList) return;
        dendaList.innerHTML = '';
        let totalItemHilang = 0; let totalDendaRp = 0;

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
                <div class="flex items-center justify-between ${bgBox} border rounded-[16px] px-4 py-3 shadow-sm transition-colors mb-2">
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

        if(elTotalRp) elTotalRp.innerText = `Rp ${totalDendaRp.toLocaleString('id-ID')}`;
        if(elTotalHilang) elTotalHilang.innerText = `${totalItemHilang} item hilang`;
        if(elTotalCalc) elTotalCalc.innerText = `${totalItemHilang} × Rp 10.000`;
    };

    window.updateHilang = function(index, change) {
        let newHilang = dendaData[index].hilang + change;
        if (newHilang >= 0 && newHilang <= dendaData[index].bawa) {
            dendaData[index].hilang = newHilang;
            dendaData[index].kembali = dendaData[index].bawa - newHilang;
            renderDendaList();
        }
    };

    if(document.getElementById('d-btn-save')) {
        document.getElementById('d-btn-save').addEventListener('click', function() {
            const btnSave = this;
            btnSave.innerHTML = 'Menyimpan...';
            btnSave.disabled = true;

            const infoTeks = dendaVisitorInfo.innerText; 
            const namaSaja = infoTeks.split(' • ')[0]; 
            
            let grandTotalRp = 0;
            dendaData.forEach(item => { if(item.hilang > 0) grandTotalRp += (item.hilang * 10000); });

            fetch('/tancak-panti/api/denda.php?action=save', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id_tiket: dendaTiketId, nama_wisatawan: namaSaja, items: dendaData })
            })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
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
    }

    function closeModalDenda() { if(modalDenda) modalDenda.classList.remove('active'); }
    if(document.getElementById('close-modal-denda')) document.getElementById('close-modal-denda').addEventListener('click', closeModalDenda);
    if(document.getElementById('d-btn-batal')) document.getElementById('d-btn-batal').addEventListener('click', closeModalDenda);

    // ==========================================
    // 7. LOGIKA NOTIFIKASI DARURAT & WHATSAPP
    // ==========================================
    if(btnNotifHeader) {
        let isNotifActive = topBanner && !topBanner.classList.contains('hidden');

        const pesanTemplates = {
            hujan: "⚠️ PEMBERITAHUAN DARURAT: Akan terjadi hujan lebat di area wisata. Seluruh wisatawan yang masih berada di area Air Terjun Tancak dimohon untuk segera turun menuju pintu keluar dengan tertib. Jangan panik, ikuti arahan petugas.",
            badai: "⚠️ PEMBERITAHUAN DARURAT: Peringatan cuaca ekstrem dan badai. Segera jauhi area air terjun dan pepohonan besar. Berlindung di pos terdekat dan segera menuju pintu keluar dengan aman.",
            banjir: "⚠️ PEMBERITAHUAN DARURAT: Potensi banjir bandang atau longsor terdeteksi. SEGERA TINGGALKAN AREA AIR TERJUN dan naik ke dataran tinggi atau ikuti jalur evakuasi menuju pintu keluar sekarang juga!",
            kustom: ""
        };

        btnNotifHeader.addEventListener('click', function() {
            if (isNotifActive) {
                if(confirm("Matikan Notifikasi Darurat? Banner akan hilang dari semua halaman pengunjung.")) {
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
                const listContainer = document.getElementById('notif-target-list');
                const btnAktifkan = document.getElementById('btn-notif-aktifkan');
                
                listContainer.innerHTML = '<p class="text-center text-[11px] text-yellow-600 font-medium py-2">Memuat data dari database...</p>';
                modalNotifSetup.classList.add('active');

                fetch('/tancak-panti/api/notif_list.php')
                    .then(response => response.json())
                    .then(res => {
                        const countSpan = document.getElementById('notif-target-count');
                        if (res.status === 'success') {
                            countSpan.textContent = res.count;
                            if (res.count > 0) {
                                let html = '';
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
                                    </div>`;
                                });
                                listContainer.innerHTML = html;
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
                        listContainer.innerHTML = '<div class="text-red-500 text-center py-4 font-medium">Gagal memuat data!</div>';
                    });
            }
        });

        const btnJenis = document.querySelectorAll('.btn-jenis-notif');
        btnJenis.forEach(btn => {
            btn.addEventListener('click', function() {
                btnJenis.forEach(b => {
                    b.className = "btn-jenis-notif border-gray-200 text-gray-600 bg-white hover:bg-gray-50 border rounded-[12px] py-2.5 text-[13px] font-bold transition-all flex justify-center items-center gap-2";
                });
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

        function closeNotifSetup() { modalNotifSetup.classList.remove('active'); }
        if(document.getElementById('btn-notif-batal')) document.getElementById('btn-notif-batal').addEventListener('click', closeNotifSetup);
        if(document.getElementById('close-notif-setup')) document.getElementById('close-notif-setup').addEventListener('click', closeNotifSetup);

        if(document.getElementById('btn-notif-aktifkan')) {
            document.getElementById('btn-notif-aktifkan').addEventListener('click', function() {
                const pesanFinal = textAreaPesan.value.trim();
                if(pesanFinal === "") { alert("Pesan tidak boleh kosong!"); return; }

                const btnAktif = this;
                btnAktif.innerHTML = 'Mengirim WA...';
                btnAktif.disabled = true;

                fetch('/tancak-panti/api/wa_darurat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ pesan: pesanFinal })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        isNotifActive = true;
                        const now = new Date();
                        const activeTime = String(now.getHours()).padStart(2, '0') + "." + String(now.getMinutes()).padStart(2, '0');
                            
                        document.getElementById('banner-time').innerText = activeTime;
                        document.getElementById('banner-count').innerText = data.dikirim_ke;
                        document.getElementById('banner-text').innerText = pesanFinal;
                            
                        topBanner.classList.remove('hidden');
                        btnNotifHeader.className = "flex items-center gap-2 px-5 py-2.5 bg-[#ef4444] text-white rounded-[14px] text-[13px] font-bold shadow-md hover:bg-[#dc2626] transition-colors";
                        textNotifHeader.innerText = "Notif Aktif";

                        document.getElementById('detail-time').innerText = activeTime;
                        document.getElementById('detail-count').innerText = data.dikirim_ke;
                        document.getElementById('detail-pesan-teks').innerText = pesanFinal;

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
        }

        if(document.getElementById('btn-baca-selengkapnya')) {
            document.getElementById('btn-baca-selengkapnya').addEventListener('click', function() {
                modalNotifDetail.classList.add('active');
            });
        }

        function closeNotifDetail() { modalNotifDetail.classList.remove('active'); }
        if(document.getElementById('btn-detail-keluar')) document.getElementById('btn-detail-keluar').addEventListener('click', closeNotifDetail);
        if(document.getElementById('close-notif-detail')) document.getElementById('close-notif-detail').addEventListener('click', closeNotifDetail);
    }
    
    // ==========================================
    // 8. LOGIKA ZOOM FOTO (OVERLAY BESAR)
    // ==========================================
    if (tbody && modalBukti) {
        tbody.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-zoom-bukti');
            if (btn) {
                const src = btn.getAttribute('data-src');
                if (src && src !== "") {
                    imgFull.src = src;
                    modalBukti.classList.remove('hidden'); 
                    setTimeout(() => {
                        modalBukti.classList.add('active');
                        document.body.style.overflow = 'hidden'; 
                    }, 10);
                }
            }
        });
    }

    window.closeBukti = function() {
        if (modalBukti) {
            modalBukti.classList.remove('active');
            document.body.style.overflow = 'auto'; 
            setTimeout(() => {
                modalBukti.classList.add('hidden');
                imgFull.src = "";
            }, 300);
        }
    }

    // ==========================================
    // LOGIKA MODERASI ULASAN (REAL-TIME, 3 KONTAINER, WARNA TIPIS)
    // ==========================================
    const containerUlasan = document.getElementById('ulasan-container');
    const emptyUlasan = document.getElementById('ulasan-empty');
    const filterBtnsUlasan = document.querySelectorAll('.filter-btn-ulasan');

    // Sistem Pintar Lencana Notifikasi
    function updatePendingBadge(change) {
        const badge = document.getElementById('badge-pending');
        if (badge) {
            let current = parseInt(badge.innerText) || 0;
            current += change;
            if (current > 0) {
                badge.innerText = current;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    // FUNGSI AJAIB: Mengubah tampilan kartu seketika persis briefing terbaru
// FUNGSI AJAIB: Mengubah UI Kartu sesuai Desain Baru
    function updateCardUI(card, status, isInitialLoad = false) {
        const oldStatus = card.getAttribute('data-status');
        card.setAttribute('data-status', status);
        
        const ribbon = card.querySelector('.status-ribbon');
        const actionContainer = card.querySelector('.action-buttons');
        const avatarCircle = card.querySelector('.avatar-circle');

        // Reset Ribbon Classes
        ribbon.className = "status-ribbon px-4 py-2.5 flex items-center justify-between text-[11px] font-extrabold uppercase tracking-widest border-b transition-colors duration-300";

        if (status === 'pending') {
            ribbon.classList.add('bg-amber-50', 'text-amber-700', 'border-amber-100');
            ribbon.innerHTML = `<span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Menunggu</span>`;
            if(avatarCircle) avatarCircle.className = "avatar-circle w-9 h-9 rounded-full bg-[#1a3326] text-white flex items-center justify-center font-extrabold text-[13px] shrink-0 transition-colors duration-300";

            actionContainer.innerHTML = `
                <button class="btn-aksi-ulasan flex-1 flex items-center justify-center gap-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-[12px] py-2.5 rounded-xl font-extrabold transition-colors" data-action="Setuju">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg> Setujui
                </button>
                <button class="btn-aksi-ulasan flex-1 flex items-center justify-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-[12px] py-2.5 rounded-xl font-extrabold transition-colors" data-action="Tolak">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m4.9 4.9 14.2 14.2"></path></svg> Tolak
                </button>
                <button class="btn-aksi-ulasan w-10 flex items-center justify-center bg-gray-50 border border-gray-100 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-xl transition-colors" data-action="Hapus" title="Hapus Permanen">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                </button>
            `;
        } else if (status === 'setuju') {
            ribbon.classList.add('bg-green-50', 'text-green-700', 'border-green-100');
            ribbon.innerHTML = `<span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Disetujui</span>`;
            if(avatarCircle) avatarCircle.className = "avatar-circle w-9 h-9 rounded-full bg-[#10b981] text-white flex items-center justify-center font-extrabold text-[13px] shrink-0 transition-colors duration-300";

            actionContainer.innerHTML = `
                <button class="btn-aksi-ulasan flex-1 flex items-center justify-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-[12px] py-2.5 rounded-xl font-extrabold transition-colors" data-action="Tolak">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m4.9 4.9 14.2 14.2"></path></svg> Tolak
                </button>
            `;
            if(!isInitialLoad && oldStatus === 'pending') updatePendingBadge(-1);
        } else if (status === 'tolak') {
            ribbon.classList.add('bg-red-50', 'text-red-700', 'border-red-100');
            ribbon.innerHTML = `<span class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg> Ditolak</span>`;
            if(avatarCircle) avatarCircle.className = "avatar-circle w-9 h-9 rounded-full bg-gray-400 text-white flex items-center justify-center font-extrabold text-[13px] shrink-0 transition-colors duration-300";

            actionContainer.innerHTML = `
                <button class="btn-aksi-ulasan flex-1 flex items-center justify-center gap-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-[12px] py-2.5 rounded-xl font-extrabold transition-colors" data-action="Setuju">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg> Setujui
                </button>
                    <button class="btn-aksi-ulasan w-10 flex items-center justify-center bg-gray-50 border border-gray-100 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-xl transition-colors" data-action="Hapus" title="Hapus Permanen">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                </button>
            `;
            if(!isInitialLoad && oldStatus === 'pending') updatePendingBadge(-1);
        }
    }

    if (containerUlasan) {
        containerUlasan.querySelectorAll('.ulasan-card').forEach(card => {
            updateCardUI(card, card.getAttribute('data-status'), true);
        });
    }

    function filterUlasanCards(statusFilter) {
        const cards = document.querySelectorAll('.ulasan-card');
        let visibleCount = 0;
        cards.forEach(card => {
            if (statusFilter === 'semua' || card.getAttribute('data-status') === statusFilter) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        if (emptyUlasan) {
            visibleCount === 0 ? emptyUlasan.classList.remove('hidden') : emptyUlasan.classList.add('hidden');
            visibleCount === 0 ? emptyUlasan.classList.add('flex') : emptyUlasan.classList.remove('flex');
        }
    }

    if (filterBtnsUlasan.length > 0) {
        filterBtnsUlasan.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtnsUlasan.forEach(b => b.className = `filter-btn-ulasan py-2 rounded-lg font-bold text-[12px] transition-all shadow-sm ${b.getAttribute('data-inactive')}`);
                this.className = `filter-btn-ulasan py-2 rounded-lg font-bold text-[12px] transition-all shadow-sm ${this.getAttribute('data-active')}`;
                filterUlasanCards(this.getAttribute('data-status'));
            });
        });
        setTimeout(() => filterBtnsUlasan[0].click(), 50);
    }

    // Klik tombol AKSI secara Real-time
    if (containerUlasan) {
        containerUlasan.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-aksi-ulasan');
            if (btn) {
                const action = btn.getAttribute('data-action');
                const card = btn.closest('.ulasan-card');
                const idUlasan = card.getAttribute('data-id');
                const currentStatus = card.getAttribute('data-status');

                if (action === 'Hapus' && !confirm("Yakin hapus ulasan ini permanen?")) return;

                const teksAsli = btn.innerText;
                btn.innerText = "⏳...";
                btn.disabled = true;

                const fd = new URLSearchParams();
                fd.append('id_ulasan', idUlasan);
                fd.append('action', action);

                fetch('/tancak-panti/api/proses_ulasan.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: fd.toString()
                }).then(() => {
                    if (action === 'Hapus') {
                        card.remove(); 
                        if(currentStatus === 'pending') updatePendingBadge(-1);
                    } else {
                        updateCardUI(card, action.toLowerCase(), false); 
                    }
                    
                    const activeFilterBtn = document.querySelector('#filter-ulasan .text-white');
                    if(activeFilterBtn) filterUlasanCards(activeFilterBtn.getAttribute('data-status'));
                }).catch(err => {
                    console.error(err);
                    btn.innerText = teksAsli;
                    btn.disabled = false;
                });
            }
        });
    }

    // Eksekusi tampilan awal saat web dibuka
    if (containerUlasan) {
        containerUlasan.querySelectorAll('.ulasan-card').forEach(card => {
            updateCardUI(card, card.getAttribute('data-status'));
        });
    }

    // Fungsi Filter Real-Time
    function filterUlasanCards(statusFilter) {
        const cards = document.querySelectorAll('.ulasan-card');
        let visibleCount = 0;
        cards.forEach(card => {
            if (statusFilter === 'semua' || card.getAttribute('data-status') === statusFilter) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        if (emptyUlasan) {
            visibleCount === 0 ? emptyUlasan.classList.remove('hidden') : emptyUlasan.classList.add('hidden');
            visibleCount === 0 ? emptyUlasan.classList.add('flex') : emptyUlasan.classList.remove('flex');
        }
    }

    // Klik tombol filter (Ganti Warna & Filter Data)
    if (filterBtnsUlasan.length > 0) {
        filterBtnsUlasan.forEach(btn => {
            btn.addEventListener('click', function() {
                // Matikan semua tombol
                filterBtnsUlasan.forEach(b => b.className = `filter-btn-ulasan py-2 rounded-lg font-bold text-[12px] transition-all shadow-sm ${b.getAttribute('data-inactive')}`);
                // Hidupkan tombol yang diklik dengan warna khasnya
                this.className = `filter-btn-ulasan py-2 rounded-lg font-bold text-[12px] transition-all shadow-sm ${this.getAttribute('data-active')}`;
                // Terapkan filter
                filterUlasanCards(this.getAttribute('data-status'));
            });
        });
        // Klik 'Semua' secara otomatis di awal
        setTimeout(() => filterBtnsUlasan[0].click(), 50);
    }

    // Klik tombol AKSI (Setuju/Tolak/Hapus) - REALTIME
    if (containerUlasan) {
        containerUlasan.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-aksi-ulasan');
            if (btn) {
                const action = btn.getAttribute('data-action');
                const card = btn.closest('.ulasan-card');
                const idUlasan = card.getAttribute('data-id');

                if (action === 'Hapus' && !confirm("Yakin hapus ulasan ini permanen?")) return;

                // Tampilkan efek loading sebentar pada tombol
                const teksAsli = btn.innerText;
                btn.innerText = "⏳...";
                btn.disabled = true;

                // 1. UPDATE DATABASE VIA AJAX
                const fd = new URLSearchParams();
                fd.append('id_ulasan', idUlasan);
                fd.append('action', action);

                fetch('/tancak-panti/api/proses_ulasan.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: fd.toString()
                }).then(() => {
                    // 2. UPDATE TAMPILAN KARTU SEKETIKA (TANPA RELOAD)
                    if (action === 'Hapus') {
                        card.remove(); // Lenyapkan dari muka bumi
                    } else {
                        updateCardUI(card, action.toLowerCase()); // Ubah jadi setuju/tolak
                    }
                    
                    // 3. RAPUKAN FILTERNYA KEMBALI
                    const activeFilterBtn = document.querySelector('#filter-ulasan .text-white');
                    if(activeFilterBtn) filterUlasanCards(activeFilterBtn.getAttribute('data-status'));
                }).catch(err => {
                    console.error(err);
                    btn.innerText = teksAsli;
                    btn.disabled = false;
                });
            }
        });
    }
    // ==========================================
    // LOGIKA FILTER BULAN REKAP & GRAFIK
    // ==========================================
    const filterBulanRekap = document.getElementById('filter-bulan-rekap');
    if(filterBulanRekap) {
        filterBulanRekap.addEventListener('change', function() {
            // Reload halaman, arahkan ke Tab Rekap, dan bawa nilai bulannya ke PHP!
            window.location.href = 'dashboard.php?tab=tab-rekap&bulan=' + this.value;
        });
    }
});
