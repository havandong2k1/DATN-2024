<?php

namespace App\Controllers;

use App\Models\CartModel;
use CodeIgniter\Controller;

class AccountController extends BaseController
{
    public function index()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('views/profile');
        }

        // Lấy thông tin người dùng từ session
        $data = [
            'userId' => session()->get('userId'),
            'email' => session()->get('email'),
            // Lấy thông tin khác của người dùng nếu cần
        ];
        
        // Lấy tổng số lượng giỏ hàng
        $data['totalQuantity'] = $this->getTotalCartQuantity(); 
       
        return view('profile', $data);
    }

    private function getTotalCartQuantity()
    {
        $cartModel = new CartModel();
        $session = session();
        $customerId = $session->get('customer_id');
        $totalQuantity = 0;

        if ($customerId) {
            // Sửa lỗi gọi model
            $dataCartUser = $cartModel->where(['deleted_at' => null, 'customer_id' => $customerId])->findAll();
            if ($dataCartUser) {
                foreach ($dataCartUser as $item) {
                    $totalQuantity += $item['quantity'];
                }
            }
        }

        return $totalQuantity;
    }
}
