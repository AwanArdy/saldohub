<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AdminSeed extends Seeder
{
    public function run(): void
    {
        $existing = $this->db->table('users')
            ->where('email', 'admin@saldohub.test')
            ->countAllResults();

        if ($existing > 0) {
            return;
        }

        $this->db->table('users')->insert([
            'name'       => 'Admin SaldoKita',
            'email'      => 'admin@saldohub.test',
            'password'   => password_hash('admin12345', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ]);
    }
}
