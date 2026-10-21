<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\Calculator;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class Api extends Controller
{
    use ResponseTrait;

    /**
     * Endpoint simulasi menghasilkan nilai rupiah. Dipakai jQuery di halaman publik.
     * GET /api/simulate?type=topup|pay&amount=100
     */
    public function simulate()
    {
        $type   = $this->request->getPost('type') ?? $this->request->getGet('type') ?? 'topup';
        $amount = (float) ($this->request->getPost('amount') ?? $this->request->getGet('amount') ?? 0);

        $calc = new Calculator();

        if ($amount <= 0) {
            return $this->respond(['error' => 'Nominal tidak valid'], 400);
        }

        $result = $type === 'pay'
            ? $calc->payService($amount)
            : $calc->topup($amount);

        $result['fee_rate_pct'] = $type === 'pay' ? (float) ((new \App\Models\SettingModel())->find('admin_fee_pct')['value'] ?? 4) : null;
        $result['fee_min']      = $type === 'pay' ? (float) ((new \App\Models\SettingModel())->find('admin_fee_min')['value'] ?? 30000) : null;

        return $this->respond($result);
    }
}
