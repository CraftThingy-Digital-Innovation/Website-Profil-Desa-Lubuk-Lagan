<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<!-- HERO SECTION -->
<div class="relative bg-gradient-to-br from-forest-900 via-forest-950 to-earth-950 text-white py-24 md:py-32 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(245,158,11,0.1),transparent_50%)]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10 text-center">
        <h2 class="text-sm font-bold tracking-widest text-earth-400 uppercase mb-3 anime-fade-up opacity-0">Profil Wilayah</h2>
        <h1 class="text-4xl md:text-6xl font-heading font-black mb-6 anime-fade-up opacity-0" style="animation-delay: 150ms;">Sejarah & Demografi</h1>
        <div class="w-24 h-1 bg-earth-500 mx-auto rounded-full mb-6 anime-fade-up opacity-0" style="animation-delay: 200ms;"></div>
        <p class="text-slate-300 max-w-2xl mx-auto text-lg md:text-xl font-light leading-relaxed anime-fade-up opacity-0" style="animation-delay: 250ms;">
            Jejak historis, asal-usul tanah leluhur, data demografi, serta sarana prasarana Desa Lubuk Lagan.
        </p>
    </div>
</div>

<!-- NAVIGATION TABS -->
<div class="bg-white border-b border-gray-200 sticky top-[72px] z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex overflow-x-auto justify-start md:justify-center gap-1 md:gap-4 py-2 no-scrollbar">
            <button onclick="switchTab('asal-usul')" id="btn-asal-usul" class="tab-btn px-5 py-3 rounded-xl text-sm font-bold transition whitespace-nowrap bg-earth-600 text-white">
                📖 Asal-Usul & Sejarah
            </button>
            <button onclick="switchTab('timeline')" id="btn-timeline" class="tab-btn px-5 py-3 rounded-xl text-sm font-bold transition whitespace-nowrap text-earth-700 hover:bg-earth-50">
                ⏳ Garis Waktu Desa
            </button>
            <button onclick="switchTab('demografi')" id="btn-demografi" class="tab-btn px-5 py-3 rounded-xl text-sm font-bold transition whitespace-nowrap text-earth-700 hover:bg-earth-50">
                📊 Demografi & Sosial
            </button>
            <button onclick="switchTab('sarana')" id="btn-sarana" class="tab-btn px-5 py-3 rounded-xl text-sm font-bold transition whitespace-nowrap text-earth-700 hover:bg-earth-50">
                🏡 Sarana & Prasarana
            </button>
        </div>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 sm:px-6 py-12 md:py-16">

    <!-- TAB 1: ASAL USUL & SEJARAH -->
    <div id="tab-asal-usul" class="tab-content space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <div class="lg:col-span-8 space-y-6 text-earth-800 leading-relaxed text-base md:text-lg">
                <div class="border-l-4 border-earth-500 pl-4 py-1 mb-8">
                    <h2 class="text-2xl md:text-3xl font-heading font-bold text-forest-900">Asal-Usul Nama Lubuk Lagan</h2>
                </div>
                
                <div class="prose max-w-none">
                    <?= $settings['sejarah_asal_usul'] ?? '<p>Sejarah asal-usul belum dikonfigurasi.</p>' ?>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-earth-100 shadow-sm space-y-6">
                <h3 class="font-heading font-bold text-forest-900 text-lg border-b border-gray-100 pb-2">Informasi Wilayah</h3>
                <div class="space-y-4 text-sm text-earth-700">
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="font-semibold">Luas Wilayah</span>
                        <span><?= esc($settings['demografi_luas_wilayah'] ?? '1.500') ?> Hektar</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="font-semibold">Kecamatan</span>
                        <span>Talo Kecil</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="font-semibold">Kabupaten</span>
                        <span>Seluma</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="font-semibold">Provinsi</span>
                        <span>Bengkulu</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="font-semibold">Suku Mayoritas</span>
                        <span>Serawai</span>
                    </div>
                </div>
                
                <div class="bg-forest-50 p-4 rounded-2xl border border-forest-100 text-xs text-forest-800 leading-relaxed">
                    <strong>Batas Wilayah:</strong>
                    <ul class="list-disc pl-4 mt-2 space-y-1">
                        <li><strong>Utara:</strong> Desa Sungai Petai (Talo Kecil)</li>
                        <li><strong>Timur:</strong> Desa Air Melancar (Semidang Alas Maras)</li>
                        <li><strong>Selatan:</strong> Desa Bakal Dalam (Talo Kecil)</li>
                        <li><strong>Barat:</strong> Desa Masmambang (Talo)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: TIMELINE -->
    <div id="tab-timeline" class="tab-content hidden space-y-8">
        <div class="border-l-4 border-earth-500 pl-4 py-1 mb-8">
            <h2 class="text-2xl md:text-3xl font-heading font-bold text-forest-900">Kronologi Perkembangan Desa</h2>
            <p class="text-sm text-earth-600">Garis waktu sejarah penting kepemimpinan dan peristiwa di Desa Lubuk Lagan.</p>
        </div>

        <div class="relative border-l-2 border-earth-200 ml-4 md:ml-32 space-y-12 py-4">
            
            <?php foreach($events as $e): ?>
            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg"><?= esc($e->year) ?></div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">Tahun <?= esc($e->year) ?></span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2"><?= esc($e->title) ?></h4>
                    <p class="text-earth-700 text-sm"><?= nl2br(esc($e->description)) ?></p>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if(empty($events)): ?>
                <div class="text-center text-earth-400 py-12">Belum ada data lini masa sejarah.</div>
            <?php endif; ?>

        </div>
    </div>

    <!-- TAB 3: DEMOGRAFI & SOSIAL -->
    <div id="tab-demografi" class="tab-content hidden space-y-12">
        <div class="border-l-4 border-earth-500 pl-4 py-1 mb-8">
            <h2 class="text-2xl md:text-3xl font-heading font-bold text-forest-900">Profil Demografi & Keadan Sosial</h2>
            <p class="text-sm text-earth-600">Statistik kependudukan, mata pencaharian, dan tingkat pendidikan masyarakat.</p>
        </div>

        <?php
            $d1_kk = (int)($settings['demografi_dusun_1_kk'] ?? 126);
            $d2_kk = (int)($settings['demografi_dusun_2_kk'] ?? 125);
            $d3_kk = (int)($settings['demografi_dusun_3_kk'] ?? 72);
            $total_kk = $d1_kk + $d2_kk + $d3_kk;

            $d1_jiwa = (int)($settings['demografi_dusun_1_jiwa'] ?? 429);
            $d2_jiwa = (int)($settings['demografi_dusun_2_jiwa'] ?? 378);
            $d3_jiwa = (int)($settings['demografi_dusun_3_jiwa'] ?? 259);
            $total_jiwa = $d1_jiwa + $d2_jiwa + $d3_jiwa;
        ?>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm text-center">
                <span class="text-xs font-bold text-earth-500 uppercase tracking-widest block mb-2">Total Penduduk</span>
                <span class="text-4xl font-extrabold text-forest-900"><?= number_format($total_jiwa) ?></span>
                <span class="text-earth-700 text-sm block mt-1">Jiwa</span>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm text-center">
                <span class="text-xs font-bold text-earth-500 uppercase tracking-widest block mb-2">Jumlah Keluarga</span>
                <span class="text-4xl font-extrabold text-forest-900"><?= number_format($total_kk) ?></span>
                <span class="text-earth-700 text-sm block mt-1">Kepala Keluarga (KK)</span>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm text-center">
                <span class="text-xs font-bold text-earth-500 uppercase tracking-widest block mb-2">Luas Lahan Produktif</span>
                <span class="text-4xl font-extrabold text-forest-900">80%</span>
                <span class="text-earth-700 text-sm block mt-1">Sawit, Karet & Persawahan</span>
            </div>
        </div>

        <!-- Population detail & Education -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Detail Wilayah Dusun -->
            <div class="bg-white p-6 rounded-3xl border border-earth-100 shadow-sm">
                <h3 class="font-heading font-bold text-forest-900 text-lg mb-4 border-b border-gray-100 pb-2">Penyebaran Dusun</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <div>
                            <span class="font-bold text-earth-800 block">Dusun I</span>
                            <span class="text-xs text-earth-500"><?= $d1_kk ?> Kepala Keluarga</span>
                        </div>
                        <span class="font-bold text-forest-900"><?= $d1_jiwa ?> Jiwa</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <div>
                            <span class="font-bold text-earth-800 block">Dusun II</span>
                            <span class="text-xs text-earth-500"><?= $d2_kk ?> Kepala Keluarga</span>
                        </div>
                        <span class="font-bold text-forest-900"><?= $d2_jiwa ?> Jiwa</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <div>
                            <span class="font-bold text-earth-800 block">Dusun III</span>
                            <span class="text-xs text-earth-500"><?= $d3_kk ?> Kepala Keluarga</span>
                        </div>
                        <span class="font-bold text-forest-900"><?= $d3_jiwa ?> Jiwa</span>
                    </div>
                </div>
            </div>

            <!-- Tingkat Pendidikan -->
            <div class="bg-white p-6 rounded-3xl border border-earth-100 shadow-sm">
                <h3 class="font-heading font-bold text-forest-900 text-lg mb-4 border-b border-gray-100 pb-2">Tingkat Pendidikan</h3>
                <div class="space-y-3">
                    <?php
                        $edu_pra = (int)($settings['demografi_edu_pra_sekolah'] ?? 623);
                        $edu_sd = (int)($settings['demografi_edu_sd'] ?? 125);
                        $edu_smp = (int)($settings['demografi_edu_sltp'] ?? 110);
                        $edu_sma = (int)($settings['demografi_edu_slta'] ?? 85);
                        $edu_uni = (int)($settings['demografi_edu_sarjana'] ?? 19);
                        $total_edu = max($edu_pra + $edu_sd + $edu_smp + $edu_sma + $edu_uni, 1);
                    ?>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>Pra Sekolah</span>
                            <span><?= $edu_pra ?> Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: <?= ($edu_pra/$total_edu)*100 ?>%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>SD Negeri</span>
                            <span><?= $edu_sd ?> Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: <?= ($edu_sd/$total_edu)*100 ?>%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>SLTP (SMP)</span>
                            <span><?= $edu_smp ?> Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: <?= ($edu_smp/$total_edu)*100 ?>%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>SLTA (SMA)</span>
                            <span><?= $edu_sma ?> Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: <?= ($edu_sma/$total_edu)*100 ?>%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>Sarjana</span>
                            <span><?= $edu_uni ?> Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: <?= ($edu_uni/$total_edu)*100 ?>%"></div></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Pekerjaan & Hewan Ternak -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Pekerjaan -->
            <div class="bg-white p-6 rounded-3xl border border-earth-100 shadow-sm">
                <h3 class="font-heading font-bold text-forest-900 text-lg mb-4 border-b border-gray-100 pb-2">Mata Pencaharian</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Petani</span>
                        <span class="font-bold text-earth-900"><?= esc($settings['demografi_job_petani'] ?? '476') ?> Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Buruh</span>
                        <span class="font-bold text-earth-900"><?= esc($settings['demografi_job_buruh'] ?? '25') ?> Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Pedagang</span>
                        <span class="font-bold text-earth-900"><?= esc($settings['demografi_job_pedagang'] ?? '22') ?> Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Pegawai Negeri (PNS)</span>
                        <span class="font-bold text-earth-900"><?= esc($settings['demografi_job_pns'] ?? '7') ?> Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Peternak</span>
                        <span class="font-bold text-earth-900"><?= esc($settings['demografi_job_peternak'] ?? '5') ?> Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Bengkel</span>
                        <span class="font-bold text-earth-900"><?= esc($settings['demografi_job_bengkel'] ?? '3') ?> Orang</span>
                    </div>
                </div>
            </div>

            <!-- Hewan Ternak -->
            <div class="bg-white p-6 rounded-3xl border border-earth-100 shadow-sm">
                <h3 class="font-heading font-bold text-forest-900 text-lg mb-4 border-b border-gray-100 pb-2">Kepemilikan Hewan Ternak</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="font-semibold text-earth-800">Ayam / Itik</span>
                        <span class="font-bold text-forest-900"><?= esc($settings['demografi_ternak_ayam_itik'] ?? '216') ?> KK</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="font-semibold text-earth-800">Kambing</span>
                        <span class="font-bold text-forest-900"><?= esc($settings['demografi_ternak_kambing'] ?? '53') ?> KK</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="font-semibold text-earth-800">Sapi</span>
                        <span class="font-bold text-forest-900"><?= esc($settings['demografi_ternak_sapi'] ?? '43') ?> KK</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 4: SARANA PRASARANA -->
    <div id="tab-sarana" class="tab-content hidden space-y-8">
        <div class="border-l-4 border-earth-500 pl-4 py-1 mb-8">
            <h2 class="text-2xl md:text-3xl font-heading font-bold text-forest-900">Sarana & Prasarana Desa</h2>
            <p class="text-sm text-earth-600">Daftar infrastruktur penunjang kehidupan sosial dan pemerintahan desa.</p>
        </div>

        <div class="bg-white rounded-3xl border border-earth-100 overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-earth-50 text-earth-800 text-xs uppercase tracking-wider font-bold">
                        <th class="py-4 px-6">No</th>
                        <th class="py-4 px-6">Nama Sarana / Prasarana</th>
                        <th class="py-4 px-6 text-center">Jumlah / Volume</th>
                        <th class="py-4 px-6 text-center">Kondisi Fisik</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-earth-700 text-sm">
                    <?php $no = 1; foreach($infrastructure as $infra): ?>
                    <tr>
                        <td class="py-4 px-6"><?= $no++ ?></td>
                        <td class="py-4 px-6 font-semibold"><?= esc($infra->name) ?></td>
                        <td class="py-4 px-6 text-center"><?= esc($infra->volume) ?></td>
                        <td class="py-4 px-6 text-center">
                            <?php if (strtolower($infra->condition) === 'baik'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">Baik</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200"><?= esc($infra->condition) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($infrastructure)): ?>
                        <tr>
                            <td colspan="4" class="py-8 text-center text-earth-400">Belum ada data sarana prasarana.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<script>
function switchTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    
    // Show chosen tab content
    document.getElementById('tab-' + tabId).classList.remove('hidden');
    
    // Reset all tab button classes
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-earth-600', 'text-white');
        btn.classList.add('text-earth-700', 'hover:bg-earth-50');
    });
    
    // Highlight chosen tab button
    const activeBtn = document.getElementById('btn-' + tabId);
    activeBtn.classList.add('bg-earth-600', 'text-white');
    activeBtn.classList.remove('text-earth-700', 'hover:bg-earth-50');
}

document.addEventListener('DOMContentLoaded', () => {
    anime({
        targets: '.anime-fade-up',
        translateY: [50, 0],
        opacity: [0, 1],
        delay: anime.stagger(150),
        duration: 1000,
        easing: 'easeOutCubic'
    });
});
</script>

<?= $this->endSection() ?>
