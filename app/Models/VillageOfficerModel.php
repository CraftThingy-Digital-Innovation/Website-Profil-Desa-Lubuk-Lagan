<?php

namespace App\Models;

use CodeIgniter\Model;

class VillageOfficerModel extends Model
{
    protected $table         = 'village_officers';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $allowedFields = ['name', 'position', 'level', 'parent_id', 'photo', 'quote', 'sort_order'];
    protected $useTimestamps = true;

    /**
     * Ambil semua perangkat, disusun sebagai tree berdasarkan parent_id & level.
     * Return array: setiap node punya ->children[]
     */
    public function getTree(): array
    {
        $all    = $this->orderBy('level', 'ASC')->orderBy('sort_order', 'ASC')->findAll();
        $map    = [];
        $roots  = [];

        foreach ($all as $item) {
            $item->children = [];
            $map[$item->id]  = $item;
        }

        foreach ($map as $item) {
            if ($item->parent_id && isset($map[$item->parent_id])) {
                $map[$item->parent_id]->children[] = &$map[$item->id];
            } else {
                $roots[] = &$map[$item->id];
            }
        }

        return $roots;
    }

    /** Flat list untuk dropdown, dengan indent berdasarkan level */
    public function getFlatList(): array
    {
        return $this->orderBy('level', 'ASC')->orderBy('sort_order', 'ASC')->findAll();
    }
}
