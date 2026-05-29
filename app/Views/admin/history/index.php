<?= $this->extend('layout/admin') ?>

<?= $this->section('admin_content') ?>

<!-- jQuery & Summernote -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

<style>
    .note-editor.note-frame { border: 1px solid #e5e7eb !important; border-radius: 0.75rem !important; }
    .note-toolbar { background: #f9fafb !important; border-bottom: 1px solid #e5e7eb !important; border-radius: 0.75rem 0.75rem 0 0 !important; padding: 0.5rem !important; }
    .note-btn { border-radius: 6px !important; }
    .note-editable { min-height: 350px !important; padding: 1.5rem !important; font-size: 15px !important; line-height: 1.8 !important; }
    .note-statusbar, .note-resizebar { display: none !important; }
</style>

<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-heading font-bold text-gray-800 mb-2">Sejarah & Profil Desa</h1>
        <p class="text-gray-500">Kelola narasi asal-usul, data statistik demografi, lini masa peristiwa, dan sarana prasarana.</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Tabs Navigation -->
<div class="flex border-b border-gray-200 mb-8 overflow-x-auto gap-4 scrollbar-none">
    <button onclick="adminSwitchTab('asal-usul-admin')" id="btn-asal-usul-admin" class="admin-tab-btn border-b-2 border-blue-600 px-4 py-2.5 font-bold text-sm text-blue-600 transition whitespace-nowrap">
        📖 Asal-Usul & Sejarah
    </button>
    <button onclick="adminSwitchTab('timeline-admin')" id="btn-timeline-admin" class="admin-tab-btn border-b-2 border-transparent px-4 py-2.5 font-semibold text-sm text-gray-500 hover:text-gray-700 transition whitespace-nowrap">
        ⏳ Lini Masa Sejarah
    </button>
    <button onclick="adminSwitchTab('demografi-admin')" id="btn-demografi-admin" class="admin-tab-btn border-b-2 border-transparent px-4 py-2.5 font-semibold text-sm text-gray-500 hover:text-gray-700 transition whitespace-nowrap">
        📊 Demografi & Sosial
    </button>
    <button onclick="adminSwitchTab('sarana-admin')" id="btn-sarana-admin" class="admin-tab-btn border-b-2 border-transparent px-4 py-2.5 font-semibold text-sm text-gray-500 hover:text-gray-700 transition whitespace-nowrap">
        🏡 Sarana & Prasarana
    </button>
</div>

<!-- ============================================== -->
<!-- TAB 1: ASAL USUL & SEJARAH NARRATIVE -->
<!-- ============================================== -->
<div id="tab-asal-usul-admin" class="admin-tab-content space-y-6">
    <form action="<?= base_url('admin/history/settings') ?>" method="post" class="space-y-6">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Narasi Asal-Usul Desa</h3>
            <div>
                <textarea id="sejarah_asal_usul" name="sejarah_asal_usul" class="hidden"><?= esc($settings['sejarah_asal_usul'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Informasi Tambahan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Luas Wilayah (Hektar)</label>
                    <input type="text" name="demografi_luas_wilayah" value="<?= esc($settings['demografi_luas_wilayah'] ?? '1500') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition">
                Simpan Narasi & Informasi
            </button>
        </div>
    </form>
</div>

<!-- ============================================== -->
<!-- TAB 2: TIMELINE CRUD -->
<!-- ============================================== -->
<div id="tab-timeline-admin" class="admin-tab-content hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- List Timeline -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Daftar Peristiwa / Lini Masa</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-3 px-4 w-24">Tahun</th>
                        <th class="py-3 px-4">Judul Peristiwa</th>
                        <th class="py-3 px-4 text-center">Urutan</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    <?php foreach($events as $e): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3.5 px-4 font-bold text-gray-800"><?= esc($e->year) ?></td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-gray-800"><?= esc($e->title) ?></div>
                            <div class="text-xs text-gray-400 line-clamp-1 mt-0.5"><?= esc($e->description) ?></div>
                        </td>
                        <td class="py-3.5 px-4 text-center"><?= esc($e->sort_order) ?></td>
                        <td class="py-3.5 px-4 text-right space-x-2">
                            <button onclick="editEvent(<?= htmlspecialchars(json_encode($e)) ?>)" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
                            <a href="<?= base_url('admin/history/events/delete/'.$e->id) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus peristiwa ini?')" class="text-red-500 hover:text-red-700 font-semibold">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($events)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-400">Belum ada data lini masa.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Timeline -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <h3 id="form-event-title" class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-6">Tambah Peristiwa Baru</h3>
        <form action="<?= base_url('admin/history/events/store') ?>" method="post" class="space-y-4">
            <input type="hidden" name="id" id="event-id" value="">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun / Periode</label>
                <input type="text" name="year" id="event-year" placeholder="Contoh: 1617 atau 1878 - 1891" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Peristiwa</label>
                <input type="text" name="title" id="event-title" placeholder="Nama peristiwa/kepemimpinan" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Singkat</label>
                <textarea name="description" id="event-description" rows="5" placeholder="Penjelasan mengenai kejadian..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampilan</label>
                <input type="number" name="sort_order" id="event-sort-order" value="1" min="1" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
            </div>

            <div class="pt-2 flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition text-sm">Simpan Peristiwa</button>
                <button type="button" onclick="cancelEditEvent()" id="btn-cancel-event" class="hidden bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-4 py-2.5 rounded-xl transition text-sm">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================== -->
<!-- TAB 3: DEMOGRAFI & SOSIAL STATS -->
<!-- ============================================== -->
<div id="tab-demografi-admin" class="admin-tab-content hidden">
    <form action="<?= base_url('admin/history/settings') ?>" method="post" class="space-y-8">
        <!-- Dusun Stats -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-6">Populasi & Dusun</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Dusun 1 -->
                <div class="p-5 bg-gray-50 rounded-xl space-y-4">
                    <h4 class="font-bold text-gray-700 text-sm">Dusun I</h4>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah KK</label>
                        <input type="number" name="demografi_dusun_1_kk" value="<?= esc($settings['demografi_dusun_1_kk'] ?? '126') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah Jiwa</label>
                        <input type="number" name="demografi_dusun_1_jiwa" value="<?= esc($settings['demografi_dusun_1_jiwa'] ?? '429') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                    </div>
                </div>

                <!-- Dusun 2 -->
                <div class="p-5 bg-gray-50 rounded-xl space-y-4">
                    <h4 class="font-bold text-gray-700 text-sm">Dusun II</h4>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah KK</label>
                        <input type="number" name="demografi_dusun_2_kk" value="<?= esc($settings['demografi_dusun_2_kk'] ?? '125') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah Jiwa</label>
                        <input type="number" name="demografi_dusun_2_jiwa" value="<?= esc($settings['demografi_dusun_2_jiwa'] ?? '378') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                    </div>
                </div>

                <!-- Dusun 3 -->
                <div class="p-5 bg-gray-50 rounded-xl space-y-4">
                    <h4 class="font-bold text-gray-700 text-sm">Dusun III</h4>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah KK</label>
                        <input type="number" name="demografi_dusun_3_kk" value="<?= esc($settings['demografi_dusun_3_kk'] ?? '72') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah Jiwa</label>
                        <input type="number" name="demografi_dusun_3_jiwa" value="<?= esc($settings['demografi_dusun_3_jiwa'] ?? '259') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Education Stats -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-6">Tingkat Pendidikan</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pra Sekolah</label>
                    <input type="number" name="demografi_edu_pra_sekolah" value="<?= esc($settings['demografi_edu_pra_sekolah'] ?? '623') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">SD / Sederajat</label>
                    <input type="number" name="demografi_edu_sd" value="<?= esc($settings['demografi_edu_sd'] ?? '125') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">SLTP / SMP</label>
                    <input type="number" name="demografi_edu_sltp" value="<?= esc($settings['demografi_edu_sltp'] ?? '110') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">SLTA / SMA</label>
                    <input type="number" name="demografi_edu_slta" value="<?= esc($settings['demografi_edu_slta'] ?? '85') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Sarjana / PT</label>
                    <input type="number" name="demografi_edu_sarjana" value="<?= esc($settings['demografi_edu_sarjana'] ?? '19') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
            </div>
        </div>

        <!-- Job Stats -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-6">Mata Pencaharian (Pekerjaan)</h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Petani</label>
                    <input type="number" name="demografi_job_petani" value="<?= esc($settings['demografi_job_petani'] ?? '476') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Buruh</label>
                    <input type="number" name="demografi_job_buruh" value="<?= esc($settings['demografi_job_buruh'] ?? '25') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Pedagang</label>
                    <input type="number" name="demografi_job_pedagang" value="<?= esc($settings['demografi_job_pedagang'] ?? '22') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">PNS</label>
                    <input type="number" name="demografi_job_pns" value="<?= esc($settings['demografi_job_pns'] ?? '7') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Peternak</label>
                    <input type="number" name="demografi_job_peternak" value="<?= esc($settings['demografi_job_peternak'] ?? '5') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Bengkel</label>
                    <input type="number" name="demografi_job_bengkel" value="<?= esc($settings['demografi_job_bengkel'] ?? '3') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
            </div>
        </div>

        <!-- Livestock Stats -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-6">Kepemilikan Hewan Ternak</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Ayam / Itik (KK)</label>
                    <input type="number" name="demografi_ternak_ayam_itik" value="<?= esc($settings['demografi_ternak_ayam_itik'] ?? '216') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kambing (KK)</label>
                    <input type="number" name="demografi_ternak_kambing" value="<?= esc($settings['demografi_ternak_kambing'] ?? '53') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Sapi (KK)</label>
                    <input type="number" name="demografi_ternak_sapi" value="<?= esc($settings['demografi_ternak_sapi'] ?? '43') ?>" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition">
                Simpan Data Demografi & Sosial
            </button>
        </div>
    </form>
</div>

<!-- ============================================== -->
<!-- TAB 4: SARANA PRASARANA CRUD -->
<!-- ============================================== -->
<div id="tab-sarana-admin" class="admin-tab-content hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- List Infrastructure -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">Daftar Sarana & Prasarana</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-xs font-bold uppercase tracking-wider border-b border-gray-100">
                        <th class="py-3 px-4">Nama Sarana</th>
                        <th class="py-3 px-4 text-center">Volume</th>
                        <th class="py-3 px-4 text-center">Kondisi</th>
                        <th class="py-3 px-4 text-center">Urutan</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    <?php foreach($infrastructure as $infra): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3.5 px-4 font-bold text-gray-800"><?= esc($infra->name) ?></td>
                        <td class="py-3.5 px-4 text-center"><?= esc($infra->volume) ?></td>
                        <td class="py-3.5 px-4 text-center">
                            <?php if (strtolower($infra->condition) === 'baik'): ?>
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">Baik</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200"><?= esc($infra->condition) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3.5 px-4 text-center"><?= esc($infra->sort_order) ?></td>
                        <td class="py-3.5 px-4 text-right space-x-2">
                            <button onclick="editInfra(<?= htmlspecialchars(json_encode($infra)) ?>)" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</button>
                            <a href="<?= base_url('admin/history/infrastructure/delete/'.$infra->id) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus sarana ini?')" class="text-red-500 hover:text-red-700 font-semibold">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($infrastructure)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-400">Belum ada data sarana prasarana.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Infrastructure -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
        <h3 id="form-infra-title" class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-6">Tambah Sarana Baru</h3>
        <form action="<?= base_url('admin/history/infrastructure/store') ?>" method="post" class="space-y-4">
            <input type="hidden" name="id" id="infra-id" value="">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Sarana / Prasarana</label>
                <input type="text" name="name" id="infra-name" placeholder="Contoh: Gedung Serbaguna, Kantor Desa" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah / Volume</label>
                <input type="text" name="volume" id="infra-volume" placeholder="Contoh: 1 Unit, 2 Unit, 1 Lokasi" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kondisi Fisik</label>
                <select name="condition" id="infra-condition" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm bg-white">
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Urutan Tampilan</label>
                <input type="number" name="sort_order" id="infra-sort-order" value="1" min="1" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition outline-none text-sm">
            </div>

            <div class="pt-2 flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition text-sm">Simpan Sarana</button>
                <button type="button" onclick="cancelEditInfra()" id="btn-cancel-infra" class="hidden bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-4 py-2.5 rounded-xl transition text-sm">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
// Tab Switcher
function adminSwitchTab(tabId) {
    document.querySelectorAll('.admin-tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById(tabId).classList.remove('hidden');

    document.querySelectorAll('.admin-tab-btn').forEach(btn => {
        btn.classList.remove('border-blue-600', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700');
    });

    const activeBtn = document.getElementById('btn-' + tabId);
    activeBtn.classList.add('border-blue-600', 'text-blue-600');
    activeBtn.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700');
    
    // Save active tab in URL hash
    window.location.hash = tabId;
}

// Edit Timeline Event
function editEvent(data) {
    document.getElementById('event-id').value = data.id;
    document.getElementById('event-year').value = data.year;
    document.getElementById('event-title').value = data.title;
    document.getElementById('event-description').value = data.description;
    document.getElementById('event-sort-order').value = data.sort_order;

    document.getElementById('form-event-title').textContent = 'Edit Peristiwa: ' + data.year;
    document.getElementById('btn-cancel-event').classList.remove('hidden');
    
    // Scroll to form on mobile
    document.getElementById('form-event-title').scrollIntoView({ behavior: 'smooth' });
}

function cancelEditEvent() {
    document.getElementById('event-id').value = '';
    document.getElementById('event-year').value = '';
    document.getElementById('event-title').value = '';
    document.getElementById('event-description').value = '';
    document.getElementById('event-sort-order').value = '1';

    document.getElementById('form-event-title').textContent = 'Tambah Peristiwa Baru';
    document.getElementById('btn-cancel-event').classList.add('hidden');
}

// Edit Infrastructure
function editInfra(data) {
    document.getElementById('infra-id').value = data.id;
    document.getElementById('infra-name').value = data.name;
    document.getElementById('infra-volume').value = data.volume;
    document.getElementById('infra-condition').value = data.condition;
    document.getElementById('infra-sort-order').value = data.sort_order;

    document.getElementById('form-infra-title').textContent = 'Edit Sarana: ' + data.name;
    document.getElementById('btn-cancel-infra').classList.remove('hidden');
    
    // Scroll to form on mobile
    document.getElementById('form-infra-title').scrollIntoView({ behavior: 'smooth' });
}

function cancelEditInfra() {
    document.getElementById('infra-id').value = '';
    document.getElementById('infra-name').value = '';
    document.getElementById('infra-volume').value = '';
    document.getElementById('infra-condition').value = 'Baik';
    document.getElementById('infra-sort-order').value = '1';

    document.getElementById('form-infra-title').textContent = 'Tambah Sarana Baru';
    document.getElementById('btn-cancel-infra').classList.add('hidden');
}

// Load Summernote WYSIWYG
$(document).ready(function() {
    $('#sejarah_asal_usul').summernote({
        height: 400,
        focus: false,
        toolbar: [
            ['style',  ['style']],
            ['font',   ['bold', 'italic', 'underline', 'clear']],
            ['color',  ['color']],
            ['para',   ['ul', 'ol', 'paragraph']],
            ['table',  ['table']],
            ['insert', ['link']],
            ['view',   ['fullscreen', 'codeview']],
        ]
    });

    // Check hash on load to open active tab
    const hash = window.location.hash;
    if (hash) {
        const cleanHash = hash.replace('#', '');
        if (document.getElementById(cleanHash)) {
            adminSwitchTab(cleanHash);
        }
    }
});
</script>

<?= $this->endSection() ?>
