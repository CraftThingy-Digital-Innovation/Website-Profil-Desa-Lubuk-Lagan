<?php

namespace App\Models;

use CodeIgniter\Model;

class CarouselModel extends Model
{
    protected $table            = 'carousels';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'media_type', 'media_url', 'sort_order', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
