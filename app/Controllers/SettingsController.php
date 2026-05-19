<?php

namespace App\Controllers;

use App\Models\SettingsModel;

class SettingsController extends BaseAdminController
{
    public function index()
    {
        if ($this->user['role'] !== 'superadmin') {
            return redirect()->to('admin/dashboard')->with('error', 'Akses ditolak. Anda bukan Superadmin.');
        }

        $settingsModel = new SettingsModel();
        
        if ($this->request->getMethod() === 'POST') {
            $postData = $this->request->getPost();
            foreach ($postData as $key => $value) {
                $settingsModel->set($key, $value);
            }
            return redirect()->to('admin/settings')->with('success', 'Pengaturan berhasil diperbarui.');
        }

        $data['title'] = 'Pengaturan Sistem';
        $data['user'] = $this->user;
        $data['settings'] = $settingsModel->getAll();

        return view('admin/settings/index', $data);
    }
}
