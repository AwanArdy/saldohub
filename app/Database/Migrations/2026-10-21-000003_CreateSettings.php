<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettings extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'key'   => ['type' => 'VARCHAR', 'constraint' => '60', 'unique' => true],
            'value' => ['type' => 'VARCHAR', 'constraint' => '120'],
        ]);
        $this->forge->addKey('key', true);
        $this->forge->createTable('settings');
    }

    public function down(): void
    {
        $this->forge->dropTable('settings', true);
    }
}
