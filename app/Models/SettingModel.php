<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table         = 'settings';
    protected $primaryKey    = 'key';
    protected $returnType    = 'array';
    protected $allowedFields  = ['key', 'value'];

    public function all(): array
    {
        $rows  = $this->findAll();
        $out   = [];
        foreach ($rows as $row) {
            $out[$row['key']] = $row['value'];
        }

        return $out;
    }

    public function upsertKey(string $key, string $value): void
    {
        if ($this->find($key) !== null) {
            $this->update($key, ['value' => $value]);
        } else {
            $this->insert(['key' => $key, 'value' => $value]);
        }
    }
}
