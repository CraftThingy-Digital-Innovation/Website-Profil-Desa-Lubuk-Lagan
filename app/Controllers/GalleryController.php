<?php

namespace App\Controllers;

use App\Models\GalleryModel;

class GalleryController extends BaseAdminController
{
    private GalleryModel $model;

    // Maps category slug → display info
    private array $categories = [
        'kkn'        => ['label' => 'Galeri KKN 107',  'route' => 'admin/gallery/kkn'],
        'kabar_desa' => ['label' => 'Kabar Desa',       'route' => 'admin/gallery/kabar-desa'],
    ];

    public function __construct()
    {
        $this->model = new GalleryModel();
    }

    /** Index for a specific category */
    public function index(string $category)
    {
        if (!isset($this->categories[$category])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data['items']      = $this->model->where('category', $category)
                                          ->orderBy('sort_order', 'ASC')
                                          ->orderBy('created_at', 'DESC')
                                          ->findAll();
        $data['category']   = $category;
        $data['catInfo']    = $this->categories[$category];
        $data['pageTitle']  = $this->categories[$category]['label'];
        return view('admin/gallery/index', $data);
    }

    public function create(string $category)
    {
        if (!isset($this->categories[$category])) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['item']      = null;
        $data['category']  = $category;
        $data['catInfo']   = $this->categories[$category];
        $data['pageTitle'] = 'Tambah Item — ' . $this->categories[$category]['label'];
        return view('admin/gallery/form', $data);
    }

    public function store(string $category)
    {
        if (!isset($this->categories[$category])) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $mediaUrl  = $this->handleUpload('media_file', null);
        $coverUrl  = $this->handleUpload('cover_file', null);
        $mediaType = $this->request->getPost('media_type') ?: 'image';

        // If no separate cover, use media_url for image type
        if (!$coverUrl && $mediaType === 'image') $coverUrl = $mediaUrl;

        $this->model->insert([
            'category'    => $category,
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'media_url'   => $mediaUrl ?? '',
            'media_type'  => $mediaType,
            'cover_url'   => $coverUrl,
            'sort_order'  => (int)($this->request->getPost('sort_order') ?? 0),
            'status'      => $this->request->getPost('status') ?: 'active',
        ]);

        $route = $this->categories[$category]['route'];
        return redirect()->to($route)->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit(string $category, int $id)
    {
        if (!isset($this->categories[$category])) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['item']      = $this->model->find($id);
        if (!$data['item']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $data['category']  = $category;
        $data['catInfo']   = $this->categories[$category];
        $data['pageTitle'] = 'Edit Item — ' . $this->categories[$category]['label'];
        return view('admin/gallery/form', $data);
    }

    public function update(string $category, int $id)
    {
        if (!isset($this->categories[$category])) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        $existing = $this->model->find($id);
        if (!$existing) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $mediaUrl  = $this->handleUpload('media_file', $existing->media_url);
        $coverUrl  = $this->handleUpload('cover_file', $existing->cover_url);
        $mediaType = $this->request->getPost('media_type') ?: $existing->media_type;
        if (!$coverUrl && $mediaType === 'image') $coverUrl = $mediaUrl;

        $this->model->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'media_url'   => $mediaUrl ?? $existing->media_url,
            'media_type'  => $mediaType,
            'cover_url'   => $coverUrl,
            'sort_order'  => (int)($this->request->getPost('sort_order') ?? 0),
            'status'      => $this->request->getPost('status') ?: 'active',
        ]);

        $route = $this->categories[$category]['route'];
        return redirect()->to($route)->with('success', 'Item berhasil diperbarui.');
    }

    public function delete(string $category, int $id)
    {
        $item = $this->model->find($id);
        if ($item) {
            if ($item->media_url) @unlink(FCPATH . $item->media_url);
            if ($item->cover_url && $item->cover_url !== $item->media_url) @unlink(FCPATH . $item->cover_url);
            $this->model->delete($id);
        }
        $route = $this->categories[$category]['route'];
        return redirect()->to($route)->with('success', 'Item berhasil dihapus.');
    }

    /** Helper: handle file upload + image compress */
    private function handleUpload(string $fieldName, ?string $existing): ?string
    {
        $file = $this->request->getFile($fieldName);
        if (!$file || !$file->isValid() || $file->hasMoved()) return $existing;

        $uploadDir = FCPATH . 'uploads/gallery/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $mime    = $file->getClientMimeType();
        $newName = 'gallery_' . uniqid();

        if (strpos($mime, 'image/') === 0) {
            $newName .= '.webp';
            $dest     = $uploadDir . $newName;
            if (extension_loaded('gd')) {
                $img = null;
                $tmp = $file->getTempName();
                if ($mime === 'image/jpeg') $img = imagecreatefromjpeg($tmp);
                elseif ($mime === 'image/png') $img = imagecreatefrompng($tmp);
                elseif ($mime === 'image/webp') $img = imagecreatefromwebp($tmp);
                if ($img) {
                    $w = imagesx($img); $h = imagesy($img);
                    if ($w > 1920) { $img = imagescale($img, 1920, (int)($h * 1920 / $w)); }
                    imagewebp($img, $dest, 82); imagedestroy($img);
                    if ($existing) @unlink(FCPATH . $existing);
                    return 'uploads/gallery/' . $newName;
                }
            }
            $file->move($uploadDir, $newName);
        } else {
            // video
            $ext     = $file->getClientExtension() ?: 'mp4';
            $newName .= '.' . $ext;
            $file->move($uploadDir, $newName);
        }

        if ($existing) @unlink(FCPATH . $existing);
        return 'uploads/gallery/' . $newName;
    }
}
