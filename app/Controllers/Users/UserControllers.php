<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Events\Events;
use CodeIgniter\Config\Factories;
use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;

class UserController extends Controller
{
    private $user;

    public function __construct() {
        // Khởi tạo đối tượng $user trong hàm khởi tạo
        $this->user = new UserModel(); // Thay thế UserModel bằng tên của model bạn sử dụng
    }
    public function add()
    {
        // Kiểm tra request có phải là Ajax không
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setBody('Bad Request');
        }

        // Kiểm tra quyền hạn của người dùng
        if (!$this->user->hasPermission('users.create')) {
            return $this->response->setJSON([
                'success' => false,
                'messages' => lang('App.invalid_permission')
            ]);
        }

        // Lấy dữ liệu từ request
        $fields = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'email' => $this->request->getPost('email'),
            'group' => $this->request->getPost('group')
        ];

        // Thiết lập các quy tắc kiểm tra hợp lệ
        $validationRules = [
            'username' => ['label' => 'Username', 'rules' => 'required|max_length[30]|min_length[3]|regex_match[/\A[a-zA-Z0-9\.]+\z/]|is_unique[users.username,id,{id}]'],
            'password' => ['label' => 'Password', 'rules' => 'required|min_length[8]'],
            'email' => ['label' => 'Email Address', 'rules' => 'required|valid_email|is_unique[auth_identities.secret,id,{id}]'],
            'group' => ['label' => 'Group', 'rules' => 'required']
        ];

        // Chạy quy tắc kiểm tra hợp lệ
        if (!$this->validate($validationRules)) {
            return $this->response->setJSON([
                'success' => false,
                'messages' => $this->validator->getErrors()
            ]);
        }

        // Thêm người dùng mới
        $users = auth()->getProvider();
        $user = new User([
            'username' => $fields['username'],
            'email' => $fields['email'],
            'password' => $fields['password'],
            'status_message' => 'New User',
        ]);
        
        $users->save($user);

        // Lấy thông tin người dùng sau khi thêm mới
        $user = $users->find($users->getInsertID());

        // Thiết lập cờ yêu cầu người dùng thay đổi mật khẩu khi đăng nhập lần đầu tiên
        $user->forcePasswordReset();

        // Đồng bộ nhóm người dùng
        $user->syncGroups($fields['group']);

        // Kích hoạt sự kiện mới và gửi các biến
        $confirm = Events::trigger('newRegistration', $user, $fields['password']);

        // Trả về kết quả
        if ($confirm) {
            return $this->response->setJSON([
                'success' => true,
                'messages' => lang('App.insert-success')
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'messages' => lang('App.insert-error')
            ]);
        }
    }
}
