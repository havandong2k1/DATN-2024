<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_blogs' =>'1',
                'content' => 'Chào mừng bạn tới trang web của chúng tôi',
                'created_at' => '10/03/2024',
                'updated_at' => '10/03/2024',
                'deleted_at' => '',
            ],

        ];

        $this->db->table('blog')->insertBatch($data);
    }
}
