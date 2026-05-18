<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table      = 'settings';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['key', 'value'];
    protected $useTimestamps = true;

    /**
     * Ambil nilai setting berdasarkan key.
     */
    public function get(string $key, string $default = ''): string
    {
        $row = $this->where('key', $key)->first();
        return $row ? (string) $row->value : $default;
    }

    /**
     * Set/update nilai setting — gunakan setValue() bukan set() karena set() adalah milik CI4 Model.
     */
    public function setValue(string $key, string $value): void
    {
        $existing = $this->where('key', $key)->first();
        if ($existing) {
            $this->update($existing->id, ['value' => $value]);
        } else {
            $this->insert(['key' => $key, 'value' => $value]);
        }
    }

    /**
     * Ambil semua settings sebagai array key => value.
     */
    public function getAll(): array
    {
        $rows = $this->findAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row->key] = $row->value;
        }
        return $result;
    }
}
