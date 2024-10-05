<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends BaseModel
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    protected $allowedFields = ['customer_id', 'order_desc', 'total_amount', 'payment_status', 'payment_method', 'created_at'];

    public function createOrder($data)
    {
        return $this->insert($data);
    }

    public function updateOrderStatus($orderId, $status)
    {
        return $this->update($orderId, ['payment_status' => $status]);
    }
}
