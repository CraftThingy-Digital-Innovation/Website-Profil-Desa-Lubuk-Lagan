<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Peta Interaktif</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola titik-titik lokasi penting pada peta desa</p>
    </div>
    <a href="<?= base_url('admin/map/create') ?>"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-500/25 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Titik Lokasi
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="py-4 px-6 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Lokasi</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Jenis Media</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Koordinat</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach($locations as $loc): ?>
            <tr class="hover:bg-gray-50 transition group">
                <td class="py-4 px-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800"><?= esc($loc->name) ?></p>
                            <p class="text-xs text-gray-400 mt-0.5 line-clamp-1"><?= esc($loc->description) ?></p>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6 text-center">
                    <?php if($loc->media_type == 'drone_video'): ?>
                        <span class="inline-flex items-center gap-1 bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-xs font-semibold">🎬 Video Drone</span>
                    <?php elseif($loc->media_type == 'photo'): ?>
                        <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-semibold">📷 Foto</span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-xs font-semibold">— Tanpa Media</span>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6 text-center">
                    <code class="text-xs bg-gray-50 text-gray-600 px-2 py-1 rounded-lg font-mono">
                        <?= $loc->latitude ?>, <?= $loc->longitude ?>
                    </code>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <a href="<?= base_url('admin/map/edit/'.$loc->id) ?>" title="Edit" class="text-gray-300 hover:text-blue-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <a href="<?= base_url('admin/map/delete/'.$loc->id) ?>" onclick="return confirm('Hapus lokasi ini?')" title="Hapus" class="text-gray-300 hover:text-red-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($locations)): ?>
            <tr>
                <td colspan="4" class="py-16 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    <p class="font-medium">Belum ada titik lokasi.</p>
                    <a href="<?= base_url('admin/map/create') ?>" class="text-blue-600 font-semibold hover:underline mt-1 inline-block">Tambah lokasi pertama</a>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
