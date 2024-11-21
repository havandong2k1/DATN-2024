<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\BaseModel;
use Faker\Provider\Base;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'password'];

    public function getUser(){
        return $this->findAll();
    }
    public function deleteById($id)
    {
        $result = $this->where('id', $id)->delete();
        if ($result) {
            log_message('info', "Sản phẩm với ID $id đã được xóa.");
        } else {
            log_message('error', "Không thể xóa sản phẩm với ID $id.");
        }
        return $result;
    }
}
