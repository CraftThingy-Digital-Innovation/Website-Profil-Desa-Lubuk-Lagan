<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? ($settings['site_name'] ?? 'Desa Lubuk Lagan') ?> — <?= $settings['site_tagline'] ?? 'Harmoni Alam & Budaya' ?></title>
    <meta name="description" content="<?= esc($settings['site_description'] ?? '') ?>">
    <meta name="keywords" content="<?= esc($settings['site_keywords'] ?? '') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('images/logo.png') ?>">

    <!-- Open Graph (WhatsApp, Facebook, Twitter) -->
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?= current_url() ?>">
    <meta property="og:site_name"   content="<?= esc($settings['site_name'] ?? 'Desa Lubuk Lagan') ?>">
    <meta property="og:title"       content="<?= esc($pageTitle ?? ($settings['site_name'] ?? 'Desa Lubuk Lagan')) ?>">
    <meta property="og:description" content="<?= esc($settings['site_description'] ?? '') ?>">
    <meta property="og:image"       content="<?= !empty($settings['site_og_image']) ? esc($settings['site_og_image']) : base_url('images/logo.png') ?>">
    <meta property="og:image:width" content="500">
    <meta property="og:image:height" content="500">
    <meta property="og:locale"      content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="summary">
    <meta name="twitter:title"       content="<?= esc($pageTitle ?? ($settings['site_name'] ?? 'Desa Lubuk Lagan')) ?>">
    <meta name="twitter:description" content="<?= esc($settings['site_description'] ?? '') ?>">
    <meta name="twitter:image"       content="<?= !empty($settings['site_og_image']) ? esc($settings['site_og_image']) : base_url('images/logo.png') ?>">
    
    <!-- Google Fonts: Playfair Display for elegant headings, Lora for body text (warm, traditional yet professional) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,500&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Lora', 'serif'],
                        heading: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        earth: {
                            50: '#fdf8f5',
                            100: '#f8ede7',
                            200: '#eedad1',
                            300: '#e1c0b1',
                            400: '#d09f8a',
                            500: '#c28166',
                            600: '#b4674c',
                            700: '#96533d',
                            800: '#7a4534',
                            900: '#633a2d',
                        },
                        forest: {
                            800: '#2d4a22',
                            900: '#1a2e12',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    
    <!-- Leaflet CSS & JS (Hanya jika dibutuhkan) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        .glass-nav {
            background: rgba(253, 248, 245, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(194, 129, 102, 0.1);
        }
        .hero-warm {
            background: linear-gradient(135deg, #1a2e12 0%, #2d4a22 100%);
        }
        /* Custom scrollbar for warm aesthetic */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #fdf8f5; }
        ::-webkit-scrollbar-thumb { background: #c28166; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #96533d; }
    </style>
</head>
<body class="bg-earth-50 text-earth-900 antialiased selection:bg-earth-500 selection:text-white flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-500 glass-nav shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="<?= base_url('/') ?>" class="text-2xl font-heading font-extrabold text-forest-900 tracking-tight flex items-center gap-2.5 anime-nav-logo">
                    <img src="<?= base_url('images/logo.png') ?>" alt="Logo Kabupaten Seluma" class="w-10 h-10 object-contain">
                    Lubuk<span class="text-earth-600">Lagan</span>
                </a>
                
                <div class="hidden md:flex space-x-6 text-earth-800 font-semibold text-sm uppercase tracking-wider anime-nav-links">
                    <a href="<?= base_url('/') ?>" class="hover:text-earth-500 transition border-b-2 border-transparent hover:border-earth-500 pb-1">Beranda</a>
                    <a href="<?= base_url('/sejarah') ?>" class="hover:text-earth-500 transition border-b-2 border-transparent hover:border-earth-500 pb-1">Sejarah</a>
                    <a href="<?= base_url('/perangkat') ?>" class="hover:text-earth-500 transition border-b-2 border-transparent hover:border-earth-500 pb-1">Pemerintahan</a>
                    <a href="<?= base_url('/kkn-107') ?>" class="hover:text-earth-500 transition border-b-2 border-transparent hover:border-earth-500 pb-1">Galeri KKN</a>
                    <a href="<?= base_url('/berita') ?>" class="hover:text-earth-500 transition border-b-2 border-transparent hover:border-earth-500 pb-1">Kabar Desa</a>
                </div>

                <a href="<?= base_url('admin/blog') ?>" class="hidden md:block bg-earth-600 hover:bg-earth-700 text-white px-6 py-2.5 rounded-full font-medium transition shadow-lg hover:shadow-xl anime-nav-btn">
                    Portal Admin
                </a>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" class="md:hidden text-earth-800 focus:outline-none p-2 rounded-lg hover:bg-earth-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-2 border-t border-earth-200/50 pt-4">
                <div class="flex flex-col space-y-4 font-semibold text-earth-800 uppercase tracking-wider text-sm">
                    <a href="<?= base_url('/') ?>" class="hover:text-earth-500 transition px-2">Beranda</a>
                    <a href="<?= base_url('/sejarah') ?>" class="hover:text-earth-500 transition px-2">Sejarah</a>
                    <a href="<?= base_url('/perangkat') ?>" class="hover:text-earth-500 transition px-2">Pemerintahan</a>
                    <a href="<?= base_url('/kkn-107') ?>" class="hover:text-earth-500 transition px-2">Galeri KKN</a>
                    <a href="<?= base_url('/berita') ?>" class="hover:text-earth-500 transition px-2">Kabar Desa</a>
                    <a href="<?= base_url('admin/dashboard') ?>" class="bg-earth-600 hover:bg-earth-700 text-white text-center px-4 py-3 rounded-xl font-medium transition mt-2 shadow-md">
                        Portal Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-24">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-forest-900 text-earth-100 py-16 border-t-[8px] border-earth-600 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute -right-20 -top-20 opacity-10 pointer-events-none">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10">
            <div class="md:col-span-2">
                <h2 class="text-4xl font-heading font-extrabold mb-4 text-earth-200">Lubuk<span class="text-earth-500">Lagan</span>.</h2>
                <p class="text-earth-300 max-w-md leading-relaxed mb-6 font-sans">
                    Desa mandiri yang terus berinovasi menjaga kelestarian budaya, kehangatan masyarakat, dan merangkul teknologi modern untuk masa depan yang lebih cerah.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-forest-800 flex items-center justify-center hover:bg-earth-600 transition">fb</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-forest-800 flex items-center justify-center hover:bg-earth-600 transition">ig</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-forest-800 flex items-center justify-center hover:bg-earth-600 transition">yt</a>
                </div>
            </div>
            
            <div>
                <h3 class="text-xl font-heading font-bold text-white mb-4">Navigasi</h3>
                <ul class="space-y-3 text-earth-300">
                    <li><a href="<?= base_url('/sejarah') ?>" class="hover:text-earth-500 transition">Sejarah Desa</a></li>
                    <li><a href="<?= base_url('/perangkat') ?>" class="hover:text-earth-500 transition">Perangkat Desa</a></li>
                    <li><a href="<?= base_url('/kkn-107') ?>" class="hover:text-earth-500 transition">Galeri KKN 107</a></li>
                    <li><a href="<?= base_url('/berita') ?>" class="hover:text-earth-500 transition">Kabar & Berita</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-xl font-heading font-bold text-white mb-4">Kontak</h3>
                <ul class="space-y-3 text-earth-300">
                    <li class="flex gap-3">
                        <span>📍</span> Kantor Kepala Desa Lubuk Lagan, Bengkulu.
                    </li>
                    <li class="flex gap-3">
                        <span>📧</span> pemdes@lubuklagan.desa.id
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-forest-800 text-center text-earth-400 text-sm">
            &copy; <?= date('Y') ?> Pemerintah Desa Lubuk Lagan. Dipersembahkan oleh Mahasiswa KKN 107.
        </div>
    </footer>

    <!-- Global Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Navbar entrance animation
            anime({
                targets: '.anime-nav-logo',
                translateY: [-20, 0],
                opacity: [0, 1],
                duration: 1000,
                easing: 'easeOutExpo'
            });
            anime({
                targets: '.anime-nav-links a',
                translateY: [-20, 0],
                opacity: [0, 1],
                delay: anime.stagger(100, {start: 300}),
                duration: 800,
                easing: 'easeOutExpo'
            });
            anime({
                targets: '.anime-nav-btn',
                scale: [0.9, 1],
                opacity: [0, 1],
                delay: 800,
                duration: 800,
                easing: 'easeOutElastic(1, .8)'
            });
            
            // Mobile Menu Toggle
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileBtn && mobileMenu) {
                mobileBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
