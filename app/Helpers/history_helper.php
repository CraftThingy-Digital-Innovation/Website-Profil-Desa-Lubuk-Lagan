<?php

use Config\Database;
use App\Models\SettingsModel;
use App\Models\HistoryEventModel;
use App\Models\HistoryInfrastructureModel;

/**
 * Ensures the history database tables exist and are populated with the initial data.
 */
function ensure_history_initialized()
{
    $db = Database::connect();

    // 1. Create history_events if not exists
    if (!$db->tableExists('history_events')) {
        $db->query("CREATE TABLE `history_events` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `year` VARCHAR(50) NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NULL,
            `sort_order` INT NOT NULL DEFAULT 0,
            `created_at` DATETIME NULL,
            `updated_at` DATETIME NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    // 2. Create history_infrastructure if not exists
    if (!$db->tableExists('history_infrastructure')) {
        $db->query("CREATE TABLE `history_infrastructure` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `volume` VARCHAR(100) NOT NULL,
            `condition` VARCHAR(50) NOT NULL,
            `sort_order` INT NOT NULL DEFAULT 0,
            `created_at` DATETIME NULL,
            `updated_at` DATETIME NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    // 3. Seed history_events if empty
    $eventModel = new HistoryEventModel();
    if ($eventModel->countAllResults() === 0) {
        $events = [
            ['year' => '1617', 'title' => 'Pendaratan & Pembukaan Talang', 'description' => 'Jungku Lintang Kanan (Sarang Bulan Lintang) datang berburu gajah dan menetap di permukiman awal.', 'sort_order' => 1],
            ['year' => '1873', 'title' => 'Peresmian Nama "Leoboek Lagan"', 'description' => 'Penemuan lubuk dan pohon kayu Lagan di Sungai Pengurungan. Musyawarah menetapkan nama Leoboek Lagan dengan Depati Sindang Aru sebagai pemimpin pertama.', 'sort_order' => 2],
            ['year' => '1878 - 1891', 'title' => 'Kepemimpinan Depati Bandung', 'description' => 'Penyatuan kebudayaan adat Lintang dengan budaya Serawai di wilayah pemukiman desa.', 'sort_order' => 3],
            ['year' => '1891 - 1910', 'title' => 'Kepemimpinan Depati Ali Sana', 'description' => 'Ali Sana (Sanek Jumbun) menjabat sebagai Depati pemimpin wilayah.', 'sort_order' => 4],
            ['year' => '1911 - 1929', 'title' => 'Perjuangan Depati Kusim', 'description' => 'Pembangunan gudang senjata untuk perlawanan terhadap kolonial Belanda (dipimpin Pak Seka, Pak Marsul, Abas, dan Gacun). Pada masa ini wabah cacar menyerang pemukiman.', 'sort_order' => 5],
            ['year' => '1930 - 1950', 'title' => 'Kepemimpinan Depati Anim', 'description' => 'Masa kepemimpinan Depati Anim memimpin jalannya roda pemerintahan adat.', 'sort_order' => 6],
            ['year' => '1954 - 1957', 'title' => 'Gejolak Masa Depati Wadip', 'description' => 'Kepemimpinan Depati Wadip. Terjadi peristiwa pergolakan PRRI di daerah.', 'sort_order' => 7],
            ['year' => '1958 - 1962', 'title' => 'Era Depati Minin & G30S/PKI', 'description' => 'Pemerintahan adat dipimpin Depati Minin, bertepatan dengan gejolak nasional G30S/PKI.', 'sort_order' => 8],
            ['year' => '1970 - 1983', 'title' => 'Transisi Sistem Kepala Desa', 'description' => 'Sistem administrasi Depati dihapus, digantikan sistem Kepala Desa. Kepala Desa pertama adalah Djailani. Sekolah SD Inpres pertama kali dibangun.', 'sort_order' => 9],
            ['year' => '2005 - 2008', 'title' => 'Definitif Kepala Desa & PNPM-MP', 'description' => 'Pjs Kepala Desa Badran diangkat menjadi definitif. Pada tahun 2008 mendapat bantuan PNPM-MP senilai Rp 132.720.000 untuk membangun jembatan gantung sepanjang 38 meter.', 'sort_order' => 10],
            ['year' => '2010', 'title' => 'Modernisasi Desa & Listrik Masuk Desa', 'description' => 'Pemilihan kepala desa dimenangkan oleh H. Syahdan Wadip, SH. Di masa ini aliran listrik masuk desa (Lisdes), dibangun gedung TK, pembangunan jalan rabat beton 487m (PNPM-MPd), PPIP pengaspalan 700m, dan mobil dinas operasional.', 'sort_order' => 11],
            ['year' => '2017 - Skrg', 'title' => 'Demokrasi Pemilihan Suprandi, S.Pd', 'description' => 'Pemilihan kepala desa secara demokratis melahirkan pemimpin terpilih Bapak Suprandi, S.Pd yang melanjutkan tongkat estafet pembangunan desa.', 'sort_order' => 12],
        ];
        foreach ($events as $e) {
            $eventModel->insert($e);
        }
    }

    // 4. Seed history_infrastructure if empty
    $infraModel = new HistoryInfrastructureModel();
    if ($infraModel->countAllResults() === 0) {
        $infras = [
            ['name' => 'Gedung Serbaguna', 'volume' => '1 Unit', 'condition' => 'Baik', 'sort_order' => 1],
            ['name' => 'Kantor BRDP', 'volume' => '1 Unit', 'condition' => 'Baik', 'sort_order' => 2],
            ['name' => 'Masjid Desa', 'volume' => '2 Unit', 'condition' => 'Baik', 'sort_order' => 3],
            ['name' => 'Pos Keamanan Lingkungan (Pos Kamling)', 'volume' => '2 Unit', 'condition' => 'Rusak Ringan', 'sort_order' => 4],
            ['name' => 'Sekolah Dasar (SD Negeri)', 'volume' => '1 Unit', 'condition' => 'Baik', 'sort_order' => 5],
            ['name' => 'SMP Satu Atap', 'volume' => '1 Unit', 'condition' => 'Baik', 'sort_order' => 6],
            ['name' => 'Tempat Pemakaman Umum (TPU)', 'volume' => '1 Lokasi', 'condition' => 'Baik', 'sort_order' => 7],
        ];
        foreach ($infras as $i) {
            $infraModel->insert($i);
        }
    }

    // 5. Seed Settings values if missing
    $settingsModel = new SettingsModel();
    $defaultSettings = [
        'sejarah_asal_usul' => '<p class="drop-cap text-xl font-serif">Pada tahun <strong>1617</strong>, datanglah kelompok masyarakat adat pertama yang dikenal sebagai <em>Jungku Lintang Kanan</em> (atau Sarang Bulan Lintang) ke wilayah ini. Awalnya mereka datang dengan tujuan berburu gajah. Melihat bentang wilayah yang sangat luas dan subur, mereka akhirnya memutuskan untuk menetap dan membuka sebuah permukiman awal (Talang). Tak lama berselang, menyusul kedatangan kelompok-kelompok adat lain seperti <em>Jungku Lubuk Sepang</em>, <em>Jungku Lubuk Layang</em>, <em>Jungku Karang Jati</em>, dan <em>Jungku Suka Dana</em>.</p><p>Kisah nama desa ini bermula pada tahun <strong>1873</strong>, ketika serombongan warga mencari ikan di dekat permukiman mereka, tepatnya menyusuri aliran Sungai Pengurungan. Di tengah perjalanan, mereka menemukan sebuah lubuk (bagian sungai yang dalam) yang sangat besar, indah, dan tenang. Di pinggiran lubuk tersebut tumbuh sebuah pohon kayu <strong>Lagan</strong> yang sangat besar dan rimbun dengan mata kayu unik (bukul) yang menonjol. Tempat teduh di bawah pohon Lagan inilah yang kemudian kerap dijadikan peristirahatan dan tempat berkumpul.</p><p>Sepulangnya dari sana, ketua-ketua jungku mengadakan musyawarah adat. Mereka bersepakat mengubah nama dusun awal mereka (Dusun Bukul atau Bo\'ok Lagan) menjadi dusun <strong>Leoboek Lagan</strong> (yang lambat laun dilafalkan menjadi Lubuk Lagan). Sebagai pemimpin adat pertama, ditunjuklah Depati pertama bernama <strong>Sindang Aru</strong> (Depati Sindang Mergo).</p>',
        'demografi_luas_wilayah' => '1500',
        'demografi_dusun_1_kk' => '126',
        'demografi_dusun_1_jiwa' => '429',
        'demografi_dusun_2_kk' => '125',
        'demografi_dusun_2_jiwa' => '378',
        'demografi_dusun_3_kk' => '72',
        'demografi_dusun_3_jiwa' => '259',
        'demografi_edu_pra_sekolah' => '623',
        'demografi_edu_sd' => '125',
        'demografi_edu_sltp' => '110',
        'demografi_edu_slta' => '85',
        'demografi_edu_sarjana' => '19',
        'demografi_job_petani' => '476',
        'demografi_job_buruh' => '25',
        'demografi_job_pedagang' => '22',
        'demografi_job_pns' => '7',
        'demografi_job_peternak' => '5',
        'demografi_job_bengkel' => '3',
        'demografi_ternak_ayam_itik' => '216',
        'demografi_ternak_kambing' => '53',
        'demografi_ternak_sapi' => '43'
    ];

    foreach ($defaultSettings as $key => $val) {
        if ($settingsModel->get($key) === '') {
            $settingsModel->setValue($key, $val);
        }
    }
}
