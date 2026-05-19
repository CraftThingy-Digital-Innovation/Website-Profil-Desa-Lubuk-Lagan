<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>
<div class="mb-8">
    <h1 class="text-3xl font-heading font-bold text-gray-800 mb-2">Pengaturan Sistem</h1>
    <p class="text-gray-500">Konfigurasi variabel utama website dan akses diagnostik.</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-earth-100 overflow-hidden">
    <div class="p-8">
        <form action="<?= base_url('admin/settings') ?>" method="post">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Site Info -->
                <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Informasi Publik</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-earth-700 mb-2">Nama Website</label>
                        <input type="text" name="site_name" value="<?= esc($settings['site_name'] ?? 'Desa Lubuk Lagan') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-earth-700 mb-2">Tagline Singkat</label>
                        <input type="text" name="site_tagline" value="<?= esc($settings['site_tagline'] ?? 'Harmoni Alam & Budaya') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-earth-700 mb-2">Deskripsi (SEO Meta)</label>
                        <textarea name="site_description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none"><?= esc($settings['site_description'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Keamanan / Sistem -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Keamanan & Sistem</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-earth-700 mb-2">Password Diagnostik (Log)</label>
                        <div class="flex gap-2">
                            <input type="text" name="system_log_password" id="log_pw" value="<?= esc($settings['system_log_password'] ?? 'developer123') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none font-mono text-sm">
                        </div>
                        <p class="text-xs text-earth-500 mt-2">Gunakan password ini pada parameter <code>?key=</code> saat mengakses halaman System Logs.</p>
                    </div>

                    <div class="bg-slate-900 rounded-xl p-5 border border-slate-700 mt-4 relative overflow-hidden group">
                        <div class="absolute right-0 bottom-0 opacity-10 group-hover:scale-110 transition-transform">
                            <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <h4 class="text-white font-bold mb-2 relative z-10 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Akses Diagnostik
                        </h4>
                        <p class="text-slate-400 text-sm mb-4 relative z-10">Pantau error log server dan periksa limit upload, versi PHP, status direktori, dsb secara real-time.</p>
                        
                        <a href="<?= base_url('system-logs?key=') ?><?= esc($settings['system_log_password'] ?? 'developer123') ?>" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded-lg text-sm font-semibold transition relative z-10">
                            Buka System Log <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-earth-100 flex justify-end">
                <button type="submit" class="bg-blue-700 hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
