<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\HistoryEventModel;
use App\Models\HistoryInfrastructureModel;

class HistoryController extends BaseAdminController
{
    public function index()
    {
        $settingsModel = new SettingsModel();
        $eventModel = new HistoryEventModel();
        $infraModel = new HistoryInfrastructureModel();

        // Trigger ensure_history_initialized just in case
        helper('history');
        ensure_history_initialized();

        $data['title'] = 'Manajemen Sejarah & Profil Desa';
        $data['user'] = auth()->user();
        $data['settings'] = $settingsModel->getAll();
        $data['events'] = $eventModel->orderBy('sort_order', 'ASC')->findAll();
        $data['infrastructure'] = $infraModel->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/history/index', $data);
    }

    public function saveSettings()
    {
        $settingsModel = new SettingsModel();
        $postData = $this->request->getPost();

        foreach ($postData as $key => $value) {
            // Strip HTML tags for specific keys if they shouldn't contain HTML (like counts),
            // but keep HTML for sejarah_asal_usul.
            if ($key !== 'sejarah_asal_usul') {
                $value = strip_tags(trim($value));
            }
            $settingsModel->setValue($key, $value);
        }

        return redirect()->to('admin/history')->with('success', 'Profil dan Demografi desa berhasil diperbarui.');
    }

    public function storeEvent()
    {
        $eventModel = new HistoryEventModel();
        
        $id = $this->request->getPost('id');
        $data = [
            'year' => strip_tags(trim($this->request->getPost('year'))),
            'title' => strip_tags(trim($this->request->getPost('title'))),
            'description' => trim($this->request->getPost('description')),
            'sort_order' => (int)$this->request->getPost('sort_order'),
        ];

        if ($id) {
            $eventModel->update($id, $data);
            $message = 'Lini masa sejarah berhasil diperbarui.';
        } else {
            $eventModel->insert($data);
            $message = 'Lini masa sejarah baru berhasil ditambahkan.';
        }

        return redirect()->to('admin/history#tab-timeline-admin')->with('success', $message);
    }

    public function deleteEvent($id)
    {
        $eventModel = new HistoryEventModel();
        $eventModel->delete($id);
        
        return redirect()->to('admin/history#tab-timeline-admin')->with('success', 'Lini masa sejarah berhasil dihapus.');
    }

    public function storeInfrastructure()
    {
        $infraModel = new HistoryInfrastructureModel();
        
        $id = $this->request->getPost('id');
        $data = [
            'name' => strip_tags(trim($this->request->getPost('name'))),
            'volume' => strip_tags(trim($this->request->getPost('volume'))),
            'condition' => strip_tags(trim($this->request->getPost('condition'))),
            'sort_order' => (int)$this->request->getPost('sort_order'),
        ];

        if ($id) {
            $infraModel->update($id, $data);
            $message = 'Sarana prasarana berhasil diperbarui.';
        } else {
            $infraModel->insert($data);
            $message = 'Sarana prasarana baru berhasil ditambahkan.';
        }

        return redirect()->to('admin/history#tab-sarana-admin')->with('success', $message);
    }

    public function deleteInfrastructure($id)
    {
        $infraModel = new HistoryInfrastructureModel();
        $infraModel->delete($id);
        
        return redirect()->to('admin/history#tab-sarana-admin')->with('success', 'Sarana prasarana berhasil dihapus.');
    }
}
