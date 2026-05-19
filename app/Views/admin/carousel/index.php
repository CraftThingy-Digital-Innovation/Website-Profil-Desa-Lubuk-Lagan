<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-heading font-bold text-gray-800 mb-2">Media Carousel</h1>
        <p class="text-gray-500">Kelola gambar dan video yang tampil bergulir di Beranda.</p>
    </div>
    <button onclick="document.getElementById('modal-add').classList.remove('hidden')" class="bg-blue-700 hover:bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold transition shadow-md flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Media
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach($carousels as $c): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
        <div class="relative h-48 bg-slate-100">
            <?php if($c->media_type === 'video'): ?>
                <video src="<?= base_url($c->media_url) ?>" class="w-full h-full object-cover" muted></video>
                <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                    <svg class="w-12 h-12 text-white/80" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>
                </div>
            <?php else: ?>
                <img src="<?= base_url($c->media_url) ?>" class="w-full h-full object-cover">
            <?php endif; ?>
            
            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-gray-800 uppercase">
                <?= $c->media_type ?>
            </div>
            
            <div class="absolute top-3 right-3">
                <a href="<?= base_url('admin/carousel/toggle/'.$c->id) ?>" class="px-2 py-1 rounded text-xs font-bold text-white shadow-sm <?= $c->status === 'active' ? 'bg-green-500 hover:bg-green-600' : 'bg-slate-400 hover:bg-slate-500' ?>">
                    <?= $c->status === 'active' ? 'Aktif' : 'Draft' ?>
                </a>
            </div>
        </div>
        
        <div class="p-5">
            <h3 class="font-bold text-gray-800 text-lg mb-1 truncate"><?= esc($c->title ?: 'Tanpa Judul') ?></h3>
            <p class="text-xs text-gray-400 mb-4 font-mono truncate"><?= esc($c->media_url) ?></p>
            
            <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Urutan: <?= $c->sort_order ?></span>
                <a href="<?= base_url('admin/carousel/delete/'.$c->id) ?>" onclick="return confirm('Hapus media ini dari carousel?')" class="text-red-500 hover:text-red-700 text-sm font-semibold transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if(empty($carousels)): ?>
        <div class="col-span-3 bg-gray-50 rounded-2xl p-12 text-center border-2 border-dashed border-gray-200">
            <p class="text-gray-400 font-medium">Belum ada media di carousel.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Tambah -->
<div id="modal-add" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-100 transition-all">
        <form action="<?= base_url('admin/carousel/store') ?>" method="post">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-2xl font-heading font-bold text-gray-800">Tambah Media Baru</h3>
                <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-8 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Pilih dari File Manager</label>
                    <div class="flex gap-2">
                        <input type="text" name="media_url" id="mediaUrlInput" required readonly placeholder="Pilih media..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 outline-none text-sm font-mono cursor-not-allowed">
                        <button type="button" onclick="openPicker()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl font-bold text-sm transition">
                            Cari
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Tipe Media</label>
                        <select name="media_type" id="mediaTypeInput" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 transition outline-none appearance-none">
                            <option value="image">Gambar (Image)</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Urutan (Opsional)</label>
                        <input type="number" name="sort_order" value="0" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 transition outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">Judul (Opsional)</label>
                    <input type="text" name="title" placeholder="Cth: Suasana Pagi Desa" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 transition outline-none">
                </div>
            </div>
            
            <div class="px-8 py-5 bg-gray-50 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')" class="px-6 py-2.5 rounded-xl font-bold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                <button type="submit" class="bg-blue-700 hover:bg-blue-600 text-white px-6 py-2.5 rounded-xl font-bold shadow-md transition">Simpan Media</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal File Picker Sederhana -->
<div id="file-picker-modal" class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[80vh] flex flex-col">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-2xl">
            <h3 class="font-bold text-gray-800">Pilih Media</h3>
            <button onclick="document.getElementById('file-picker-modal').classList.add('hidden')" class="text-gray-500">&times; Tutup</button>
        </div>
        <div class="p-4 flex-1 overflow-y-auto grid grid-cols-2 md:grid-cols-4 gap-4" id="picker-grid">
            <!-- Diisi via AJAX -->
        </div>
    </div>
</div>

<script>
async function openPicker() {
    document.getElementById('file-picker-modal').classList.remove('hidden');
    const grid = document.getElementById('picker-grid');
    grid.innerHTML = '<div class="col-span-full text-center py-8">Memuat file...</div>';
    
    try {
        const res = await fetch('<?= base_url('admin/file-manager/api/list') ?>');
        const files = await res.json();
        
        grid.innerHTML = '';
        files.forEach(f => {
            const isVideo = f.type === 'video';
            const thumb = isVideo 
                ? '<div class="w-full h-32 bg-slate-800 flex items-center justify-center rounded-lg"><span class="text-white text-xs">VIDEO</span></div>'
                : `<img src="<?= base_url() ?>${f.url}" class="w-full h-32 object-cover rounded-lg">`;
            
            const div = document.createElement('div');
            div.className = 'cursor-pointer hover:ring-4 hover:ring-earth-400 rounded-lg transition overflow-hidden bg-earth-50 border border-earth-100';
            div.innerHTML = `
                ${thumb}
                <div class="p-2 text-xs truncate text-center">${f.name}</div>
            `;
            div.onclick = () => {
                document.getElementById('mediaUrlInput').value = f.url;
                document.getElementById('mediaTypeInput').value = isVideo ? 'video' : 'image';
                document.getElementById('file-picker-modal').classList.add('hidden');
            };
            grid.appendChild(div);
        });
    } catch(e) {
        grid.innerHTML = '<div class="col-span-full text-center text-red-500">Gagal memuat file.</div>';
    }
}
</script>

<?= $this->endSection() ?>
