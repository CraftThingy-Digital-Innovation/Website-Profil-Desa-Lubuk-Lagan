<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Blog & Berita</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola semua artikel dan pengumuman desa</p>
    </div>
    <a href="<?= base_url('admin/blog/create') ?>"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-500/25 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tulis Berita Baru
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="py-4 px-6 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Judul Artikel</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Skor SEO</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach($blogs as $blog): ?>
            <tr class="hover:bg-gray-50 transition group">
                <td class="py-4 px-6">
                    <p class="font-semibold text-gray-800 group-hover:text-blue-600 transition truncate max-w-xs"><?= esc($blog->title) ?></p>
                    <p class="text-xs text-gray-400 mt-0.5 font-mono">/baca/<?= esc($blog->slug) ?></p>
                </td>
                <td class="py-4 px-6 text-center">
                    <?php if($blog->status == 'public'): ?>
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Tayang
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Draft
                        </span>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <div class="w-16 bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="h-full rounded-full <?= ($blog->seo_score ?? 0) > 70 ? 'bg-green-500' : (($blog->seo_score ?? 0) > 40 ? 'bg-yellow-500' : 'bg-red-400') ?>"
                                 style="width: <?= $blog->seo_score ?? 0 ?>%"></div>
                        </div>
                        <span class="text-xs font-bold <?= ($blog->seo_score ?? 0) > 70 ? 'text-green-600' : 'text-red-500' ?>"><?= $blog->seo_score ?? 0 ?></span>
                    </div>
                </td>
                <td class="py-4 px-6 text-center text-xs text-gray-400">
                    <?= date('d M Y', strtotime($blog->created_at)) ?>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <a href="<?= base_url($blog->status === 'draft' ? 'admin/blog/preview/'.$blog->id : 'baca/'.$blog->slug) ?>" target="_blank" title="Pratinjau" class="text-gray-300 hover:text-blue-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="<?= base_url('admin/blog/edit/'.$blog->id) ?>" title="Edit" class="text-gray-300 hover:text-blue-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <a href="<?= base_url('admin/blog/delete/'.$blog->id) ?>" onclick="return confirm('Hapus artikel ini permanen?')" title="Hapus" class="text-gray-300 hover:text-red-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($blogs)): ?>
            <tr>
                <td colspan="5" class="py-16 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="font-medium">Belum ada artikel.</p>
                    <a href="<?= base_url('admin/blog/create') ?>" class="text-blue-600 font-semibold hover:underline mt-1 inline-block">Tulis artikel pertama</a>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
