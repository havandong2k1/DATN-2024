<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends BaseModel
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    protected $allowedFields = [
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'order_desc',
        'total_amount',
        'payment_status',
        'created_at',
        'updated_at',
        'deleted_at',
        'order_status',
        'order_code',
    ];

    protected $useAutoIncrement = true; // Sử dụng AUTO_INCREMENT cho cột khóa chính
    protected $useTimestamps = true; // Sử dụng timestamp
    protected $useSoftDeletes = true; // Sử dụng soft delete

    // Khai báo sự kiện trước khi insert
    protected $beforeInsert = ['beforeInsertCallback'];

    // Sự kiện trước khi insert
    protected function beforeInsertCallback(array $data)
    {
        // Tạo mã đơn hàng ngẫu nhiên và thêm vào dữ liệu
        $data['data']['order_code'] = $this->generateRandomOrderCode();
        return $data; // Trả lại dữ liệu đã cập nhật với order_code
    }

    // Hàm tạo mã đơn hàng ngẫu nhiên (vừa số vừa chữ)
    public function generateRandomOrderCode($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        // Tạo chuỗi ngẫu nhiên với độ dài mong muốn
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Hàm tạo đơn hàng
    public function createOrder($data)
    {
        return $this->insert($data); // Insert đơn hàng, sẽ tự động thêm mã đơn hàng khi trước insert
    }

    // Hàm cập nhật đơn hàng
    public function updateOrder($orderId, $data)
    {
        return $this->update($orderId, $data); // Cập nhật đơn hàng
    }

    // Hàm lấy tất cả đơn hàng chưa bị xóa
    public function getOrders()
    {
        return $this->where('deleted_at', null)->findAll(); // Lấy tất cả đơn hàng chưa bị xóa
    }
    public function getOrderWithProducts($orderCode, $customerEmail, $customerPhone)
    {
        return $this->db->table('orders')
            ->select('orders.*, products.image, products.product_name')  // Lấy thông tin đơn hàng và ảnh sản phẩm
            ->join('order_items', 'orders.id_order = order_items.order_id')  // Liên kết với bảng order_items
            ->join('products', 'order_items.product_id = products.id_product')  // Liên kết với bảng products
            ->where('orders.order_code', $orderCode)
            ->where('orders.customer_email', $customerEmail)
            ->where('orders.customer_phone', $customerPhone)
            ->get()->getRowArray();  // Trả về đơn hàng và thông tin sản phẩm
    }
}
