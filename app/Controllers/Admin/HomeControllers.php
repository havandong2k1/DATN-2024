<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class HomeControllers extends BaseController
{
    public function __construct()
    {
        // Kết nối với cơ sở dữ liệu
        // Nếu không cần thiết, có thể loại bỏ biến này
        // $db = \Config\Database::connect();
    }

    public function index(): string
    {
        // Khởi tạo các model cần thiết
        $customerModel = new CustomerModel();
        $productModel = new ProductModel();
        $blogModel = new BlogModel();
        $orderModel = new OrderModel();
        $totalUsers = $customerModel->countDataByConditions(['deleted_at' => null]);
        $totalProduct = $this->totalProduct();
        $totalBlog = $this->totalBlog();
        $totalOrders = $this->totalOrders();
        $data = [
            'totalUsers' => $totalUsers,
            'totalProduct' => $totalProduct,
            'totalBlog' => $totalBlog,
            'totalOrders' => $totalOrders,
        ];
        
        $cssFiles = [];
        $jsFiles = [];
        $data = $this->loadMasterLayout($data, 'Trang chủ', 'admin/pages/home', $jsFiles, $cssFiles);
        return view('admin/main', $data);
    }

    public function totalProduct()
    {
        $productModel = new ProductModel();
        $condition = [
            'deleted_at' => null,
        ];
        
        // Đếm số lượng sản phẩm thỏa mãn điều kiện
        $productCount = $productModel->where($condition)
                                      ->whereIn('status_product', [1, 2])
                                      ->countAllResults();
        return $productCount; 
    }

    public function totalBlog()
    {
        $blogModel = new BlogModel();
        $condition = [
            'deleted_at' => null,
            'status_blogs' => 1,
        ];
        $blogCount = $blogModel->countDataByConditions($condition);
        return $blogCount ?: 0; // Trả về 0 nếu không có bài viết
    }

    public function totalOrders()
    {
        $orderModel = new OrderModel();
        $condition = [
            'deleted_at' => null,
        ];
        $orderCount = $orderModel->countDataByConditions($condition);
        return $orderCount; // Trả về số lượng đơn hàng
    }
}
