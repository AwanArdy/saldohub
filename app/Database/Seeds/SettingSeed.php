<?php

declare(strict_types=1);

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeed extends Seeder
{
    public function run(): void
    {
        $settings = [
            'rate'          => '18450',
            'min_topup_usd' => '30',
            'min_pay_usd'   => '5',
            'admin_fee_pct' => '4',
            'admin_fee_min' => '30000',
            'whatsapp'      => '6281234567890',
            'bank_name'     => 'BCA',
            'bank_account'  => '1234567890',
            'bank_holder'   => 'PT Contoh Digital Sejahtera',
        ];

        foreach ($settings as $key => $value) {
            $this->db->query(
                'INSERT INTO settings ("key", value) VALUES (:k:, :v:) ON CONFLICT("key") DO UPDATE SET value = :v:',
                ['k' => $key, 'v' => $value]
            );
        }
    }
}
