<?php

namespace App\Services;

use App\Models\UserModel;
use App\Common\ResultUtils;


class LoginService extends BaseService
{
    private $users;

    /**
     * Tạo hàm constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->users = new UserModel();
    }

    public function hasLoginInfo($reqData)
    {
        $validate = $this->validateLogin($reqData);


        if ($validate->getErrors()) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => $validate->getError()
            ];
        }

        $params = $reqData->getPost();
        $user = $this->users->where('email', $params['email'])->first();

        if (!$user) {
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'messages' => [
                    'notExit' => 'Email chưa được đăng ký'
                ]
            ];
        }

        if (!password_verify($params['password'], $user['password'])) {
            return [
                'status' => ResultUtils::STATUS_CODE_OK,
                'messageCode' => ResultUtils::MESSAGE_CODE_OK,
                'messages' => [
                    'wrongpass' => 'Mật khẩu chưa đúng!'
                ]
            ];
        }

        $session = session();

        unset($user['password']);

        $session->set('user_login', $user);

        return [
            'status' => ResultUtils::STATUS_CODE_OK,
            'messageCode' => ResultUtils::MESSAGE_CODE_OK,
            'messages' => null
        ];
    }

    private function validateLogin($reqData)
    {
        $rule = [
            'email' => 'valid_email',
            'password' => 'max_length[30], min_length[6]',
        ];

        $message = [
            'email' => [
                'valid_email' => 'Tài khoản {filed} {values} không đúng định dạng'
            ],
            'password' => [
                'max_length' => 'Mật khẩu quá dài, vui lòng nhập {param} ký tự',
                'min_length' => 'Mật khẩu không được ít hơn {param} ký tự'
            ],
        ];


        $this->validation->setRules($rule, $message);
        $this->validation->withrequest($reqData)->run();

        return $this->validation;
    }

    public function logout()
    {
        $session = session();
    }
}
