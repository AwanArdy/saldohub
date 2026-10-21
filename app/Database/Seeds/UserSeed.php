<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeed extends Seeder
{
    public function run(): void
    {
        $this->db->table('users')->insertBatch([
            [
                'name'       => 'Demo User',
                'email'      => 'user@saldohub.test',
                'password'   => password_hash('user12345', PASSWORD_DEFAULT),
                'role'       => 'user',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ]);
    }
}
