<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends BaseModel
{
    protected $table = 'blog';
    protected $primaryKey = 'id_blogs';
    protected $allowedFields = ['title', 'content', 'status_blogs', 'create_at', 'update_at', 'deleted_at'];
    protected $useAutoIncrement = true; // Thêm dòng này để bật AUTO_INCREMENT cho cột khóa chính

    protected function beforeInsert(array $data)
    {
        // Add your logic here
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

    public function index()
    {
        $BlogModel = new BlogModel();
        $data['blogs'] = $BlogModel->findAll(); // Lấy danh sách blog từ model

        return view('blog', $data); // Chuyển dữ liệu blog đến view
    }
}