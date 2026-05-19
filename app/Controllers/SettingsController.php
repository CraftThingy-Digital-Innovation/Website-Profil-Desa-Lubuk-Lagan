<?php

namespace App\Controllers;

use App\Models\SettingsModel;

class SettingsController extends BaseAdminController
{
    public function index()
    {
        if (!auth()->user()->inGroup('superadmin')) {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak. Anda bukan Superadmin.');
        }

        $settingsModel = new SettingsModel();
        
        if ($this->request->getMethod() === 'POST') {
            $postData = $this->request->getPost();
            foreach ($postData as $key => $value) {
                $settingsModel->setValue($key, $value);
            }
            return redirect()->to('admin/settings')->with('success', 'Pengaturan berhasil diperbarui.');
        }

        $data['title'] = 'Pengaturan Sistem';
        $data['user'] = auth()->user();
        $data['settings'] = $settingsModel->getAll();

        return view('admin/settings/index', $data);
    }
}
