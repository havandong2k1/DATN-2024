<?php


namespace App\Models;

use CodeIgniter\Model;
use Faker\Provider\Base;

class CartModel extends BaseModel
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $allowedFields = ['customer_id', 'id_product', 'quantity', 'created_at', 'updated_at']; // Đảm bảo rằng 'updated_at' có trong đây
    protected $useAutoIncrement = true;
    protected function beforeInsert(array $data)
    {
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
        $data['updated_at'] = $currentTimestamp; // Cập nhật trường updated_at
        return $data;
    }
    public function getCartWithProducts($customerId)
    {
        return $this->select('cart.*, products.name, products.price, products.images, products.description')
                    ->join('products', 'products.id_product = cart.id_product') // INNER JOIN với bảng product
                    ->where('cart.customer_id', $customerId)
                    ->where('cart.deleted_at', null) // Nếu bạn có cột `deleted_at` để soft delete
                    ->findAll();
    }
    
}