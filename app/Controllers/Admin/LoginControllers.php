<?php

namespace App\Controllers\Admin;

use App\Common\ResultUtils;
use App\Controllers\BaseController;
use App\Services\LoginService;
use App\Models\UserModel;


class LoginControllers extends BaseController
{

    /**
        @var Service
     */
    private $service;

    public function __construct()
    {
        $this->service = new LoginService();
    }


    public function index()
    {
        if(session()->has('admin_login')){
            return redirect('admin/login');
        }
        return view('admin/pages/login');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('email', $email)->first();

        if($data){
            if ($data['status_users'] == 0) {
                // Tài khoản đã bị disable, hiển thị thông báo lỗi và chuyển hướng người dùng đến trang đăng nhập
                $session->setFlashdata('error', 'Tài khoản của bạn đã bị vô hiệu hóa.');
                return redirect()->to('admin/login');
            }
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                $ses_data = [
                    'id'       => $data['id'],
                    'email'     => $data['email'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('admin/pages/home');
            }else{
                $session->setFlashdata('error', 'Password is incorrect.');
                return redirect()->to('admin/login');
            }
        }else{
            $session->setFlashdata('error', 'Email does not exist.');
            return redirect()->to('admin/login');
        }
    }


    public function logout()
    {
        // Load the session service
        $session = session();

        // Destroy the session
        $session->destroy();
        // Xóa tất cả dữ liệu phiên
        $this->service->logout();

        // Chuyển hướng người dùng đến trang đăng nhập
        return redirect('admin/login');
    }
}
