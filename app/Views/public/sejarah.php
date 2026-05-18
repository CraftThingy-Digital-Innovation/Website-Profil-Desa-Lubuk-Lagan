<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-4xl mx-auto px-6 py-24">
    <div class="text-center mb-16 anime-fade-up opacity-0">
        <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Jejak Masa Lalu</h2>
        <h1 class="text-5xl font-heading font-extrabold text-forest-900 mb-6">Sejarah Desa Lubuk Lagan</h1>
        <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full"></div>
    </div>

    <div class="prose prose-lg prose-stone max-w-none text-earth-800 leading-loose anime-fade-up opacity-0" style="animation-delay: 200ms;">
        <p class="mb-6 drop-cap text-2xl font-serif">
            <span class="float-left text-7xl font-heading text-earth-600 pr-3 leading-none mt-2">D</span>esa Lubuk Lagan memiliki sejarah panjang yang mengakar kuat pada kebudayaan lokal Bengkulu. Konon nama "Lubuk Lagan" berasal dari gabungan dua kata kuno yang bermakna tempat penampungan air (Lubuk) dan nama pohon besar (Lagan) yang dulunya menaungi tempat berkumpulnya para pendiri desa ini.
        </p>

        <p class="mb-6">
            Di masa lampau, wilayah ini merupakan rute perlintasan penting bagi para pedagang yang menelusuri lembah dan perbukitan di sekitar pegunungan Bukit Barisan. Hal ini memicu akulturasi budaya yang kental, sehingga karakter masyarakat desa menjadi sangat ramah, terbuka, dan menjunjung tinggi nilai gotong royong.
        </p>

        <div class="my-12 p-8 bg-earth-100 rounded-3xl border border-earth-200 shadow-inner relative">
            <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg border border-earth-200">
                <svg class="w-6 h-6 text-earth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            <h3 class="text-2xl font-heading font-bold text-forest-900 mb-4 text-center">Titik Balik Modernisasi</h3>
            <p class="text-center italic">
                "Pada era modern ini, Lubuk Lagan tidak lagi hanya sebuah persinggahan, melainkan sebuah destinasi. Destinasi inovasi, edukasi, dan kelestarian."
            </p>
        </div>

        <p class="mb-6">
            Kini, di era digital, Desa Lubuk Lagan terus bertransformasi. Di bawah pimpinan aparatur desa yang progresif serta bantuan dari berbagai kelompok pengabdian masyarakat (seperti KKN), desa ini mengembangkan potensinya melalui teknologi informasi untuk memperkenalkan keindahannya kepada dunia.
        </p>
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
});
</script>

<?= $this->endSection() ?>
