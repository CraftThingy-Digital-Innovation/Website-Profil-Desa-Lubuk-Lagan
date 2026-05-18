<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-6xl mx-auto px-6 py-24">
    <div class="text-center mb-16 anime-fade-up opacity-0">
        <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Struktur Pemerintahan</h2>
        <h1 class="text-5xl font-heading font-extrabold text-forest-900 mb-6">Perangkat Desa</h1>
        <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full"></div>
        <p class="mt-6 text-earth-700 max-w-2xl mx-auto">Mengenal lebih dekat para pelayan masyarakat yang berdedikasi membangun Desa Lubuk Lagan.</p>
    </div>

    <!-- Kades -->
    <div class="flex justify-center mb-16 anime-fade-up opacity-0">
        <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-earth-100 text-center max-w-sm w-full">
            <div class="w-32 h-32 mx-auto bg-earth-200 rounded-full mb-6 border-4 border-earth-100 flex items-center justify-center overflow-hidden">
                <svg class="w-16 h-16 text-earth-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-forest-900">Bapak Kepala Desa</h3>
            <p class="text-earth-500 font-medium mb-4">Kepala Desa Lubuk Lagan</p>
            <p class="text-sm text-earth-600 italic">"Melayani dengan hati, membangun dengan aksi."</p>
        </div>
    </div>

    <!-- Other Officials -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php 
        $perangkat = [
            'Sekretaris Desa', 'Kaur Keuangan', 'Kaur Perencanaan', 
            'Kasi Pemerintahan', 'Kasi Kesejahteraan', 'Kasi Pelayanan'
        ];
        foreach($perangkat as $jabatan):
        ?>
        <div class="bg-earth-50 p-6 rounded-3xl shadow-sm hover:shadow-md transition border border-earth-100 text-center anime-card opacity-0">
            <div class="w-24 h-24 mx-auto bg-white rounded-full mb-4 border-2 border-earth-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-earth-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-earth-800">Nama Perangkat</h4>
            <p class="text-earth-500 text-sm"><?= $jabatan ?></p>
        </div>
        <?php endforeach; ?>
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
        translateY: [30, 0],
        opacity: [0, 1],
        delay: anime.stagger(100, {start: 600}),
        duration: 800,
        easing: 'easeOutQuad'
    });
});
</script>

<?= $this->endSection() ?>
