<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> — Admin Desa Lubuk Lagan</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        sidebar: { DEFAULT: '#0f172a', hover: '#1e293b', active: '#1d4ed8' },
                        brand: { DEFAULT: '#1d4ed8', light: '#3b82f6', dark: '#1e3a8a' }
                    }
                }
            }
        }
    </script>

    <!-- Anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <style>
        body { background-color: #f1f5f9; }
        #sidebar { transition: width 0.3s ease; }
        .nav-item { transition: all 0.15s ease; }
        .nav-item:hover, .nav-item.active { background: rgba(255,255,255,0.1); }
        .nav-item.active { border-left: 3px solid #3b82f6; }
        .nav-item.active svg, .nav-item.active span { color: #93c5fd; }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="w-64 bg-sidebar text-white flex flex-col flex-shrink-0 overflow-y-auto z-30 shadow-2xl">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
            <img src="<?= base_url('images/logo.png') ?>" alt="Logo Seluma" class="w-9 h-9 object-contain flex-shrink-0">
            <div>
                <p class="font-heading font-bold text-white text-base leading-tight">Lubuk Lagan</p>
                <p class="text-xs text-slate-400">Portal Manajemen</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 space-y-1">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest px-3 mb-3 mt-2">Menu Utama</p>

            <a href="<?= base_url('admin/dashboard') ?>" class="nav-item <?= (current_url() == base_url('admin/dashboard')) ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <a href="<?= base_url('admin/blog') ?>" class="nav-item <?= str_contains(current_url(), 'admin/blog') ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                <span class="font-medium text-sm">Blog & Berita</span>
            </a>

            <a href="<?= base_url('admin/file-manager') ?>" class="nav-item <?= str_contains(current_url(), 'admin/file-manager') ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium text-sm">File Manager</span>
            </a>

            <a href="<?= base_url('admin/map') ?>" class="nav-item <?= str_contains(current_url(), 'admin/map') ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                <span class="font-medium text-sm">Peta Interaktif</span>
            </a>

            <a href="<?= base_url('admin/carousel') ?>" class="nav-item <?= str_contains(current_url(), 'admin/carousel') ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium text-sm">Media Carousel</span>
            </a>

            <?php if (auth()->user()->inGroup('superadmin')): ?>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest px-3 mb-3 mt-5">Superadmin</p>
            <a href="<?= base_url('admin/users') ?>" class="nav-item <?= str_contains(current_url(), 'admin/users') ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium text-sm">Manajemen User</span>
            </a>
            
            <a href="<?= base_url('admin/settings') ?>" class="nav-item <?= str_contains(current_url(), 'admin/settings') ? 'active' : '' ?> flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white mt-1">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-medium text-sm">Pengaturan Sistem</span>
            </a>
            <?php endif; ?>
        </nav>

        <!-- User Section -->
        <div class="border-t border-white/10 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-brand-dark flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    <?= strtoupper(substr(auth()->user()->username, 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate"><?= auth()->user()->username ?></p>
                    <p class="text-xs text-slate-400 truncate"><?= implode(', ', auth()->user()->getGroups()) ?></p>
                </div>
                <a href="<?= base_url('logout') ?>" title="Logout" class="text-slate-400 hover:text-red-400 transition flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between flex-shrink-0 z-20 shadow-sm">
            <div>
                <h1 class="text-xl font-semibold text-gray-800"><?= $pageTitle ?? 'Dashboard' ?></h1>
                <p class="text-xs text-gray-400 mt-0.5"><?= $pageSubtitle ?? 'Portal Admin Desa Lubuk Lagan' ?></p>
            </div>
            <div class="flex items-center gap-4">
                <a href="<?= base_url('/') ?>" target="_blank" class="flex items-center gap-2 text-sm text-gray-500 hover:text-brand bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 hover:border-brand transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Lihat Website
                </a>
            </div>
        </header>

        <!-- Scrollable Page Content -->
        <main class="flex-1 overflow-y-auto p-8 bg-slate-50">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('admin_content') ?>
        </main>
    </div>

    <!-- Sidebar entrance animation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            anime({
                targets: '#sidebar .nav-item',
                translateX: [-20, 0],
                opacity: [0, 1],
                delay: anime.stagger(60, {start: 200}),
                duration: 500,
                easing: 'easeOutCubic'
            });
        });
    </script>
</body>
</html>
