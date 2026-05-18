<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\BlogModel;

class BlogController extends BaseController
{
    public function index()
    {
        $model = new BlogModel();
        $data['blogs'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('admin/blog/index', $data);
    }

    // Membuat draft kosong dan langsung redirect ke form edit agar autosave mudah
    public function create_draft()
    {
        $model = new BlogModel();
        $id = $model->insert([
            'title' => 'Draft Tanpa Judul',
            'slug' => 'draft-' . uniqid(),
            'status' => 'draft',
            'author_id' => auth()->id() ?? 1
        ]);
        return redirect()->to('/admin/blog/edit/' . $id);
    }

    public function edit($id)
    {
        $model = new BlogModel();
        $data['blog'] = $model->find($id);
        if (!$data['blog']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        
        return view('admin/blog/form', $data);
    }

    public function autosave()
    {
        $model = new BlogModel();
        $id = $this->request->getPost('id');
        
        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'content' => $this->request->getPost('content'),
            'seo_score' => $this->request->getPost('seo_score'),
            'status' => $this->request->getPost('status')
        ];

        // Jika slug manual dari client, kita tidak overwrite di server, biarkan client urus auto-gen
        $model->update($id, $data);
        
        return $this->response->setJSON(['status' => 'success', 'last_saved' => date('H:i:s')]);
    }

    public function delete($id)
    {
        $model = new BlogModel();
        $model->delete($id);
        return redirect()->to('/admin/blog');
    }
}
