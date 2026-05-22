<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<?php
$routeSlug = $category === 'kkn' ? 'kkn' : 'kabar-desa';
$listUrl   = base_url("admin/gallery/{$routeSlug}");
$actionUrl = $item
    ? base_url("admin/gallery/{$routeSlug}/update/{$item->id}")
    : base_url("admin/gallery/{$routeSlug}/store");
?>

<div class="mb-6 flex items-center gap-3">
    <a href="<?= $listUrl ?>" class="p-2 rounded-xl text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $item ? 'Edit Item' : 'Tambah Item' ?></h1>
        <p class="text-gray-400 text-sm mt-0.5"><?= esc($catInfo['label']) ?></p>
    </div>
</div>

<form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data">

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Main Fields -->
    <div class="lg:col-span-2 space-y-5">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Informasi Item</h3>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" required value="<?= esc($item->title ?? '') ?>"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition"
                    placeholder="Cth: Kegiatan Penyuluhan Pertanian">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition resize-none"
                    placeholder="Keterangan singkat tentang foto/video ini..."><?= esc($item->description ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe Media</label>
                    <select name="media_type" id="mediaTypeSelect"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 outline-none transition appearance-none bg-white">
                        <option value="image" <?= ($item->media_type ?? 'image') === 'image' ? 'selected' : '' ?>>🖼️ Gambar / Foto</option>
                        <option value="video" <?= ($item->media_type ?? '') === 'video' ? 'selected' : '' ?>>🎬 Video</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan</label>
                    <input type="number" name="sort_order" min="0" value="<?= $item->sort_order ?? 0 ?>"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 outline-none transition">
                </div>
            </div>
        </div>

        <!-- Media Upload -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Upload Media</h3>

            <div id="imageUploadSection">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    File Foto <span class="text-gray-400 font-normal">(JPG/PNG/WebP — auto-kompres)</span>
                </label>
                <?php if (!empty($item->media_url) && ($item->media_type ?? '') === 'image'): ?>
                <div class="mb-3 rounded-xl overflow-hidden border border-gray-100 h-40 bg-gray-50">
                    <img src="<?= base_url($item->media_url) ?>" class="w-full h-full object-cover" id="imgPreview">
                </div>
                <?php else: ?>
                <div class="mb-3 rounded-xl overflow-hidden border border-dashed border-gray-200 h-40 bg-gray-50 flex items-center justify-center" id="imgPreviewBox">
                    <span class="text-gray-300 text-sm">Preview foto</span>
                </div>
                <?php endif; ?>
                <label class="flex items-center gap-2 cursor-pointer w-full bg-gray-50 hover:bg-gray-100 border-2 border-dashed border-gray-200 hover:border-blue-300 text-gray-500 font-medium py-3 px-4 rounded-xl text-sm transition justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <?= ($item && $item->media_url) ? 'Ganti Foto' : 'Upload Foto' ?>
                    <input type="file" name="media_file" accept="image/*" class="hidden" id="mediaFileInput">
                </label>
            </div>

            <div id="videoUploadSection" class="hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    File Video <span class="text-gray-400 font-normal">(MP4/MOV — maks 100MB)</span>
                </label>
                <?php if (!empty($item->media_url) && ($item->media_type ?? '') === 'video'): ?>
                <video src="<?= base_url($item->media_url) ?>" controls class="w-full rounded-xl mb-3 max-h-48"></video>
                <?php endif; ?>
                <label class="flex items-center gap-2 cursor-pointer w-full bg-gray-50 hover:bg-gray-100 border-2 border-dashed border-gray-200 hover:border-blue-300 text-gray-500 font-medium py-3 px-4 rounded-xl text-sm transition justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <?= ($item && $item->media_type === 'video') ? 'Ganti Video' : 'Upload Video' ?>
                    <input type="file" name="media_file" accept="video/*" class="hidden" id="videoFileInput">
                </label>

                <div class="mt-3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Thumbnail Video (Opsional)</label>
                    <label class="flex items-center gap-2 cursor-pointer w-full bg-gray-50 hover:bg-gray-100 border-2 border-dashed border-gray-200 hover:border-blue-300 text-gray-500 py-2.5 px-4 rounded-xl text-sm transition justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Upload Thumbnail
                        <input type="file" name="cover_file" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-5">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Status Publikasi</h3>
            <div class="space-y-2">
                <?php foreach (['active' => ['✅ Aktif — Tampil di website', 'bg-green-50 border-green-200 text-green-700'],
                                'draft'  => ['📝 Draft — Tersembunyi', 'bg-yellow-50 border-yellow-200 text-yellow-700']] as $val => $info): ?>
                <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition hover:bg-gray-50 <?= ($item->status ?? 'active') === $val ? $info[1] : 'border-gray-100' ?>">
                    <input type="radio" name="status" value="<?= $val ?>" <?= ($item->status ?? 'active') === $val ? 'checked' : '' ?> class="w-4 h-4 accent-blue-600">
                    <span class="text-sm font-medium"><?= $info[0] ?></span>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition shadow flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?= $item ? 'Simpan Perubahan' : 'Tambah Item' ?>
            </button>
            <a href="<?= $listUrl ?>" class="block text-center w-full py-3 rounded-xl font-medium text-gray-500 hover:bg-gray-50 transition text-sm">Batal</a>
        </div>
    </div>
</div>
</form>

<script>
// Toggle image/video sections based on type select
const typeSelect = document.getElementById('mediaTypeSelect');
const imgSection = document.getElementById('imageUploadSection');
const vidSection = document.getElementById('videoUploadSection');

function toggleSections() {
    if (typeSelect.value === 'video') {
        imgSection.classList.add('hidden');
        vidSection.classList.remove('hidden');
    } else {
        imgSection.classList.remove('hidden');
        vidSection.classList.add('hidden');
    }
}
typeSelect.addEventListener('change', toggleSections);
toggleSections(); // run on load

// Image preview
document.getElementById('mediaFileInput').addEventListener('change', function() {
    if (this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            let preview = document.getElementById('imgPreview');
            if (!preview) {
                const box = document.getElementById('imgPreviewBox');
                box.innerHTML = '<img id="imgPreview" class="w-full h-full object-cover">';
                preview = document.getElementById('imgPreview');
            }
            preview.src = e.target.result;
            preview.parentElement.classList.remove('border-dashed');
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<?= $this->endSection() ?>
