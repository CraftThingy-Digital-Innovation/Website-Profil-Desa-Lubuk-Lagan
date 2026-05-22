<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-7xl mx-auto px-6 py-24">
    <div class="flex flex-col md:flex-row justify-between items-center mb-16 anime-fade-up opacity-0">
        <div class="mb-8 md:mb-0 text-center md:text-left">
            <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Informasi</h2>
            <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900">Kabar & Berita Desa</h1>
            <div class="w-24 h-1 bg-earth-400 rounded-full mt-4 mx-auto md:mx-0"></div>
        </div>
        
        <!-- Search Bar -->
        <form action="" method="GET" class="w-full md:w-1/3 relative">
            <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Cari berita..." class="w-full bg-white border-2 border-earth-100 focus:border-earth-400 focus:ring-0 rounded-full py-3 px-6 pr-12 outline-none shadow-sm transition">
            <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-earth-400 hover:text-earth-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <?php if(!empty($search)): ?>
        <p class="text-earth-600 mb-8 anime-fade-up opacity-0">Hasil pencarian untuk: <strong>"<?= htmlspecialchars($search) ?>"</strong></p>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        <?php foreach($blogs as $blog): ?>
        <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group flex flex-col anime-card opacity-0 border border-earth-100">
            <div class="p-8 flex-grow relative">
                <div class="text-xs font-bold text-earth-500 mb-4 uppercase tracking-widest">
                    <?= date('d M Y', strtotime($blog->published_at ?? $blog->created_at)) ?>
                </div>
                <h4 class="text-2xl font-heading font-bold text-forest-900 mb-4 group-hover:text-earth-600 transition leading-snug">
                    <a href="<?= base_url('baca/'.$blog->slug) ?>"><?= htmlspecialchars($blog->title) ?></a>
                </h4>
                <p class="text-earth-700 leading-relaxed line-clamp-3">
                    <?= htmlspecialchars($blog->description ?? 'Deskripsi singkat belum tersedia untuk berita ini.') ?>
                </p>
            </div>
            <div class="px-8 pb-8 mt-auto">
                <a href="<?= base_url('baca/'.$blog->slug) ?>" class="inline-flex items-center text-forest-800 font-bold hover:text-earth-600 transition uppercase text-sm tracking-wider">
                    Baca Selengkapnya
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <?php if(empty($blogs)): ?>
        <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-earth-100 anime-fade-up opacity-0">
            <svg class="w-16 h-16 mx-auto text-earth-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            <h3 class="text-2xl font-heading font-bold text-forest-900 mb-2">Tidak Ada Berita</h3>
            <p class="text-earth-500">Belum ada publikasi yang cocok dengan pencarian Anda.</p>
        </div>
    <?php endif; ?>

    <!-- Pagination -->
    <div class="mt-16 flex justify-center anime-fade-up opacity-0" style="animation-delay: 800ms;">
        <?= $pager->links() ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    anime({
        targets: '.anime-fade-up',
        translateY: [50, 0],
        opacity: [0, 1],
        delay: anime.stagger(200),
        duration: 1000,
        easing: 'easeOutCubic'
    });
    anime({
        targets: '.anime-card',
        translateY: [50, 0],
        opacity: [0, 1],
        delay: anime.stagger(150, {start: 400}),
        duration: 800,
        easing: 'easeOutQuad'
    });
});
</script>

<?= $this->endSection() ?>
