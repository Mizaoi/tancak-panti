document.addEventListener('DOMContentLoaded', function() {

    // ==========================================
    // 0. DEKLARASI SEMUA VARIABEL GLOBAL
    // ==========================================
    let prosesMenyimpan = 0; 
    const tbody = document.getElementById('wisatawan-tbody'); 
    
    // Variabel Modal Zoom
    const modalBukti = document.getElementById('modal-bukti');
    const imgFull = document.getElementById('img-bukti-full');

    // Variabel Filter Search (HANYA SEARCH, TANGGAL DIHAPUS)
    const searchInput = document.getElementById('main-search');

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
    // 1. LOGIKA PINDAH TABS PINTAR
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
                const urlParams = new URLSearchParams(window.location.search);
                const currentBulan = urlParams.get('bulan');
                
                let newUrl = '/tancak-panti/admin/dashboard?tab=' + targetId;
                if (currentBulan) newUrl += '&bulan=' + currentBulan;
                window.location.href = newUrl;
            });
        });
    }

    // ==========================================
    // 2. RENDER GRAFIK STATUS WISATAWAN 
    // ==========================================
    const canvasStatus = document.getElementById('chartStatusWisatawan');
    if (canvasStatus && typeof Chart !== 'undefined') {
        
        // --- SAKTI: HANCURKAN GRAFIK LAMA SEBELUM BIKIN BARU ---
        let chartStatusExist = Chart.getChart(canvasStatus);
        if (chartStatusExist) {
            chartStatusExist.destroy();
        }

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
                    borderRadius: 8, barThickness: 35
                }]
            },
            options: {
                indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { 
                        grid: { display: false, drawBorder: false }, 
                        beginAtZero: true, 
                        ticks: { 
                            precision: 0, 
                            font: { size: 11 }, 
                            color: '#6b7280' 
                        } 
                    },
                    y: { 
                        grid: { display: false, drawBorder: false }, 
                        ticks: { font: { weight: 'bold', size: 12 }, color: '#374151' } 
                    }
                }
            }
        });
    }

    // ==========================================
    // 3. RENDER GRAFIK TREN SAMPAH HARIAN
    // ==========================================
    const canvasLine = document.getElementById('lineChartSampah');
    if (canvasLine && typeof Chart !== 'undefined') {
        
        // --- SAKTI: HANCURKAN GRAFIK LAMA SEBELUM BIKIN BARU ---
        let chartLineExist = Chart.getChart(canvasLine);
        if (chartLineExist) {
            chartLineExist.destroy();
        }

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
                        pointBackgroundColor: '#3b82f6', 
                        borderWidth: 2, 
                        order: 2 
                    },
                    { 
                        label: 'Sampah Aman (Kembali)', 
                        data: window.dataSampahBawa.map((val, i) => Math.max(0, val - (window.dataSampahHilang[i] || 0))), 
                        borderColor: '#10b981', 
                        backgroundColor: 'rgba(16, 185, 129, 0.4)', 
                        fill: true, 
                        tension: 0.4, 
                        pointRadius: 0, 
                        pointBackgroundColor: '#10b981', 
                        borderWidth: 3, 
                        order: 1 
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'top', labels: { usePointStyle: true, font: { weight: 'bold', size: 12 } } },
                    tooltip: { 
                        mode: 'index', 
                        intersect: false,
                        itemSort: function(a, b) {
                            return a.datasetIndex - b.datasetIndex; 
                        },
                        backgroundColor: 'rgba(26, 51, 38, 0.95)', 
                        titleColor: '#ffffff',
                        bodyColor: '#e5e7eb',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13, weight: 'normal' },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false, 
                        callbacks: {
                            title: function(tooltipItems) {
                                return 'Tanggal ' + tooltipItems[0].label;
                            },
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return 'Sampah dibawa : ' + context.raw;
                                } else if (context.datasetIndex === 1) {
                                    return 'Sampah kembali : ' + context.raw;
                                }
                            }
                        }
                    } 
                },
                scales: {
                    x: { grid: { display: false }, title: { display: true, text: 'Tanggal di Bulan ' + (typeof window.namaBulanPilih !== 'undefined' ? window.namaBulanPilih : '') } },
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    }

    // ==========================================
    // 4. FILTER SEARCH & PAGINATION (25 BARIS)
    // ==========================================
    if(tbody && searchInput) {
        const allRows = Array.from(tbody.querySelectorAll('.row-tiket'));
        const rowsPerPage = 25; 
        let currentPage = 1;
        let filteredRows = [...allRows]; 

        // Hitung ulang 3 kotak besar (Belum Check-in, dll) sesuai pencarian
        function updateRealtimeCounts(rowsToCount) {
            let c0 = 0, c1 = 0, c2 = 0;
            rowsToCount.forEach(row => {
                const statusBtn = row.querySelector('.status-toggle');
                if (statusBtn) {
                    const state = parseInt(statusBtn.getAttribute('data-state'));
                    if (state === 0) c0++;
                    if (state === 1) c1++;
                    if (state === 2) c2++;
                }
            });
            
            if(document.getElementById('count-0')) document.getElementById('count-0').innerText = c0;
            if(document.getElementById('count-1')) document.getElementById('count-1').innerText = c1;
            if(document.getElementById('count-2')) document.getElementById('count-2').innerText = c2;

            if(window.chartStatusObj) {
                window.chartStatusObj.data.datasets[0].data = [c0, c1, c2];
                window.chartStatusObj.update(); 
            }
        }

        // Tampilkan tabel & Pagination (Batas 25 Baris)
        function renderPagination() {
            let totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if (totalPages === 0) totalPages = 1; // PAKSA MINIMAL 1 HALAMAN BIAR PAGINATION SELALU MUNCUL!
            
            const paginationControls = document.getElementById('pagination-controls');
            const pageInfo = document.getElementById('page-info');
            
            allRows.forEach(row => row.style.display = 'none'); // Sembunyikan semua dulu
            
            if (filteredRows.length === 0) {
                if(pageInfo) pageInfo.innerHTML = 'Menampilkan <span class="font-extrabold text-gray-800">0</span> tiket';
            } else {
                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex = Math.min(startIndex + rowsPerPage, filteredRows.length);
                
                // Munculkan hanya 25 baris di halaman ini
                for(let i = startIndex; i < endIndex; i++) {
                    filteredRows[i].style.display = '';
                }

                if(pageInfo) {
                    pageInfo.innerHTML = `Menampilkan <span class="font-extrabold text-gray-800">${startIndex + 1} - ${endIndex}</span> dari <span class="font-extrabold text-gray-800">${filteredRows.length}</span> tiket`;
                }
            }

            // Bikin Tombol Prev & Next UI Elegan
            if(paginationControls) {
                let html = '';
                const btnBase = "flex items-center justify-center px-3.5 py-1.5 rounded-[8px] text-[13px] font-bold transition-all duration-200 border outline-none";
                const btnDisabled = "text-gray-400 border-gray-100 bg-gray-50 cursor-not-allowed opacity-70";
                const btnActive = "text-gray-600 border-gray-200 bg-white hover:bg-gray-50 hover:text-[#1a3326] hover:border-[#1a3326] shadow-sm cursor-pointer";
                
                const isPrevDisabled = currentPage === 1;
                html += `<button type="button" onclick="goToPage(${currentPage - 1})" class="${btnBase} ${isPrevDisabled ? btnDisabled : btnActive}" ${isPrevDisabled ? 'disabled' : ''}><svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg> Prev</button>`;
                
                html += `<div class="flex items-center justify-center px-4 py-1.5 text-[13px] font-extrabold text-[#1a3326] bg-[#f4f9f6] rounded-[8px] border border-[#d1f4e0] shadow-sm min-w-[80px]">${currentPage} <span class="mx-1.5 text-[#1a3326] opacity-40 font-medium">/</span> ${totalPages}</div>`;
                
                const isNextDisabled = currentPage === totalPages;
                html += `<button type="button" onclick="goToPage(${currentPage + 1})" class="${btnBase} ${isNextDisabled ? btnDisabled : btnActive}" ${isNextDisabled ? 'disabled' : ''}>Next <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg></button>`;
                
                paginationControls.innerHTML = html;
            }
        }

        window.goToPage = function(page) {
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            if(page >= 1 && page <= totalPages) {
                currentPage = page;
                renderPagination();
            }
        };

        // Fungsi Otak Filter Lintas Pagination
        function applyFilters() {
            const keyword = searchInput.value.toLowerCase();

            // Saring SEMUA data, bukan cuma yang ada di layar
            filteredRows = allRows.filter(row => {
                const rowText = row.innerText.toLowerCase(); 
                return rowText.includes(keyword);
            });
            
            currentPage = 1; // Balik ke halaman 1 kalau abis nyari
            updateRealtimeCounts(filteredRows); 
            renderPagination();
        }

        searchInput.addEventListener('input', applyFilters);
        
        // JALANKAN OTOMATIS SAAT HALAMAN DIBUKA!
        applyFilters();
    }

    // ==========================================
    // 5. LOGIKA KLIK STATUS TIKET (AJAX)
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
    // 6. LOGIKA MODAL SAMPAH (AJAX)
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
    // 7. LOGIKA MODAL DENDA (AJAX)
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
    // 8. LOGIKA NOTIFIKASI DARURAT & WHATSAPP
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
    // 9. LOGIKA ZOOM FOTO BUKTI TRANSFER/ULASAN
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
    // 10. LOGIKA MODERASI ULASAN (ANTI-DUPLIKAT)
    // ==========================================
    const containerUlasan = document.getElementById('ulasan-container');
    const emptyUlasan = document.getElementById('ulasan-empty');
    const filterBtnsUlasan = document.querySelectorAll('.filter-btn-ulasan');

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

    function updateCardUI(card, status, isInitialLoad = false) {
        const oldStatus = card.getAttribute('data-status');
        card.setAttribute('data-status', status);
        
        const ribbon = card.querySelector('.status-ribbon');
        const actionContainer = card.querySelector('.action-buttons');
        const avatarCircle = card.querySelector('.avatar-circle');

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

    // ==========================================
    // 11. LOGIKA FILTER BULAN REKAP & GRAFIK (ANTI 404)
    // ==========================================
    const filterBulanRekap = document.getElementById('filter-bulan-rekap');
    if(filterBulanRekap) {
        filterBulanRekap.addEventListener('change', function() {
            // Tembak lurus ke Router tanpa ekstensi .php!
            window.location.href = '/tancak-panti/admin/dashboard?tab=tab-rekap&bulan=' + this.value;
        });
    }

// ==========================================
    // 12. LOGIKA MODAL ANGGOTA ROMBONGAN (AJAX)
    // ==========================================
    const modalAnggota = document.getElementById('modal-anggota');
    const anggotaList = document.getElementById('a-anggota-list');
    const modalKode = document.getElementById('a-modal-kode');
    const modalKetua = document.getElementById('a-modal-ketua');

    document.querySelectorAll('.btn-lihat-anggota').forEach(btn => {
        btn.addEventListener('click', function() {
            const idTiket = this.getAttribute('data-id');
            const namaKetua = this.getAttribute('data-nama');
            const kode = this.getAttribute('data-kode');

            // Set tulisan header dan ketua
            if(modalKode) modalKode.innerText = kode;
            if(modalKetua) modalKetua.innerText = namaKetua;
            
            if(modalAnggota) modalAnggota.classList.add('active');
            if(anggotaList) anggotaList.innerHTML = '<div class="py-4 text-gray-400 text-[12px]">Memuat data...</div>';

            // Ambil data anggota dari database
            fetch(`/tancak-panti/api/anggota.php?id=${idTiket}`)
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        if(data.data.length > 0) {
                            let html = '';
                            // Nampilin nama polos berjejer ke bawah rata tengah
                            data.data.forEach((nama) => {
                                html += `<div class="py-1 capitalize text-gray-700">${nama}</div>`;
                            });
                            anggotaList.innerHTML = html;
                        } else {
                            anggotaList.innerHTML = '<div class="py-2 text-gray-400 text-[13px] italic">Tidak ada anggota tambahan</div>';
                        }
                    } else {
                        anggotaList.innerHTML = '<div class="py-2 text-red-500 text-[12px]">Data tidak ditemukan.</div>';
                    }
                })
                .catch(() => {
                    if(anggotaList) anggotaList.innerHTML = '<div class="py-2 text-red-400 text-[12px]">Gagal memuat data jaringan!</div>';
                });
        });
    });

    function closeModalAnggota() {
        if(modalAnggota) modalAnggota.classList.remove('active');
    }
    
    if(document.getElementById('close-modal-anggota')) document.getElementById('close-modal-anggota').addEventListener('click', closeModalAnggota);
    if(document.getElementById('a-btn-tutup')) document.getElementById('a-btn-tutup').addEventListener('click', closeModalAnggota);
});