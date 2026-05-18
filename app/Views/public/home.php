<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Lubuk Lagan - Pesona Alam & Budaya</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS with custom config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            900: '#14532d',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in-up': 'fadeInUp 1s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        .text-gradient {
            background: linear-gradient(to right, #4ade80, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center glass rounded-full px-6 py-3 shadow-lg">
                <a href="#" class="text-2xl font-heading font-extrabold text-white tracking-tight">Lubuk<span class="text-brand-500">Lagan</span>.</a>
                <div class="hidden md:flex space-x-8 text-white font-medium">
                    <a href="#beranda" class="hover:text-brand-500 transition">Beranda</a>
                    <a href="#peta" class="hover:text-brand-500 transition">Peta Desa</a>
                    <a href="#berita" class="hover:text-brand-500 transition">Kabar Terbaru</a>
                </div>
                <a href="<?= base_url('admin/blog') ?>" class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2 rounded-full font-medium transition shadow-[0_0_15px_rgba(34,197,94,0.4)] hover:shadow-[0_0_25px_rgba(34,197,94,0.6)]">
                    Portal Admin
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative min-h-screen flex items-center justify-center hero-gradient overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>

        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto opacity-0 animate-fade-in-up">
            <h1 class="text-5xl md:text-7xl font-heading font-extrabold text-white mb-6 leading-tight">
                Jelajahi Pesona <br>
                <span class="text-gradient">Desa Lubuk Lagan</span>
            </h1>
            <p class="text-lg md:text-2xl text-gray-300 mb-10 font-light">
                Digitalisasi inovatif menyatukan alam, budaya, dan teknologi dalam satu harmoni kehidupan masyarakat.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#peta" class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-4 px-8 rounded-full transition transform hover:-translate-y-1 shadow-lg shadow-brand-500/30">
                    Jelajahi Peta Interaktif
                </a>
                <a href="#berita" class="glass text-white font-bold py-4 px-8 rounded-full hover:bg-white/20 transition transform hover:-translate-y-1">
                    Baca Kabar Terbaru
                </a>
            </div>
        </div>
    </section>

    <!-- Interactive Map Section -->
    <section id="peta" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold tracking-widest text-brand-600 uppercase mb-2">Eksplorasi</h2>
                <h3 class="text-4xl font-heading font-extrabold text-dark-900 mb-4">Peta Satelit Interaktif Desa</h3>
                <p class="text-gray-600 max-w-2xl mx-auto">Sistem Informasi Geografis (SIG) modern yang memetakan seluruh potensi dan lokasi vital Desa Lubuk Lagan dengan presisi tinggi.</p>
            </div>

            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white ring-1 ring-gray-200 group">
                <div id="map" class="w-full h-[600px] z-10 relative transition duration-700"></div>
                <!-- Overlay glow -->
                <div class="absolute inset-0 shadow-[inset_0_0_100px_rgba(0,0,0,0.1)] pointer-events-none z-20"></div>
            </div>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6" id="location-cards">
                <!-- Javascript will populate this based on markers clicked -->
                <div class="col-span-3 text-center text-gray-400 italic">
                    Klik salah satu marker di peta untuk melihat detail lokasi.
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section id="berita" class="py-24 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <h2 class="text-sm font-bold tracking-widest text-brand-600 uppercase mb-2">Informasi</h2>
                    <h3 class="text-4xl font-heading font-extrabold text-dark-900">Kabar Terbaru</h3>
                </div>
                <a href="#" class="hidden md:inline-flex text-brand-600 font-semibold hover:text-brand-700 transition items-center gap-2">
                    Lihat Semua <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach($blogs as $blog): ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col">
                    <div class="p-8 flex-grow">
                        <div class="text-xs font-bold text-gray-400 mb-3 uppercase tracking-wider">
                            <?= date('d M Y', strtotime($blog->created_at)) ?>
                        </div>
                        <h4 class="text-2xl font-bold text-gray-800 mb-4 group-hover:text-brand-600 transition">
                            <a href="<?= base_url('baca/'.$blog->slug) ?>"><?= htmlspecialchars($blog->title) ?></a>
                        </h4>
                        <p class="text-gray-600 line-clamp-3">
                            <?= htmlspecialchars($blog->description ?? 'Deskripsi singkat belum tersedia untuk berita ini.') ?>
                        </p>
                    </div>
                    <div class="px-8 pb-8 mt-auto">
                        <a href="<?= base_url('baca/'.$blog->slug) ?>" class="inline-flex items-center text-brand-600 font-semibold hover:text-brand-800 transition">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if(empty($blogs)): ?>
                    <div class="col-span-3 text-center text-gray-500 py-12">
                        Belum ada berita yang diterbitkan.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-3xl font-heading font-extrabold mb-4">Lubuk<span class="text-brand-500">Lagan</span>.</h2>
                <p class="text-gray-400 max-w-sm">Website Profil Desa cerdas yang dibangun dengan estetika modern dan arsitektur kokoh untuk kemajuan masyarakat.</p>
            </div>
            <div class="flex md:justify-end items-end">
                <p class="text-gray-500 text-sm">
                    &copy; <?= date('Y') ?> Pemerintah Desa Lubuk Lagan.<br>
                    Crafted with ❤️ using CodeIgniter 4 & Tailwind.
                </p>
            </div>
        </div>
    </footer>

    <!-- Interactive Map Script -->
    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('bg-dark-900/80', 'backdrop-blur-md');
            } else {
                nav.classList.remove('bg-dark-900/80', 'backdrop-blur-md');
            }
        });

        // Data dari PHP
        const locations = <?= json_encode($locations) ?>;
        
        // Setup Peta (Default Lubuk Lagan center)
        const defaultLat = locations.length > 0 ? locations[0].latitude : -3.791552;
        const defaultLng = locations.length > 0 ? locations[0].longitude : 102.261895;

        const map = L.map('map', {
            zoomControl: false // Kita akan custom
        }).setView([defaultLat, defaultLng], 14);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Satelit Esri
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        }).addTo(map);
        // Label Jalan
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        // Custom Marker Icon SVG
        const customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div class="relative flex h-10 w-10">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-500 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-10 w-10 bg-brand-500 border-2 border-white items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                      </span>
                   </div>`,
            iconSize: [40, 40],
            iconAnchor: [20, 40]
        });

        // Loop dan pasang marker
        locations.forEach(loc => {
            const marker = L.marker([loc.latitude, loc.longitude], { icon: customIcon }).addTo(map);
            
            // Pop-up estetik saat di hover
            marker.bindTooltip(`<div class="font-bold text-gray-800">${loc.name}</div>`, {
                direction: 'top',
                offset: [0, -40],
                className: 'custom-tooltip'
            });

            // Klik marker
            marker.on('click', () => {
                map.flyTo([loc.latitude, loc.longitude], 17, {
                    animate: true,
                    duration: 1.5
                });
                showLocationDetail(loc);
            });
        });

        function showLocationDetail(loc) {
            const container = document.getElementById('location-cards');
            
            let mediaHtml = '';
            if (loc.media_type === 'photo' && loc.media_url) {
                mediaHtml = `<img src="${loc.media_url}" class="w-full h-64 object-cover rounded-xl shadow-md" alt="${loc.name}">`;
            } else if (loc.media_type === 'drone_video' && loc.media_url) {
                mediaHtml = `<video src="${loc.media_url}" class="w-full h-64 object-cover rounded-xl shadow-md" autoplay muted loop controls preload="none"></video>`;
            } else {
                mediaHtml = `<div class="w-full h-32 bg-gray-100 flex items-center justify-center rounded-xl text-gray-400">Tidak ada media</div>`;
            }

            container.innerHTML = `
                <div class="col-span-3 bg-white p-8 rounded-2xl shadow-xl ring-1 ring-gray-100 animate-fade-in-up">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div>
                            <span class="inline-block px-3 py-1 bg-brand-100 text-brand-600 rounded-full text-xs font-bold uppercase tracking-wider mb-4">Lokasi Sorotan</span>
                            <h4 class="text-3xl font-bold text-gray-800 mb-4">${loc.name}</h4>
                            <p class="text-gray-600 leading-relaxed text-lg">${loc.description || 'Deskripsi belum tersedia.'}</p>
                            <div class="mt-6 text-sm text-gray-400 font-mono bg-gray-50 p-3 rounded-lg inline-block">
                                Lat: ${loc.latitude} | Lng: ${loc.longitude}
                            </div>
                        </div>
                        <div class="relative">
                            ${mediaHtml}
                        </div>
                    </div>
                </div>
            `;
        }
    </script>

    <style>
        .custom-tooltip {
            background: white;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }
        .leaflet-container {
            font-family: inherit;
        }
        html { scroll-behavior: smooth; }
    </style>
</body>
</html>
