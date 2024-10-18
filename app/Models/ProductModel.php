<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends BaseModel
{
    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $allowedFields = ['name', 'description', 'price', 'images', 'amount', 'category',
                                'status_product', 'created_at', 'updated_at', 'deleted_at'];
    protected $useAutoIncrement = true; 
    protected $returnType = 'array';
    protected function beforeInsert(array $data)
    {
        unset($data['id_product']);
        return $this->updateTimestamp($data);
    }
    protected function beforeUpdate(array $data)
    {
        return $this->updateTimestamp($data);
    }

    protected function updateTimestamp(array $data)
    {
        $currentTimestamp = date('Y-m-d H:i:s');

        if (!array_key_exists('created_at', $data)) {
            $data['created_at'] = $currentTimestamp;
        }

        $data['updated_at'] = $currentTimestamp;

        return $data;
    }


    public function __construct()
    {
        parent::__construct();
    }


    public function getProduct($id)
    {
        return $this->find($id, );
    }
    public function deleteById($id)
    {
        $result = $this->where('id_product', $id)->delete();
        if ($result) {
            log_message('info', "Sản phẩm với ID $id đã được xóa.");
        } else {
            log_message('error', "Không thể xóa sản phẩm với ID $id.");
        }
        return $result;
    }
    

    // public function search($keyword)
    // {
    //    $db = \Config\Database::connect();
    //    $buider = $this->table = 'products';
    //    $buider->select('*');
    //    $buider->where('name',$keyword );
    //    $querry = $buider->get();
    //    return $querry->getResults();
    // }


}

