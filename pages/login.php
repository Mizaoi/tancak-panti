<?php
session_start();
include '../config/koneksi.php';

// PROSES LOGIN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); 

    $query = mysqli_query($koneksi, "SELECT * FROM tb_admin WHERE username = '$username'");
    $data = mysqli_fetch_assoc($query);

    // Langsung gabung! Jika data ketemu DAN passwordnya cocok
    if ($data && $password == $data['password']) {
        $_SESSION['admin'] = $data['username'];
        header("Location: ../admin/dashboard.php"); 
        exit;
    } else {
        // Jika salah satu salah, pesan errornya sama persis!
        $_SESSION['alert'] = ['type' => 'error', 'msg' => '⚠️ Username atau password salah, coba lagi ya!'];
        header("Location: login.php");
        exit; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SI-TANCAK PANTI</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/login.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
    </style>
</head>
<body class="flex flex-col min-h-screen relative bg-gray-900">
    <!-- POP-UP LOGIN GAGAL -->
    <?php if(isset($_SESSION['error_login'])): ?>
        <div id="popup-error" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity duration-300">
            <div class="bg-white rounded-[24px] p-8 shadow-2xl transform scale-100 transition-transform duration-300 flex flex-col items-center text-center max-w-[320px] mx-4 animate-pop">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <h3 class="text-[20px] font-bold text-[#1a3326] mb-2">Login Gagal!</h3>
                <p class="text-[13px] text-gray-500 font-medium leading-relaxed"><?php echo $_SESSION['error_login']; ?></p>
            </div>
        </div>
        <?php unset($_SESSION['error_login']); ?>

        <style>
            @keyframes pop {
                0% { transform: scale(0.8); opacity: 0; }
                100% { transform: scale(1); opacity: 1; }
            }
            .animate-pop { animation: pop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        </style>

        <script>
            // Hilang otomatis dalam 3 detik (3000 ms)
            setTimeout(() => {
                const popup = document.getElementById('popup-error');
                if(popup) {
                    popup.style.opacity = '0'; // Hilang pelan-pelan
                    popup.children[0].style.transform = 'scale(0.9)'; // Mengecil
                    setTimeout(() => popup.remove(), 300); // Hapus dari HTML
                }
            }, 3000);
        </script>
    <?php endif; ?>

    <div class="absolute inset-0 z-0">
        <img src="../assets/images/air-terjun-depan.png" alt="Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="relative z-20">
        <?php include '../components/navbar.php'; ?>
    </div>

    <?php if(isset($_SESSION['alert'])): ?>
        <div id="custom-alert" class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-full shadow-lg text-white text-[14px] font-semibold transition-all duration-500 <?php echo ($_SESSION['alert']['type'] == 'success') ? 'bg-[#2d6a4f]' : 'bg-red-500'; ?>">
            <?php echo $_SESSION['alert']['msg']; ?>
        </div>
        <?php unset($_SESSION['alert']); ?>
        <script>
            setTimeout(() => {
                const alertBox = document.getElementById('custom-alert');
                if(alertBox) {
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translate(-50%, -20px)';
                    setTimeout(() => alertBox.remove(), 500);
                }
            }, 3000);
        </script>
    <?php endif; ?>

    <main class="flex-1 flex items-center justify-center relative z-10 px-6 pt-20 pb-12">
        
        <div class="w-full max-w-[420px] rounded-[24px] overflow-hidden shadow-2xl reveal-zoom" id="login-card">
            
            <div class="bg-[#1a3326] p-8 text-center flex flex-col items-center">
                <div class="w-14 h-14 rounded-[14px] bg-white/10 flex items-center justify-center text-white mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <h2 class="text-white text-[22px] font-bold mb-1">Portal Admin Kebersihan</h2>
                <p class="text-white/70 text-[13px]">Pantau dan kelola laporan sampah wisatawan Tancak Panti</p>
            </div>

            <div class="bg-white p-8">
                <form action="" method="POST">
                    
                    <div class="mb-5">
                    
                    <div class="mb-5">
                        <label class="block text-[#1a3326] text-[13px] font-bold mb-2 text-center">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <input type="text" name="username" required placeholder="Username" class="w-full bg-[#f8faf9] border border-gray-200 rounded-[12px] pl-11 pr-4 py-3.5 text-[14px] text-gray-700 outline-none focus:border-[#2d6a4f] transition-colors">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-[#1a3326] text-[13px] font-bold mb-2 text-center">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </div>
                            <input type="password" name="password" id="password-input" required placeholder="Password" class="w-full bg-[#f8faf9] border border-gray-200 rounded-[12px] pl-11 pr-12 py-3.5 text-[14px] text-gray-700 outline-none focus:border-[#2d6a4f] transition-colors">
                            
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer z-10" id="toggle-password">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hover:text-[#2d6a4f] transition-colors">
                                    <!-- Default: Mata Disilang -->
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="login" class="w-full bg-[#1a3326] text-white font-semibold text-[14px] py-3.5 rounded-[12px] flex items-center justify-center hover:bg-[#12241b] transition-colors shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        Masuk ke Dashboard
                    </button>

                </form>
            </div>
        </div>
    </main>

    <script src="../js/navbar.js"></script>
    <script src="../js/login.js"></script>
    <!-- TOAST ALERT MELAYANG (OVAL) -->
     
    <?php if(isset($_SESSION['alert'])): ?>
        <div id="custom-alert" class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[100] px-6 py-3 rounded-full shadow-2xl text-white text-[14px] font-semibold transition-all duration-500 <?php echo ($_SESSION['alert']['type'] == 'success') ? 'bg-[#2d6a4f]' : 'bg-red-500'; ?> flex items-center gap-2">
            <?php echo $_SESSION['alert']['msg']; ?>
        </div>
        <script>
            // Hilang otomatis dalam 3 detik
            setTimeout(() => {
                const alertBox = document.getElementById('custom-alert');
                if(alertBox) {
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translate(-50%, -20px)';
                    setTimeout(() => alertBox.remove(), 500);
                }
            }, 3000);
        </script>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>
    
</body>
</html>