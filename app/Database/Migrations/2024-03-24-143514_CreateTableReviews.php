<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableReviews extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_product' => [
                'type'       => 'INT',
            ],
            'user_id' => [
                'type'       => 'INT',
            ],
            'rating' => [
                'type'       => 'INT',
            ],
            'comment' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp']);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('reviews', true);
    }

    public function down()
    {
        $this->forge->dropTable('reviews');
    }
}
