<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use Exception;

class OrderControllers extends BaseController
{
    // Bỏ CSRF cho các phương thức này
    protected $csrfExemptMethods = ['edit', 'update'];

    /**
     * Hàm hiển thị danh sách đơn hàng
     */
    public function list(): string
    {
        $orderModel = new OrderModel(); // Sử dụng OrderModel để lấy dữ liệu
        $orders = $orderModel->findAll(); // Lấy tất cả đơn hàng từ database

        // Kiểm tra nếu có đơn hàng
        if (empty($orders)) {
            return redirect()->back()->with('msg_error', 'Không có đơn hàng nào.');
        }

        // Truyền danh sách đơn hàng vào view
        $dataLayout = [
            'orders' => $orders // Truyền dữ liệu đơn hàng vào view
        ];

        // Thêm các file CSS và JS cần thiết cho DataTable
        $cssFiles = [
            'http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js',
            base_url() . '/assets/admin/js/datatable.js',
            base_url() . '/assets/admin/js/event.js',
        ];

        $jsFiles = [
            'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css',
            base_url() . '/assets/admin/css/datatable.css'
        ];

        // Load layout cho trang danh sách đơn hàng
        $data = $this->loadMasterLayout([], 'Danh sách đơn hàng', 'admin/pages/order/list', $dataLayout, $cssFiles, $jsFiles);

        return view('admin/main', $data);
    }

    /**
     * Hàm chỉnh sửa đơn hàng
     */
    public function edit($orderId)
    {
        try {
            $orderModel = new OrderModel();

            // Lấy thông tin đơn hàng từ database
            $order = $orderModel->find($orderId);

            // Kiểm tra nếu đơn hàng tồn tại
            if (!$order) {
                return redirect()->back()->with('msg_error', 'Đơn hàng không tồn tại.');
            }

            // Truyền biến $order vào view
            $dataLayout = [
                'order' => $order // Chắc chắn $order được truyền vào view
            ];

            // Gọi view với data đã truyền
            return view('admin/pages/order/edit', $dataLayout);
        } catch (Exception $e) {
            // Xử lý lỗi
            return redirect()->back()->with('msg_error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Hàm cập nhật đơn hàng
     */
    public function update($id_order)
    {
        // Validate input
        if (!$this->validate([
            'customer_name' => 'required|min_length[3]',
            'customer_email' => 'required|valid_email',
            'customer_phone' => 'required|numeric',
            'customer_address' => 'required',
            'payment_status' => 'required',
            'order_status' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('msg_error', 'Dữ liệu không hợp lệ.');
        }

        // Update the order
        $orderModel = new OrderModel();
        $data = [
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_email' => $this->request->getPost('customer_email'),
            'customer_phone' => $this->request->getPost('customer_phone'),
            'customer_address' => $this->request->getPost('customer_address'),
            'payment_status' => $this->request->getPost('payment_status'),
            'order_status' => $this->request->getPost('order_status')
        ];

        // Thực hiện cập nhật đơn hàng
        if ($orderModel->updateOrder($id_order, $data)) {
            return redirect()->to(base_url('admin/order/list'))->with('msg_success', 'Đơn hàng đã được cập nhật thành công.');
        } else {
            return redirect()->back()->with('msg_error', 'Cập nhật đơn hàng thất bại.');
        }
    }
    public function deletedOrder($orderId)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId); // Tìm đơn hàng

        if (!$order) {
            // Nếu không tìm thấy đơn hàng
            return redirect()->back()->with('msg_error', 'Đơn hàng không tồn tại');
        }

        $isDeleted = $orderModel->deleteById($orderId); // Xóa đơn hàng

        if (!$isDeleted) {
            // Nếu việc xóa thất bại
            return redirect()->back()->with('msg_error', 'Lỗi không xóa đơn hàng');
        } else {
            // Nếu việc xóa thành công
            return redirect()->back()->with('msg_success', 'Xóa đơn hàng thành công');
        }
    }

}
