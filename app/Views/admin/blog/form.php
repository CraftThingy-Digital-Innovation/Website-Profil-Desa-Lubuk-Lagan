<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<!-- jQuery harus dimuat SEBELUM Summernote -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

<style>
    .note-editor.note-frame { border: 1px solid #e5e7eb !important; border-radius: 0.75rem !important; }
    .note-toolbar { background: #f9fafb !important; border-bottom: 1px solid #e5e7eb !important; border-radius: 0.75rem 0.75rem 0 0 !important; padding: 0.5rem !important; }
    .note-btn { border-radius: 6px !important; }
    .note-editable { min-height: 420px !important; padding: 1.5rem !important; font-size: 15px !important; line-height: 1.8 !important; }
    .note-statusbar, .note-resizebar { display: none !important; }
    .note-popover .popover-content, .note-editor .note-toolbar { display: flex; flex-wrap: wrap; }

    /* File Manager Modal */
    #filePickerModal {
        display: none; position: fixed; inset: 0; z-index: 9999;
        background: rgba(15,23,42,0.65); backdrop-filter: blur(4px);
        align-items: center; justify-content: center;
    }
    #filePickerModal.open { display: flex; }
</style>

<!-- FILE PICKER MODAL -->
<div id="filePickerModal">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl mx-4 flex flex-col overflow-hidden" style="max-height:85vh">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 flex-shrink-0">
            <div>
                <h3 class="font-bold text-gray-800 text-lg" id="modalTitle">Pilih File</h3>
                <p class="text-xs text-gray-400 mt-0.5">Klik thumbnail untuk menyisipkan ke konten artikel</p>
            </div>
            <button onclick="closePicker()" class="w-8 h-8 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-700 transition text-xl font-bold flex items-center justify-center">&times;</button>
        </div>

        <!-- Upload bar — kompresi kini di server -->
        <div class="px-6 py-3 border-b border-gray-50 bg-gray-50 flex-shrink-0 flex items-center gap-4">
            <label class="inline-flex items-center gap-2 cursor-pointer bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                Upload File Baru
                <input type="file" id="pickerUploadInput" class="hidden" accept="image/*,video/*">
            </label>
            <div id="pickerUploadStatus" class="text-sm text-gray-500 flex items-center gap-2">
                <span id="pickerStatusText"></span>
                <div id="pickerProgress" class="hidden w-32 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                    <div id="pickerProgressBar" class="h-full bg-blue-500 transition-all" style="width:0%"></div>
                </div>
            </div>
        </div>

        <!-- File grid -->
        <div class="flex-1 overflow-y-auto p-6">
            <div id="filePickerGrid" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                <div class="col-span-full text-center py-10 text-gray-400">
                    <div class="animate-pulse">Memuat file media...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LAYOUT UTAMA -->
<div class="flex gap-6 items-start">

    <!-- MAIN EDITOR -->
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <a href="<?= base_url('admin/blog') ?>" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="text-xl font-bold text-gray-800">Editor Berita</h2>
            </div>
            <span id="saveStatus" class="text-xs font-bold px-3 py-1.5 rounded-full bg-gray-100 text-gray-500">● Idle</span>
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
                <span class="text-xs font-bold text-gray-400 whitespace-nowrap">/baca/</span>
                <input type="text" id="slug"
                    class="flex-1 text-sm text-blue-500 border-0 outline-none bg-transparent font-mono"
                    value="<?= htmlspecialchars($blog->slug) ?>" readonly>
                <button onclick="toggleSlugEdit()" class="text-xs text-gray-400 hover:text-blue-500 transition flex-shrink-0">Edit</button>
            </div>

            <!-- Summernote -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <textarea id="content"><?= $blog->content ?></textarea>
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="w-72 flex-shrink-0 space-y-4">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Publikasi</h3>
            <select id="status" class="w-full border border-gray-200 focus:border-blue-500 rounded-xl px-3 py-2.5 text-sm outline-none transition mb-3">
                <option value="draft"  <?= $blog->status == 'draft'  ? 'selected' : '' ?>>📝 Draft — Tersembunyi</option>
                <option value="public" <?= $blog->status == 'public' ? 'selected' : '' ?>>🌐 Publik — Tayang</option>
            </select>

            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tanggal Terbit</label>
            <input type="date" id="publishedAt"
                value="<?= $blog->published_at ? date('Y-m-d', strtotime($blog->published_at)) : date('Y-m-d') ?>"
                class="w-full border border-gray-200 focus:border-blue-500 rounded-xl px-3 py-2.5 text-sm outline-none transition mb-3"
                onchange="autoSavePost()">

            <button onclick="autoSavePost()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm transition">
                Simpan Sekarang
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Skor SEO</h3>
            <div class="flex items-end gap-2 mb-2">
                <span id="seoScoreText" class="text-4xl font-black text-gray-800">0</span>
                <span class="text-gray-300 text-lg mb-1">/100</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2 mb-3">
                <div id="seoBar" class="h-2 rounded-full bg-red-400 transition-all duration-500" style="width:0%"></div>
            </div>
            <input type="hidden" id="seoScore" value="<?= $blog->seo_score ?? 0 ?>">
            <p class="text-xs text-gray-400 leading-relaxed" id="seoFeedback">Ketik konten untuk analisis SEO.</p>
        </div>

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
                placeholder="Deskripsi SEO 100-160 karakter..."><?= htmlspecialchars($blog->description ?? '') ?></textarea>
            <div id="seoSuggestion" class="mt-2 hidden text-xs bg-blue-50 text-blue-700 p-3 rounded-xl border border-blue-100 cursor-pointer hover:bg-blue-100 transition">
                <strong class="block mb-1">🤖 Sugesti AI:</strong>
                <span id="autoSuggestionText" class="italic"></span>
                <div class="mt-2 text-right font-bold text-blue-600">↑ Klik untuk Pakai</div>
            </div>
        </div>

        <a href="<?= base_url($blog->status === 'draft' ? 'admin/blog/preview/'.$blog->id : 'baca/'.$blog->slug) ?>" target="_blank"
            class="flex items-center justify-center gap-2 w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-xl text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Pratinjau Artikel
        </a>
    </div>
</div>

<script>
// ============================================================
// SUMMERNOTE — custom buttons upload via file manager kita
// ============================================================
let currentPickerMode = 'image';

function makePickerBtn(label, icon, mode) {
    return function(context) {
        return $.summernote.ui.button({
            contents: icon + ' ' + label,
            tooltip: 'Pilih atau upload ' + label.toLowerCase() + ' dari server',
            click: function() { openPicker(mode); }
        }).render();
    };
}

$(document).ready(function() {
    $('#content').summernote({
        height: 420,
        toolbar: [
            ['style',  ['style']],
            ['font',   ['bold', 'italic', 'underline', 'clear']],
            ['color',  ['color']],
            ['para',   ['ul', 'ol', 'paragraph']],
            ['table',  ['table']],
            ['insert', ['link', 'uploadImg', 'uploadVid']],
            ['view',   ['fullscreen', 'codeview']],
        ],
        buttons: {
            uploadImg: makePickerBtn('Upload Foto', '🖼️', 'image'),
            uploadVid: makePickerBtn('Upload Video', '🎬', 'video'),
        },
        disableDragAndDrop: false,
        callbacks: {
            onImageUpload: function(files) {
                // Intercept default image paste/drop → upload ke server kita
                uploadToServer(files[0], function(url) {
                    $('#content').summernote('insertImage', url);
                });
            },
            onChange: function() {
                analyzeSEO();
                scheduleAutoSave();
            }
        }
    });
});

// ============================================================
// FILE PICKER MODAL
// ============================================================
async function openPicker(mode) {
    currentPickerMode = mode;
    document.getElementById('modalTitle').textContent =
        mode === 'image' ? '🖼️ Pilih atau Upload Foto' : '🎬 Pilih atau Upload Video';
    document.getElementById('filePickerModal').classList.add('open');
    await loadPickerFiles(mode);
}

function closePicker() {
    document.getElementById('filePickerModal').classList.remove('open');
}

// Klik backdrop → tutup
document.getElementById('filePickerModal').addEventListener('click', function(e) {
    if (e.target === this) closePicker();
});

async function loadPickerFiles(filterType) {
    const grid = document.getElementById('filePickerGrid');
    grid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-400 animate-pulse">Memuat...</div>';
    try {
        const res   = await fetch('<?= base_url('admin/file-manager/api/list') ?>');
        const data  = await res.json();
        let files   = (data.files || []).filter(f => f.file_type.startsWith(filterType));

        if (!files.length) {
            grid.innerHTML = '<div class="col-span-full text-center py-10 text-gray-400">Belum ada ' + filterType + '. Upload dulu!</div>';
            return;
        }

        grid.innerHTML = files.map(f => `
            <div class="group rounded-xl overflow-hidden border border-gray-100 cursor-pointer hover:border-blue-400 hover:shadow-lg transition-all duration-200"
                 onclick="insertFromPicker('${f.url}', '${f.file_type}', '${escHtml(f.original_name)}')">
                ${f.file_type.startsWith('image')
                    ? `<img src="${f.url}" loading="lazy" class="w-full h-24 object-cover">`
                    : `<div class="w-full h-24 bg-gray-900 flex items-center justify-center text-3xl">▶</div>`
                }
                <div class="p-2 bg-white">
                    <p class="text-xs text-gray-600 truncate font-medium">${escHtml(f.original_name)}</p>
                    <p class="text-xs text-gray-400">${(f.file_size/1024).toFixed(0)} KB</p>
                </div>
            </div>`
        ).join('');
    } catch(e) {
        grid.innerHTML = `<div class="col-span-full text-center py-6 text-red-400">❌ Gagal memuat: ${e.message}</div>`;
    }
}

function insertFromPicker(url, type, name) {
    if (type.startsWith('image')) {
        $('#content').summernote('insertImage', url, name);
    } else {
        const html = `<div style="margin:1rem 0;"><video controls preload="metadata" style="max-width:100%;border-radius:8px;" src="${url}">Video tidak didukung browser ini.</video></div><p><br></p>`;
        $('#content').summernote('pasteHTML', html);
    }
    closePicker();
    scheduleSave();
}

function escHtml(s) { return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/"/g,'&quot;'); }

// ============================================================
// QUICK UPLOAD dari modal (server-side compression)
// ============================================================
document.getElementById('pickerUploadInput').addEventListener('change', async function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const statusText = document.getElementById('pickerStatusText');
    const bar        = document.getElementById('pickerProgress');
    const barFill    = document.getElementById('pickerProgressBar');
    const origMB     = (file.size / (1024 * 1024)).toFixed(2);
    
    bar.classList.remove('hidden');
    barFill.style.width = '5%';

    let fileToUpload = file;
    if (file.type.startsWith('image/')) {
        statusText.textContent = `⚙️ Mengkompresi ${file.name} (${origMB} MB)...`;
        fileToUpload = await compressImageClientSide(file);
        const compMB = (fileToUpload.size / (1024 * 1024)).toFixed(2);
        statusText.textContent = `📦 Terkompresi: ${origMB} MB → ${compMB} MB. Mengunggah...`;
    } else {
        statusText.textContent = `🎬 Mengunggah video ${origMB} MB (akan diproses server)...`;
    }
    barFill.style.width = '20%';

    try {
        const form = new FormData();
        form.append('file', fileToUpload);
        
        await new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('admin/file-manager/upload') ?>');
            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    const pct = Math.round((e.loaded / e.total) * 100);
                    // Map upload progress to 20-90% of total bar
                    barFill.style.width = (20 + Math.round(pct * 0.7)) + '%';
                    const loadedMB = (e.loaded / (1024 * 1024)).toFixed(2);
                    const totalMB = (e.total / (1024 * 1024)).toFixed(2);
                    statusText.textContent = `⬆️ Mengunggah ${loadedMB} / ${totalMB} MB (${pct}%)`;
                }
            };
            xhr.onload = () => {
                barFill.style.width = '95%';
                statusText.textContent = '⚙️ Server memproses...';
                try {
                    const result = JSON.parse(xhr.responseText);
                    if (result.status === 'success') {
                        barFill.style.width = '100%';
                        statusText.textContent = `✅ Selesai! (${origMB} MB → ${(fileToUpload.size/1024/1024).toFixed(2)} MB)`;
                        resolve(result);
                    } else {
                        reject(new Error(result.message));
                    }
                } catch(err) {
                    reject(new Error('Respons server tidak valid.'));
                }
            };
            xhr.onerror = () => reject(new Error('Terjadi kesalahan jaringan.'));
            xhr.send(form);
        });

        await loadPickerFiles(currentPickerMode);
    } catch(err) {
        statusText.textContent = '❌ Error: ' + err.message;
        barFill.style.width = '0%';
    }
    setTimeout(() => { bar.classList.add('hidden'); barFill.style.width='0%'; statusText.textContent=''; }, 5000);
    this.value = '';
});

// ============================================================
// UPLOAD langsung dari drag-drop/paste ke editor
// ============================================================
async function compressImageClientSide(file, maxWidth = 1920, quality = 0.82) {
    return new Promise((resolve) => {
        // Only compress images, pass through videos
        if (!file.type.startsWith('image/')) { resolve(file); return; }
        const img = new Image();
        const url = URL.createObjectURL(file);
        img.onload = () => {
            URL.revokeObjectURL(url);
            let { width, height } = img;
            if (width > maxWidth) {
                height = Math.round((height * maxWidth) / width);
                width = maxWidth;
            }
            const canvas = document.createElement('canvas');
            canvas.width = width; canvas.height = height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, width, height);
            canvas.toBlob((blob) => {
                resolve(new File([blob], file.name.replace(/\.[^.]+$/, '.webp'), { type: 'image/webp' }));
            }, 'image/webp', quality);
        };
        img.onerror = () => { URL.revokeObjectURL(url); resolve(file); };
        img.src = url;
    });
}

function uploadToServer(file, callback) {
    compressImageClientSide(file).then(compressedFile => {
        const form = new FormData();
        form.append('file', compressedFile);
        fetch('<?= base_url('admin/file-manager/upload') ?>', { method:'POST', body:form })
            .then(r => r.json())
            .then(data => { if (data.status === 'success' && callback) callback(data.url); })
            .catch(console.error);
    });
}

// ============================================================
// SEO + AUTOSAVE
// ============================================================
const titleEl  = document.getElementById('title');
const slugEl   = document.getElementById('slug');
const descEl   = document.getElementById('description');
const statusEl = document.getElementById('status');

titleEl.addEventListener('input', () => {
    slugEl.value = titleEl.value.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
        .replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)+/g,'');
    analyzeSEO(); scheduleSave();
});
statusEl.addEventListener('change', scheduleSave);
descEl.addEventListener('input', () => {
    document.getElementById('autoSeoToggle').checked = false;
    analyzeSEO(); scheduleSave();
});
document.getElementById('autoSeoToggle').addEventListener('change', analyzeSEO);
document.getElementById('seoSuggestion').addEventListener('click', function() {
    descEl.value = document.getElementById('autoSuggestionText').innerText;
    document.getElementById('autoSeoToggle').checked = true;
    this.classList.add('hidden');
    analyzeSEO(); scheduleSave();
});

function analyzeSEO() {
    let score = 0, fb = [];
    const title = titleEl.value;
    const html  = $('#content').summernote('code');
    const text  = html.replace(/<[^>]+>/g,'').replace(/&nbsp;/gi,' ').trim();
    const desc  = descEl.value;
    const sug   = text.substring(0,155).trim();
    const auto  = document.getElementById('autoSeoToggle').checked;

    if (auto && sug) descEl.value = sug;
    else if (sug && sug !== desc && !auto) {
        document.getElementById('seoSuggestion').classList.remove('hidden');
        document.getElementById('autoSuggestionText').innerText = sug;
    } else {
        document.getElementById('seoSuggestion').classList.add('hidden');
    }

    if (title.length >= 30 && title.length <= 60) score += 30; else fb.push('Judul 30-60 karakter.');
    if (text.length > 300) score += 40; else fb.push('Konten min. 300 karakter.');
    if (desc.length >= 100 && desc.length <= 160) score += 30; else fb.push('Deskripsi SEO 100-160 karakter.');
    if (score === 100) fb = ['✅ SEO sempurna!'];

    document.getElementById('seoScore').value = score;
    const st = document.getElementById('seoScoreText');
    const bar = document.getElementById('seoBar');
    st.textContent = score;
    st.className = 'text-4xl font-black ' + (score>70?'text-green-500':score>40?'text-yellow-500':'text-red-400');
    bar.style.width = score + '%';
    bar.className = 'h-2 rounded-full transition-all duration-500 ' + (score>70?'bg-green-500':score>40?'bg-yellow-500':'bg-red-400');
    document.getElementById('seoFeedback').textContent = fb.join(' ');
}

let _saveTimer;
function scheduleSave() {
    clearTimeout(_saveTimer);
    const ss = document.getElementById('saveStatus');
    ss.textContent = '● Mengetik...';
    ss.className = 'text-xs font-bold px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-700';
    _saveTimer = setTimeout(autoSavePost, 2000);
}
function scheduleAutoSave() { scheduleSave(); }

async function autoSavePost() {
    const ss = document.getElementById('saveStatus');
    ss.textContent = '● Menyimpan...';
    ss.className = 'text-xs font-bold px-3 py-1.5 rounded-full bg-blue-100 text-blue-700';
    const form = new FormData();
    form.append('id',           document.getElementById('blogId').value);
    form.append('title',        titleEl.value);
    form.append('slug',         slugEl.value);
    form.append('description',  descEl.value);
    form.append('content',      $('#content').summernote('code'));
    form.append('seo_score',    document.getElementById('seoScore').value);
    form.append('status',       statusEl.value);
    form.append('published_at', document.getElementById('publishedAt').value);
    try {
        const res    = await fetch('<?= base_url(($category ?? "blog") === "kkn" ? "admin/kkn/autosave" : "admin/blog/autosave") ?>', { method:'POST', body:form });
        const result = await res.json();
        if (result.status === 'success') {
            ss.textContent = '✓ Tersimpan ' + result.last_saved;
            ss.className = 'text-xs font-bold px-3 py-1.5 rounded-full bg-green-100 text-green-700';
        }
    } catch(e) {
        ss.textContent = '✕ Gagal!';
        ss.className = 'text-xs font-bold px-3 py-1.5 rounded-full bg-red-100 text-red-700 animate-pulse';
    }
}

function toggleSlugEdit() {
    const s = document.getElementById('slug');
    s.readOnly = !s.readOnly;
    if (!s.readOnly) s.focus();
}

setTimeout(analyzeSEO, 600);
</script>

<?= $this->endSection() ?>
