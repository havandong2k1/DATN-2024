<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\UserModel;

class HomeControllers extends BaseController
{
    public function __construct()
    {
        $db = \Config\Database::connect();
    }

    public function index(): string
    {
        // Khởi tạo model CustomerModel
        $customerModel = new CustomerModel();
        // Gọi phương thức totalCustomer để lấy tổng số khách hàng
        $totalUsers = $customerModel->countDataByConditions(['deleted_at' => null]);
        $data = [
            'totalUsers' => $totalUsers, // Truyền dữ liệu sang view
        ];
        $cssFiles = [];
        $jsFiles = [];
        // Tải layout chính
        $data = $this->loadMasterLayout($data, 'Trang chủ', 'admin/pages/home', $jsFiles, $cssFiles);
        
        return view('admin/main', $data);
    }


    public function totalCustomer()
    {
        $customerModel = new CustomerModel();
        $condition = ['deleted_at' => null ];
        $countCustomer = $customerModel->countDataByConditions($condition);
       
        return $countCustomer;
    }
}
