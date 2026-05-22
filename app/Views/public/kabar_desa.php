<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-6xl mx-auto px-4 sm:px-6 py-20 md:py-28">

    <div class="text-center mb-16 anime-fade-up opacity-0">
        <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Informasi Terkini</h2>
        <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900 mb-4">Kabar Desa</h1>
        <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full mb-6"></div>
        <p class="text-earth-700 max-w-2xl mx-auto">Dokumentasi kegiatan, momen spesial, dan potret kehidupan Desa Lubuk Lagan.</p>
    </div>

    <?php if (empty($blogs)): ?>
    <div class="text-center py-20 text-earth-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-earth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        <p class="text-xl font-medium">Belum ada kabar desa.</p>
    </div>
    <?php else: ?>

    <!-- Card Grid — uses BlogModel ($blogs), consistent with blog_list -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
        <?php foreach ($blogs as $blog): ?>
        <article class="bg-white rounded-[2rem] shadow-sm border border-earth-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 anime-card opacity-0 group">
            <!-- Cover image (extract from content) -->
            <div class="relative overflow-hidden h-52 bg-earth-100">
                <?php
                preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $blog->content ?? '', $imgMatch);
                $thumb = $imgMatch[1] ?? null;
                ?>
                <?php if ($thumb): ?>
                    <img src="<?= esc($thumb) ?>" alt="<?= esc($blog->title) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-earth-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                <?php endif; ?>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
            </div>

            <div class="p-6">
                <h3 class="font-heading font-bold text-forest-900 text-lg leading-tight mb-2 group-hover:text-earth-700 transition"><?= esc($blog->title) ?></h3>
                <?php if ($blog->description): ?>
                <p class="text-earth-600 text-sm line-clamp-2 leading-relaxed"><?= esc($blog->description) ?></p>
                <?php endif; ?>
                <div class="mt-4 pt-4 border-t border-earth-50 flex items-center justify-between">
                    <time class="text-xs text-earth-400 font-medium"><?= date('d M Y', strtotime($blog->published_at ?? $blog->created_at)) ?></time>
                    <a href="<?= base_url('baca/' . $blog->slug) ?>" class="text-earth-500 text-xs font-semibold flex items-center gap-1 hover:text-earth-700 transition">
                        Baca <svg class="w-3 h-3 transform group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    anime({ targets: '.anime-fade-up', translateY: [40,0], opacity: [0,1], duration: 900, easing: 'easeOutCubic' });
    anime({ targets: '.anime-card', translateY: [30,0], opacity: [0,1], delay: anime.stagger(80, {start:400}), duration: 700, easing: 'easeOutQuad' });
});
</script>

<?= $this->endSection() ?>
