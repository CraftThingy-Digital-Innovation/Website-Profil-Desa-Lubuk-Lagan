<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryInfrastructureModel extends Model
{
    protected $table            = 'history_infrastructure';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['name', 'volume', 'condition', 'sort_order'];
    protected $useTimestamps    = true;
}
