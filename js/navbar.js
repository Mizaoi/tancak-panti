document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-item');
    
    // Ambil nama file dari URL saat ini
    let currentPath = window.location.pathname.split("/").pop();
    
    // Jika path kosong (artinya user buka localhost/folder-project/ saja), anggap itu index.php
    if (currentPath === '') {
        currentPath = 'index.php';
    }

    // Periksa semua menu navigasi
    navLinks.forEach(link => {
        // Jika link tujuan sama dengan file yang sedang dibuka, jadikan aktif
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }

        // Efek transisi aktif saat diklik
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});