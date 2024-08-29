<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' =>'1',
                'images_name' => 'Slider1',
                
            ],
            [
                'id' =>'2',
                'images_name' => 'Slider2',
                
            ],
            [
                'id' =>'3',
                'images_name' => 'Slider3',
                
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
