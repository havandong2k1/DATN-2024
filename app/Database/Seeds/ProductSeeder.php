<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' =>'1',
                'images' => '',
                'name' => 'Asus Vivobook S210',
                'price' => '20.000.000',
                'description' => 'Sản phẩm mới luôn tốt và bền',
                'caterory' => 'Laptop',
                'amount' => '100',
            ],

        ];

        $this->db->table('products')->insertBatch($data);
    }
}
