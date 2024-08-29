<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' =>'1',
                'name' => 'Admin',
                'password' => password_hash('123123', PASSWORD_BCRYPT),
                'email' => 'admin@gmail.com',
            ],
            [
                'id' =>'2',
                'name' => 'Admin1',
                'password' => password_hash('123123', PASSWORD_BCRYPT),
                'email' => 'admin1@gmail.com',   
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
