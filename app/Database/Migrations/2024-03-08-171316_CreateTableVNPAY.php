<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableVNPAY extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'vnp_RequestId' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'np_Command' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'vnp_TmnCode' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'vnp_TxnRef' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'vnp_OrderInfo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'vnp_TransactionDate' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'vnp_CreateDate' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'vnp_IpAddr' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('VNPAY');
    }

    public function down()
    {
        //
        $this->forge->dropTable('VNPAY');
    }
}
