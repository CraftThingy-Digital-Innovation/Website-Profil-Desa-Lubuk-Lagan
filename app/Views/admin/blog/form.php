<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita - Desa Lubuk Lagan</title>
    <!-- jQuery, Bootstrap (required for Summernote), Summernote -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .note-editor { background: white; }
    </style>
</head>
<body class="bg-gray-100 p-8 font-sans">

<div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-6">
    <!-- Main Form -->
    <div class="w-full md:w-3/4 bg-white rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Editor Berita</h1>
            <span id="saveStatus" class="text-sm text-gray-500 font-bold bg-gray-200 px-3 py-1 rounded">Autosave: Idle</span>
        </div>

        <input type="hidden" id="blogId" value="<?= $blog->id ?>">

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Judul Berita</label>
            <input type="text" id="title" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg font-semibold" value="<?= htmlspecialchars($blog->title) ?>" placeholder="Mulai ketik deskripsi atau konten, ini akan otomatis terisi...">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Slug (URL)</label>
            <input type="text" id="slug" class="w-full border p-2 rounded bg-gray-50 focus:outline-none" value="<?= htmlspecialchars($blog->slug) ?>" readonly title="Diisi otomatis dari Judul">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Konten</label>
            <textarea id="content"><?= $blog->content ?></textarea>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="w-full md:w-1/4 flex flex-col gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="font-bold text-gray-800 mb-2">Status Publikasi</h2>
            <select id="status" class="w-full border p-2 rounded mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="draft" <?= $blog->status == 'draft' ? 'selected' : '' ?>>Draft (Sembunyikan)</option>
                <option value="public" <?= $blog->status == 'public' ? 'selected' : '' ?>>Publik (Tampilkan)</option>
            </select>

            <h2 class="font-bold text-gray-800 mb-2">SEO Score</h2>
            <div class="text-3xl font-black mb-2" id="seoScoreText">0/100</div>
            <input type="hidden" id="seoScore" value="<?= $blog->seo_score ?>">
            <p class="text-xs text-gray-500 mb-4" id="seoFeedback">Ketik sesuatu untuk menilai SEO.</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-2">
                <h2 class="font-bold text-gray-800">Deskripsi SEO</h2>
                <label class="text-xs flex items-center gap-1 cursor-pointer font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">
                    <input type="checkbox" id="autoSeoToggle" <?= empty($blog->description) ? 'checked' : '' ?>> AUTO
                </label>
            </div>
            <p class="text-xs text-gray-400 mb-2">Berpengaruh untuk Google Search.</p>
            <textarea id="description" rows="5" class="w-full border p-2 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Biarkan Auto menyala agar AI meringkas konten..."><?= htmlspecialchars($blog->description ?? '') ?></textarea>
            
            <!-- Saran SEO AI -->
            <div id="seoSuggestion" class="mt-3 text-xs text-blue-700 hidden bg-blue-100 p-3 rounded-lg border border-blue-200 cursor-pointer hover:bg-blue-200 transition">
                <strong class="block mb-1">🤖 Sugesti Otomatis:</strong> 
                <span id="autoSuggestionText" class="italic"></span>
                <div class="mt-2 text-right font-bold">Klik untuk Pakai</div>
            </div>
        </div>
        
        <a href="<?= base_url('admin/blog') ?>" class="text-center w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 rounded-lg shadow-md transition">
            &larr; Kembali ke Daftar
        </a>
    </div>
</div>

<script>
    // Initialize Summernote
    $(document).ready(function() {
        $('#content').summernote({
            height: 500,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    analyzeSEO();
                    scheduleAutoSave();
                }
            }
        });
    });

    const titleEl = document.getElementById('title');
    const slugEl = document.getElementById('slug');
    const descEl = document.getElementById('description');
    const statusEl = document.getElementById('status');
    const saveStatus = document.getElementById('saveStatus');
    const seoScoreText = document.getElementById('seoScoreText');
    const seoScoreInput = document.getElementById('seoScore');
    const seoFeedback = document.getElementById('seoFeedback');
    const autoSeoToggle = document.getElementById('autoSeoToggle');
    const seoSuggestion = document.getElementById('seoSuggestion');
    const autoSuggestionText = document.getElementById('autoSuggestionText');

    let typingTimer;

    // Auto-generate Slug & trigger analysis
    titleEl.addEventListener('input', function() {
        slugEl.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        analyzeSEO();
        scheduleAutoSave();
    });
    
    statusEl.addEventListener('change', scheduleAutoSave);
    
    // User manual type on Description
    descEl.addEventListener('input', () => {
        if (autoSeoToggle.checked) autoSeoToggle.checked = false; // Turn off auto if manual edit
        analyzeSEO();
        scheduleAutoSave();
    });

    // Toggle Auto SEO
    autoSeoToggle.addEventListener('change', function() {
        if(this.checked) {
            seoSuggestion.classList.add('hidden');
            analyzeSEO();
            scheduleAutoSave();
        }
    });

    // Click suggestion to apply
    seoSuggestion.addEventListener('click', function() {
        descEl.value = autoSuggestionText.innerText;
        autoSeoToggle.checked = true;
        this.classList.add('hidden');
        analyzeSEO();
        scheduleAutoSave();
    });

    function analyzeSEO() {
        let score = 0;
        let feedback = [];
        
        const title = titleEl.value;
        const contentHtml = $('#content').summernote('code');
        const contentText = contentHtml.replace(/<\/?[^>]+(>|$)/g, "").replace(/&nbsp;/ig, " ").trim();
        const desc = descEl.value;

        // Auto Generate Title from Description if title is draft/empty
        if ((title === 'Draft Tanpa Judul' || title.length === 0) && desc.length > 5) {
            titleEl.value = desc.substring(0, 40) + '...';
            slugEl.value = titleEl.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        }
        
        // Auto Generate Title from Content if both Title & Desc are empty
        if ((titleEl.value === 'Draft Tanpa Judul' || titleEl.value.length === 0) && contentText.length > 5) {
            titleEl.value = contentText.substring(0, 40) + '...';
            slugEl.value = titleEl.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        }

        // Sugesti Auto Description dari Konten
        let suggestedDesc = contentText.substring(0, 150).trim();
        if (autoSeoToggle.checked && suggestedDesc.length > 0) {
            descEl.value = suggestedDesc;
        } else if (suggestedDesc !== desc && suggestedDesc.length > 0 && !autoSeoToggle.checked) {
            seoSuggestion.classList.remove('hidden');
            autoSuggestionText.innerText = suggestedDesc;
        } else {
            seoSuggestion.classList.add('hidden');
        }

        // Scoring Logic
        if (titleEl.value.length > 30 && titleEl.value.length < 60) { score += 30; } else { feedback.push("Panjang judul harus 30-60."); }
        if (contentText.length > 300) { score += 40; } else { feedback.push("Konten harus >300 karakter."); }
        if (descEl.value.length > 100 && descEl.value.length <= 160) { score += 30; } else { feedback.push("Deskripsi SEO harus 100-160."); }

        if(score === 100) feedback.push("SEO Sempurna! Lanjutkan.");

        seoScoreInput.value = score;
        seoScoreText.innerText = score + '/100';
        seoScoreText.className = "text-3xl font-black mb-2 " + (score > 70 ? "text-green-500" : (score > 40 ? "text-yellow-500" : "text-red-500"));
        seoFeedback.innerText = feedback.join(" ");
    }

    function scheduleAutoSave() {
        clearTimeout(typingTimer);
        saveStatus.innerText = "Autosave: Mengetik...";
        saveStatus.className = "text-sm text-yellow-700 font-bold bg-yellow-200 px-3 py-1 rounded shadow-sm";
        typingTimer = setTimeout(autoSavePost, 2000); // Debounce 2 seconds
    }

    async function autoSavePost() {
        saveStatus.innerText = "Autosave: Menyimpan...";
        saveStatus.className = "text-sm text-blue-700 font-bold bg-blue-200 px-3 py-1 rounded shadow-sm";
        
        const formData = new FormData();
        formData.append('id', document.getElementById('blogId').value);
        formData.append('title', titleEl.value);
        formData.append('slug', slugEl.value);
        formData.append('description', descEl.value);
        formData.append('content', $('#content').summernote('code'));
        formData.append('seo_score', seoScoreInput.value);
        formData.append('status', statusEl.value);

        try {
            const response = await fetch('<?= base_url('admin/blog/autosave') ?>', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.status === 'success') {
                saveStatus.innerText = "Tersimpan pada " + result.last_saved;
                saveStatus.className = "text-sm text-green-700 font-bold bg-green-200 px-3 py-1 rounded shadow-sm transition-all";
            }
        } catch (e) {
            saveStatus.innerText = "Gagal Menyimpan! Cek Internet.";
            saveStatus.className = "text-sm text-red-700 font-bold bg-red-200 px-3 py-1 rounded shadow-sm animate-pulse";
        }
    }

    // Initial Analysis
    setTimeout(analyzeSEO, 500);
</script>
</body>
</html>
