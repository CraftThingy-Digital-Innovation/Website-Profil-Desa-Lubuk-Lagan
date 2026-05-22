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

            <!-- Struktur Perangkat Desa Section -->
            <div class="mt-8 pt-8 border-t border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Bagan Struktur Organisasi</h3>
                <p class="text-sm text-gray-500 mb-6">Pilih apakah ingin menampilkan struktur bagan organisasi interaktif (berdasarkan data perangkat desa) atau mengunggah sebuah gambar tunggal.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Mode Selection -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-earth-700 mb-2">Mode Tampilan Struktur</label>
                            <select name="officer_structure_mode" id="structureMode" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 outline-none transition appearance-none bg-white">
                                <option value="dynamic" <?= ($settings['officer_structure_mode'] ?? 'dynamic') === 'dynamic' ? 'selected' : '' ?>>Bagan Interaktif (Data Perangkat)</option>
                                <option value="photo" <?= ($settings['officer_structure_mode'] ?? 'dynamic') === 'photo' ? 'selected' : '' ?>>Gambar / Foto Struktur Tunggal</option>
                            </select>
                            <p class="text-xs text-gray-400 mt-2">Mode interaktif menyusun organisasi secara dinamis berdasarkan hirarki level atasan langsung pada menu Perangkat Desa.</p>
                        </div>
                    </div>

                    <!-- Single Photo Config -->
                    <div id="photoModeContainer" class="space-y-4 <?= ($settings['officer_structure_mode'] ?? 'dynamic') === 'photo' ? '' : 'opacity-50 pointer-events-none' ?>">
                        <label class="block text-sm font-semibold text-earth-700 mb-1">Unggah Gambar Bagan Struktur</label>
                        
                        <!-- Preview -->
                        <div class="w-full h-48 bg-gray-50 rounded-xl border border-gray-200 overflow-hidden flex items-center justify-center relative" id="structurePreviewContainer">
                            <?php if (!empty($settings['officer_structure_image'])): ?>
                                <img src="<?= base_url($settings['officer_structure_image']) ?>" class="w-full h-full object-contain p-2" id="structurePreviewImg">
                            <?php else: ?>
                                <div class="text-gray-400 text-xs text-center p-4" id="structurePlaceholder">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Belum ada foto bagan struktur organisasi.
                                </div>
                                <img id="structurePreviewImg" class="w-full h-full object-contain p-2 hidden">
                            <?php endif; ?>
                        </div>

                        <!-- Upload field path -->
                        <input type="hidden" name="officer_structure_image" id="structureImageUrl" value="<?= esc($settings['officer_structure_image'] ?? '') ?>">
                        
                        <label class="block cursor-pointer">
                            <div class="flex items-center justify-center gap-2 w-full bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-xl text-xs transition shadow-sm">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span id="uploadBtnText">Pilih / Unggah Gambar</span>
                            </div>
                            <input type="file" id="structureFileInput" accept="image/*,.heic,.heif" class="hidden">
                        </label>
                        <div id="uploadProgressText" class="text-xs text-blue-600 font-medium hidden"></div>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-8 border-t border-earth-100 flex justify-end">
                <button type="submit" class="bg-blue-700 hover:bg-blue-600 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- heic2any: converts HEIC/HEIF (iPhone photos) to WebP/JPEG in the browser -->
<script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const structureMode = document.getElementById('structureMode');
    const photoModeContainer = document.getElementById('photoModeContainer');
    const structureFileInput = document.getElementById('structureFileInput');
    const structureImageUrl = document.getElementById('structureImageUrl');
    const structurePreviewImg = document.getElementById('structurePreviewImg');
    const structurePlaceholder = document.getElementById('structurePlaceholder');
    const uploadBtnText = document.getElementById('uploadBtnText');
    const uploadProgressText = document.getElementById('uploadProgressText');

    // Toggle container view
    structureMode.addEventListener('change', function() {
        if (this.value === 'photo') {
            photoModeContainer.classList.remove('opacity-50', 'pointer-events-none');
        } else {
            photoModeContainer.classList.add('opacity-50', 'pointer-events-none');
        }
    });

    // Helper functions for image compression / HEIC conversion
    function isHeic(file) {
        if (file.type === 'image/heic' || file.type === 'image/heif') return true;
        const ext = (file.name.split('.').pop() || '').toLowerCase();
        return ext === 'heic' || ext === 'heif';
    }

    async function toWebP(file, maxWidth = 1920, quality = 0.85) {
        let src = file;
        if (isHeic(file)) {
            const blob = await heic2any({ blob: file, toType: 'image/jpeg', quality: 0.9 });
            src = new File([Array.isArray(blob) ? blob[0] : blob],
                file.name.replace(/\.(heic|heif)$/i, '.jpg'), { type: 'image/jpeg' });
        }
        return new Promise((resolve) => {
            const img = new Image();
            const url = URL.createObjectURL(src);
            img.onload = () => {
                URL.revokeObjectURL(url);
                let { width, height } = img;
                if (width > maxWidth) { height = Math.round(height * maxWidth / width); width = maxWidth; }
                const canvas = document.createElement('canvas');
                canvas.width = width; canvas.height = height;
                canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                canvas.toBlob(blob => {
                    resolve(new File([blob], file.name.replace(/\.[^.]+$/, '.webp'), { type: 'image/webp' }));
                }, 'image/webp', quality);
            };
            img.onerror = () => { URL.revokeObjectURL(url); resolve(file); };
            img.src = url;
        });
    }

    // Handle file selection and upload
    structureFileInput.addEventListener('change', async function() {
        const file = this.files[0];
        if (!file) return;

        uploadBtnText.textContent = '⚙️ Memproses Gambar...';
        uploadProgressText.classList.remove('hidden');
        uploadProgressText.textContent = isHeic(file) ? '🔄 Mengkonversi HEIC ke WebP...' : '⚡ Mengompresi Gambar...';

        try {
            const webpFile = await toWebP(file);
            uploadProgressText.textContent = '⬆️ Mengunggah ke server...';

            const formData = new FormData();
            formData.append('file', webpFile);

            const response = await fetch('<?= base_url('admin/file-manager/upload') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                let savedPath = result.url;
                // Convert to relative path
                const uploadsIndex = savedPath.indexOf('uploads/');
                if (uploadsIndex !== -1) {
                    savedPath = savedPath.substring(uploadsIndex);
                }

                structureImageUrl.value = savedPath;
                structurePreviewImg.src = '<?= base_url() ?>' + savedPath;
                structurePreviewImg.classList.remove('hidden');
                if (structurePlaceholder) structurePlaceholder.classList.add('hidden');

                uploadProgressText.textContent = '✅ Gambar berhasil diunggah!';
                setTimeout(() => uploadProgressText.classList.add('hidden'), 3000);
            } else {
                alert('Gagal unggah: ' + result.message);
                uploadProgressText.textContent = '❌ Upload gagal.';
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat memproses gambar.');
            uploadProgressText.textContent = '❌ Terjadi kesalahan.';
        } finally {
            uploadBtnText.textContent = 'Pilih / Unggah Gambar';
            structureFileInput.value = ''; // Reset input
        }
    });
});
</script>

<?= $this->endSection() ?>
