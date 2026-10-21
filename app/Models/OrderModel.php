<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id', 'type', 'amount', 'rate', 'admin_fee',
        'total_rupiah', 'paypal_acc', 'item_url', 'note', 'status', 'proof_path',
    ];

    protected $validationRules = [
        'amount' => 'required|greater_than[0]',
    ];

    public function forUser(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function withUser(): array
    {
        return $this->select('orders.*, users.name AS user_name, users.email AS user_email')
            ->join('users', 'users.id = orders.user_id')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();
    }
}
