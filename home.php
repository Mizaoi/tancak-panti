<?php include 'components/header.php'; ?>

<?php
$features = [
    [
        'icon' => 'bi-clock',
        'title' => 'Buka 24 Jam',
        'desc' => 'Nikmati keindahan air terjun kapan saja, siang atau malam hari.'
    ],
    [
        'icon' => 'bi-tree',
        'title' => 'Alam Asri',
        'desc' => 'Dikelilingi perkebunan kopi dan hutan tropis lereng Argopuro.'
    ],
    [
        'icon' => 'bi-people',
        'title' => 'Ramah Keluarga',
        'desc' => 'Cocok untuk wisata keluarga, pasangan, maupun rombongan.'
    ],
    [
        'icon' => 'bi-star-fill',
        'title' => 'Rating Tinggi',
        'desc' => 'Destinasi air terjun terfavorit di Kabupaten Jember.'
    ]
];

$galleryImages = [
    'https://images.unsplash.com/photo-1700474449167-aa7171e64af7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080',
    'https://images.unsplash.com/photo-1552301726-af49f3010981?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080',
    'https://images.unsplash.com/photo-1522645951282-750282e3b142?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080'
];
?>

<!-- Hero Section -->
<section class="position-relative min-vh-100 d-flex align-items-center overflow-hidden">
    <img src="https://images.unsplash.com/photo-1700474449167-aa7171e64af7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&w=1080" 
         alt="Air Terjun Tancak" 
         class="position-absolute w-100 h-100 object-fit-cover top-0 start-0">
    
    <!-- Gradient overlays -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.4), transparent);"></div>
    <div class="position-absolute bottom-0 start-0 w-100 h-50" style="background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);"></div>
    
    <div class="container position-relative z-1 px-4">
        <div class="row justify-content-start">
            <div class="col-lg-7 col-xl-6 fade-in-up">
                <span class="d-inline-block bg-success bg-opacity-75 text-white px-3 py-1 rounded-pill mb-4 small" style="backdrop-filter: blur(4px); background-color: #2d6a4f !important;">
                    🌿 Wisata Alam Jember
                </span>
                
                <h1 class="text-white mb-3" style="font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 800; line-height: 1.1;">
                    Air Terjun<br>
                    <span style="color: #a8d5a2;">Tancak</span>
                </h1>
                
                <p class="text-white text-opacity-90 mb-4" style="font-size: 0.95rem; max-width: 480px; font-weight: 400; line-height: 1.5;">
                    Lepas penatmu di air terjun tertinggi Jember. Nikmati kesegaran alam lereng Argopuro dan hamparan kebun kopi hanya dengan 
                    <span class="fw-semibold" style="color: #a8d5a2;">Rp 7.500</span>.
                </p>
                
                <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="btn px-4 py-2 rounded-pill fw-semibold text-white" style="background-color: #2d6a4f; border: none;">
                        Pesan Sekarang
                    </a>
                    <a href="#" class="btn px-4 py-2 rounded-pill fw-semibold text-white" style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.5);">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3 text-white text-opacity-75 text-center d-none d-md-block">
        <div class="small" style="font-size: 0.75rem;">Scroll</div>
        <i class="bi bi-chevron-down animate-float d-block"></i>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-white">
    <div class="container px-4">
        <div class="text-center mb-5 fade-in-up">
            <h2 class="fw-bold" style="color: #1a3d2b; font-size: 1.8rem;">Mengapa Air Terjun Tancak?</h2>
            <p class="text-secondary opacity-75" style="font-size: 0.9rem;">Temukan keindahan alam yang tiada tara di lereng Gunung Argopuro</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($features as $index => $feature): ?>
            <div class="col-sm-6 col-lg-3 fade-in-up" style="transition-delay: <?= $index * 0.1 ?>s;">
                <div class="rounded-4 p-4 text-center h-100" style="background-color: #f4f9f5; transition: all 0.3s ease;">
                    <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex p-3 mb-3">
                        <i class="<?= $feature['icon'] ?> fs-2" style="color: #2d6a4f;"></i>
                    </div>
                    <h3 class="fs-6 fw-bold mb-2" style="color: #1a3d2b;"><?= $feature['title'] ?></h3>
                    <p class="text-secondary opacity-75" style="font-size: 0.75rem;"><?= $feature['desc'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-5" style="background-color: #e8ede9;">
    <div class="container px-4">
        <div class="text-center mb-4 fade-in-up">
            <h2 class="fw-bold" style="color: #1a3d2b; font-size: 1.8rem;">Galeri Keindahan</h2>
            <p class="text-secondary opacity-75" style="font-size: 0.9rem;">Panorama alam yang memukau menanti Anda</p>
        </div>
        
        <div class="row g-3">
            <?php foreach ($galleryImages as $index => $image): ?>
            <div class="col-md-4 fade-in-up" style="transition-delay: <?= $index * 0.1 ?>s;">
                <div class="position-relative overflow-hidden rounded-4" style="aspect-ratio: 4/3;">
                    <img src="<?= $image ?>" 
                         alt="Gallery <?= $index + 1 ?>" 
                         class="w-100 h-100 object-fit-cover" 
                         style="transition: transform 0.5s ease; cursor: pointer;">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.4), transparent); opacity: 0; transition: opacity 0.3s ease;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a3d2b 0%, #2d6a4f 100%);">
    <div class="container px-4 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8 fade-in-up">
                <h2 class="text-white mb-3" style="font-size: clamp(1.5rem, 4vw, 2.2rem); font-weight: 800;">
                    Siap Berpetualang?
                </h2>
                <p class="text-white text-opacity-80 mb-4" style="font-size: 0.9rem;">
                    Pesan tiket sekarang dan nikmati keindahan Air Terjun Tancak bersama orang-orang tersayang
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <a href="#" class="btn px-4 py-2 rounded-pill fw-semibold" style="background-color: white; color: #1a3d2b;">
                        Beli Tiket Sekarang
                    </a>
                    <a href="#" class="btn px-4 py-2 rounded-pill fw-semibold text-white" style="border: 1px solid rgba(255,255,255,0.5);">
                        Lihat Ulasan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-4 text-center" style="background-color: #0f2318; color: rgba(255,255,255,0.6);">
    <div class="container">
        <p class="mb-0" style="font-size: 0.7rem;">© 2025 Air Terjun Tancak Panti, Kabupaten Jember. Semua hak dilindungi.</p>
    </div>
</footer>

<?php include 'components/footer.php'; ?>