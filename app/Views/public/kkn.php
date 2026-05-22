<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-6xl mx-auto px-4 sm:px-6 py-20 md:py-28">

    <div class="text-center mb-16 anime-fade-up opacity-0">
        <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Galeri Memori</h2>
        <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900 mb-4">Kenang-kenangan KKN 107</h1>
        <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full mb-6"></div>
        <p class="text-earth-700 max-w-2xl mx-auto">Sumbangsih nyata mahasiswa KKN Kelompok 107 dalam memajukan digitalisasi dan potensi Desa Lubuk Lagan.</p>
    </div>

    <?php if (empty($blogs)): ?>
    <div class="text-center py-20 text-earth-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-earth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <p class="text-xl font-medium">Galeri belum tersedia.</p>
    </div>
    <?php else: ?>

    <!-- Masonry Gallery — uses BlogModel data ($blogs), displays title + content -->
    <div class="columns-1 sm:columns-2 lg:columns-3 gap-5 space-y-5">
        <?php foreach ($blogs as $i => $blog): ?>
        <div class="break-inside-avoid bg-white rounded-2xl shadow-sm border border-earth-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 anime-card opacity-0 cursor-pointer group"
             onclick="openLightbox(<?= $i ?>)">

            <!-- Cover image (if description contains an image, otherwise show placeholder) -->
            <div class="relative overflow-hidden h-52 bg-earth-100">
                <?php
                // Extract first image from content if any
                preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $blog->content ?? '', $imgMatch);
                $thumb = $imgMatch[1] ?? null;
                ?>
                <?php if ($thumb): ?>
                    <img src="<?= esc($thumb) ?>" alt="<?= esc($blog->title) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-earth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                <?php endif; ?>
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
            </div>

            <div class="p-4">
                <h3 class="font-bold text-earth-900 text-sm leading-tight mb-1"><?= esc($blog->title) ?></h3>
                <?php if ($blog->description): ?>
                <p class="text-earth-600 text-xs"><?= esc($blog->description) ?></p>
                <?php endif; ?>
                <time class="text-[10px] text-earth-400 mt-2 block"><?= date('d M Y', strtotime($blog->created_at)) ?></time>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>

<!-- Lightbox — menampilkan full content artikel -->
<?php if (!empty($blogs)): ?>
<div id="lightbox" class="fixed inset-0 z-[9000] bg-black/95 hidden items-center justify-center p-4">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white/70 hover:text-white text-4xl leading-none z-10">&times;</button>
    <button onclick="prevItem()" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white z-10 p-3 rounded-full bg-white/10 hover:bg-white/20 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button onclick="nextItem()" class="absolute right-14 md:right-16 top-1/2 -translate-y-1/2 text-white/70 hover:text-white z-10 p-3 rounded-full bg-white/10 hover:bg-white/20 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>
    <div class="max-w-3xl max-h-[90vh] w-full overflow-y-auto rounded-2xl bg-white flex flex-col" id="lightboxContent"></div>
</div>

<script>
const kknItems = <?= json_encode(array_map(fn($b) => [
    'title'       => $b->title,
    'description' => $b->description,
    'content'     => $b->content,
    'date'        => date('d F Y', strtotime($b->created_at)),
    'url'         => base_url('baca/' . $b->slug),
], $blogs)) ?>;

let currentIdx = 0;
const lightbox  = document.getElementById('lightbox');
const lbContent = document.getElementById('lightboxContent');

function openLightbox(idx) {
    currentIdx = idx; renderLightbox();
    lightbox.classList.remove('hidden'); lightbox.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    lightbox.classList.add('hidden'); lightbox.classList.remove('flex');
    document.body.style.overflow = '';
}
function prevItem() { currentIdx = (currentIdx - 1 + kknItems.length) % kknItems.length; renderLightbox(); }
function nextItem() { currentIdx = (currentIdx + 1) % kknItems.length; renderLightbox(); }

function renderLightbox() {
    const item = kknItems[currentIdx];
    lbContent.innerHTML = `
        <div class="p-6 border-b border-gray-100 flex-shrink-0">
            <p class="text-xs text-gray-400 mb-2">${currentIdx + 1} / ${kknItems.length} · ${item.date}</p>
            <h2 class="text-xl font-bold text-gray-800">${item.title}</h2>
            ${item.description ? `<p class="text-sm text-gray-500 mt-1">${item.description}</p>` : ''}
        </div>
        <div class="p-6 prose max-w-none text-sm text-gray-700 leading-relaxed flex-1">${item.content || ''}</div>
        <div class="p-4 border-t border-gray-100 flex justify-end flex-shrink-0">
            <a href="${item.url}" class="text-blue-600 text-sm font-semibold hover:underline">Buka halaman penuh →</a>
        </div>
    `;
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
    anime({ targets: '.anime-card', scale: [0.9,1], opacity: [0,1], delay: anime.stagger(70, {start:400}), duration: 600, easing: 'easeOutQuad' });
});
</script>

<?= $this->endSection() ?>
