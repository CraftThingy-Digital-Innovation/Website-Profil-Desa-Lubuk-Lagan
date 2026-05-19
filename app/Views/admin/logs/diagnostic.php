<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Diagnostik - Desa Lubuk Lagan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="bg-slate-900 text-slate-300 font-mono min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-4 border-b border-slate-700 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Sistem Diagnostik & Log Server
                </h1>
                <p class="text-slate-400 text-sm mt-1">Status Lingkungan: <span class="text-emerald-400 font-semibold"><?= ENVIRONMENT ?></span> | PHP: <?= PHP_VERSION ?> | CI: <?= \CodeIgniter\CodeIgniter::CI_VERSION ?></p>
            </div>
            
            <form action="" method="get" class="flex gap-2 w-full md:w-auto">
                <input type="hidden" name="key" value="<?= esc($key) ?>">
                <select name="file" class="bg-slate-800 border border-slate-600 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-green-500 w-full md:w-auto" onchange="this.form.submit()">
                    <?php if(empty($files)): ?>
                        <option value="">Tidak ada file log</option>
                    <?php else: ?>
                        <?php foreach($files as $f): ?>
                            <option value="<?= basename($f) ?>" <?= $currentFile === basename($f) ? 'selected' : '' ?>><?= basename($f) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button type="button" onclick="location.reload()" class="bg-slate-700 hover:bg-slate-600 px-3 py-1.5 rounded transition text-sm flex-shrink-0">
                    Refresh
                </button>
            </form>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-1 space-y-6">
                <!-- Server Info -->
                <div class="bg-slate-800 rounded-lg p-5 border border-slate-700 shadow-lg">
                    <h3 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider border-b border-slate-700 pb-2">Informasi Server</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between"><span class="text-slate-400">OS</span> <span class="text-right"><?= php_uname('s') ?></span></li>
                        <li class="flex justify-between"><span class="text-slate-400">Software</span> <span class="text-right truncate ml-2" title="<?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?>"><?= substr($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown', 0, 20) ?>...</span></li>
                        <li class="flex justify-between"><span class="text-slate-400">Timezone</span> <span><?= date_default_timezone_get() ?></span></li>
                        <li class="flex justify-between"><span class="text-slate-400">Max Upload</span> <span><?= ini_get('upload_max_filesize') ?></span></li>
                        <li class="flex justify-between"><span class="text-slate-400">Post Max Size</span> <span><?= ini_get('post_max_size') ?></span></li>
                        <li class="flex justify-between"><span class="text-slate-400">Memory Limit</span> <span><?= ini_get('memory_limit') ?></span></li>
                        <li class="flex justify-between">
                            <span class="text-slate-400">shell_exec</span> 
                            <span class="<?= is_callable('shell_exec') && false === stripos(ini_get('disable_functions'), 'shell_exec') ? 'text-green-400' : 'text-red-400' ?>">
                                <?= is_callable('shell_exec') && false === stripos(ini_get('disable_functions'), 'shell_exec') ? 'Enabled' : 'Disabled' ?>
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Diagnostics -->
                <div class="bg-slate-800 rounded-lg p-5 border border-slate-700 shadow-lg">
                    <h3 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider border-b border-slate-700 pb-2">Cek Status Direktori</h3>
                    <ul class="space-y-3 text-sm">
                        <?php 
                        $dirs = [
                            'Writable' => WRITEPATH,
                            'Uploads' => FCPATH . 'uploads',
                            'Logs' => WRITEPATH . 'logs',
                            'Cache' => WRITEPATH . 'cache',
                        ];
                        foreach($dirs as $name => $path): 
                            $exists = is_dir($path);
                            $writable = $exists && is_writable($path);
                        ?>
                        <li class="flex justify-between items-center">
                            <span class="text-slate-400"><?= $name ?></span> 
                            <?php if($writable): ?>
                                <span class="bg-green-500/20 text-green-400 px-2 py-0.5 rounded text-xs">OK</span>
                            <?php elseif($exists): ?>
                                <span class="bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded text-xs">Read-only</span>
                            <?php else: ?>
                                <span class="bg-red-500/20 text-red-400 px-2 py-0.5 rounded text-xs">Not Found</span>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-3 flex flex-col">
                <div class="bg-black rounded-t-lg px-4 py-2 flex justify-between items-center border border-slate-700 border-b-0">
                    <span class="text-slate-400 text-sm">Menampilkan: <span class="text-white font-semibold"><?= $currentFile ?: 'Tidak ada file' ?></span></span>
                    <?php if($currentFile): ?>
                    <span class="text-xs text-slate-500"><?= number_format(filesize(WRITEPATH . 'logs/' . $currentFile) / 1024, 2) ?> KB</span>
                    <?php endif; ?>
                </div>
                <div class="bg-[#1e1e1e] p-4 rounded-b-lg border border-slate-700 shadow-inner flex-grow overflow-x-auto relative min-h-[400px]">
                    <?php if(empty($logContent)): ?>
                        <div class="absolute inset-0 flex items-center justify-center text-slate-500">
                            <?= $currentFile ? 'File log ini kosong.' : 'Belum ada catatan log.' ?>
                        </div>
                    <?php else: ?>
                        <pre class="text-[13px] leading-relaxed whitespace-pre-wrap break-words"><?php
                            // Syntax highlight sederhana untuk ERROR, DEBUG, INFO, CRITICAL
                            $lines = explode("\n", htmlspecialchars($logContent));
                            foreach($lines as $line) {
                                if (strpos($line, 'ERROR') !== false || strpos($line, 'CRITICAL') !== false) {
                                    echo '<span class="text-red-400 font-bold">' . $line . '</span>' . "\n";
                                } elseif (strpos($line, 'DEBUG') !== false) {
                                    echo '<span class="text-blue-400">' . $line . '</span>' . "\n";
                                } elseif (strpos($line, 'INFO') !== false) {
                                    echo '<span class="text-green-400">' . $line . '</span>' . "\n";
                                } else {
                                    echo '<span class="text-slate-300">' . $line . '</span>' . "\n";
                                }
                            }
                        ?></pre>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="mt-8 text-center text-slate-500 text-xs">
            Halaman ini adalah rahasia dan hanya boleh diakses oleh Superadmin / Developer.
        </div>
    </div>
</body>
</html>
