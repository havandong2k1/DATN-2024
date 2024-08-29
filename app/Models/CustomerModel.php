<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends BaseModel
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    protected $allowedFields = ['customer_name', 'customer_email', 'customer_password', 'created_at',
                                'updated_at', 'deleted_at', 'status_customer'];
    protected $useAutoIncrement = true; // Thêm dòng này để bật AUTO_INCREMENT cho cột khóa chính
    protected $returnType = 'array';
    protected function beforeInsert(array $data)
    {
        unset($data['customer_id']);
        return $this->updateTimestamp($data);
    }
    protected function beforeUpdate(array $data)
    {
        return $this->updateTimestamp($data);
    }

    protected function updateTimestamp(array $data)
    {
        $currentTimestamp = date('Y-m-d H:i:s');

        if (!array_key_exists('created_at', $data)) {
            $data['created_at'] = $currentTimestamp;
        }

        $data['updated_at'] = $currentTimestamp;

        return $data;
    }
}

