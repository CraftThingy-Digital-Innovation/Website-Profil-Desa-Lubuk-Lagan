<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Admin Desa Lubuk Lagan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <style>
        body { background:#f1f5f9; font-family:'Inter',sans-serif; }
        .sidebar { background: #0f172a; transition: width 0.3s ease; }
        .nav-item { transition: all .15s; }
        .nav-item:hover, .nav-item.active { background: rgba(255,255,255,0.08); }
        .nav-item.active { border-left: 3px solid #3b82f6; }
        .stat-card { transition: transform .3s ease, box-shadow .3s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<aside class="sidebar w-64 text-white flex flex-col flex-shrink-0 overflow-y-auto z-30 shadow-2xl">
    <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        </div>
        <div>
            <p class="font-semibold text-white text-base leading-tight">Lubuk Lagan</p>
            <p class="text-xs text-slate-400">Portal Manajemen</p>
        </div>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1" id="sidebar-nav">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest px-3 mb-3 mt-2">Menu Utama</p>
        <a href="<?= base_url('admin/dashboard') ?>" class="nav-item active flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
            <span class="font-medium text-sm text-blue-300">Dashboard</span>
        </a>
        <a href="<?= base_url('admin/blog') ?>" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            <span class="font-medium text-sm">Blog & Berita</span>
        </a>
        <a href="<?= base_url('admin/file-manager') ?>" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="font-medium text-sm">File Manager</span>
        </a>
        <a href="<?= base_url('admin/map') ?>" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
            <span class="font-medium text-sm">Peta Interaktif</span>
        </a>
        <?php if (auth()->user()->inGroup('superadmin')): ?>
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest px-3 mb-2 mt-5">Superadmin</p>
        <a href="<?= base_url('admin/users') ?>" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="font-medium text-sm">Manajemen User</span>
        </a>
        <?php endif; ?>
    </nav>

    <div class="border-t border-white/10 p-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-blue-700 flex items-center justify-center text-white font-bold text-sm">
                <?= strtoupper(substr(auth()->user()->username, 0, 1)) ?>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate"><?= esc(auth()->user()->username) ?></p>
                <p class="text-xs text-slate-400 truncate"><?= implode(', ', auth()->user()->getGroups()) ?></p>
            </div>
            <a href="<?= base_url('logout') ?>" title="Logout" class="text-slate-400 hover:text-red-400 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </a>
        </div>
    </div>
</aside>

<!-- MAIN -->
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shadow-sm">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
            <p class="text-xs text-gray-400 mt-0.5">Selamat datang kembali, <?= esc(auth()->user()->username) ?>!</p>
        </div>
        <a href="<?= base_url('/') ?>" target="_blank" class="flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 hover:border-blue-300 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Lihat Website
        </a>
    </header>

    <main class="flex-1 overflow-y-auto p-8">
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10" id="stat-cards">
            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-800"><?= $totalBlogs ?></p>
                    <p class="text-sm text-gray-500 mt-0.5">Total Artikel</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-800"><?= $publishedBlogs ?></p>
                    <p class="text-sm text-gray-500 mt-0.5">Artikel Tayang</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-800"><?= $totalFiles ?></p>
                    <p class="text-sm text-gray-500 mt-0.5">File Media</p>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-800"><?= $totalLocations ?></p>
                    <p class="text-sm text-gray-500 mt-0.5">Titik Peta</p>
                </div>
            </div>
        </div>

        <!-- Recent Blogs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6" id="recent-section">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-semibold text-gray-800 text-lg">Artikel Terbaru</h2>
                <a href="<?= base_url('admin/blog') ?>" class="text-blue-600 text-sm font-medium hover:text-blue-700">Kelola Semua &rarr;</a>
            </div>

            <div class="space-y-3">
                <?php foreach ($recentBlogs as $blog): ?>
                <div class="flex items-center justify-between py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 px-3 rounded-xl transition group">
                    <div class="flex-1 min-w-0 pr-4">
                        <h3 class="font-medium text-gray-800 group-hover:text-blue-600 transition truncate"><?= esc($blog->title) ?></h3>
                        <p class="text-xs text-gray-400 mt-0.5"><?= date('d M Y, H:i', strtotime($blog->created_at)) ?></p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $blog->status === 'public' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                            <?= $blog->status === 'public' ? 'Tayang' : 'Draft' ?>
                        </span>
                        <a href="<?= base_url('admin/blog/edit/' . $blog->id) ?>" class="text-gray-400 hover:text-blue-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (empty($recentBlogs)): ?>
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Belum ada artikel. <a href="<?= base_url('admin/blog/create') ?>" class="text-blue-600 font-medium">Buat artikel pertama</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        anime({
            targets: '#sidebar-nav .nav-item',
            translateX: [-20, 0],
            opacity: [0, 1],
            delay: anime.stagger(50, {start: 100}),
            duration: 400,
            easing: 'easeOutCubic'
        });
        anime({
            targets: '#stat-cards .stat-card',
            translateY: [20, 0],
            opacity: [0, 1],
            delay: anime.stagger(80),
            duration: 600,
            easing: 'easeOutCubic'
        });
        anime({
            targets: '#recent-section',
            translateY: [20, 0],
            opacity: [0, 1],
            delay: 450,
            duration: 600,
            easing: 'easeOutCubic'
        });
    });
</script>
</body>
</html>
