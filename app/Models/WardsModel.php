<?php

namespace App\Models;

use CodeIgniter\Model;

class WardsModel extends BaseModel
{
    protected $table = 'wards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['district_id', 'name'];
    protected $useAutoIncrement = true;

    public function getWardsByDistrict($districtId)
    {
        return $this->where('district_id', $districtId)->findAll();
    }
}
