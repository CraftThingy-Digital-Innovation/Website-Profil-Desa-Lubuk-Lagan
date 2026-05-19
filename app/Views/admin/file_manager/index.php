<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">File Manager</h2>
        <p class="text-sm text-gray-500 mt-1">Upload dan kelola media desa — Gambar → WebP (max 1MB) · Video → MP4 (max 100MB) — diproses server</p>
    </div>
</div>

<!-- Upload Zone -->
<div class="bg-white rounded-2xl shadow-sm border-2 border-dashed border-gray-200 hover:border-blue-400 transition-colors p-8 text-center mb-8 group">
    <input type="file" id="fileUpload" class="hidden" accept="image/*,video/*">
    <label for="fileUpload" class="cursor-pointer block">
        <div class="w-16 h-16 rounded-2xl bg-blue-50 group-hover:bg-blue-100 flex items-center justify-center mx-auto mb-4 transition">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
        </div>
        <p class="text-gray-700 font-semibold text-lg">Klik atau seret file ke sini</p>
        <p class="text-gray-400 text-sm mt-1">Gambar dikonversi ke WebP · Video dikompres ke MP4 — otomatis di server</p>
    </label>
    <div id="uploadStatus" class="mt-4 text-sm font-medium text-blue-600 hidden"></div>
    <div id="progressContainer" class="w-full max-w-sm mx-auto bg-gray-100 rounded-full h-2 mt-3 hidden">
        <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
    </div>
</div>

<!-- Gallery Grid -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4" id="gallery">
    <?php foreach($files as $file): ?>
    <div class="relative group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" id="file-<?= $file->id ?>">
        <?php if (strpos($file->file_type, 'image') !== false): ?>
            <img src="<?= base_url($file->file_path) ?>" loading="lazy" class="w-full h-36 object-cover" alt="<?= esc($file->original_name) ?>">
        <?php elseif (strpos($file->file_type, 'video') !== false): ?>
            <div class="w-full h-36 bg-gray-900 flex items-center justify-center relative">
                <video src="<?= base_url($file->file_path) ?>" class="w-full h-36 object-cover" preload="none"></video>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <svg class="w-10 h-10 text-white opacity-60" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
            </div>
        <?php else: ?>
            <div class="w-full h-36 flex items-center justify-center bg-gray-50 text-gray-400">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        <?php endif; ?>

        <!-- Hover Actions -->
        <div class="absolute inset-0 bg-gray-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 rounded-2xl">
            <button onclick="copyLink('<?= base_url($file->file_path) ?>')"
                class="bg-white hover:bg-blue-50 text-blue-600 text-xs font-bold py-1.5 px-3 rounded-lg transition shadow">
                📋 Copy Link
            </button>
            <button onclick="deleteFile(<?= $file->id ?>)"
                class="bg-white hover:bg-red-50 text-red-600 text-xs font-bold py-1.5 px-3 rounded-lg transition shadow">
                🗑️ Hapus
            </button>
        </div>

        <!-- File info -->
        <div class="p-3 border-t border-gray-50">
            <p class="text-xs font-semibold text-gray-700 truncate"><?= esc($file->original_name) ?></p>
            <p class="text-xs text-gray-400 mt-0.5"><?= number_format($file->file_size / 1024, 1) ?> KB</p>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if(empty($files)): ?>
    <div class="col-span-full py-12 text-center text-gray-400">
        <svg class="w-12 h-12 mx-auto text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <p class="font-medium">Belum ada file. Upload file pertama Anda!</p>
    </div>
    <?php endif; ?>
</div>

<script>
// Upload via XHR agar ada progress bar — kompresi dilakukan PHP server-side
const fileUpload        = document.getElementById('fileUpload');
const uploadStatusEl    = document.getElementById('uploadStatus');
const progressContainer = document.getElementById('progressContainer');
const progressBar       = document.getElementById('progressBar');

function showStatus(msg, color = 'text-blue-600') {
    uploadStatusEl.textContent = msg;
    uploadStatusEl.className   = `mt-4 text-sm font-medium ${color}`;
    uploadStatusEl.classList.remove('hidden');
}

fileUpload.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 500 * 1024 * 1024) {
        showStatus('❌ File terlalu besar (maks 500MB).', 'text-red-600');
        return;
    }

    progressContainer.classList.remove('hidden');
    progressBar.style.width = '5%';
    showStatus(`⏳ Mengunggah "${file.name}"… server akan mengompresi otomatis.`);

    const formData = new FormData();
    formData.append('file', file);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= base_url('admin/file-manager/upload') ?>');

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const pct = Math.round((e.loaded / e.total) * 85);
            progressBar.style.width = pct + '%';
        }
    };

    xhr.onload = function() {
        progressBar.style.width = '100%';
        try {
            const result = JSON.parse(xhr.responseText);
            if (result.status === 'success') {
                showStatus('✅ Upload & kompresi berhasil!', 'text-green-600');
                setTimeout(() => location.reload(), 1200);
            } else {
                showStatus('❌ Gagal: ' + result.message, 'text-red-600');
                progressContainer.classList.add('hidden');
            }
        } catch(e) {
            showStatus('❌ Response tidak valid dari server.', 'text-red-600');
        }
    };

    xhr.onerror = function() {
        showStatus('❌ Koneksi gagal. Cek internet.', 'text-red-600');
        progressContainer.classList.add('hidden');
    };

    xhr.send(formData);
    event.target.value = '';
});

async function deleteFile(id) {
    if (!confirm('Hapus file ini secara permanen?')) return;
    const res    = await fetch(`<?= base_url('admin/file-manager/delete/') ?>${id}`, { method: 'DELETE' });
    const result = await res.json();
    if (result.status === 'success') {
        document.getElementById(`file-${id}`).remove();
    } else {
        alert(result.message);
    }
}

function copyLink(url) {
    navigator.clipboard.writeText(url).then(function() {
        const btns = document.querySelectorAll('button');
        btns.forEach(b => {
            if (b.onclick && b.onclick.toString().includes(url)) {
                const orig = b.textContent;
                b.textContent = '✅ Disalin!';
                setTimeout(() => b.textContent = orig, 2000);
            }
        });
    });
}
</script>

<?= $this->endSection() ?>
