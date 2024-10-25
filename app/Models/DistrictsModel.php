<?php

namespace App\Models;

use CodeIgniter\Model;

class DistrictsModel extends BaseModel // Lưu ý: Kế thừa từ BaseModel là đúng nếu bạn có chức năng bổ sung ở đó
{
    protected $table = 'districts'; // Tên bảng
    protected $primaryKey = 'district_id'; // Không có khoảng trắng sau 'district_id'
    protected $allowedFields = ['province_id', 'name'];

    protected $useAutoIncrement = true;

    // Phương thức để lấy quận theo ID tỉnh
    public function getDistrictsByProvince($provinceId)
    {
        return $this->where('province_id', $provinceId)->findAll();
    }
}
