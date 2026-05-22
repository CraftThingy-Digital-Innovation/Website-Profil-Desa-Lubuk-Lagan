<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\VillageLocationModel;
use App\Models\SettingsModel;
use App\Models\VillageOfficerModel;

class Home extends BaseController
{
    private function getSettings(): array
    {
        $sm = new SettingsModel();
        return $sm->getAll();
    }

    public function index()
    {
        $blogModel     = new BlogModel();
        $mapModel      = new VillageLocationModel();
        $carouselModel = new \App\Models\CarouselModel();

        // Home only shows regular blog posts (category=blog)
        $data['blogs']     = $blogModel->where('category', 'blog')->where('status', 'public')->orderBy('created_at', 'DESC')->findAll(3);
        $data['locations'] = $mapModel->findAll();
        $data['carousels'] = $carouselModel->where('status', 'active')->orderBy('sort_order', 'ASC')->findAll();
        $data['settings']  = $this->getSettings();

        return view('public/home', $data);
    }

    public function read_blog($slug)
    {
        $blogModel    = new BlogModel();
        $data['blog'] = $blogModel->where('slug', $slug)->where('status', 'public')->first();

        if (!$data['blog']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['settings'] = $this->getSettings();
        return view('public/blog_single', $data);
    }

    public function sejarah()
    {
        $data['settings'] = $this->getSettings();
        return view('public/sejarah', $data);
    }

    public function perangkat()
    {
        $officerModel     = new VillageOfficerModel();
        $data['officers'] = $officerModel->orderBy('level', 'ASC')->orderBy('sort_order', 'ASC')->findAll();
        $data['settings'] = $this->getSettings();
        return view('public/perangkat_desa', $data);
    }

    public function kkn()
    {
        $blogModel        = new BlogModel();
        $data['blogs']    = $blogModel->where('category', 'kkn')->where('status', 'public')->orderBy('created_at', 'DESC')->findAll();
        $data['settings'] = $this->getSettings();
        return view('public/kkn', $data);
    }

    public function kabar_desa()
    {
        $blogModel        = new BlogModel();
        $data['blogs']    = $blogModel->where('category', 'blog')->where('status', 'public')->orderBy('created_at', 'DESC')->findAll();
        $data['settings'] = $this->getSettings();
        return view('public/kabar_desa', $data);
    }

    public function blog_list()
    {
        $blogModel = new BlogModel();

        $search = $this->request->getGet('q');
        if ($search) {
            $blogModel->like('title', $search)->orLike('description', $search)->orLike('content', $search);
        }

        $data['blogs']    = $blogModel->where('status', 'public')->orderBy('created_at', 'DESC')->paginate(9);
        $data['pager']    = $blogModel->pager;
        $data['search']   = $search;
        $data['settings'] = $this->getSettings();

        return view('public/blog_list', $data);
    }
}
