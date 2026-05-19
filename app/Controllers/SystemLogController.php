<?php

namespace App\Controllers;

use App\Models\SettingsModel;

class SystemLogController extends BaseController
{
    public function index()
    {
        $settingsModel = new SettingsModel();
        // Password bisa diubah di settings (database) nantinya, default: developer123
        $logPassword = $settingsModel->get('system_log_password', 'developer123');

        $inputKey = $this->request->getGet('key');

        if ($inputKey !== $logPassword) {
            return $this->response->setStatusCode(403)
                ->setContentType('text/plain')
                ->setBody("Akses Ditolak. Gunakan parameter ?key=PASSWORD_ANDA\nPassword dapat diatur di tabel settings dengan key 'system_log_password'");
        }

        $logPath = WRITEPATH . 'logs/';
        $files = glob($logPath . '*.log');
        
        if (empty($files)) {
            return $this->response->setContentType('text/plain')->setBody("Belum ada log file di server.");
        }

        // Urutkan file untuk mendapatkan yang terbaru
        rsort($files);
        
        $currentFile = $this->request->getGet('file');
        if (!$currentFile || !in_array($logPath . $currentFile, $files)) {
            $currentFile = !empty($files) ? basename($files[0]) : null;
        }

        $logContent = '';
        if ($currentFile && file_exists($logPath . $currentFile)) {
            $logContent = file_get_contents($logPath . $currentFile);
        }

        return view('admin/logs/diagnostic', [
            'files' => $files,
            'currentFile' => $currentFile,
            'logContent' => $logContent,
            'key' => $inputKey
        ]);
    }
}
