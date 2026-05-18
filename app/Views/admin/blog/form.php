<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<!-- Summernote Assets (harus di dalam layout, sebelum script Tailwind) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

<style>
    .note-editor.note-frame { border-radius: 0.75rem; border-color: #e5e7eb; }
    .note-toolbar { background: #f9fafb !important; border-bottom: 1px solid #e5e7eb !important; border-radius: 0.75rem 0.75rem 0 0 !important; }
    .note-editable { min-height: 450px !important; font-family: 'Inter', sans-serif; font-size: 15px; line-height: 1.8; padding: 1.5rem !important; }
    .note-status-output { display: none !important; }
    .note-resizebar { display: none !important; }
    
    /* File Manager Modal */
    #fileManagerModal {
        display: none; position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
        align-items: center; justify-content: center;
    }
    #fileManagerModal.open { display: flex; }
</style>

<!-- File Manager Modal Overlay -->
<div id="fileManagerModal" role="dialog">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl mx-4 max-h-[85vh] flex flex-col overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <div>
                <h3 class="font-bold text-gray-800 text-lg" id="modalTitle">Pilih File</h3>
                <p class="text-sm text-gray-400 mt-0.5">Klik file untuk menyisipkan ke konten</p>
            </div>
            <button onclick="closeFileManager()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition text-xl font-bold">&times;</button>
        </div>

        <!-- Upload Quick Area -->
        <div class="px-6 py-3 border-b border-gray-50 bg-gray-50">
            <label for="quickUpload" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 cursor-pointer hover:text-blue-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                Upload File Baru
            </label>
            <input type="file" id="quickUpload" class="hidden" accept="image/*,video/*">
            <span id="quickUploadStatus" class="ml-3 text-sm text-gray-500"></span>
        </div>

        <!-- File Grid -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="grid grid-cols-3 md:grid-cols-5 gap-3" id="modalFileGrid">
                <div class="col-span-full text-center py-10 text-gray-400">
                    <svg class="w-10 h-10 mx-auto text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Memuat file...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Layout -->
<div class="flex gap-6 items-start">

    <!-- MAIN EDITOR -->
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <a href="<?= base_url('admin/blog') ?>" class="text-gray-400 hover:text-blue-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="text-xl font-bold text-gray-800">Editor Berita</h2>
            </div>
            <span id="saveStatus" class="text-xs font-bold px-3 py-1.5 rounded-full bg-gray-100 text-gray-500 transition-all">
                ● Idle
            </span>
        </div>

        <input type="hidden" id="blogId" value="<?= $blog->id ?>">

        <div class="space-y-4">
            <!-- Judul -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Judul Artikel</label>
                <input type="text" id="title"
                    class="w-full text-xl font-bold text-gray-800 border-0 outline-none placeholder-gray-300 bg-transparent"
                    value="<?= htmlspecialchars($blog->title) ?>"
                    placeholder="Tulis judul yang menarik dan informatif...">
            </div>

            <!-- Slug -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-3 flex items-center gap-3">
                <span class="text-xs font-bold text-gray-400 whitespace-nowrap">URL Artikel:</span>
                <span class="text-gray-300 text-sm">/baca/</span>
                <input type="text" id="slug"
                    class="flex-1 text-sm text-blue-500 border-0 outline-none bg-transparent font-mono"
                    value="<?= htmlspecialchars($blog->slug) ?>" readonly>
                <button onclick="document.getElementById('slug').removeAttribute('readonly'); document.getElementById('slug').focus();"
                    class="text-xs text-gray-400 hover:text-blue-500 transition flex-shrink-0">Edit</button>
            </div>

            <!-- Summernote Editor -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <textarea id="content"><?= $blog->content ?></textarea>
            </div>
        </div>
    </div>

    <!-- SIDEBAR PANEL -->
    <div class="w-72 flex-shrink-0 space-y-4">

        <!-- Status Publikasi -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Status Publikasi</h3>
            <select id="status" class="w-full border border-gray-200 focus:border-blue-500 rounded-xl px-3 py-2.5 text-sm outline-none transition mb-3">
                <option value="draft"  <?= $blog->status == 'draft'  ? 'selected' : '' ?>>📝 Draft — Tersembunyi</option>
                <option value="public" <?= $blog->status == 'public' ? 'selected' : '' ?>>🌐 Publik — Tayang</option>
            </select>
            <button onclick="autoSavePost()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm transition">
                Simpan Sekarang
            </button>
        </div>

        <!-- SEO Score -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Skor SEO</h3>
            <div class="flex items-end gap-2 mb-2">
                <span id="seoScoreText" class="text-4xl font-black text-gray-800">0</span>
                <span class="text-gray-300 text-lg mb-1">/100</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2 mb-3">
                <div id="seoBar" class="h-2 rounded-full transition-all duration-500 bg-red-400" style="width: 0%"></div>
            </div>
            <input type="hidden" id="seoScore" value="<?= $blog->seo_score ?? 0 ?>">
            <p class="text-xs text-gray-400 leading-relaxed" id="seoFeedback">Ketik konten untuk memulai analisis SEO.</p>
        </div>

        <!-- Deskripsi SEO -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Deskripsi SEO</h3>
                <label class="flex items-center gap-1.5 cursor-pointer">
                    <input type="checkbox" id="autoSeoToggle" <?= empty($blog->description) ? 'checked' : '' ?> class="w-3.5 h-3.5">
                    <span class="text-xs font-semibold text-blue-600">Auto</span>
                </label>
            </div>
            <textarea id="description" rows="4"
                class="w-full border border-gray-200 focus:border-blue-500 rounded-xl px-3 py-2 text-xs outline-none transition resize-none"
                placeholder="Deskripsi untuk Google (100-160 karakter)..."><?= htmlspecialchars($blog->description ?? '') ?></textarea>
            <div id="seoSuggestion" class="mt-2 hidden text-xs bg-blue-50 text-blue-700 p-3 rounded-xl border border-blue-100 cursor-pointer hover:bg-blue-100 transition">
                <strong class="block mb-1">🤖 Sugesti AI:</strong>
                <span id="autoSuggestionText" class="italic"></span>
                <div class="mt-2 text-right font-bold text-blue-600">↑ Klik untuk Pakai</div>
            </div>
        </div>

        <!-- Pratinjau -->
        <a href="<?= base_url('baca/'.$blog->slug) ?>" target="_blank"
            class="flex items-center justify-center gap-2 w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-xl text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Pratinjau Artikel
        </a>
    </div>
</div>

<!-- Image Compression -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.1/dist/browser-image-compression.js"></script>
<!-- FFmpeg -->
<script src="https://unpkg.com/@ffmpeg/ffmpeg@0.12.6/dist/umd/ffmpeg.js"></script>
<script src="https://unpkg.com/@ffmpeg/util@0.12.1/dist/umd/index.js"></script>

<script>
const UPLOAD_URL     = '<?= base_url('admin/file-manager/upload') ?>';
const FILE_LIST_URL  = '<?= base_url('admin/file-manager') ?>';

let insertMode = 'image'; // 'image' | 'video'

// ============================================================
// CUSTOM SUMMERNOTE BUTTONS — Upload Gambar & Video ke Server
// ============================================================
function buildUploadImageButton(context) {
    const ui = $.summernote.ui;
    return ui.button({
        contents: '<i class="note-icon-picture"></i> Upload Foto',
        tooltip: 'Upload foto dari komputer ke File Manager',
        click: () => { insertMode = 'image'; openFileManager('image'); }
    }).render();
}
function buildUploadVideoButton(context) {
    const ui = $.summernote.ui;
    return ui.button({
        contents: '<svg style="width:14px;height:14px;vertical-align:middle;display:inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg> Upload Video',
        tooltip: 'Upload video dari komputer ke File Manager',
        click: () => { insertMode = 'video'; openFileManager('video'); }
    }).render();
}

// ============================================================
// INIT SUMMERNOTE
// ============================================================
$(document).ready(function() {
    $('#content').summernote({
        height: 480,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'uploadImage', 'uploadVideo']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        buttons: {
            uploadImage: buildUploadImageButton,
            uploadVideo: buildUploadVideoButton,
        },
        callbacks: {
            onChange: function(contents) {
                analyzeSEO();
                scheduleAutoSave();
            }
        }
    });
});

// ============================================================
// FILE MANAGER MODAL
// ============================================================
let fileManagerFiles = [];

async function openFileManager(mode) {
    insertMode = mode;
    document.getElementById('modalTitle').textContent = mode === 'image' ? 'Pilih atau Upload Foto' : 'Pilih atau Upload Video';
    document.getElementById('fileManagerModal').classList.add('open');
    await loadFileList(mode);
}

function closeFileManager() {
    document.getElementById('fileManagerModal').classList.remove('open');
}

async function loadFileList(filterType = null) {
    const grid = document.getElementById('modalFileGrid');
    grid.innerHTML = '<div class="col-span-full text-center py-6 text-gray-400">Memuat...</div>';

    try {
        // We hit the file manager page via fetch and parse won't work for JSON
        // Instead, let's use a dedicated API endpoint
        const res  = await fetch('<?= base_url('admin/file-manager/api/list') ?>');
        const data = await res.json();

        let files = data.files || [];
        if (filterType) {
            files = files.filter(f => f.file_type.startsWith(filterType));
        }

        if (!files.length) {
            grid.innerHTML = `<div class="col-span-full text-center py-8 text-gray-400">Belum ada file. Upload di bawah!</div>`;
            return;
        }

        grid.innerHTML = files.map(f => `
            <div class="group rounded-xl overflow-hidden border border-gray-100 cursor-pointer hover:border-blue-400 hover:shadow-md transition"
                 onclick="insertFile('${f.url}', '${f.file_type}', '${f.original_name}')">
                ${f.file_type.startsWith('image')
                    ? `<img src="${f.url}" loading="lazy" class="w-full h-24 object-cover">`
                    : `<div class="w-full h-24 flex items-center justify-center bg-gray-900 text-white text-3xl">▶</div>`
                }
                <div class="p-2 bg-white">
                    <p class="text-xs text-gray-600 truncate">${f.original_name}</p>
                    <p class="text-xs text-gray-400">${(f.file_size/1024).toFixed(1)} KB</p>
                </div>
            </div>
        `).join('');
    } catch (e) {
        grid.innerHTML = `<div class="col-span-full text-center py-6 text-red-400">Gagal memuat file: ${e.message}</div>`;
    }
}

function insertFile(url, type, name) {
    if (type.startsWith('image')) {
        $('#content').summernote('insertImage', url, name);
    } else {
        // Insert video as HTML5 video tag
        const videoHtml = `<div class="video-wrapper" style="margin:1rem 0;"><video controls preload="metadata" style="max-width:100%;border-radius:8px;" src="${url}">Browser Anda tidak mendukung video.</video></div>`;
        $('#content').summernote('pasteHTML', videoHtml);
    }
    closeFileManager();
}

// ============================================================
// QUICK UPLOAD (dari modal file manager)
// ============================================================
document.getElementById('quickUpload').addEventListener('change', async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const statusEl = document.getElementById('quickUploadStatus');
    statusEl.textContent = 'Memproses...';
    let processedFile = file;

    try {
        if (file.type.startsWith('image/')) {
            statusEl.textContent = 'Mengompresi ke WebP...';
            const compressed = await imageCompression(file, {
                maxSizeMB: 1, maxWidthOrHeight: 1920, useWebWorker: true,
                fileType: 'image/webp'
            });
            processedFile = new File([compressed], file.name.replace(/\.[^.]+$/, '.webp'), { type: 'image/webp' });
        } else if (file.type.startsWith('video/')) {
            statusEl.textContent = 'Mengompresi video (mohon tunggu)...';
            const { FFmpeg } = FFmpegWASM;
            const { fetchFile } = FFmpegUtil;
            const ffmpeg = new FFmpeg();
            await ffmpeg.load({
                coreURL: 'https://unpkg.com/@ffmpeg/core@0.12.6/dist/umd/ffmpeg-core.js',
                wasmURL: 'https://unpkg.com/@ffmpeg/core@0.12.6/dist/umd/ffmpeg-core.wasm'
            });
            const ext = file.name.match(/\.[^.]+$/)[0];
            await ffmpeg.writeFile('input' + ext, await fetchFile(file));
            await ffmpeg.exec(['-i', 'input'+ext, '-vcodec', 'libx264', '-crf', '28', '-preset', 'ultrafast', '-c:a', 'aac', '-b:a', '128k', 'output.mp4']);
            const data = await ffmpeg.readFile('output.mp4');
            processedFile = new File([data.buffer], file.name.replace(/\.[^.]+$/, '.mp4'), { type: 'video/mp4' });
        }

        statusEl.textContent = 'Mengunggah...';
        const form = new FormData();
        form.append('file', processedFile);
        const res = await fetch(UPLOAD_URL, { method: 'POST', body: form });
        const result = await res.json();

        if (result.status === 'success') {
            statusEl.textContent = '✅ Upload berhasil!';
            await loadFileList(insertMode === 'image' ? 'image' : 'video');
        } else {
            statusEl.textContent = '❌ Gagal: ' + result.message;
        }
    } catch(e) {
        statusEl.textContent = '❌ Error: ' + e.message;
    }
    event.target.value = '';
});

// Close modal on backdrop click
document.getElementById('fileManagerModal').addEventListener('click', function(e) {
    if (e.target === this) closeFileManager();
});

// ============================================================
// SEO + AUTOSAVE
// ============================================================
const titleEl = document.getElementById('title');
const slugEl  = document.getElementById('slug');
const descEl  = document.getElementById('description');
const statusEl = document.getElementById('status');
const saveStatus = document.getElementById('saveStatus');
const seoScoreText  = document.getElementById('seoScoreText');
const seoScoreInput = document.getElementById('seoScore');
const seoFeedback   = document.getElementById('seoFeedback');
const seoBar        = document.getElementById('seoBar');
const autoSeoToggle = document.getElementById('autoSeoToggle');
const seoSuggestion = document.getElementById('seoSuggestion');
const autoSuggestionText = document.getElementById('autoSuggestionText');

let typingTimer;

titleEl.addEventListener('input', () => {
    slugEl.value = titleEl.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    analyzeSEO(); scheduleAutoSave();
});
statusEl.addEventListener('change', scheduleAutoSave);
descEl.addEventListener('input', () => { if (autoSeoToggle.checked) autoSeoToggle.checked = false; analyzeSEO(); scheduleAutoSave(); });
autoSeoToggle.addEventListener('change', () => { if (autoSeoToggle.checked) analyzeSEO(); });
seoSuggestion.addEventListener('click', () => {
    descEl.value = autoSuggestionText.innerText;
    autoSeoToggle.checked = true;
    seoSuggestion.classList.add('hidden');
    analyzeSEO(); scheduleAutoSave();
});

function analyzeSEO() {
    let score = 0, feedback = [];
    const title = titleEl.value;
    const contentHtml = $('#content').summernote('code');
    const contentText = contentHtml.replace(/<\/?[^>]+(>|$)/g, '').replace(/&nbsp;/ig, ' ').trim();
    const desc = descEl.value;

    if ((title === 'Draft Tanpa Judul' || !title) && contentText.length > 5) {
        titleEl.value = contentText.substring(0, 50) + '...';
        slugEl.value = titleEl.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    }

    const suggested = contentText.substring(0, 155).trim();
    if (autoSeoToggle.checked && suggested) {
        descEl.value = suggested;
    } else if (suggested && suggested !== desc && !autoSeoToggle.checked) {
        seoSuggestion.classList.remove('hidden');
        autoSuggestionText.innerText = suggested;
    } else {
        seoSuggestion.classList.add('hidden');
    }

    if (title.length >= 30 && title.length <= 60) { score += 30; } else { feedback.push('Judul 30-60 karakter.'); }
    if (contentText.length > 300) { score += 40; } else { feedback.push('Konten min. 300 karakter.'); }
    if (desc.length >= 100 && desc.length <= 160) { score += 30; } else { feedback.push('Deskripsi SEO 100-160 karakter.'); }
    if (score === 100) feedback = ['✅ SEO sempurna!'];

    seoScoreInput.value = score;
    seoScoreText.innerText = score;
    seoBar.style.width = score + '%';
    seoBar.className = 'h-2 rounded-full transition-all duration-500 ' + (score > 70 ? 'bg-green-500' : (score > 40 ? 'bg-yellow-500' : 'bg-red-400'));
    seoScoreText.className = 'text-4xl font-black ' + (score > 70 ? 'text-green-500' : (score > 40 ? 'text-yellow-500' : 'text-red-400'));
    seoFeedback.innerText = feedback.join(' ');
}

function scheduleAutoSave() {
    clearTimeout(typingTimer);
    saveStatus.textContent = '● Mengetik...';
    saveStatus.className = 'text-xs font-bold px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-700';
    typingTimer = setTimeout(autoSavePost, 2000);
}

async function autoSavePost() {
    saveStatus.textContent = '● Menyimpan...';
    saveStatus.className = 'text-xs font-bold px-3 py-1.5 rounded-full bg-blue-100 text-blue-700';
    const form = new FormData();
    form.append('id',          document.getElementById('blogId').value);
    form.append('title',       titleEl.value);
    form.append('slug',        slugEl.value);
    form.append('description', descEl.value);
    form.append('content',     $('#content').summernote('code'));
    form.append('seo_score',   seoScoreInput.value);
    form.append('status',      statusEl.value);
    try {
        const res    = await fetch('<?= base_url('admin/blog/autosave') ?>', { method: 'POST', body: form });
        const result = await res.json();
        if (result.status === 'success') {
            saveStatus.textContent = '✓ Tersimpan ' + result.last_saved;
            saveStatus.className = 'text-xs font-bold px-3 py-1.5 rounded-full bg-green-100 text-green-700';
        }
    } catch(e) {
        saveStatus.textContent = '✕ Gagal!';
        saveStatus.className = 'text-xs font-bold px-3 py-1.5 rounded-full bg-red-100 text-red-700 animate-pulse';
    }
}

setTimeout(analyzeSEO, 500);
</script>

<?= $this->endSection() ?>
