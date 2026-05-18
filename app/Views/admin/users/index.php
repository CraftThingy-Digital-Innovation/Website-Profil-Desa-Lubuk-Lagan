<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen User</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola akun admin, author, dan superadmin</p>
    </div>
    <a href="<?= base_url('admin/users/create') ?>"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-500/25 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah User Baru
    </a>
</div>

<!-- Grup Role Info -->
<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-red-50 border border-red-100 rounded-2xl p-4">
        <div class="flex items-center gap-3 mb-2">
            <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center text-lg">👑</span>
            <h3 class="font-bold text-red-700 text-sm">Superadmin</h3>
        </div>
        <p class="text-xs text-red-500">Akses penuh: kelola user, semua konten, dan pengaturan sistem.</p>
    </div>
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
        <div class="flex items-center gap-3 mb-2">
            <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-lg">🛠️</span>
            <h3 class="font-bold text-blue-700 text-sm">Admin</h3>
        </div>
        <p class="text-xs text-blue-500">Kelola blog, peta, dan file manager. Tidak bisa kelola user.</p>
    </div>
    <div class="bg-green-50 border border-green-100 rounded-2xl p-4">
        <div class="flex items-center gap-3 mb-2">
            <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-lg">✍️</span>
            <h3 class="font-bold text-green-700 text-sm">Author</h3>
        </div>
        <p class="text-xs text-green-500">Hanya bisa menulis dan mengelola blog/berita.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="py-4 px-6 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">User</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Grup / Role</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Bergabung</th>
                <th class="py-4 px-6 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php foreach($users as $user): ?>
            <?php $groups = $user->getGroups(); ?>
            <tr class="hover:bg-gray-50 transition group">
                <td class="py-4 px-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm text-white flex-shrink-0
                            <?= in_array('superadmin', $groups) ? 'bg-red-500' : (in_array('admin', $groups) ? 'bg-blue-500' : 'bg-green-500') ?>">
                            <?= strtoupper(substr($user->username, 0, 1)) ?>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 flex items-center gap-2">
                                <?= esc($user->username) ?>
                                <?php if ($user->id == auth()->id()): ?>
                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Anda</span>
                                <?php endif; ?>
                            </p>
                            <p class="text-xs text-gray-400"><?= esc($user->email) ?></p>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6 text-center">
                    <?php
                    $groupColors = [
                        'superadmin' => 'bg-red-100 text-red-700',
                        'admin'      => 'bg-blue-100 text-blue-700',
                        'author'     => 'bg-green-100 text-green-700',
                    ];
                    foreach ($groups as $g):
                        $color = $groupColors[$g] ?? 'bg-gray-100 text-gray-600';
                    ?>
                        <span class="inline-block <?= $color ?> text-xs font-bold py-1 px-3 rounded-full"><?= ucfirst($g) ?></span>
                    <?php endforeach; ?>
                    <?php if (empty($groups)): ?>
                        <span class="text-xs text-gray-400">— Tanpa Grup</span>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6 text-center">
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                    </span>
                </td>
                <td class="py-4 px-6 text-center text-xs text-gray-400">
                    <?= date('d M Y', strtotime($user->created_at)) ?>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <a href="<?= base_url('admin/users/edit/'.$user->id) ?>" title="Edit" class="text-gray-300 hover:text-blue-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <?php if ($user->id != auth()->id()): ?>
                        <a href="<?= base_url('admin/users/delete/'.$user->id) ?>"
                           onclick="return confirm('Hapus user \'<?= esc($user->username) ?>\'? Tindakan ini tidak dapat dibatalkan!')"
                           title="Hapus" class="text-gray-300 hover:text-red-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
