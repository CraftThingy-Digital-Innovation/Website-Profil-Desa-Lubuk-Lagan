<?= $this->extend('layout/admin') ?>
<?= $this->section('admin_content') ?>

<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <a href="<?= base_url('admin/users') ?>" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar User
        </a>
        <h2 class="text-2xl font-bold text-gray-800"><?= $user ? 'Edit User' : 'Tambah User Baru' ?></h2>
        <p class="text-sm text-gray-500 mt-1"><?= $user ? 'Perbarui informasi akun user.' : 'Buat akun admin baru. Password wajib minimal 8 karakter.' ?></p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-5 p-4 bg-red-50 text-red-600 rounded-xl text-sm border border-red-100">
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <form action="<?= $user ? base_url('admin/users/update/'.$user->id) : base_url('admin/users/store') ?>" method="POST" class="space-y-5">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="<?= esc($user->username ?? old('username')) ?>" required
                    class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-3 outline-none transition text-sm"
                    placeholder="contoh: budi_admin">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="<?= esc($user->email ?? old('email')) ?>" required
                    class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-3 outline-none transition text-sm"
                    placeholder="budi@desalubuklagan.local">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Password <?= $user ? '<span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span>' : '<span class="text-red-500">*</span>' ?>
                </label>
                <input type="password" name="password" <?= !$user ? 'required' : '' ?> minlength="8"
                    class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-3 outline-none transition text-sm"
                    placeholder="Minimal 8 karakter">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role / Grup <span class="text-red-500">*</span></label>
                <?php
                $currentGroup = $user ? ($user->getGroups()[0] ?? 'author') : 'author';
                ?>
                <select name="group" required
                    class="w-full border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-xl px-4 py-3 outline-none transition text-sm">
                    <option value="author"     <?= $currentGroup == 'author'     ? 'selected' : '' ?>>✍️ Author — Hanya bisa menulis blog</option>
                    <option value="admin"      <?= $currentGroup == 'admin'      ? 'selected' : '' ?>>🛠️ Admin — Kelola konten & media</option>
                    <option value="superadmin" <?= $currentGroup == 'superadmin' ? 'selected' : '' ?>>👑 Superadmin — Akses penuh</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-500/25 transition">
                    <?= $user ? 'Simpan Perubahan' : 'Buat User' ?>
                </button>
                <a href="<?= base_url('admin/users') ?>"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl text-center transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
