<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table         = 'gallery_items';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['category', 'title', 'description', 'media_url', 'media_type', 'cover_url', 'sort_order', 'status'];
    protected $useTimestamps = true;

    public function getByCategory(string $category, bool $activeOnly = true): array
    {
        $q = $this->where('category', $category)->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC');
        if ($activeOnly) $q->where('status', 'active');
        return $q->findAll();
    }
}
