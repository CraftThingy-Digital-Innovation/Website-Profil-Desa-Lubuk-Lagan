<?php

namespace App\Controllers;

use App\Models\VillageLocationModel;

class MapController extends BaseAdminController
{
    public function index()
    {
        $model = new VillageLocationModel();
        $data['locations'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('admin/map/index', $data);
    }

    public function create()
    {
        $data['location'] = (object) [
            'id' => null,
            'name' => '',
            'description' => '',
            'latitude' => '-3.791552', // Default somewhere in Lubuk Lagan/Bengkulu
            'longitude' => '102.261895',
            'media_type' => 'none',
            'media_url' => ''
        ];
        return view('admin/map/form', $data);
    }

    public function edit($id)
    {
        $model = new VillageLocationModel();
        $data['location'] = $model->find($id);
        if (!$data['location']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        return view('admin/map/form', $data);
    }

    public function save()
    {
        $model = new VillageLocationModel();
        
        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'latitude'    => $this->request->getPost('latitude'),
            'longitude'   => $this->request->getPost('longitude'),
            'media_type'  => $this->request->getPost('media_type'),
            'media_url'   => $this->request->getPost('media_url'),
        ];

        $id = $this->request->getPost('id');
        if ($id) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to('/admin/map')->with('success', 'Lokasi berhasil disimpan!');
    }

    public function delete($id)
    {
        $model = new VillageLocationModel();
        $model->delete($id);
        return redirect()->to('/admin/map')->with('success', 'Lokasi dihapus!');
    }
}
