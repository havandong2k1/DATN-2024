<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderItemsModel extends BaseModel
{
    protected $table = 'order_items'; 
    protected $primaryKey = 'id'; 

    protected $allowedFields = ['id_order', 'id_product', 'quantity', 'price', 'deleted_at', 'created_at', 'updated_at']; // Các trường có thể gán
    protected $useAutoIncrement = true; // Sử dụng AUTO_INCREMENT cho cột khóa chính

    // Định nghĩa các sự kiện
    protected $beforeInsert = ['beforeInsert'];

    // Phương thức xử lý sự kiện beforeInsert
    protected function beforeInsert(array $data)
    {
        // Thêm logic cần thiết trước khi chèn dữ liệu
        $data['data']['created_at'] = date('Y-m-d H:i:s'); // Thêm thời gian tạo
        return $data; // Trả về dữ liệu đã được sửa đổi
    }
}
