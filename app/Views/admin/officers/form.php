<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<!-- heic2any: converts HEIC/HEIF (iPhone photos) to WebP/JPEG in the browser -->
<script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.4/dist/heic2any.min.js"></script>

<div class="mb-6 flex items-center gap-3">
    <a href="<?= base_url('admin/officers') ?>" class="p-2 rounded-xl text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-800"><?= $officer ? 'Edit Perangkat' : 'Tambah Perangkat' ?></h1>
        <p class="text-gray-400 text-sm mt-0.5">Isi data lengkap perangkat desa dan atur posisi hierarkinya.</p>
    </div>
</div>

<form action="<?= $officer ? base_url('admin/officers/update/'.$officer->id) : base_url('admin/officers/store') ?>" method="post" enctype="multipart/form-data">

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- LEFT: Main Fields -->
    <div class="lg:col-span-2 space-y-5">

        <!-- Nama & Jabatan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Identitas</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required value="<?= esc($officer->name ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition"
                        placeholder="Cth: Budi Santoso">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="position" required value="<?= esc($officer->position ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition"
                        placeholder="Cth: Kepala Desa, Sekretaris Desa, Kaur Keuangan...">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kutipan / Motto (Opsional)</label>
                    <input type="text" name="quote" value="<?= esc($officer->quote ?? '') ?>"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 outline-none transition"
                        placeholder="Cth: Melayani dengan sepenuh hati">
                </div>
            </div>
        </div>

        <!-- Hierarki -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Hierarki & Posisi</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Level Hierarki <span class="text-red-500">*</span></label>
                    <select name="level" id="levelSelect"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 outline-none transition appearance-none bg-white">
                        <?php for ($l = 1; $l <= 5; $l++): ?>
                        <option value="<?= $l ?>" <?= ($officer->level ?? 1) == $l ? 'selected' : '' ?>>
                            Level <?= $l ?> — <?= ['Kepala Desa', 'Sekretaris / Wakil', 'Kepala Urusan / Seksi', 'Staff / Pelaksana', 'Kadus / Lainnya'][$l-1] ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                    <p class="text-xs text-gray-400 mt-1.5">Level 1 = paling atas (Kades)</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Atasan Langsung</label>
                    <select name="parent_id"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 outline-none transition appearance-none bg-white">
                        <option value="">— Tidak ada (posisi tertinggi) —</option>
                        <?php foreach ($parents as $p):
                            if ($officer && $p->id == $officer->id) continue; // skip self
                        ?>
                        <option value="<?= $p->id ?>" <?= ($officer->parent_id ?? null) == $p->id ? 'selected' : '' ?>>
                            <?= str_repeat('　', max(0, $p->level - 1)) ?>└ <?= esc($p->name) ?> (<?= esc($p->position) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-xs text-gray-400 mt-1.5">Siapa yang membawahi perangkat ini?</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="<?= $officer->sort_order ?? 0 ?>" min="0"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 outline-none transition">
                    <p class="text-xs text-gray-400 mt-1.5">Angka kecil tampil lebih dulu</p>
                </div>
            </div>

            <!-- Live preview badge -->
            <div class="mt-5 p-4 bg-blue-50 rounded-xl border border-blue-100">
                <p class="text-xs font-bold text-blue-600 mb-1">Preview Posisi:</p>
                <div class="flex items-center gap-2 flex-wrap" id="hierarchyPreview">
                    <span id="previewBadge" class="px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white">Level 1 — Kepala Desa</span>
                    <span id="previewParent" class="text-xs text-blue-500"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: Photo & Submit -->
    <div class="space-y-5">
        <!-- Photo Upload -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Foto</h3>

            <!-- Preview -->
            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden bg-gray-100 border-4 border-gray-200 mb-4 flex items-center justify-center" id="photoPreview">
                <?php if (!empty($officer->photo)): ?>
                    <img src="<?= base_url($officer->photo) ?>" class="w-full h-full object-cover" id="previewImg">
                <?php else: ?>
                    <svg id="previewPlaceholder" class="w-14 h-14 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                    <img id="previewImg" class="w-full h-full object-cover hidden">
                <?php endif; ?>
            </div>

            <label class="block cursor-pointer">
                <div class="flex items-center justify-center gap-2 w-full bg-gray-50 hover:bg-gray-100 border-2 border-dashed border-gray-200 hover:border-blue-300 text-gray-500 font-medium py-3 px-4 rounded-xl text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <?= $officer && $officer->photo ? 'Ganti Foto' : 'Upload Foto' ?>
                </div>
                <input type="file" name="photo" accept="image/*,.heic,.heif" class="hidden" id="photoInput">
                <!-- Hidden input populated with WebP-converted file for HEIC uploads -->
                <input type="file" name="photo_converted" id="photoConverted" class="hidden">
            </label>
            <p class="text-xs text-gray-400 text-center mt-2">JPG/PNG/WebP/<strong>HEIC</strong> — otomatis dikompres ke WebP</p>
        </div>

        <!-- Submit -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition shadow flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?= $officer ? 'Simpan Perubahan' : 'Tambah Perangkat' ?>
            </button>
            <a href="<?= base_url('admin/officers') ?>" class="block text-center w-full py-3 rounded-xl font-medium text-gray-500 hover:bg-gray-50 transition text-sm">
                Batal
            </a>
        </div>
    </div>
</div>
</form>

<script>
// ============================================================
// HEIC HELPERS
// ============================================================
function isHeic(file) {
    if (file.type === 'image/heic' || file.type === 'image/heif') return true;
    const ext = (file.name.split('.').pop() || '').toLowerCase();
    return ext === 'heic' || ext === 'heif';
}

async function toWebP(file, maxWidth = 1200, quality = 0.85) {
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

// ============================================================
// Photo preview + HEIC auto-convert
// ============================================================
const photoInput     = document.getElementById('photoInput');
const photoConverted = document.getElementById('photoConverted');
const previewImg     = document.getElementById('previewImg');
const previewPH      = document.getElementById('previewPlaceholder');

photoInput.addEventListener('change', async function() {
    const file = this.files[0];
    if (!file) return;

    const label = this.closest('label');
    const origText = label ? label.querySelector('div')?.textContent?.trim() : '';
    if (label) label.querySelector('div').textContent = isHeic(file) ? '⚙️ Mengkonversi HEIC...' : '⚙️ Memproses...';

    try {
        const webpFile = await toWebP(file);

        // Show preview
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            if (previewPH) previewPH.classList.add('hidden');
        };
        reader.readAsDataURL(webpFile);

        // Inject converted file into a DataTransfer so the server receives it
        const dt = new DataTransfer();
        dt.items.add(webpFile);
        photoInput.files = dt.files; // replace original with converted

    } catch(e) {
        console.error('Conversion failed:', e);
        // Fallback: just show original preview
        const reader = new FileReader();
        reader.onload = e => { previewImg.src = e.target.result; previewImg.classList.remove('hidden'); if (previewPH) previewPH.classList.add('hidden'); };
        reader.readAsDataURL(file);
    } finally {
        if (label) label.querySelector('div').textContent = '✓ Siap diunggah';
    }
});

// Level badge preview
const levelLabels = ['', 'Kepala Desa', 'Sekretaris / Wakil', 'Kepala Urusan / Seksi', 'Staff / Pelaksana', 'Kadus / Lainnya'];
const levelColors = ['', 'bg-blue-600', 'bg-green-600', 'bg-yellow-500', 'bg-gray-500', 'bg-purple-500'];

document.getElementById('levelSelect').addEventListener('change', function() {
    const l = parseInt(this.value);
    const badge = document.getElementById('previewBadge');
    badge.textContent = 'Level ' + l + ' — ' + (levelLabels[l] || '');
    badge.className = 'px-3 py-1 rounded-full text-xs font-bold text-white ' + (levelColors[l] || 'bg-gray-400');
});

// Trigger on load
document.getElementById('levelSelect').dispatchEvent(new Event('change'));
</script>

<?= $this->endSection() ?>
