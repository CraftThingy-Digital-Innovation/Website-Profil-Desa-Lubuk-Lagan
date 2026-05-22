<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Perangkat Desa</h1>
        <p class="text-gray-400 text-sm mt-1">Kelola struktur organisasi dan hierarki perangkat desa.</p>
    </div>
    <a href="<?= base_url('admin/officers/create') ?>" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-600 text-white font-bold px-5 py-2.5 rounded-xl shadow transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Perangkat
    </a>
</div>

<?php if (empty($officers)): ?>
<div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 p-16 text-center">
    <svg class="w-14 h-14 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    <p class="text-gray-400 font-medium">Belum ada data perangkat. Mulai tambahkan!</p>
    <a href="<?= base_url('admin/officers/create') ?>" class="mt-4 inline-block bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm">+ Tambah Sekarang</a>
</div>
<?php else: ?>

<!-- Visual org chart preview (read-only, admin) -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6 overflow-x-auto">
    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Pratinjau Struktur</p>
    <div class="flex gap-4 flex-wrap">
        <?php foreach ($officers as $o): ?>
        <div class="flex flex-col items-center text-center" style="min-width:90px">
            <div class="w-14 h-14 rounded-full overflow-hidden bg-gray-100 border-2 <?= $o->level == 1 ? 'border-blue-500' : ($o->level == 2 ? 'border-green-400' : 'border-gray-300') ?> mb-1 flex-shrink-0">
                <?php if ($o->photo): ?>
                    <img src="<?= base_url($o->photo) ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xl">👤</div>
                <?php endif; ?>
            </div>
            <span class="text-xs font-bold text-gray-700 leading-tight"><?= esc(substr($o->name, 0, 14)) ?><?= strlen($o->name) > 14 ? '…' : '' ?></span>
            <span class="text-[10px] text-gray-400 leading-tight"><?= esc(substr($o->position, 0, 18)) ?></span>
            <span class="mt-1 px-1.5 py-0.5 rounded text-[9px] font-bold <?= $o->level == 1 ? 'bg-blue-100 text-blue-700' : ($o->level == 2 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500') ?>">Lv.<?= $o->level ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-widest">
                <th class="py-3 px-5 text-left">Perangkat</th>
                <th class="py-3 px-5 text-left hidden md:table-cell">Jabatan</th>
                <th class="py-3 px-4 text-center">Level</th>
                <th class="py-3 px-4 text-center hidden sm:table-cell">Atasan</th>
                <th class="py-3 px-4 text-center hidden sm:table-cell">Urutan</th>
                <th class="py-3 px-5 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php
            $officerMap = [];
            foreach ($officers as $o) $officerMap[$o->id] = $o;
            foreach ($officers as $o):
            ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="py-3 px-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-200">
                            <?php if ($o->photo): ?>
                                <img src="<?= base_url($o->photo) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-300">👤</div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800"><?= esc($o->name) ?></p>
                            <p class="text-xs text-gray-400 md:hidden"><?= esc($o->position) ?></p>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-5 text-gray-600 hidden md:table-cell"><?= esc($o->position) ?></td>
                <td class="py-3 px-4 text-center">
                    <span class="px-2 py-1 rounded-lg text-xs font-bold <?= $o->level == 1 ? 'bg-blue-100 text-blue-700' : ($o->level == 2 ? 'bg-green-100 text-green-700' : ($o->level == 3 ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500')) ?>">
                        Level <?= $o->level ?>
                    </span>
                </td>
                <td class="py-3 px-4 text-center text-xs text-gray-400 hidden sm:table-cell">
                    <?= $o->parent_id && isset($officerMap[$o->parent_id]) ? esc($officerMap[$o->parent_id]->name) : '<span class="text-gray-300 italic">—</span>' ?>
                </td>
                <td class="py-3 px-4 text-center text-xs text-gray-400 hidden sm:table-cell"><?= $o->sort_order ?></td>
                <td class="py-3 px-5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <a href="<?= base_url('admin/officers/edit/'.$o->id) ?>" class="p-1.5 rounded-lg text-gray-300 hover:text-blue-500 hover:bg-blue-50 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <a href="<?= base_url('admin/officers/delete/'.$o->id) ?>" onclick="return confirm('Hapus perangkat ini?')" class="p-1.5 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
