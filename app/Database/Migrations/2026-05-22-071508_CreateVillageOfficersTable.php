<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVillageOfficersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'position'    => ['type' => 'VARCHAR', 'constraint' => 255], // jabatan
            'level'       => ['type' => 'INT', 'constraint' => 11, 'default' => 1], // 1=paling atas
            'parent_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'default' => null], // atasan
            'photo'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'quote'       => ['type' => 'VARCHAR', 'constraint' => 512, 'null' => true],
            'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('village_officers');
    }

    public function down()
    {
        $this->forge->dropTable('village_officers');
    }
}
