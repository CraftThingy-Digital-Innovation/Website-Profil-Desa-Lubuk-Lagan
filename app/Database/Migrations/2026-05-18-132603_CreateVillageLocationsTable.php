<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVillageLocationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT', 'null' => true],
            'latitude'    => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => true],
            'longitude'   => ['type' => 'DECIMAL', 'constraint' => '11,8', 'null' => true],
            'media_type'  => ['type' => 'ENUM', 'constraint' => ['photo', 'drone_video', 'none'], 'default' => 'none'],
            'media_url'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('village_locations');
    }

    public function down()
    {
        $this->forge->dropTable('village_locations');
    }
}
