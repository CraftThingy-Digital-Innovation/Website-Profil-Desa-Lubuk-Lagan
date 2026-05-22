<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-6xl mx-auto px-4 sm:px-6 py-20 md:py-28">

    <div class="text-center mb-16 anime-fade-up opacity-0">
        <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Galeri Memori</h2>
        <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900 mb-4">Kenang-kenangan KKN 107</h1>
        <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full mb-6"></div>
        <p class="text-earth-700 max-w-2xl mx-auto">Sumbangsih nyata mahasiswa KKN Kelompok 107 dalam memajukan digitalisasi dan potensi Desa Lubuk Lagan.</p>
    </div>

    <?php if (empty($items)): ?>
    <div class="text-center py-20 text-earth-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-earth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <p class="text-xl font-medium">Galeri belum tersedia.</p>
    </div>
    <?php else: ?>

    <!-- Masonry Gallery -->
    <div class="columns-1 sm:columns-2 lg:columns-3 gap-5 space-y-5" id="gallery-grid">
        <?php foreach ($items as $i => $item): ?>
        <div class="break-inside-avoid bg-white rounded-2xl shadow-sm border border-earth-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 anime-card opacity-0 cursor-pointer group"
             onclick="openLightbox(<?= $i ?>)">

            <!-- Media -->
            <div class="relative overflow-hidden">
                <?php if ($item->media_type === 'video'): ?>
                    <?php if ($item->cover_url): ?>
                        <img src="<?= base_url($item->cover_url) ?>" alt="<?= esc($item->title) ?>" class="w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-52 bg-forest-900 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/40" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        </div>
                    <?php endif; ?>
                    <!-- Play overlay -->
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center group-hover:bg-black/40 transition">
                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-xl">
                            <svg class="w-7 h-7 text-forest-900 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        </div>
                    </div>
                <?php else: ?>
                    <img src="<?= base_url($item->media_url) ?>" alt="<?= esc($item->title) ?>" class="w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-4">
                        <span class="text-white text-xs font-bold">🔍 Lihat</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Caption -->
            <div class="p-4">
                <h3 class="font-bold text-earth-900 text-sm leading-tight"><?= esc($item->title) ?></h3>
                <?php if ($item->description): ?>
                <p class="text-earth-600 text-xs mt-1"><?= esc($item->description) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>
</section>

<!-- Lightbox -->
<?php if (!empty($items)): ?>
<div id="lightbox" class="fixed inset-0 z-[9000] bg-black/95 hidden items-center justify-center p-4" onclick="closeLightbox(event)">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white/70 hover:text-white text-4xl leading-none z-10">&times;</button>
    <button onclick="prevItem()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white z-10 p-3 rounded-full bg-white/10 hover:bg-white/20 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button onclick="nextItem()" class="absolute right-14 top-1/2 -translate-y-1/2 text-white/70 hover:text-white z-10 p-3 rounded-full bg-white/10 hover:bg-white/20 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>
    <div class="max-w-5xl max-h-full w-full flex flex-col items-center gap-4" id="lightboxContent"></div>
</div>

<script>
const galleryItems = <?= json_encode(array_map(fn($i) => [
    'title'      => $i->title,
    'description'=> $i->description,
    'media_url'  => base_url($i->media_url),
    'cover_url'  => $i->cover_url ? base_url($i->cover_url) : null,
    'media_type' => $i->media_type,
], $items)) ?>;

let currentIdx = 0;
const lightbox = document.getElementById('lightbox');
const lbContent = document.getElementById('lightboxContent');

function openLightbox(idx) {
    currentIdx = idx;
    renderLightbox();
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeLightbox(e) {
    if (e && e.target !== lightbox && !e.currentTarget.closest('button')) return;
    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
    document.body.style.overflow = '';
    // stop any playing video
    lightbox.querySelectorAll('video').forEach(v => v.pause());
}
function prevItem() { currentIdx = (currentIdx - 1 + galleryItems.length) % galleryItems.length; renderLightbox(); }
function nextItem() { currentIdx = (currentIdx + 1) % galleryItems.length; renderLightbox(); }

function renderLightbox() {
    const item = galleryItems[currentIdx];
    lbContent.innerHTML = '';
    // Counter
    const counter = document.createElement('p');
    counter.className = 'text-white/50 text-xs';
    counter.textContent = `${currentIdx + 1} / ${galleryItems.length}`;
    lbContent.appendChild(counter);
    // Media
    if (item.media_type === 'video') {
        const v = document.createElement('video');
        v.src = item.media_url; v.controls = true; v.autoplay = true;
        v.className = 'max-h-[70vh] max-w-full rounded-xl';
        lbContent.appendChild(v);
    } else {
        const img = document.createElement('img');
        img.src = item.media_url; img.alt = item.title;
        img.className = 'max-h-[70vh] max-w-full object-contain rounded-xl';
        lbContent.appendChild(img);
    }
    // Caption
    const cap = document.createElement('div');
    cap.className = 'text-center';
    cap.innerHTML = `<h3 class="text-white font-bold text-lg">${item.title}</h3>${item.description ? `<p class="text-white/60 text-sm mt-1">${item.description}</p>` : ''}`;
    lbContent.appendChild(cap);
}

// Keyboard navigation
document.addEventListener('keydown', e => {
    if (lightbox.classList.contains('flex')) {
        if (e.key === 'ArrowLeft') prevItem();
        if (e.key === 'ArrowRight') nextItem();
        if (e.key === 'Escape') { lightbox.classList.add('hidden'); lightbox.classList.remove('flex'); document.body.style.overflow = ''; }
    }
});
</script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    anime({ targets: '.anime-fade-up', translateY: [40,0], opacity: [0,1], duration: 900, easing: 'easeOutCubic' });
    anime({ targets: '.anime-card', scale: [0.9,1], opacity: [0,1], delay: anime.stagger(70, {start:400}), duration: 600, easing: 'easeOutQuad' });
});
</script>

<?= $this->endSection() ?>
