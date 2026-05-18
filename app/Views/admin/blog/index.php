<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - Desa Lubuk Lagan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Blog & Berita Desa</h1>
        <a href="<?= base_url('admin/blog/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Tulis Berita Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Judul</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Skor SEO</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php foreach($blogs as $blog): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <span class="font-medium"><?= htmlspecialchars($blog->title) ?></span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <?php if($blog->status == 'public'): ?>
                            <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Publik</span>
                        <?php else: ?>
                            <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">Draft</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="font-bold <?= $blog->seo_score > 70 ? 'text-green-500' : 'text-red-500' ?>"><?= $blog->seo_score ?>/100</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <a href="<?= base_url('admin/blog/edit/'.$blog->id) ?>" class="transform hover:text-blue-500 hover:scale-110">Edit</a>
                            <a href="<?= base_url('admin/blog/delete/'.$blog->id) ?>" onclick="return confirm('Hapus berita ini?')" class="transform hover:text-red-500 hover:scale-110">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
