<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends BaseModel
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_product', 'customer_id', 'rating', 'review', 'created_at'];
    protected $useAutoIncrement = true;

    protected function beforeInsert(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s'); // Thêm timestamp khi thêm mới
        return $data;
    }
}
