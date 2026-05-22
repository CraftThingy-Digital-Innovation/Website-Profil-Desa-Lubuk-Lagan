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
                
                <p class="drop-cap text-xl font-serif">
                    Pada tahun <strong>1617</strong>, datanglah kelompok masyarakat adat pertama yang dikenal sebagai <em>Jungku Lintang Kanan</em> (atau Sarang Bulan Lintang) ke wilayah ini. Awalnya mereka datang dengan tujuan berburu gajah. Melihat bentang wilayah yang sangat luas dan subur, mereka akhirnya memutuskan untuk menetap dan membuka sebuah permukiman awal (Talang). Tak lama berselang, menyusul kedatangan kelompok-kelompok adat lain seperti <em>Jungku Lubuk Sepang</em>, <em>Jungku Lubuk Layang</em>, <em>Jungku Karang Jati</em>, dan <em>Jungku Suka Dana</em>.
                </p>

                <p>
                    Kisah nama desa ini bermula pada tahun <strong>1873</strong>, ketika serombongan warga mencari ikan di dekat permukiman mereka, tepatnya menyusuri aliran Sungai Pengurungan. Di tengah perjalanan, mereka menemukan sebuah lubuk (bagian sungai yang dalam) yang sangat besar, indah, dan tenang. Di pinggiran lubuk tersebut tumbuh sebuah pohon kayu <strong>Lagan</strong> yang sangat besar dan rimbun dengan mata kayu unik (bukul) yang menonjol. Tempat teduh di bawah pohon Lagan inilah yang kemudian kerap dijadikan peristirahatan dan tempat berkumpul.
                </p>

                <p>
                    Sepulangnya dari sana, ketua-ketua jungku mengadakan musyawarah adat. Mereka bersepakat mengubah nama dusun awal mereka (Dusun Bukul atau Bo'ok Lagan) menjadi dusun <strong>Leoboek Lagan</strong> (yang lambat laun dilafalkan menjadi Lubuk Lagan). Sebagai pemimpin adat pertama, ditunjuklah Depati pertama bernama <strong>Sindang Aru</strong> (Depati Sindang Mergo).
                </p>

                <div class="p-6 bg-earth-50 rounded-2xl border border-earth-100 italic my-6">
                    "Dari rimbunnya dedaunan kayu Lagan dan tenangnya air Lubuk Pengurungan, lahirlah sebuah pemukiman yang kini kita kenal sebagai Desa Lubuk Lagan."
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-earth-100 shadow-sm space-y-6">
                <h3 class="font-heading font-bold text-forest-900 text-lg border-b border-gray-100 pb-2">Informasi Wilayah</h3>
                <div class="space-y-4 text-sm text-earth-700">
                    <div class="flex justify-between py-1.5 border-b border-gray-50">
                        <span class="font-semibold">Luas Wilayah</span>
                        <span>1.500 Hektar</span>
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
            
            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1617</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">Tahun 1617</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Pendaratan & Pembukaan Talang</h4>
                    <p class="text-earth-700 text-sm">Jungku Lintang Kanan (Sarang Bulan Lintang) datang berburu gajah dan menetap di permukiman awal.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1873</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">Tahun 1873</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Peresmian Nama "Leoboek Lagan"</h4>
                    <p class="text-earth-700 text-sm">Penemuan lubuk dan pohon kayu Lagan di Sungai Pengurungan. Musyawarah menetapkan nama Leoboek Lagan dengan Depati Sindang Aru sebagai pemimpin pertama.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1878 - 1891</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">1878 - 1891</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Kepemimpinan Depati Bandung</h4>
                    <p class="text-earth-700 text-sm">Penyatuan kebudayaan adat Lintang dengan budaya Serawai di wilayah pemukiman desa.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1891 - 1910</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">1891 - 1910</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Kepemimpinan Depati Ali Sana</h4>
                    <p class="text-earth-700 text-sm">Ali Sana (Sanek Jumbun) menjabat sebagai Depati pemimpin wilayah.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1911 - 1929</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">1911 - 1929</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Perjuangan Depati Kusim</h4>
                    <p class="text-earth-700 text-sm">Pembangunan gudang senjata untuk perlawanan terhadap kolonial Belanda (dipimpin Pak Seka, Pak Marsul, Abas, dan Gacun). Pada masa ini wabah cacar menyerang pemukiman.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1930 - 1950</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">1930 - 1950</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Kepemimpinan Depati Anim</h4>
                    <p class="text-earth-700 text-sm">Masa kepemimpinan Depati Anim memimpin jalannya roda pemerintahan adat.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1954 - 1957</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">1954 - 1957</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Gejolak Masa Depati Wadip</h4>
                    <p class="text-earth-700 text-sm">Kepemimpinan Depati Wadip. Terjadi peristiwa pergolakan PRRI di daerah.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1958 - 1962</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">1958 - 1962</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Era Depati Minin & G30S/PKI</h4>
                    <p class="text-earth-700 text-sm">Pemerintahan adat dipimpin Depati Minin, bertepatan dengan gejolak nasional G30S/PKI.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">1970 - 1983</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">1970 - 1983</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Transisi Sistem Kepala Desa</h4>
                    <p class="text-earth-700 text-sm">Sistem administrasi Depati dihapus, digantikan sistem Kepala Desa. Kepala Desa pertama adalah Djailani. Sekolah SD Inpres pertama kali dibangun.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">2005 - 2008</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">2005 - 2008</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Definitif Kepala Desa & PNPM-MP</h4>
                    <p class="text-earth-700 text-sm">Pjs Kepala Desa Badran diangkat menjadi definitif. Pada tahun 2008 mendapat bantuan PNPM-MP senilai Rp 132.720.000 untuk membangun jembatan gantung sepanjang 38 meter.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">2010</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">Tahun 2010</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Modernisasi Desa & Listrik Masuk Desa</h4>
                    <p class="text-earth-700 text-sm">Pemilihan kepala desa dimenangkan oleh H. Syahdan Wadip, SH. Di masa ini aliran listrik masuk desa (Lisdes), dibangun gedung TK, pembangunan jalan rabat beton 487m (PNPM-MPd), PPIP pengaspalan 700m, dan mobil dinas operasional.</p>
                </div>
            </div>

            <!-- Event Item -->
            <div class="relative pl-6 md:pl-8">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 bg-earth-500 rounded-full border-4 border-white ring-2 ring-earth-200"></div>
                <div class="hidden md:block absolute -left-36 top-1 text-right w-28 font-bold text-earth-600 text-lg">2017 - Skrg</div>
                <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm hover:shadow-md transition">
                    <span class="inline-block md:hidden bg-earth-100 text-earth-700 px-3 py-1 rounded-full text-xs font-bold mb-2">2017 - Sekarang</span>
                    <h4 class="font-bold text-forest-900 text-lg mb-2">Demokrasi Pemilihan Suprandi, S.Pd</h4>
                    <p class="text-earth-700 text-sm">Pemilihan kepala desa secara demokratis melahirkan pemimpin terpilih Bapak Suprandi, S.Pd yang melanjutkan tongkat estafet pembangunan desa.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- TAB 3: DEMOGRAFI & SOSIAL -->
    <div id="tab-demografi" class="tab-content hidden space-y-12">
        <div class="border-l-4 border-earth-500 pl-4 py-1 mb-8">
            <h2 class="text-2xl md:text-3xl font-heading font-bold text-forest-900">Profil Demografi & Keadan Sosial</h2>
            <p class="text-sm text-earth-600">Statistik kependudukan, mata pencaharian, dan tingkat pendidikan masyarakat.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm text-center">
                <span class="text-xs font-bold text-earth-500 uppercase tracking-widest block mb-2">Total Penduduk</span>
                <span class="text-4xl font-extrabold text-forest-900">1.066</span>
                <span class="text-earth-700 text-sm block mt-1">Jiwa</span>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-earth-100 shadow-sm text-center">
                <span class="text-xs font-bold text-earth-500 uppercase tracking-widest block mb-2">Jumlah Keluarga</span>
                <span class="text-4xl font-extrabold text-forest-900">323</span>
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
                            <span class="text-xs text-earth-500">126 Kepala Keluarga</span>
                        </div>
                        <span class="font-bold text-forest-900">429 Jiwa</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <div>
                            <span class="font-bold text-earth-800 block">Dusun II</span>
                            <span class="text-xs text-earth-500">125 Kepala Keluarga</span>
                        </div>
                        <span class="font-bold text-forest-900">378 Jiwa</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <div>
                            <span class="font-bold text-earth-800 block">Dusun III</span>
                            <span class="text-xs text-earth-500">72 Kepala Keluarga</span>
                        </div>
                        <span class="font-bold text-forest-900">259 Jiwa</span>
                    </div>
                </div>
            </div>

            <!-- Tingkat Pendidikan -->
            <div class="bg-white p-6 rounded-3xl border border-earth-100 shadow-sm">
                <h3 class="font-heading font-bold text-forest-900 text-lg mb-4 border-b border-gray-100 pb-2">Tingkat Pendidikan</h3>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>Pra Sekolah</span>
                            <span>623 Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: 65%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>SD Negeri</span>
                            <span>125 Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: 15%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>SLTP (SMP)</span>
                            <span>110 Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: 13%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>SLTA (SMA)</span>
                            <span>85 Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: 9%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-earth-700 mb-1">
                            <span>Sarjana</span>
                            <span>19 Orang</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full"><div class="bg-earth-500 h-2 rounded-full" style="width: 3%"></div></div>
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
                        <span class="font-bold text-earth-900">476 Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Buruh</span>
                        <span class="font-bold text-earth-900">25 Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Pedagang</span>
                        <span class="font-bold text-earth-900">22 Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Pegawai Negeri (PNS)</span>
                        <span class="font-bold text-earth-900">7 Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Peternak</span>
                        <span class="font-bold text-earth-900">5 Orang</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 block">Bengkel</span>
                        <span class="font-bold text-earth-900">3 Orang</span>
                    </div>
                </div>
            </div>

            <!-- Hewan Ternak -->
            <div class="bg-white p-6 rounded-3xl border border-earth-100 shadow-sm">
                <h3 class="font-heading font-bold text-forest-900 text-lg mb-4 border-b border-gray-100 pb-2">Kepemilikan Hewan Ternak</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="font-semibold text-earth-800">Ayam / Itik</span>
                        <span class="font-bold text-forest-900">216 KK</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="font-semibold text-earth-800">Kambing</span>
                        <span class="font-bold text-forest-900">53 KK</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="font-semibold text-earth-800">Sapi</span>
                        <span class="font-bold text-forest-900">43 KK</span>
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
                    <tr>
                        <td class="py-4 px-6">1</td>
                        <td class="py-4 px-6 font-semibold">Gedung Serbaguna</td>
                        <td class="py-4 px-6 text-center">1 Unit</td>
                        <td class="py-4 px-6 text-center"><span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">Baik</span></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-6">2</td>
                        <td class="py-4 px-6 font-semibold">Kantor BRDP</td>
                        <td class="py-4 px-6 text-center">1 Unit</td>
                        <td class="py-4 px-6 text-center"><span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">Baik</span></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-6">3</td>
                        <td class="py-4 px-6 font-semibold">Masjid Desa</td>
                        <td class="py-4 px-6 text-center">2 Unit</td>
                        <td class="py-4 px-6 text-center"><span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">Baik</span></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-6">4</td>
                        <td class="py-4 px-6 font-semibold">Pos Keamanan Lingkungan (Pos Kamling)</td>
                        <td class="py-4 px-6 text-center">2 Unit</td>
                        <td class="py-4 px-6 text-center"><span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200">Rusak Ringan</span></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-6">5</td>
                        <td class="py-4 px-6 font-semibold">Sekolah Dasar (SD Negeri)</td>
                        <td class="py-4 px-6 text-center">1 Unit</td>
                        <td class="py-4 px-6 text-center"><span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">Baik</span></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-6">6</td>
                        <td class="py-4 px-6 font-semibold">SMP Satu Atap</td>
                        <td class="py-4 px-6 text-center">1 Unit</td>
                        <td class="py-4 px-6 text-center"><span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">Baik</span></td>
                    </tr>
                    <tr>
                        <td class="py-4 px-6">7</td>
                        <td class="py-4 px-6 font-semibold">Tempat Pemakaman Umum (TPU)</td>
                        <td class="py-4 px-6 text-center">1 Lokasi</td>
                        <td class="py-4 px-6 text-center"><span class="px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">Baik</span></td>
                    </tr>
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
