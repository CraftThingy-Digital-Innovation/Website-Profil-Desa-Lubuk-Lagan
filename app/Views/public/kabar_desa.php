<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-6xl mx-auto px-4 sm:px-6 py-20 md:py-28">

    <div class="text-center mb-16 anime-fade-up opacity-0">
        <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Informasi Terkini</h2>
        <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900 mb-4">Kabar Desa</h1>
        <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full mb-6"></div>
        <p class="text-earth-700 max-w-2xl mx-auto">Dokumentasi kegiatan, momen spesial, dan potret kehidupan Desa Lubuk Lagan.</p>
    </div>

    <?php if (empty($items)): ?>
    <div class="text-center py-20 text-earth-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-earth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        <p class="text-xl font-medium">Belum ada kabar desa.</p>
    </div>
    <?php else: ?>

    <!-- Card Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php foreach ($items as $i => $item): ?>
        <article class="bg-white rounded-[2rem] shadow-sm border border-earth-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 anime-card opacity-0 group cursor-pointer"
                 onclick="openLightbox(<?= $i ?>)">

            <!-- Thumbnail -->
            <div class="relative overflow-hidden h-52">
                <?php if ($item->media_type === 'video'): ?>
                    <?php if ($item->cover_url): ?>
                        <img src="<?= base_url($item->cover_url) ?>" alt="<?= esc($item->title) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-full bg-forest-900 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/30" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        </div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center group-hover:bg-black/40 transition">
                        <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-xl">
                            <svg class="w-7 h-7 text-forest-900 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        </div>
                    </div>
                    <span class="absolute top-3 left-3 bg-forest-900/80 text-white text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">🎬 Video</span>
                <?php else: ?>
                    <img src="<?= base_url($item->media_url) ?>" alt="<?= esc($item->title) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                <?php endif; ?>
            </div>

            <!-- Content -->
            <div class="p-6">
                <h3 class="font-heading font-bold text-forest-900 text-lg leading-tight mb-2 group-hover:text-earth-700 transition"><?= esc($item->title) ?></h3>
                <?php if ($item->description): ?>
                <p class="text-earth-600 text-sm line-clamp-2 leading-relaxed"><?= esc($item->description) ?></p>
                <?php endif; ?>
                <div class="mt-4 pt-4 border-t border-earth-50 flex items-center justify-between">
                    <time class="text-xs text-earth-400 font-medium"><?= date('d M Y', strtotime($item->created_at)) ?></time>
                    <span class="text-earth-500 text-xs font-semibold flex items-center gap-1 group-hover:text-earth-700 transition">
                        Lihat <svg class="w-3 h-3 transform group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>
</section>

<!-- Lightbox -->
<?php if (!empty($items)): ?>
<div id="lightbox" class="fixed inset-0 z-[9000] bg-black/95 hidden items-center justify-center p-4">
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

function openLightbox(idx) { currentIdx = idx; renderLightbox(); lightbox.classList.remove('hidden'); lightbox.classList.add('flex'); document.body.style.overflow = 'hidden'; }
function closeLightbox() { lightbox.classList.add('hidden'); lightbox.classList.remove('flex'); document.body.style.overflow = ''; lightbox.querySelectorAll('video').forEach(v => v.pause()); }
function prevItem() { currentIdx = (currentIdx - 1 + galleryItems.length) % galleryItems.length; renderLightbox(); }
function nextItem() { currentIdx = (currentIdx + 1) % galleryItems.length; renderLightbox(); }

function renderLightbox() {
    const item = galleryItems[currentIdx];
    lbContent.innerHTML = `<p class="text-white/50 text-xs">${currentIdx + 1} / ${galleryItems.length}</p>`;
    if (item.media_type === 'video') {
        lbContent.innerHTML += `<video src="${item.media_url}" controls autoplay class="max-h-[70vh] max-w-full rounded-xl"></video>`;
    } else {
        lbContent.innerHTML += `<img src="${item.media_url}" alt="${item.title}" class="max-h-[70vh] max-w-full object-contain rounded-xl">`;
    }
    lbContent.innerHTML += `<div class="text-center"><h3 class="text-white font-bold text-lg">${item.title}</h3>${item.description ? `<p class="text-white/60 text-sm mt-1">${item.description}</p>` : ''}</div>`;
}

document.addEventListener('keydown', e => {
    if (lightbox.classList.contains('flex')) {
        if (e.key === 'ArrowLeft') prevItem();
        if (e.key === 'ArrowRight') nextItem();
        if (e.key === 'Escape') closeLightbox();
    }
});
lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
</script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    anime({ targets: '.anime-fade-up', translateY: [40,0], opacity: [0,1], duration: 900, easing: 'easeOutCubic' });
    anime({ targets: '.anime-card', translateY: [30,0], opacity: [0,1], delay: anime.stagger(80, {start:400}), duration: 700, easing: 'easeOutQuad' });
});
</script>

<?= $this->endSection() ?>
