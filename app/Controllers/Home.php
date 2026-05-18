<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\VillageLocationModel;

class Home extends BaseController
{
    public function index()
    {
        $blogModel = new BlogModel();
        $mapModel = new VillageLocationModel();

        $data['blogs'] = $blogModel->where('status', 'public')->orderBy('created_at', 'DESC')->findAll(3); // Ambil 3 berita terbaru
        $data['locations'] = $mapModel->findAll();

        return view('public/home', $data);
    }

    public function read_blog($slug)
    {
        $blogModel = new BlogModel();
        $data['blog'] = $blogModel->where('slug', $slug)->where('status', 'public')->first();

        if (!$data['blog']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('public/blog_single', $data);
    }
}
