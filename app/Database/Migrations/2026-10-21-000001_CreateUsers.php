<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INTEGER', 'auto_increment' => true, 'unsigned' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => '120'],
            'email'      => ['type' => 'VARCHAR', 'constraint' => '180', 'unique' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => '255'],
            'paypal_acc' => ['type' => 'VARCHAR', 'constraint' => '180', 'null' => true],
            'role'       => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'user'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down(): void
    {
        $this->forge->dropTable('users', true);
    }
}
