<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvincesModel extends BaseModel
{
    protected $table = 'provinces';
    protected $primaryKey = 'province_id';
    protected $allowedFields = ['name'];
    protected $useAutoIncrement = true;
    public function findAllProvinces()
    {
        return $this->findAll(); // Trả về tất cả các tỉnh
    }
}
