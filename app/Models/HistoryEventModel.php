<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryEventModel extends Model
{
    protected $table            = 'history_events';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['year', 'title', 'description', 'sort_order'];
    protected $useTimestamps    = true;
}
