<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Desa Lubuk Lagan' ?> - Harmoni Alam & Budaya</title>
    
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
                <a href="<?= base_url('/') ?>" class="text-3xl font-heading font-extrabold text-forest-900 tracking-tight flex items-center gap-2 anime-nav-logo">
                    <!-- Simple Leaf Icon -->
                    <svg class="w-8 h-8 text-earth-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 4.42 2.87 8.17 6.84 9.5.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34-.45-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.87 1.52 2.34 1.07 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.55-1.11-4.55-4.92 0-1.11.38-2 1.03-2.71-.1-.25-.45-1.29.1-2.64 0 0 .84-.27 2.75 1.02.79-.22 1.65-.33 2.5-.33.85 0 1.71.11 2.5.33 1.91-1.29 2.75-1.02 2.75-1.02.55 1.35.2 2.39.1 2.64.65.71 1.03 1.6 1.03 2.71 0 3.82-2.34 4.66-4.57 4.91.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12c0-5.52-4.48-10-10-10z" style="display:none;"/><path d="M17.5,2C15.2,2 13.13,3.13 12,5C10.87,3.13 8.8,2 6.5,2C2.86,2 0,4.86 0,8.5C0,14.63 12,22 12,22C12,22 24,14.63 24,8.5C24,4.86 21.14,2 17.5,2M12,19.34C6.54,14.54 2,10.63 2,8.5C2,5.95 4.05,4 6.5,4C8.38,4 10.15,5.18 10.74,6.86H13.25C13.84,5.18 15.61,4 17.5,4C19.95,4 22,5.95 22,8.5C22,10.63 17.45,14.53 12,19.34Z" fill="none" stroke="currentColor" stroke-width="2"/></svg>
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
                <button class="md:hidden text-earth-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
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
        });
    </script>
</body>
</html>
