<?php
session_start();
include '../../config/koneksi.php';

// Proteksi Halaman Admin
if (!isset($_SESSION['login_status'])) {
    header("Location: ../login.php");
    exit;
}

$count_0 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_tiket WHERE status = 0"))['total'];
$count_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_tiket WHERE status = 1"))['total'];
$count_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_tiket WHERE status = 2"))['total'];

$query = mysqli_query($koneksi, "SELECT * FROM tb_tiket ORDER BY id_tiket DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SI-TANCAK PANTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../style/admin.css">
    <style>
        .overlay-modal { position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 999; opacity: 0; visibility: hidden; transition: all 0.3s ease; }
        .overlay-modal.active { opacity: 1; visibility: visible; }
        .modal-card { transform: scale(0.8); transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .overlay-modal.active .modal-card { transform: scale(1); }
        .table-fixed-layout { table-layout: fixed; width: 100%; min-width: 1250px; }
        .truncate-text { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-[#eff3f0] font-[Poppins] flex flex-col min-h-screen">

    <main class="flex-1 pt-12 pb-12 px-6 lg:px-8 max-w-[1440px] mx-auto w-full">
        
        <div class="bg-white rounded-[20px] p-5 flex justify-between items-center shadow-sm mb-4">
            <div>
                <h1 class="text-[24px] font-extrabold text-[#1a3326]">Dashboard Admin</h1>
                <p class="text-gray-400 text-[13px]">Halo, <?= $_SESSION['username']; ?></p>
            </div>
            <a href="logout.php" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-[12px] text-[12px] font-bold">Keluar</a>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div id="filter-0" class="stat-card-filter cursor-pointer bg-[#fef2f2] rounded-[16px] p-5 text-center border border-red-100" data-filter="0">
                <div class="text-red-500 font-bold text-[13px] mb-1">✕ Belum Check-in</div>
                <div id="count-0" class="text-red-600 text-[32px] font-extrabold"><?= $count_0 ?></div>
            </div>
            <div id="filter-1" class="stat-card-filter cursor-pointer bg-[#fefce8] rounded-[16px] p-5 text-center border border-yellow-100" data-filter="1">
                <div class="text-yellow-600 font-bold text-[13px] mb-1">! Masih di Wisata</div>
                <div id="count-1" class="text-yellow-600 text-[32px] font-extrabold"><?= $count_1 ?></div>
            </div>
            <div id="filter-2" class="stat-card-filter cursor-pointer bg-[#f0fdf4] rounded-[16px] p-5 text-center border border-green-100" data-filter="2">
                <div class="text-green-500 font-bold text-[13px] mb-1">✓ Sudah Pulang</div>
                <div id="count-2" class="text-green-500 text-[32px] font-extrabold"><?= $count_2 ?></div>
            </div>
        </div>

        <div class="bg-white rounded-[16px] p-2 pl-4 flex items-center shadow-sm mb-6 border border-gray-100 relative">
            <input type="text" id="main-search" placeholder="Cari nama, alamat..." class="w-full text-[13px] outline-none py-2 bg-transparent font-medium">
            <button id="clear-search" class="hidden absolute right-40 p-1 text-gray-400 hover:text-red-500">✕</button>
            <div class="flex items-center border-l border-gray-200 pl-4 ml-4">
                <input type="date" id="date-filter" class="bg-gray-50 border border-gray-200 rounded-[8px] px-3 py-1.5 text-[12px] outline-none">
            </div>
        </div>

        <div class="bg-white rounded-[12px] shadow-sm overflow-x-auto no-scrollbar">
            <table class="table-fixed-layout text-left border-collapse">
                <thead class="bg-[#1a3326] text-white">
                    <tr>
                        <th class="w-[120px] p-4 text-[11px] uppercase">Tanggal</th>
                        <th class="w-[85px] p-4 text-[11px] uppercase">ID</th>
                        <th class="w-[160px] p-4 text-[11px] uppercase">Nama</th>
                        <th class="w-[140px] p-4 text-[11px] uppercase">Alamat</th>
                        <th class="w-[70px] p-4 text-[11px] uppercase text-center">Orang</th>
                        <th class="w-[130px] p-4 text-[11px] uppercase">Telepon 1</th>
                        <th class="w-[85px] p-4 text-[11px] uppercase text-center">Sampah</th>
                        <th class="w-[180px] p-4 text-[11px] uppercase text-center">Status</th>
                    </tr>
                </thead>
                <tbody id="wisatawan-tbody">
                    <?php while($row = mysqli_fetch_assoc($query)): 
                        $id_tk = $row['id_tiket'];
                        $res_s = mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM tb_sampah_bawaan WHERE id_tiket = $id_tk");
                        $total_s = mysqli_fetch_assoc($res_s)['total'] ?? 0;
                        
                        $st = $row['status'];
                        $st_class = ($st == 0) ? 'bg-red-50 text-red-500 border-red-100' : (($st == 1) ? 'bg-yellow-50 text-yellow-600 border-yellow-100' : 'bg-green-50 text-green-500 border-green-100');
                        $st_text = ($st == 0) ? 'Belum Check-in' : (($st == 1) ? 'Masih di Wisata' : 'Sudah Pulang');
                    ?>
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="data-tgl p-4 text-[13px] text-gray-500" data-value="<?= $row['tanggal_kunjungan']; ?>"><?= date('d M', strtotime($row['tanggal_kunjungan'])); ?></td>
                        <td class="data-id p-4 text-[13px] font-bold text-[#2d6a4f]">#<?= $row['id_tiket']; ?></td>
                        <td class="data-nama p-4 text-[13px] font-bold text-[#1a3326] truncate-text" title="<?= $row['nama']; ?>"><?= $row['nama']; ?></td>
                        <td class="data-alamat p-4 text-[13px] text-gray-500 truncate-text"><?= $row['alamat']; ?></td>
                        <td class="p-4 text-[13px] text-center font-bold"><?= $row['jumlah_orang']; ?></td>
                        <td class="p-4 text-[12px] font-bold text-green-600"><?= $row['no_telp']; ?></td>
                        
                        <td class="p-4 text-center">
                            <button class="btn-kelola-sampah bg-green-50 text-green-700 px-3 py-1 rounded-lg font-bold text-[11px]" data-id="<?= $id_tk; ?>" data-nama="<?= $row['nama']; ?>">
                                <?= $total_s; ?> <span class="font-normal text-[9px]">item</span>
                            </button>
                        </td>

                        <td class="p-4 text-center">
                            <div class="status-toggle cursor-pointer border px-4 py-1.5 rounded-full text-[11px] font-bold flex items-center justify-center gap-1.5 min-w-[145px] mx-auto <?= $st_class; ?>" data-state="<?= $st; ?>" data-id="<?= $id_tk; ?>">
                                <?= $st_text; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="modal-trash" class="overlay-modal">
        <div class="modal-card bg-white rounded-[32px] w-full max-w-[480px] shadow-2xl overflow-hidden">
            <div class="bg-[#1a3326] p-6 text-white relative">
                <h3 class="font-extrabold text-[18px]">Kelola Daftar Sampah</h3>
                <p id="m-visitor-info" class="text-[12px] text-gray-300">Memuat...</p>
                <button id="close-modal" class="absolute top-6 right-6 font-bold">✕</button>
            </div>
            <div class="p-8">
                <div id="m-trash-list" class="space-y-3 mb-6 max-h-[220px] overflow-y-auto"></div>
                <div class="flex gap-2 mb-10">
                    <input type="text" id="m-input-new" placeholder="Nama item baru..." class="flex-1 bg-gray-50 border rounded-[14px] px-4 py-3 text-[13px] outline-none">
                    <button id="m-btn-add" class="bg-[#1a3326] text-white px-6 rounded-[14px] text-[13px] font-bold">+ Tambah</button>
                </div>
                <button id="m-btn-save" class="w-full bg-[#1a3326] text-white py-3.5 rounded-[18px] text-[14px] font-bold">Simpan Daftar</button>
            </div>
        </div>
    </div>

    <script src="../../js/admin.js"></script>
</body>
</html>