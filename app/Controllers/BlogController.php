<?php

namespace App\Controllers;

use App\Models\BlogModel;

class BlogController extends BaseAdminController
{
    /**
     * Valid categories: 'blog' = Berita/Blog biasa, 'kkn' = Galeri KKN 107
     * Category menentukan tab aktif di admin dan filter di public.
     */
    private array $categories = [
        'blog' => ['label' => 'Blog & Berita',  'create_label' => 'Tulis Berita Baru',  'back_url' => 'admin/blog'],
        'kkn'  => ['label' => 'Galeri KKN 107', 'create_label' => 'Tambah Entri KKN',   'back_url' => 'admin/kkn'],
    ];

    /** Resolves which category we're in based on current URL segment */
    private function detectCategory(): string
    {
        return str_contains(current_url(), 'admin/kkn') ? 'kkn' : 'blog';
    }

    public function index()
    {
        $cat   = $this->detectCategory();
        $model = new BlogModel();
        $data['blogs']    = $model->where('category', $cat)->orderBy('created_at', 'DESC')->findAll();
        $data['category'] = $cat;
        $data['catInfo']  = $this->categories[$cat];
        $data['pageTitle'] = $this->categories[$cat]['label'];
        return view('admin/blog/index', $data);
    }

    public function create_draft()
    {
        $cat   = $this->detectCategory();
        $model = new BlogModel();
        $id = $model->insert([
            'title'     => 'Draft Tanpa Judul',
            'slug'      => 'draft-' . uniqid(),
            'status'    => 'draft',
            'category'  => $cat,
            'author_id' => auth()->id() ?? 1,
        ]);
        $backUrl = $cat === 'kkn' ? 'admin/kkn' : 'admin/blog';
        return redirect()->to("/{$backUrl}/edit/{$id}");
    }

    public function edit($id)
    {
        $cat   = $this->detectCategory();
        $model = new BlogModel();
        $data['blog']     = $model->find($id);
        if (!$data['blog']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['category'] = $cat;
        $data['catInfo']  = $this->categories[$cat];
        $data['pageTitle'] = 'Edit — ' . $this->categories[$cat]['label'];
        return view('admin/blog/form', $data);
    }

    public function autosave()
    {
        $model = new BlogModel();
        $id    = $this->request->getPost('id');
        $model->update($id, [
            'title'        => $this->request->getPost('title'),
            'slug'         => $this->request->getPost('slug'),
            'description'  => $this->request->getPost('description'),
            'content'      => $this->request->getPost('content'),
            'seo_score'    => $this->request->getPost('seo_score'),
            'status'       => $this->request->getPost('status'),
            'published_at' => $this->request->getPost('published_at') ?: null,
        ]);
        return $this->response->setJSON(['status' => 'success', 'last_saved' => date('H:i:s')]);
    }

    public function delete($id)
    {
        $cat   = $this->detectCategory();
        $model = new BlogModel();
        $model->delete($id);
        $backUrl = $cat === 'kkn' ? 'admin/kkn' : 'admin/blog';
        return redirect()->to("/{$backUrl}");
    }

    public function preview($id)
    {
        $model        = new BlogModel();
        $data['blog'] = $model->find($id);
        if (!$data['blog']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['is_preview'] = true;
        $data['settings']   = (new \App\Models\SettingsModel())->getAll();
        return view('public/blog_single', $data);
    }
}
