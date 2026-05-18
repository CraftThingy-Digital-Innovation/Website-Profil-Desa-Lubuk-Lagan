<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($blog->title) ?> - Desa Lubuk Lagan</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= htmlspecialchars($blog->description) ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            500: '#22c55e',
                            600: '#16a34a',
                        },
                        dark: {
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Format Summernote content beautifully */
        .blog-content h1, .blog-content h2, .blog-content h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: #1e293b;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        .blog-content h1 { font-size: 2.25rem; }
        .blog-content h2 { font-size: 1.875rem; }
        .blog-content h3 { font-size: 1.5rem; }
        .blog-content p {
            margin-bottom: 1.25rem;
            line-height: 1.8;
            color: #475569;
        }
        .blog-content img {
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            max-width: 100%;
            height: auto;
        }
        .blog-content ul, .blog-content ol {
            margin-left: 1.5rem;
            margin-bottom: 1.25rem;
            color: #475569;
        }
        .blog-content ul { list-style-type: disc; }
        .blog-content ol { list-style-type: decimal; }
        .blog-content a { color: #22c55e; text-decoration: underline; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Navigation (Simplified) -->
    <nav class="bg-dark-900 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="<?= base_url('/') ?>" class="text-2xl font-heading font-extrabold text-white tracking-tight">Lubuk<span class="text-brand-500">Lagan</span>.</a>
                <a href="<?= base_url('/') ?>#berita" class="text-gray-300 hover:text-white font-medium transition">&larr; Kembali</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-16">
        <article class="max-w-3xl mx-auto px-6 bg-white rounded-3xl shadow-xl overflow-hidden">
            
            <header class="pt-12 pb-8 text-center border-b border-gray-100">
                <div class="text-brand-500 font-bold uppercase tracking-wider text-sm mb-4">
                    Kabar Desa
                </div>
                <h1 class="text-4xl md:text-5xl font-heading font-extrabold text-dark-900 mb-6 leading-tight">
                    <?= htmlspecialchars($blog->title) ?>
                </h1>
                <div class="flex items-center justify-center text-gray-500 text-sm gap-4 font-medium">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <?= date('d F Y, H:i', strtotime($blog->created_at)) ?>
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Admin Desa
                    </span>
                </div>
            </header>

            <div class="p-8 md:p-12 blog-content">
                <!-- HTML content from Summernote is rendered here -->
                <?= $blog->content ?>
            </div>

            <footer class="p-8 bg-gray-50 border-t border-gray-100 flex justify-center">
                <a href="<?= base_url('/') ?>#berita" class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:-translate-y-1">
                    Baca Berita Lainnya
                </a>
            </footer>
        </article>
    </main>

    <!-- Footer -->
    <footer class="bg-dark-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-heading font-extrabold mb-2">Lubuk<span class="text-brand-500">Lagan</span>.</h2>
            <p class="text-gray-500 text-sm">
                &copy; <?= date('Y') ?> Pemerintah Desa Lubuk Lagan.
            </p>
        </div>
    </footer>

</body>
</html>
