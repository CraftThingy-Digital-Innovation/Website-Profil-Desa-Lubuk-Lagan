<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\FileManagerModel;

class FileManagerController extends BaseController
{
    public function index()
    {
        $fileModel = new FileManagerModel();
        $data['files'] = $fileModel->orderBy('created_at', 'DESC')->findAll();
        
        return view('admin/file_manager/index', $data);
    }

    public function upload()
    {
        $file = $this->request->getFile('file');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);

            $fileModel = new FileManagerModel();
            $fileModel->insert([
                'filename'      => $newName,
                'original_name' => $file->getClientName(),
                'file_type'     => $file->getClientMimeType(),
                'file_size'     => $file->getSize(),
                'file_path'     => 'uploads/' . $newName,
                'uploaded_by'   => auth()->id() ?? null,
            ]);

            return $this->response->setJSON(['status' => 'success', 'message' => 'File uploaded successfully', 'url' => base_url('uploads/' . $newName)]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Upload failed']);
    }

    public function delete($id)
    {
        $fileModel = new FileManagerModel();
        $file = $fileModel->find($id);

        if ($file) {
            $filePath = FCPATH . $file->file_path;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $fileModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'File deleted']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'File not found']);
    }
}
