<?= $this->extend('layout/public') ?>

<?= $this->section('content') ?>

<!-- Hero Section with Parallax and Anime.js -->
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden -mt-24 pt-24">
    <!-- Background Image / Texture -->
    <div class="absolute inset-0 bg-earth-900 z-0">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-center opacity-40 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-earth-50 via-transparent to-forest-900/50"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute left-10 top-1/4 w-32 h-32 border border-earth-400 rounded-full opacity-20 anime-hero-shape"></div>
    <div class="absolute right-20 bottom-1/3 w-64 h-64 border border-earth-300 rounded-full opacity-10 anime-hero-shape" style="animation-delay: 1s;"></div>

    <div class="relative z-10 text-center px-6 max-w-5xl mx-auto">
        <div class="inline-block mb-4 px-4 py-1 rounded-full border border-earth-300/30 bg-earth-100/10 backdrop-blur-sm anime-hero-text">
            <span class="text-earth-200 text-sm tracking-widest uppercase font-semibold">Selamat Datang di</span>
        </div>
        
        <h1 class="text-5xl md:text-8xl font-heading font-extrabold text-white mb-6 leading-tight drop-shadow-lg anime-hero-title">
            Desa Lubuk <span class="text-earth-400">Lagan</span>
        </h1>
        
        <p class="text-lg md:text-2xl text-earth-100 mb-10 font-sans font-light max-w-3xl mx-auto drop-shadow anime-hero-text">
            Merajut harmoni antara kelestarian alam, kearifan budaya lokal, dan inovasi teknologi digital untuk kesejahteraan bersama.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-5 anime-hero-btn">
            <a href="#eksplor" class="bg-earth-600 hover:bg-earth-500 text-white font-bold py-4 px-10 rounded-full transition transform hover:-translate-y-1 shadow-xl shadow-earth-900/30">
                Mulai Menjelajah
            </a>
            <a href="<?= base_url('/sejarah') ?>" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white font-bold py-4 px-10 rounded-full transition transform hover:-translate-y-1">
                Pelajari Sejarah
            </a>
        </div>
    </div>
</section>

<!-- Peta Interaktif -->
<section id="eksplor" class="py-24 relative z-20 bg-earth-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16 anime-fade-up">
            <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Eksplorasi</h2>
            <h3 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900 mb-6">Peta Digital Desa</h3>
            <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full mb-6"></div>
            <p class="text-earth-700 max-w-2xl mx-auto text-lg">Sistem Informasi Geografis memetakan seluruh potensi, fasilitas, dan lokasi vital Desa Lubuk Lagan dengan presisi satelit.</p>
        </div>

        <div class="relative rounded-[2rem] overflow-hidden shadow-2xl border-8 border-white group">
            <div id="map" class="w-full h-[600px] z-10 relative"></div>
        </div>
        
        <div class="mt-12 grid grid-cols-1 gap-6" id="location-cards">
            <!-- Javascript will populate this based on markers clicked -->
            <div class="text-center text-earth-400 italic bg-white p-8 rounded-2xl shadow-sm border border-earth-100">
                <svg class="w-12 h-12 mx-auto text-earth-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                Klik salah satu pin merah di peta untuk melihat detail lokasi, foto, atau video drone.
            </div>
        </div>
    </div>
</section>

<!-- Kabar Terbaru -->
<section class="py-24 bg-white border-t border-earth-100 relative overflow-hidden">
    <!-- Decorative branch -->
    <div class="absolute -left-20 top-40 opacity-5 pointer-events-none">
        <svg width="300" height="300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v6h2v-6h-2zm0-4v2h2V7h-2z"/></svg>
    </div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 anime-fade-up">
            <div>
                <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Informasi</h2>
                <h3 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900">Kabar & Agenda</h3>
                <div class="w-24 h-1 bg-earth-400 rounded-full mt-6"></div>
            </div>
            <a href="<?= base_url('/berita') ?>" class="inline-flex text-earth-600 font-bold hover:text-earth-800 transition items-center gap-2 group">
                Lihat Semua Berita 
                <span class="transform group-hover:translate-x-2 transition">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php foreach($blogs as $index => $blog): ?>
            <div class="bg-earth-50 rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 group flex flex-col anime-card" style="opacity:0;">
                <div class="p-8 flex-grow relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                    
                    <div class="text-xs font-bold text-earth-500 mb-4 uppercase tracking-widest">
                        <?= date('d M Y', strtotime($blog->created_at)) ?>
                    </div>
                    <h4 class="text-2xl font-heading font-bold text-forest-900 mb-4 group-hover:text-earth-600 transition leading-snug">
                        <a href="<?= base_url('baca/'.$blog->slug) ?>"><?= htmlspecialchars($blog->title) ?></a>
                    </h4>
                    <p class="text-earth-700 leading-relaxed line-clamp-3">
                        <?= htmlspecialchars($blog->description ?? 'Deskripsi singkat berita ini belum tersedia.') ?>
                    </p>
                </div>
                <div class="px-8 pb-8 mt-auto">
                    <a href="<?= base_url('baca/'.$blog->slug) ?>" class="inline-flex items-center text-forest-800 font-bold hover:text-earth-600 transition uppercase text-sm tracking-wider border-b-2 border-forest-800 hover:border-earth-600 pb-1">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if(empty($blogs)): ?>
                <div class="col-span-3 text-center text-earth-500 py-16 bg-earth-50 rounded-3xl border border-earth-100">
                    Belum ada publikasi berita terbaru.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Map Script -->
<script>
    // Anime JS Animations for Home
    document.addEventListener('DOMContentLoaded', () => {
        // Hero Timeline
        let tl = anime.timeline({
            easing: 'easeOutExpo',
            duration: 1200
        });

        tl.add({
            targets: '.anime-hero-shape',
            scale: [0, 1],
            opacity: [0, 0.2],
            delay: anime.stagger(200)
        })
        .add({
            targets: '.anime-hero-title',
            translateY: [50, 0],
            opacity: [0, 1],
        }, '-=800')
        .add({
            targets: '.anime-hero-text',
            translateY: [30, 0],
            opacity: [0, 1],
            delay: anime.stagger(150)
        }, '-=1000')
        .add({
            targets: '.anime-hero-btn',
            translateY: [20, 0],
            opacity: [0, 1],
        }, '-=800');

        // Scroll Animations using IntersectionObserver
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('anime-fade-up')) {
                        anime({
                            targets: entry.target,
                            translateY: [50, 0],
                            opacity: [0, 1],
                            duration: 1000,
                            easing: 'easeOutCubic'
                        });
                        observer.unobserve(entry.target);
                    }
                    
                    if (entry.target.classList.contains('anime-card')) {
                        anime({
                            targets: entry.target,
                            translateY: [50, 0],
                            opacity: [0, 1],
                            delay: anime.stagger(150),
                            duration: 800,
                            easing: 'easeOutQuad'
                        });
                        observer.unobserve(entry.target);
                    }
                }
            });
        }, observerOptions);

        document.querySelectorAll('.anime-fade-up, .anime-card').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });
    });

    // --- LEAFLET MAP ---
    const locations = <?= json_encode($locations) ?>;
    const defaultLat = locations.length > 0 ? locations[0].latitude : -3.791552;
    const defaultLng = locations.length > 0 ? locations[0].longitude : 102.261895;

    const map = L.map('map', { zoomControl: false }).setView([defaultLat, defaultLng], 14);
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri'
    }).addTo(map);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    const customIcon = L.divIcon({
        className: 'custom-div-icon',
        html: `<div class="relative flex h-12 w-12 cursor-pointer group">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-earth-500 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-12 w-12 bg-gradient-to-br from-earth-500 to-earth-700 border-[3px] border-white items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                  </span>
               </div>`,
        iconSize: [48, 48],
        iconAnchor: [24, 48]
    });

    locations.forEach(loc => {
        const marker = L.marker([loc.latitude, loc.longitude], { icon: customIcon }).addTo(map);
        
        marker.bindTooltip(`<div class="font-heading font-bold text-forest-900 text-lg">${loc.name}</div>`, {
            direction: 'top', offset: [0, -48], className: 'map-tooltip'
        });

        marker.on('click', () => {
            map.flyTo([loc.latitude, loc.longitude], 17, { animate: true, duration: 1.5 });
            showLocationDetail(loc);
        });
    });

    function showLocationDetail(loc) {
        const container = document.getElementById('location-cards');
        let mediaHtml = '';
        if (loc.media_type === 'photo' && loc.media_url) {
            mediaHtml = `<img src="${loc.media_url}" class="w-full h-[400px] object-cover rounded-3xl shadow-2xl" alt="${loc.name}">`;
        } else if (loc.media_type === 'drone_video' && loc.media_url) {
            mediaHtml = `<video src="${loc.media_url}" class="w-full h-[400px] object-cover rounded-3xl shadow-2xl" autoplay muted loop controls preload="none"></video>`;
        } else {
            mediaHtml = `<div class="w-full h-full min-h-[300px] bg-earth-100 flex items-center justify-center rounded-3xl border-2 border-dashed border-earth-300 text-earth-500 font-medium">Visualisasi Belum Tersedia</div>`;
        }

        container.innerHTML = `
            <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-xl border border-earth-100 relative overflow-hidden" id="detail-card">
                <!-- Watermark -->
                <div class="absolute -right-10 -bottom-10 text-[150px] font-heading font-black text-earth-50 opacity-50 pointer-events-none select-none">
                    LL.
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-12 h-1 bg-earth-500 rounded-full"></span>
                            <span class="text-earth-600 font-bold uppercase tracking-widest text-sm">Titik Lokasi</span>
                        </div>
                        <h4 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900 mb-6 leading-tight">${loc.name}</h4>
                        <p class="text-earth-700 leading-relaxed text-lg font-sans mb-8">${loc.description || 'Deskripsi detail untuk lokasi ini masih dalam tahap penyusunan.'}</p>
                        <div class="inline-flex items-center gap-4 text-sm font-mono bg-earth-50 px-6 py-4 rounded-2xl border border-earth-200 shadow-inner">
                            <div class="text-earth-500">
                                <span class="block text-xs font-bold text-earth-400 uppercase tracking-widest mb-1">Latitude</span>
                                ${loc.latitude}
                            </div>
                            <div class="w-px h-8 bg-earth-200"></div>
                            <div class="text-earth-500">
                                <span class="block text-xs font-bold text-earth-400 uppercase tracking-widest mb-1">Longitude</span>
                                ${loc.longitude}
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        ${mediaHtml}
                        <!-- Decorative frame -->
                        <div class="absolute -inset-4 border-2 border-earth-200 rounded-[3rem] -z-10 hidden md:block"></div>
                    </div>
                </div>
            </div>
        `;

        // Animate card entrance
        anime({
            targets: '#detail-card',
            translateY: [40, 0],
            opacity: [0, 1],
            duration: 800,
            easing: 'easeOutCubic'
        });
    }
</script>

<style>
    .map-tooltip {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        border: 2px solid #e1c0b1;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border-radius: 1rem;
        padding: 0.75rem 1.5rem;
    }
    .leaflet-container { font-family: inherit; }
</style>

<?= $this->endSection() ?>
