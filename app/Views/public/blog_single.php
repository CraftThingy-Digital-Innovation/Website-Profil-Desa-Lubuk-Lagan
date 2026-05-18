<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<!-- Custom Styles for Summernote Content inside layout -->
<style>
    .blog-content h1, .blog-content h2, .blog-content h3 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: #1a2e12;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .blog-content h1 { font-size: 2.25rem; }
    .blog-content h2 { font-size: 1.875rem; }
    .blog-content h3 { font-size: 1.5rem; }
    .blog-content p {
        margin-bottom: 1.25rem;
        line-height: 1.8;
        color: #44403c;
    }
    .blog-content img {
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        margin: 2rem auto;
        max-width: 100%;
        height: auto;
    }
    .blog-content ul, .blog-content ol {
        margin-left: 1.5rem;
        margin-bottom: 1.25rem;
        color: #44403c;
    }
    .blog-content ul { list-style-type: disc; }
    .blog-content ol { list-style-type: decimal; }
    .blog-content a { color: #b4674c; text-decoration: underline; }
</style>

<article class="max-w-4xl mx-auto px-6 py-16">
    <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-earth-100 anime-fade-up opacity-0">
        
        <header class="pt-16 pb-10 px-8 md:px-16 text-center border-b border-earth-50 relative overflow-hidden">
            <!-- Decorative leaves/shapes -->
            <div class="absolute -right-10 -top-10 opacity-5 pointer-events-none">
                <svg width="200" height="200" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
            </div>

            <div class="text-earth-500 font-bold uppercase tracking-widest text-sm mb-6 inline-flex items-center gap-2 bg-earth-50 px-4 py-1.5 rounded-full border border-earth-200">
                <span class="w-2 h-2 rounded-full bg-earth-500"></span>
                Kabar Desa
            </div>
            
            <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-forest-900 mb-8 leading-tight">
                <?= htmlspecialchars($blog->title) ?>
            </h1>
            
            <div class="flex flex-wrap items-center justify-center text-earth-500 text-sm gap-6 font-medium">
                <span class="flex items-center gap-2 bg-earth-50 px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <?= date('d F Y', strtotime($blog->created_at)) ?>
                </span>
                <span class="flex items-center gap-2 bg-earth-50 px-4 py-2 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Admin Desa
                </span>
            </div>
        </header>

        <div class="p-8 md:p-16 blog-content font-sans text-lg">
            <!-- HTML content from Summernote is rendered here -->
            <?= $blog->content ?>
        </div>

        <footer class="p-8 md:p-12 bg-earth-50 border-t border-earth-100 flex justify-center">
            <a href="<?= base_url('/berita') ?>" class="bg-forest-900 hover:bg-forest-800 text-white font-bold py-4 px-10 rounded-full shadow-xl shadow-forest-900/20 transition transform hover:-translate-y-1">
                Kembali ke Daftar Berita
            </a>
        </footer>
    </div>
</article>

<script>
document.addEventListener('DOMContentLoaded', () => {
    anime({
        targets: '.anime-fade-up',
        translateY: [50, 0],
        opacity: [0, 1],
        duration: 1000,
        easing: 'easeOutCubic'
    });
});
</script>

<?= $this->endSection() ?>
