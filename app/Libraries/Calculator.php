<?php

declare(strict_types=1);

namespace App\Libraries;

use App\Models\SettingModel;

class Calculator
{
    private array $settings;

    public function __construct()
    {
        $this->settings = (new SettingModel())->all();
    }

    public function rate(): int
    {
        return (int) ($this->settings['rate'] ?? 0);
    }

    public function adminFee(float $amountUsd): float
    {
        $pct = (float) ($this->settings['admin_fee_pct'] ?? 4);
        $min = (float) ($this->settings['admin_fee_min'] ?? 30000);

        $fee = round($amountUsd * $this->rate() * ($pct / 100), 2);

        return max($fee, $min);
    }

    /**
     * Simulasi top up saldo: rupiah yang perlu dibayar & USD yang diterima.
     */
    public function topup(float $amountUsd): array
    {
        $rate    = $this->rate();
        $rupiah  = round($amountUsd * $rate, 2);

        return [
            'usd'     => $amountUsd,
            'rate'    => $rate,
            'fee'     => 0.0,
            'rupiah'  => $rupiah,
        ];
    }

    /**
     * Simulasi jasa bayar: biaya admin + total rupiah.
     */
    public function payService(float $amountUsd): array
    {
        $rate = $this->rate();
        $fee  = $this->adminFee($amountUsd);

        return [
            'usd'     => $amountUsd,
            'rate'    => $rate,
            'fee'     => $fee,
            'rupiah'  => round($amountUsd * $rate + $fee, 2),
        ];
    }

    public function minTopup(): float
    {
        return (float) ($this->settings['min_topup_usd'] ?? 30);
    }

    public function minPay(): float
    {
        return (float) ($this->settings['min_pay_usd'] ?? 5);
    }
}
