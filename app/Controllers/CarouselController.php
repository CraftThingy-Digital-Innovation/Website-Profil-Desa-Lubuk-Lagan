<?php

namespace App\Controllers;

use App\Models\CarouselModel;

class CarouselController extends BaseAdminController
{
    protected $carouselModel;

    public function __construct()
    {
        $this->carouselModel = new CarouselModel();
    }

    public function index()
    {
        $data['title'] = 'Media Carousel';
        $data['carousels'] = $this->carouselModel->orderBy('sort_order', 'ASC')->findAll();
        
        return view('admin/carousel/index', $data);
    }

    public function store()
    {
        $rules = [
            'media_url' => 'required',
            'media_type' => 'required|in_list[image,video]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Gagal menambahkan. URL Media dan Tipe wajib diisi.');
        }

        $this->carouselModel->insert([
            'title'      => $this->request->getPost('title'),
            'media_type' => $this->request->getPost('media_type'),
            'media_url'  => $this->request->getPost('media_url'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'status'     => $this->request->getPost('status') ?: 'active'
        ]);

        return redirect()->to('admin/carousel')->with('success', 'Media berhasil ditambahkan ke carousel.');
    }

    public function delete($id)
    {
        $this->carouselModel->delete($id);
        return redirect()->to('admin/carousel')->with('success', 'Media berhasil dihapus dari carousel.');
    }

    public function updateStatus($id)
    {
        $item = $this->carouselModel->find($id);
        if ($item) {
            $newStatus = $item->status === 'active' ? 'inactive' : 'active';
            $this->carouselModel->update($id, ['status' => $newStatus]);
            return redirect()->to('admin/carousel')->with('success', 'Status media diperbarui.');
        }
        return redirect()->to('admin/carousel')->with('error', 'Media tidak ditemukan.');
    }
}
