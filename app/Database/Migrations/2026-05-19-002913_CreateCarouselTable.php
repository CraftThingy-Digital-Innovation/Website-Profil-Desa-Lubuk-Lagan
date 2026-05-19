<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCarouselTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'media_type'  => ['type' => 'ENUM', 'constraint' => ['image', 'video'], 'default' => 'image'],
            'media_url'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'status'      => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('carousels');
    }

    public function down()
    {
        $this->forge->dropTable('carousels');
    }
}
