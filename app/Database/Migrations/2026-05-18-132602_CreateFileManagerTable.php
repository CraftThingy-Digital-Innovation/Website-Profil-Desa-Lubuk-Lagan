<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFileManagerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'filename'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'original_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_type'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'file_size'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'file_path'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'uploaded_by'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('file_manager');
    }

    public function down()
    {
        $this->forge->dropTable('file_manager');
    }
}
