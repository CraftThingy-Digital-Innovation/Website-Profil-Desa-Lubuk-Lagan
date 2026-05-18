<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-6xl mx-auto px-6 py-24">
    <div class="text-center mb-16 anime-fade-up opacity-0">
        <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Galeri Memori</h2>
        <h1 class="text-5xl font-heading font-extrabold text-forest-900 mb-6">Kenang-kenangan KKN 107</h1>
        <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full"></div>
        <p class="mt-6 text-earth-700 max-w-2xl mx-auto">Sumbangsih nyata mahasiswa KKN Kelompok 107 dalam memajukan digitalisasi dan potensi Desa Lubuk Lagan.</p>
    </div>

    <!-- Masonry-like Grid for Gallery -->
    <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
        <!-- Dummy Items -->
        <?php for($i=1; $i<=6; $i++): ?>
        <div class="break-inside-avoid bg-white p-2 rounded-2xl shadow-sm border border-earth-100 hover:shadow-lg transition anime-card opacity-0">
            <div class="bg-earth-200 w-full h-<?= rand(40, 80) ?> rounded-xl flex items-center justify-center overflow-hidden relative group">
                <!-- Placeholder for images -->
                <div class="absolute inset-0 bg-forest-900/0 group-hover:bg-forest-900/40 transition flex items-center justify-center">
                    <span class="text-white opacity-0 group-hover:opacity-100 font-bold tracking-wider transition">Lihat Foto</span>
                </div>
                <svg class="w-12 h-12 text-earth-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div class="p-4">
                <p class="text-earth-700 text-sm font-medium">Kegiatan Pengabdian Masyarakat #<?= $i ?></p>
            </div>
        </div>
        <?php endfor; ?>
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
        scale: [0.9, 1],
        opacity: [0, 1],
        delay: anime.stagger(100, {start: 500}),
        duration: 800,
        easing: 'easeOutQuad'
    });
});
</script>

<?= $this->endSection() ?>
