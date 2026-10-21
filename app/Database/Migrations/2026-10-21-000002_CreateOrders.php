<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrders extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INTEGER', 'auto_increment' => true, 'unsigned' => true],
            'user_id'     => ['type' => 'INTEGER', 'unsigned' => true],
            'type'        => ['type' => 'VARCHAR', 'constraint' => '20', 'comment' => 'topup|pay'],
            'amount'      => ['type' => 'DECIMAL', 'constraint' => '14,2', 'comment' => 'USD'],
            'rate'        => ['type' => 'INTEGER', 'comment' => 'rate used at order time'],
            'admin_fee'   => ['type' => 'DECIMAL', 'constraint' => '14,2', 'default' => 0],
            'total_rupiah'=> ['type' => 'DECIMAL', 'constraint' => '16,2'],
            'paypal_acc'  => ['type' => 'VARCHAR', 'constraint' => '180', 'null' => true],
            'item_url'    => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'note'        => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'pending', 'comment' => 'pending|processing|done|cancelled'],
            'created_at'  => ['type' => 'DATETIME'],
            'updated_at'  => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('orders');
    }

    public function down(): void
    {
        $this->forge->dropTable('orders', true);
    }
}
