<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta & Lokasi Desa - Desa Lubuk Lagan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 font-sans">

<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Lokasi & Peta Interaktif</h1>
        <a href="<?= base_url('admin/map/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Tambah Titik Lokasi Baru
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nama Lokasi</th>
                    <th class="py-3 px-6 text-center">Tipe Media</th>
                    <th class="py-3 px-6 text-center">Koordinat</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php foreach($locations as $loc): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <span class="font-medium"><?= htmlspecialchars($loc->name) ?></span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <?php if($loc->media_type == 'drone_video'): ?>
                            <span class="bg-indigo-100 text-indigo-600 py-1 px-3 rounded-full text-xs">Video Drone</span>
                        <?php elseif($loc->media_type == 'photo'): ?>
                            <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs">Foto</span>
                        <?php else: ?>
                            <span class="bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-xs">Tanpa Media</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-6 text-center text-xs">
                        <?= $loc->latitude ?>, <?= $loc->longitude ?>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <a href="<?= base_url('admin/map/edit/'.$loc->id) ?>" class="transform hover:text-blue-500 hover:scale-110">Edit</a>
                            <a href="<?= base_url('admin/map/delete/'.$loc->id) ?>" onclick="return confirm('Hapus lokasi ini?')" class="transform hover:text-red-500 hover:scale-110">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($locations)): ?>
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">Belum ada titik lokasi yang ditambahkan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
