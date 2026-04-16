// Proses untuk mendeteksi menu mana yang sedang aktif
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-item');
    const currentPath = window.location.pathname.split("/").pop();

    navLinks.forEach(link => {
        // Mengecek apakah nama file sama dengan halaman yang dibuka
        if (link.getAttribute('href') === currentPath || (currentPath === '' && link.getAttribute('href') === 'index.php')) {
            link.classList.add('active');
        }

        // Efek klik untuk pindah halaman
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});