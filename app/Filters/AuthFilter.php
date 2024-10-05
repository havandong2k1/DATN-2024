<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$session->get('logged_in')) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
            return redirect()->to('admin/login');
        } else {
            // Nếu đã đăng nhập và cố gắng truy cập trang đăng nhập, chuyển hướng đến trang chính
            if (current_url() === base_url() . 'admin/login') {
                return redirect()->to('admin/dashboard'); // Hoặc một trang nào đó bạn muốn
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Không cần thực hiện gì sau khi xử lý yêu cầu
    }
}
