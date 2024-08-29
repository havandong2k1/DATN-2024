<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\BaseModel;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'password'];

    public function getUser(){
        return $this->findAll();
    }
}
