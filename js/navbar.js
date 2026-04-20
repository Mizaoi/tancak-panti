document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-item');
    const currentPath = window.location.pathname.split("/").pop(); // Mendapatkan 'home.php' atau 'profile.php'

    navLinks.forEach(link => {
        // Ambil nama file dari href masing-masing menu (misal dari 'home.php' jadi 'home.php')
        const linkHref = link.getAttribute('href').split("/").pop(); 

        // Mengecek apakah nama file sama dengan halaman yang dibuka
        if (linkHref === currentPath || (currentPath === '' && linkHref === 'home.php')) {
            link.classList.add('active');
        }

        // Efek klik untuk pindah halaman
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});