<?php
include 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: /tancak-panti/admin/login");
    exit;
}

$selected_month = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
$nama_bulan = date('F Y', strtotime($selected_month . '-01'));
$harga_tiket = 5000;

// ==========================================
// KUMPULKAN DATA GRAFIK (FULL 1 BULAN BIAR SAMA KAYA WEB)
// ==========================================
$tahun_pilih = date('Y', strtotime($selected_month . "-01"));
$bulan_pilih = date('m', strtotime($selected_month . "-01"));
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan_pilih, $tahun_pilih);

$query_agregat = mysqli_query($koneksi, "
    SELECT 
        t.tanggal_kunjungan,
        SUM(t.orang) as total_pengunjung,
        SUM(t.orang * $harga_tiket) as pendapatan_tiket,
        (SELECT IFNULL(SUM(jumlah), 0) FROM sampah s WHERE s.id_tiket IN (SELECT id_tiket FROM tiket WHERE tanggal_kunjungan = t.tanggal_kunjungan)) as bawa,
        (SELECT IFNULL(SUM(jumlah_hilang), 0) FROM denda d WHERE d.id_tiket IN (SELECT id_tiket FROM tiket WHERE tanggal_kunjungan = t.tanggal_kunjungan)) as hilang,
        (SELECT IFNULL(SUM(total_denda), 0) FROM denda d WHERE d.id_tiket IN (SELECT id_tiket FROM tiket WHERE tanggal_kunjungan = t.tanggal_kunjungan)) as pendapatan_denda
    FROM tiket t
    WHERE t.tanggal_kunjungan LIKE '$selected_month%'
    GROUP BY t.tanggal_kunjungan
");

$data_db = [];
while($row = mysqli_fetch_assoc($query_agregat)) {
    $data_db[$row['tanggal_kunjungan']] = $row;
}

$labels = []; $data_wisatawan = []; $data_bawa = []; $data_aman = [];
$total_uang_tiket = 0; $total_uang_denda = 0; $total_orang = 0;

// Looping 1 sampai 30/31 agar grafiknya landai (TIDAK TERPUTUS)
for($d = 1; $d <= $jumlah_hari; $d++) {
    $tgl_cek = $selected_month . "-" . str_pad($d, 2, '0', STR_PAD_LEFT);
    $labels[] = $d; // Angka tanggal
    
    if(isset($data_db[$tgl_cek])) {
        $r = $data_db[$tgl_cek];
        $data_wisatawan[] = (int)$r['total_pengunjung'];
        
        $bawa = (int)$r['bawa'];
        $hilang = (int)$r['hilang'];
        
        $data_bawa[] = $bawa;
        // JURUS ANTI MINUS: Memastikan hasilnya minimal 0
        $data_aman[] = max(0, $bawa - $hilang);
        
        $total_uang_tiket += (int)$r['pendapatan_tiket'];
        $total_uang_denda += (int)$r['pendapatan_denda'];
        $total_orang += (int)$r['total_pengunjung'];
    } else {
        // Kalau kosong di hari itu, kasih 0
        $data_wisatawan[] = 0;
        $data_bawa[] = 0;
        $data_aman[] = 0;
    }
}
$grand_total_pendapatan = $total_uang_tiket + $total_uang_denda;

// ==========================================
// KUMPULKAN DATA UNTUK BAGIAN 2 & 3
// ==========================================
$query_wisatawan = mysqli_query($koneksi, "SELECT * FROM tiket WHERE tanggal_kunjungan LIKE '$selected_month%' ORDER BY tanggal_kunjungan ASC");

// HAPUS d.keterangan KARENA MEMANG TIDAK ADA DI DATABASE
$query_sampah_hilang = mysqli_query($koneksi, "
    SELECT 
        t.tanggal_kunjungan, 
        t.kode_tiket, 
        t.nama, 
        d.jumlah_hilang, 
        d.total_denda
    FROM denda d
    JOIN tiket t ON d.id_tiket = t.id_tiket
    WHERE t.tanggal_kunjungan LIKE '$selected_month%' AND d.jumlah_hilang > 0
    ORDER BY t.tanggal_kunjungan ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan <?= $nama_bulan ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @page { size: A4; margin: 15mm; }
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 10pt; color: #333; margin: 0; padding: 0; }
        
        .btn-print { position: fixed; top: 15px; right: 15px; background: #1b3d2f; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; z-index: 1000; }
        @media print { .btn-print { display: none; } }

        .page-section { page-break-after: always; padding-top: 10px; }
        .page-section:last-child { page-break-after: auto; }

        .section-title { background: #1b3d2f; color: white; padding: 8px 12px; font-weight: bold; margin: 0 0 20px 0; border-radius: 4px; }

        .summary-cards { display: flex; gap: 15px; margin-bottom: 30px; }
        .card { flex: 1; background: #f8fdfa; border: 1px solid #cde4d7; border-radius: 6px; padding: 15px; text-align: center; }
        .card h3 { margin: 0; font-size: 10pt; color: #666; font-weight: normal; }
        .card p { margin: 8px 0 0; font-size: 16pt; font-weight: bold; color: #1b3d2f; }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
/* KOP SURAT RESMI (BG PUTIH) */
        .kop-surat-resmi {
            display: flex;
            align-items: center;
            background: #ffffff;
            padding: 0 0 20px 0;
            margin-bottom: 30px;
            border-bottom: 4px solid #1b3d2f;
            position: relative;
        }

        /* 1. BAGIAN LOGO (DARI NAVBAR) */
        .brand-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-right: 25px;
        }
        .brand-logo-circle {
            border: 2px solid #1b3d2f; /* Border pengganti white/50 */
            border-radius: 50%;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .brand-logo-circle svg {
            width: 32px; /* Sedikit dibesarkan dari navbar biar pas di kertas */
            height: 32px;
            stroke: #1b3d2f; /* Warna SVG disamakan dengan tema hijau */
        }
        .brand-text {
            display: flex;
            flex-direction: column;
            color: #1b3d2f;
        }
        .brand-text-top {
            font-size: 11pt;
            letter-spacing: 1px;
            line-height: 1;
            text-transform: uppercase;
        }
        .brand-text-bottom {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: -0.5px;
            line-height: 1;
            text-transform: uppercase;
        }

        /* 2. BAGIAN TEKS ALAMAT (TENGAH) */
        .kop-teks {
            flex: 1;
            border-left: 2px solid #1b3d2f; /* Garis estetik pemisah logo & alamat */
            padding-left: 20px;
        }
        .kop-teks h1 {
            margin: 0;
            font-size: 18pt;
            font-weight: 900;
            color: #1b3d2f;
            text-transform: uppercase;
        }
        .kop-teks p {
            margin: 5px 0 0 0;
            font-size: 10.5pt;
            color: #333;
        }
        .kop-teks .kontak {
            font-size: 9.5pt;
            color: #666;
            margin-top: 3px;
        }

        /* 3. INFO PERIODE (KANAN) */
        .kop-meta {
            text-align: right;
            font-size: 10pt;
            color: #666;
        }
        .kop-meta strong {
            display: block;
            color: #1b3d2f;
            font-size: 12pt;
            margin-top: 3px;
        }

        .charts-wrapper { display: flex; flex-direction: column; gap: 30px; }
        .chart-box { border: 1px solid #eaeaea; border-radius: 6px; padding: 15px; height: 280px; }

        table { width: 100%; border-collapse: collapse; font-size: 9.5pt; margin-bottom: 20px;}
        table th { background: #e3efe8; color: #1b3d2f; padding: 10px; border: 1px solid #cde4d7; }
        table td { padding: 8px 10px; border: 1px solid #eaeaea; }
        table tr:nth-child(even) { background-color: #fafafa; }
        .text-center { text-align: center; } .text-right { text-align: right; }

        .ttd-box { width: 250px; float: right; text-align: center; margin-top: 40px; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">🖨️ Cetak A4</button>

<div class="page-section">
        <div class="kop-surat-resmi">
            
            <div class="brand-container">
                <div class="brand-logo-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1b3d2f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 6c.6.5 1.2 1 2.5 1C5.8 7 7 6 7 6s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/>
                        <path d="M2 12c.6.5 1.2 1 2.5 1 1.3 0 2.5-1 2.5-1s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/>
                        <path d="M2 18c.6.5 1.2 1 2.5 1 1.3 0 2.5-1 2.5-1s1.2-1 2.5-1c1.3 0 2.5 1 2.5 1s1.2 1 2.5 1c1.3 0 2.5-1 2.5-1s1.2-1 2.5-1 2.5 1 2.5 1"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <span class="brand-text-top">Air Terjun</span>
                    <span class="brand-text-bottom">TANCAK</span>
                </div>
            </div>
            
            <div class="kop-teks">
                <h1>Wisata Air Terjun Tancak</h1>
                <p>Desa Gumukmas, Kecamatan Panti, Kabupaten Jember, Jawa Timur</p>
                <p class="kontak">Pengelola Wisata Alam Tancak Panti &middot; Kontak: (0331) 123-456</p>
            </div>

            <div class="kop-meta">
                Periode Cetak:<br>
                <strong><?= $nama_bulan ?></strong>
            </div>

        </div>
        <div class="section-title">BAGIAN 1: RINGKASAN KEUANGAN & GRAFIK TREN</div>
        
        <div class="summary-cards">
            <div class="card">
                <h3>Total Pengunjung</h3>
                <p><?= number_format($total_orang) ?> Org</p>
            </div>
            <div class="card">
                <h3>Pendapatan Tiket</h3>
                <p>Rp <?= number_format($total_uang_tiket) ?></p>
            </div>
            <div class="card">
                <h3>Pendapatan Denda</h3>
                <p style="color: #ef4444;">Rp <?= number_format($total_uang_denda) ?></p>
            </div>
            <div class="card" style="background: #1b3d2f; color: white;">
                <h3 style="color: #cde4d7;">GRAND TOTAL</h3>
                <p style="color: white;">Rp <?= number_format($grand_total_pendapatan) ?></p>
            </div>
        </div>

        <div class="charts-wrapper">
            <div class="chart-box">
                <canvas id="chartSampah"></canvas>
            </div>
            <div class="chart-box" style="height: 220px;">
                <canvas id="chartWisatawan"></canvas>
            </div>
        </div>
    </div>

    <div class="page-section">
        <div class="section-title">BAGIAN 2: RINCIAN DATA KUNJUNGAN WISATAWAN</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="15%">Kode Tiket</th>
                    <th width="25%">Nama Lengkap</th>
                    <th width="30%">Alamat</th>
                    <th width="10%">Orang</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($query_wisatawan) > 0) {
                    while($w = mysqli_fetch_assoc($query_wisatawan)): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= date('d-m-Y', strtotime($w['tanggal_kunjungan'])) ?></td>
                        <td class="text-center"><strong><?= $w['kode_tiket'] ?></strong></td>
                        <td><?= htmlspecialchars($w['nama']) ?></td>
                        <td><?= htmlspecialchars($w['alamat']) ?></td>
                        <td class="text-center"><?= $w['orang'] ?> Org</td>
                    </tr>
                    <?php endwhile; 
                } else {
                    echo '<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="page-section">
        <div class="section-title">BAGIAN 3: RINCIAN PELANGGARAN SAMPAH (TIDAK KEMBALI)</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Kode Tiket</th>
                    <th width="30%">Nama Pelanggar</th>
                    <th width="15%">Jumlah Item Hilang</th>
                    <th width="15%">Denda Dibayar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no2 = 1;
                if (mysqli_num_rows($query_sampah_hilang) > 0) {
                    while($s = mysqli_fetch_assoc($query_sampah_hilang)): ?>
                    <tr>
                        <td class="text-center"><?= $no2++ ?></td>
                        <td class="text-center"><?= date('d-m-Y', strtotime($s['tanggal_kunjungan'])) ?></td>
                        <td class="text-center"><strong><?= $s['kode_tiket'] ?></strong></td>
                        <td><?= htmlspecialchars($s['nama']) ?></td>
                        <td class="text-center" style="color: #ef4444; font-weight: bold;"><?= $s['jumlah_hilang'] ?> Item</td>
                        <td class="text-right">Rp <?= number_format($s['total_denda']) ?></td>
                    </tr>
                    <?php endwhile;
                } else {
                    echo '<tr><td colspan="6" class="text-center" style="font-weight:bold;">Tidak ada sampah yang hilang bulan ini.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <div class="ttd-box clearfix">
            <p>Jember, <?= date('d F Y') ?></p>
            <p>Mengetahui,<br><strong>Admin Operasional</strong></p>
            <div style="height: 80px;"></div>
            <p style="text-decoration: underline; font-weight: bold;">( .................................................. )</p>
        </div>
    </div>

    <script>
        const namaBulanPilih = "<?= date('F Y', strtotime($selected_month.'-01')) ?>";
        const fontConfig = { size: 10, family: "'Helvetica Neue', Helvetica, Arial, sans-serif" };

        new Chart(document.getElementById('chartSampah'), {
            type: 'line',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [
                    {
                        label: 'Total Sampah Bawa',
                        data: <?= json_encode($data_bawa) ?>,
                        borderColor: '#3b82f6', 
                        backgroundColor: 'rgba(59, 130, 246, 0.1)', 
                        fill: true, tension: 0.4, pointRadius: 0, borderWidth: 2, order: 2
                    },
                    {
                        label: 'Sampah Aman (Kembali)',
                        data: <?= json_encode($data_aman) ?>,
                        borderColor: '#10b981', 
                        backgroundColor: 'rgba(16, 185, 129, 0.4)', 
                        fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#10b981', borderWidth: 3, order: 1
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'top', labels: { usePointStyle: true, font: { weight: 'bold', size: 11 } } },
                    title: { display: true, text: 'TREN PENGELOLAAN SAMPAH', font: { size: 12, weight: 'bold' } }
                },
                scales: { 
                    y: { beginAtZero: true, stacked: false, ticks: { font: fontConfig, stepSize: 1 } }, 
                    x: { grid: { display: false }, title: { display: true, text: 'Tanggal (' + namaBulanPilih + ')', font: fontConfig }, ticks: { font: fontConfig } } 
                }
            }
        });

        new Chart(document.getElementById('chartWisatawan'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Pengunjung (Orang)',
                    data: <?= json_encode($data_wisatawan) ?>,
                    backgroundColor: '#1b3d2f', borderRadius: 4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { 
                    legend: { display: true, position: 'top', labels: { font: fontConfig } },
                    title: { display: true, text: 'TREN KUNJUNGAN WISATAWAN', font: { size: 12, weight: 'bold' } }
                },
                scales: { 
                    y: { beginAtZero: true, ticks: { font: fontConfig, stepSize: 1 } }, 
                    x: { grid: { display: false }, ticks: { font: fontConfig } } 
                }
            }
        });
    </script>
</body>
</html>