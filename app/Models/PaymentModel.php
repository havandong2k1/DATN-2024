<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends BaseModel
{
    protected $table = 'payments'; // Bảng thanh toán
    protected $primaryKey = 'id';

    protected $allowedFields = ['customer_id', 'total_amount', 'payment_status', 'created_at'];
    protected $useAutoIncrement = true;

    protected function beforeInsert(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s'); // Thêm timestamp khi thêm mới
        return $data;
    }
}


