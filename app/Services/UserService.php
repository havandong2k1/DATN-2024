<?php

namespace App\Services;

use App\Models\UserModel;
use App\Common\ResultUtils;
use Exception;

class UserService extends BaseService
{
    private $users;
    /**
        Tạo hàm constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->users = new UserModel();
        $this->users->protect(false);
    }

    public function getAllUsers()
    {
        return $this->users->findAll();
    }

    public function addUserInfo($requestData)
    {
        $validate = $this->validateAddUser($requestData);

        if ($validate->getErrors()) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => $validate->getError()
            ];
        }
        $dataSave = $requestData->getPost();
        unset($dataSave['password_confirm']);
        $dataSave['password'] = password_hash($dataSave['password'], PASSWORD_BCRYPT);
        try {
            $this->users->save($dataSave);
            return [
                'status' => ResultUtils::STATUS_CODE_OK,
                'massageCode' => ResultUtils::MESSAGE_CODE_OK,
                'messages' => ['success' => 'Đăng ký thông tin thành công']
            ];
        } catch (Exception $e) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => ['success' => $e->getMessage()]
            ];
        }
    }


    public function updateUserInfo($requestData)
    {
       
        $validate = $this->validateEditUser($requestData);

        if ($validate->getErrors()) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => $validate->getError()
            ];
        }
        $dataSave = $requestData->getPost();
        if (!empty($dataSave['change_password'])) {
            unset($dataSave['change_password']);
            unset($dataSave['password_confirm']);
            $dataSave['password'] = password_hash($dataSave['password'], PASSWORD_BCRYPT);
        } else{
            unset($dataSave['password']);
            unset($dataSave['password_confirm']);
        }
        //dd($dataSave);

        try {
            $this->users->save($dataSave);
            return [
                'status' => ResultUtils::STATUS_CODE_OK,
                'massageCode' => ResultUtils::MESSAGE_CODE_OK,
                'messages' => ['success' => 'Lưu thông tin thành công']
            ];
        } catch (Exception $e) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => ['success' => $e->getMessage()]
            ];
        }
        //unset($dataSave['password_confirm']);
        //
        //
        //if (!empty($dataSave['change_password'])) {
        //    unset($dataSave['change_password']);
        //    unset($dataSave['password_confirm']);
//
        //    dd($dataSave);
        //}
    }



    public function getUserByID($idUser)
    {
        return $this->users->where('id', $idUser)->first();
    }

    public function deleteUser ($idUser)
    {
        try {
            $this->users->delete($idUser);
            return [
                'status' => ResultUtils::STATUS_CODE_OK,
                'massageCode' => ResultUtils::MESSAGE_CODE_OK,
                'messages' => ['success' => 'Xóa thông tin thành công']
            ];
        } catch (Exception $e) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => ['success' => $e->getMessage()]
            ];
        }
    }

    public function validateAddUser($requestData)
    {
        $rule = [
            'email' => 'valid_email|is_unique[users.email]',
            'name' => 'max_length[100]',
            'password' => 'max_length[30]|min_length[6]',
            'password_confirm' => 'matches[password]',

        ];
        $message = [
            'email' => [
                'valid_email' => 'Tài khoản {field} {value} không đúng định dạng',
                'is_unique' => 'Email đã được đăng ký',
            ],

            'name' => [
                'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự!',
            ],

            'password' => [
                'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự!',
                'min_length' => 'Mật khẩu ít nhất {param} ký tự!',
            ],

            'confirm_password' => [
                'matches' => 'Mật khẩu không khớp vui lòng kiểm tra lại!',
            ],

        ];
        $this->validation->setRules($rule, $message);
        $this->validation->withrequest($requestData)->run();

        return $this->validation;
    }

    public function validateEditUser($requestData)
    {
        $rule = [
            'email' => 'valid_email|is_unique[users.email, id,' . $requestData->getPost()['id'] . ']',
            'name' => 'max_length[100]',
        ];

        $message = [
            'email' => [
                'valid_email' => 'Tài khoản {field} {value} không đúng định dạng',
                'is_unique' => 'Email đã được đăng ký',
            ],

            'name' => [
                'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự!',
            ],
        ];

        if (!empty($requestData->getPost()['change_password'])) {
            $rule['password'] = 'max_length[30]|min_length[6]';
            $rule['password_confirm'] = 'matches[password]';

            $message['password'] = [
                'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự!',
                'min_length' => 'Mật khẩu ít nhất {param} ký tự!',
            ];

            $message['confirm_password'] = [
                'matches' => 'Mật khẩu không khớp vui lòng kiểm tra lại!',
            ];
        }

        $this->validation->setRules($rule, $message);
        $this->validation->withrequest($requestData)->run();

        return $this->validation;
    }
}
