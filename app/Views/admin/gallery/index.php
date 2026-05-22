<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<?php
// Tab config
$tabs = [
    'kkn'        => ['label' => '📸 Galeri KKN 107',  'slug' => 'kkn'],
    'kabar_desa' => ['label' => '📰 Kabar Desa',       'slug' => 'kabar-desa'],
];
$routeSlug = $category === 'kkn' ? 'kkn' : 'kabar-desa';
$createUrl = base_url("admin/gallery/{$routeSlug}/create");
?>

<!-- Header -->
<div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Galeri & Media</h1>
        <p class="text-gray-400 text-sm mt-1">Kelola foto dan video untuk semua halaman galeri.</p>
    </div>
    <a href="<?= $createUrl ?>" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-600 text-white font-bold px-5 py-2.5 rounded-xl shadow transition flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Item
    </a>
</div>

<!-- Category Tabs -->
<div class="flex gap-2 mb-6 bg-white rounded-2xl p-1.5 shadow-sm border border-gray-100 w-fit">
    <?php foreach ($tabs as $cat => $tab): ?>
    <a href="<?= base_url("admin/gallery/{$tab['slug']}") ?>"
       class="px-5 py-2.5 rounded-xl text-sm font-semibold transition <?= $category === $cat
           ? 'bg-blue-700 text-white shadow'
           : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' ?>">
        <?= $tab['label'] ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- Content -->
<?php if (empty($items)): ?>
<div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 p-16 text-center">
    <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    <p class="text-gray-400 font-medium">Belum ada item di kategori ini. Mulai tambahkan foto atau video!</p>
    <a href="<?= $createUrl ?>" class="mt-4 inline-block bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm">+ Tambah Sekarang</a>
</div>
<?php else: ?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    <?php foreach ($items as $item): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group flex flex-col">
        <!-- Thumbnail -->
        <div class="relative h-44 bg-gray-100 overflow-hidden">
            <?php if ($item->media_type === 'video'): ?>
                <?php if ($item->cover_url): ?>
                    <img src="<?= base_url($item->cover_url) ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white/50" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                    </div>
                <?php endif; ?>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-10 h-10 bg-white/80 rounded-full flex items-center justify-center shadow">
                        <svg class="w-5 h-5 text-gray-700 ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                    </div>
                </div>
                <span class="absolute top-2 left-2 bg-gray-900/70 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">VIDEO</span>
            <?php else: ?>
                <img src="<?= base_url($item->media_url) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <?php endif; ?>
            <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[10px] font-bold <?= $item->status === 'active' ? 'bg-green-500 text-white' : 'bg-yellow-400 text-yellow-900' ?>">
                <?= $item->status === 'active' ? 'Aktif' : 'Draft' ?>
            </span>
        </div>

        <!-- Info -->
        <div class="p-4 flex-1 flex flex-col">
            <h3 class="font-bold text-gray-800 text-sm mb-1 truncate"><?= esc($item->title) ?></h3>
            <?php if ($item->description): ?>
            <p class="text-xs text-gray-400 line-clamp-2 flex-1"><?= esc($item->description) ?></p>
            <?php endif; ?>
            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50">
                <span class="text-[10px] font-semibold text-gray-300 uppercase tracking-widest">Urutan: <?= $item->sort_order ?></span>
                <div class="flex items-center gap-1.5">
                    <a href="<?= base_url("admin/gallery/{$routeSlug}/edit/{$item->id}") ?>" class="p-1.5 rounded-lg text-gray-300 hover:text-blue-500 hover:bg-blue-50 transition" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <a href="<?= base_url("admin/gallery/{$routeSlug}/delete/{$item->id}") ?>" onclick="return confirm('Hapus item ini?')" class="p-1.5 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
