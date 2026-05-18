<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Portal Admin Desa Lubuk Lagan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .heading { font-family: 'Playfair Display', serif; }
        .login-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f2027 100%);
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-6">

    <!-- Left Panel — Branding -->
    <div class="hidden lg:flex flex-col justify-between w-1/2 max-w-lg pr-16 opacity-0" id="login-brand">
        <div>
            <h1 class="heading text-5xl font-bold text-white mb-4 leading-tight">
                Portal Manajemen<br/>
                <span class="text-blue-400">Desa Lubuk Lagan</span>
            </h1>
            <p class="text-slate-400 text-lg leading-relaxed">
                Sistem pengelolaan konten desa berbasis teknologi modern. Kelola berita, media, dan peta interaktif desa dengan mudah dan profesional.
            </p>
        </div>
        <div class="flex gap-6 text-slate-500 text-sm mt-12">
            <span>📰 Kelola Berita</span>
            <span>🗺️ Peta Desa</span>
            <span>📁 File Manager</span>
        </div>
    </div>

    <!-- Right Panel — Login Form -->
    <div class="w-full max-w-md opacity-0" id="login-card">
        <div class="bg-white rounded-3xl shadow-2xl p-10">
            <div class="mb-8 text-center lg:text-left">
                <div class="inline-flex w-12 h-12 rounded-xl bg-blue-600 items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Masuk ke Portal</h2>
                <p class="text-gray-500 text-sm mt-1">Silakan masuk dengan akun Anda</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-5 p-4 bg-red-50 text-red-600 rounded-xl text-sm border border-red-100">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="redirect_url" value="<?= base_url('admin/dashboard') ?>">

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email / Username</label>
                    <input type="text" name="email" value="<?= old('email') ?>" placeholder="admin@desalubuklagan.local" required
                        class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-3 outline-none transition text-gray-800 placeholder-gray-400">
                </div>

                <div class="mb-7">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required
                        class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-3 outline-none transition text-gray-800">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-500/25 transition transform hover:-translate-y-0.5">
                    Masuk ke Portal →
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="<?= base_url('/') ?>" class="text-sm text-gray-400 hover:text-gray-600 transition">&larr; Kembali ke halaman publik</a>
            </div>
        </div>
    </div>

    <script>
        anime({
            targets: '#login-brand',
            translateX: [-30, 0],
            opacity: [0, 1],
            duration: 1000,
            easing: 'easeOutExpo'
        });
        anime({
            targets: '#login-card',
            translateY: [30, 0],
            opacity: [0, 1],
            duration: 900,
            delay: 200,
            easing: 'easeOutExpo'
        });
    </script>
</body>
</html>
