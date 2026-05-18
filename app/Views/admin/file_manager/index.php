<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager - Desa Lubuk Lagan</title>
    <!-- Tailwind CSS (for quick styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Browser Image Compression -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.1/dist/browser-image-compression.js"></script>
    <!-- FFmpeg.wasm for Video Compression -->
    <script src="https://unpkg.com/@ffmpeg/ffmpeg@0.12.6/dist/umd/ffmpeg.js"></script>
    <script src="https://unpkg.com/@ffmpeg/util@0.12.1/dist/umd/index.js"></script>
    <style>
        .lazy-bg { background-color: #f3f4f6; }
    </style>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Manajer File (Media Gallery)</h1>
    
    <div class="mb-6 p-4 border-2 border-dashed border-gray-300 rounded-lg text-center bg-gray-50">
        <label for="fileUpload" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded inline-block transition">
            Pilih File (Gambar maks 1MB, Video maks 100MB)
        </label>
        <input type="file" id="fileUpload" class="hidden" accept="image/*,video/*">
        <div id="uploadStatus" class="mt-3 text-sm text-gray-600"></div>
        <div id="progressContainer" class="w-full bg-gray-200 rounded-full h-2.5 mt-2 hidden">
            <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="gallery">
        <?php foreach($files as $file): ?>
            <div class="relative group rounded-lg overflow-hidden border shadow-sm lazy-bg" id="file-<?= $file->id ?>">
                <?php if (strpos($file->file_type, 'image') !== false): ?>
                    <img src="<?= base_url($file->file_path) ?>" loading="lazy" class="w-full h-40 object-cover" alt="<?= $file->original_name ?>">
                <?php elseif (strpos($file->file_type, 'video') !== false): ?>
                    <video src="<?= base_url($file->file_path) ?>" class="w-full h-40 object-cover" controls preload="none"></video>
                <?php else: ?>
                    <div class="w-full h-40 flex items-center justify-center bg-gray-200 text-gray-500 text-xs break-all p-2">
                        <?= $file->original_name ?>
                    </div>
                <?php endif; ?>
                
                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center">
                    <button onclick="copyToClipboard('<?= base_url($file->file_path) ?>')" class="bg-green-500 text-white text-xs py-1 px-3 rounded mb-2">Copy Link</button>
                    <button onclick="deleteFile(<?= $file->id ?>)" class="bg-red-500 text-white text-xs py-1 px-3 rounded">Delete</button>
                </div>
                <div class="p-2 text-xs text-gray-600 truncate bg-white">
                    <?= $file->original_name ?> (<?= number_format($file->file_size / 1024, 1) ?> KB)
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    const fileUpload = document.getElementById('fileUpload');
    const uploadStatus = document.getElementById('uploadStatus');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');

    fileUpload.addEventListener('change', async (event) => {
        const file = event.target.files[0];
        if (!file) return;

        let processedFile = file;

        progressContainer.classList.remove('hidden');
        progressBar.style.width = '0%';

        try {
            if (file.type.startsWith('image/')) {
                uploadStatus.innerText = "Mengompresi dan mengonversi gambar ke WebP...";
                // Konfigurasi kompresi browser-image-compression
                const options = {
                    maxSizeMB: 1, // Target Maksimal 1MB
                    maxWidthOrHeight: 1920,
                    useWebWorker: true,
                    fileType: 'image/webp',
                    onProgress: (p) => { progressBar.style.width = p + '%'; }
                };
                let compressedBlob = await imageCompression(file, options);
                
                // Ganti ekstensi file menjadi .webp
                const newName = file.name.substring(0, file.name.lastIndexOf('.')) + '.webp';
                processedFile = new File([compressedBlob], newName, { type: 'image/webp' });
                
                uploadStatus.innerText = "Kompresi gambar WebP selesai. Mengunggah...";
                
            } else if (file.type.startsWith('video/')) {
                uploadStatus.innerText = "Memuat modul kompresi video pintar (FFmpeg)...";
                const { FFmpeg } = FFmpegWASM;
                const { fetchFile } = FFmpegUtil;
                const ffmpeg = new FFmpeg();
                
                ffmpeg.on('progress', ({ progress }) => {
                    const percent = Math.round(progress * 100);
                    progressBar.style.width = percent + '%';
                    uploadStatus.innerText = `Mengompresi video: ${percent}% (Proses ini memakan waktu, harap tunggu...)`;
                });

                // Load single-thread core to avoid SharedArrayBuffer header issues
                await ffmpeg.load({
                    coreURL: 'https://unpkg.com/@ffmpeg/core@0.12.6/dist/umd/ffmpeg-core.js',
                    wasmURL: 'https://unpkg.com/@ffmpeg/core@0.12.6/dist/umd/ffmpeg-core.wasm'
                });

                const inputExt = file.name.substring(file.name.lastIndexOf('.'));
                const inputName = 'input' + inputExt;
                const outputName = 'output.mp4';
                
                await ffmpeg.writeFile(inputName, await fetchFile(file));
                
                // Compress video to mp4, crf 28 (kompresi tinggi), audio aac
                uploadStatus.innerText = "Mulai proses konversi dan kompresi video...";
                await ffmpeg.exec(['-i', inputName, '-vcodec', 'libx264', '-crf', '28', '-preset', 'ultrafast', '-c:a', 'aac', '-b:a', '128k', outputName]);
                
                const data = await ffmpeg.readFile(outputName);
                const newName = file.name.substring(0, file.name.lastIndexOf('.')) + '.mp4';
                processedFile = new File([data.buffer], newName, { type: 'video/mp4' });
                
                if (processedFile.size > 100 * 1024 * 1024) {
                    alert("Peringatan: Walaupun telah dikompresi, ukuran video masih melebihi 100MB. Coba unggah video dengan durasi lebih pendek.");
                    uploadStatus.innerText = "Upload dibatalkan karena melebihi batas 100MB.";
                    progressContainer.classList.add('hidden');
                    return;
                }
                
                uploadStatus.innerText = "Kompresi video selesai. Mengunggah...";
            }

            // Upload ke server via AJAX
            const formData = new FormData();
            formData.append('file', processedFile);

            const response = await fetch('<?= base_url('admin/file-manager/upload') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            progressBar.style.width = '100%';

            if (result.status === 'success') {
                uploadStatus.innerText = "Upload Berhasil!";
                setTimeout(() => location.reload(), 1000); // Reload to show new file
            } else {
                uploadStatus.innerText = "Upload Gagal: " + result.message;
            }

        } catch (error) {
            console.error(error);
            uploadStatus.innerText = "Terjadi kesalahan: " + error.message;
        }
    });

    async function deleteFile(id) {
        if(!confirm("Hapus file ini?")) return;
        
        const response = await fetch(`<?= base_url('admin/file-manager/delete/') ?>${id}`, {
            method: 'DELETE'
        });
        const result = await response.json();
        if(result.status === 'success') {
            document.getElementById(`file-${id}`).remove();
        } else {
            alert(result.message);
        }
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert("Link berhasil dicopy!");
        });
    }
</script>
</body>
</html>
