<?php

namespace App\Controllers;

use App\Models\VillageOfficerModel;

class OfficerController extends BaseAdminController
{
    private VillageOfficerModel $model;

    public function __construct()
    {
        $this->model = new VillageOfficerModel();
    }

    public function index()
    {
        $data['officers']  = $this->model->orderBy('level', 'ASC')->orderBy('sort_order', 'ASC')->findAll();
        $data['pageTitle'] = 'Perangkat Desa';
        return view('admin/officers/index', $data);
    }

    public function create()
    {
        $data['officer']   = null;
        $data['parents']   = $this->model->getFlatList();
        $data['pageTitle'] = 'Tambah Perangkat';
        return view('admin/officers/form', $data);
    }

    public function store()
    {
        $photo = null;
        $file  = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $newName = 'officer_' . uniqid() . '.webp';
            if (extension_loaded('gd')) {
                $tmp  = $file->getTempName();
                $mime = $file->getClientMimeType();
                $img  = null;
                if ($mime === 'image/jpeg') $img = imagecreatefromjpeg($tmp);
                elseif ($mime === 'image/png') $img = imagecreatefrompng($tmp);
                elseif ($mime === 'image/webp') $img = imagecreatefromwebp($tmp);
                if ($img) {
                    $w = imagesx($img); $h = imagesy($img);
                    if ($w > 600) { $nh = (int)($h * 600 / $w); $img = imagescale($img, 600, $nh); }
                    imagewebp($img, $uploadDir . $newName, 85);
                    imagedestroy($img);
                    $photo = 'uploads/' . $newName;
                }
            }
            if (!$photo) {
                $file->move($uploadDir, $newName);
                $photo = 'uploads/' . $newName;
            }
        }

        $this->model->insert([
            'name'       => $this->request->getPost('name'),
            'position'   => $this->request->getPost('position'),
            'level'      => (int) $this->request->getPost('level') ?: 1,
            'parent_id'  => $this->request->getPost('parent_id') ?: null,
            'photo'      => $photo,
            'quote'      => $this->request->getPost('quote'),
            'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
        ]);

        return redirect()->to('admin/officers')->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['officer']   = $this->model->find($id);
        if (!$data['officer']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['parents']   = $this->model->getFlatList();
        $data['pageTitle'] = 'Edit Perangkat';
        return view('admin/officers/form', $data);
    }

    public function update($id)
    {
        $officer = $this->model->find($id);
        if (!$officer) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $photo = $officer->photo;
        $file  = $this->request->getFile('photo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/';
            $newName = 'officer_' . uniqid() . '.webp';
            if (extension_loaded('gd')) {
                $tmp  = $file->getTempName();
                $mime = $file->getClientMimeType();
                $img  = null;
                if ($mime === 'image/jpeg') $img = imagecreatefromjpeg($tmp);
                elseif ($mime === 'image/png') $img = imagecreatefrompng($tmp);
                elseif ($mime === 'image/webp') $img = imagecreatefromwebp($tmp);
                if ($img) {
                    $w = imagesx($img); $h = imagesy($img);
                    if ($w > 600) { $nh = (int)($h * 600 / $w); $img = imagescale($img, 600, $nh); }
                    imagewebp($img, $uploadDir . $newName, 85);
                    imagedestroy($img);
                    if ($officer->photo) @unlink(FCPATH . $officer->photo);
                    $photo = 'uploads/' . $newName;
                }
            }
            if ($photo === $officer->photo) { // GD failed
                $file->move($uploadDir, $newName);
                if ($officer->photo) @unlink(FCPATH . $officer->photo);
                $photo = 'uploads/' . $newName;
            }
        }

        $this->model->update($id, [
            'name'       => $this->request->getPost('name'),
            'position'   => $this->request->getPost('position'),
            'level'      => (int) $this->request->getPost('level') ?: 1,
            'parent_id'  => $this->request->getPost('parent_id') ?: null,
            'photo'      => $photo,
            'quote'      => $this->request->getPost('quote'),
            'sort_order' => (int) $this->request->getPost('sort_order') ?: 0,
        ]);

        return redirect()->to('admin/officers')->with('success', 'Perangkat berhasil diperbarui.');
    }

    public function delete($id)
    {
        $officer = $this->model->find($id);
        if ($officer && $officer->photo) @unlink(FCPATH . $officer->photo);
        $this->model->delete($id);
        return redirect()->to('admin/officers')->with('success', 'Perangkat berhasil dihapus.');
    }
}
