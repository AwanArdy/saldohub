<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProofPath extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('orders', [
            'proof_path' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true, 'after' => 'status'],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('orders', 'proof_path');
    }
}
