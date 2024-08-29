<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AccountController extends Controller
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

        // Hiển thị trang tài khoản với thông tin người dùng
        return view('profile', $data);
    }
}


  

