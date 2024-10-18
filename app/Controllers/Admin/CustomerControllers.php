<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class CustomerControllers extends BaseController
{
    public function listCustomer()
    {
        // Code lấy danh sách khách hàng
        $customerModel = new CustomerModel();
        $listCustomer = $customerModel->findAll(); // Lấy tất cả đơn hàng từ database
        if (empty($listCustomer)) {
            return redirect()->back()->with('msg_error', 'Không có khách hàng nào.');
        }
       
        $dataLayout = [
            'listCustomer' => $listCustomer // Truyền dữ liệu đơn hàng vào view
        ];
        $cssFiles = [
            'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css',
            base_url() . '/assets/admin/css/datatable.css',
        ];

        $jsFiles = [
            'https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js',
            base_url() . '/assets/admin/js/datatable.js',
        ];
     

        $data = $this->loadMasterLayout([], 'Danh sách khách hàng', 'admin/pages/customer/list', $dataLayout, $cssFiles, $jsFiles);
        
        return view('admin/main', $data);
    }
    public function toggleStatus($customerId)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($customerId);

        if ($customer) {
            // Đảo ngược trạng thái khóa/mở khóa
            $newStatus = $customer['status_customer'] == 1 ? 0 : 1;
            $customerModel->update($customerId, ['status_customer' => $newStatus]);

            $message = $newStatus == 1 ? 'Tài khoản đã được mở khóa.' : 'Tài khoản đã bị khóa.';
            return redirect()->back()->with('msg_success', $message);
        }

        return redirect()->back()->with('msg_error', 'Khách hàng không tồn tại.');
    }
    public function delete($customerId)
    {
        $customerModel = new CustomerModel();

        // Kiểm tra xem khách hàng có tồn tại không
        $customer = $customerModel->find($customerId);
        if (!$customer) {
            return redirect()->back()->with('msg_error', 'Khách hàng không tồn tại.');
        }
        // Xóa khách hàng
        $customerModel->delete($customerId);

        return redirect()->back()->with('msg_success', 'Khách hàng đã được xóa thành công.');
    }

}
