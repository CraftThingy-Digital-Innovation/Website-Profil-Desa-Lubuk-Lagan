<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<?php
$isKkn   = ($category ?? 'blog') === 'kkn';
$tabs = [
    'blog' => ['label' => '📰 Blog & Berita',  'url' => base_url('admin/blog')],
    'kkn'  => ['label' => '📸 Galeri KKN 107', 'url' => base_url('admin/kkn')],
];
$createUrl = base_url(($isKkn ? 'admin/kkn' : 'admin/blog') . '/create');
?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800"><?= esc($catInfo['label']) ?></h2>
        <p class="text-sm text-gray-500 mt-1">Kelola semua <?= $isKkn ? 'entri galeri KKN 107' : 'artikel dan pengumuman desa' ?></p>
    </div>
    <a href="<?= $createUrl ?>"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-500/25 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <?= esc($catInfo['create_label']) ?>
    </a>
</div>

<!-- Category Tabs -->
<div class="flex gap-2 mb-6 bg-white rounded-2xl p-1.5 shadow-sm border border-gray-100 w-fit">
    <?php foreach ($tabs as $cat => $tab): ?>
    <a href="<?= $tab['url'] ?>"
       class="px-5 py-2.5 rounded-xl text-sm font-semibold transition <?= ($category ?? 'blog') === $cat
           ? 'bg-blue-600 text-white shadow'
           : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' ?>">
        <?= $tab['label'] ?>
    </a>
    <?php endforeach; ?>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="py-4 px-6 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Judul</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider hidden md:table-cell">Skor SEO</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
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
                <td class="py-4 px-6 text-center hidden md:table-cell">
                    <div class="flex items-center justify-center gap-2">
                        <div class="w-16 bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="h-full rounded-full <?= ($blog->seo_score ?? 0) > 70 ? 'bg-green-500' : (($blog->seo_score ?? 0) > 40 ? 'bg-yellow-500' : 'bg-red-400') ?>"
                                 style="width: <?= $blog->seo_score ?? 0 ?>%"></div>
                        </div>
                        <span class="text-xs font-bold <?= ($blog->seo_score ?? 0) > 70 ? 'text-green-600' : 'text-red-500' ?>"><?= $blog->seo_score ?? 0 ?></span>
                    </div>
                </td>
                <td class="py-4 px-6 text-center text-xs text-gray-400 hidden sm:table-cell">
                    <?= date('d M Y', strtotime($blog->published_at ?? $blog->created_at)) ?>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <?php
                        $editBase = $isKkn ? 'admin/kkn' : 'admin/blog';
                        $delBase  = $isKkn ? 'admin/kkn' : 'admin/blog';
                        ?>
                        <a href="<?= base_url($blog->status === 'draft' ? $editBase.'/preview/'.$blog->id : 'baca/'.$blog->slug) ?>" target="_blank" title="Pratinjau" class="text-gray-300 hover:text-blue-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <a href="<?= base_url($editBase.'/edit/'.$blog->id) ?>" title="Edit" class="text-gray-300 hover:text-blue-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <a href="<?= base_url($delBase.'/delete/'.$blog->id) ?>" onclick="return confirm('Hapus artikel ini permanen?')" title="Hapus" class="text-gray-300 hover:text-red-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($blogs)): ?>
            <tr>
                <td colspan="5" class="py-16 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="font-medium">Belum ada <?= $isKkn ? 'entri KKN' : 'artikel' ?>.</p>
                    <a href="<?= $createUrl ?>" class="text-blue-600 font-semibold hover:underline mt-1 inline-block">Tambah sekarang</a>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
