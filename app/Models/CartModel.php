<?php


namespace App\Models;


use CodeIgniter\Model;

class CartModel extends BaseModel
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $allowedFields = ['customer_id', 'product_id ', 'quantity ', 'created_at', 'update_at', 'deleted_at'];
    protected $useAutoIncrement = true; // Thêm dòng này để bật AUTO_INCREMENT cho cột khóa chính
    protected function beforeInsert(array $data)
    {
        // Add your logic here
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

        return $data;
    }
}