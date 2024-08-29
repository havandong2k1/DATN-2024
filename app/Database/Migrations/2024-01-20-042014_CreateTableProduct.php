<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableProduct extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'images' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                ],

            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],

            'price' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'description' => [
                'type' => 'TEXT',
                'constraint' => 255,
            ],

            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'amount' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'created_at' => [
                'type' => 'DATE',
                'constraint' => 255,
            ],

            'updated_at' => [
                'type' => 'DATE',
                'constraint' => 255,
            ],

            'deleted_at' => [
                'type' => 'DATE',
                'constraint' => 255,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
