<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGalleryItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'category'    => ['type' => 'ENUM', 'constraint' => ['kkn', 'kabar_desa'], 'default' => 'kkn'],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'description' => ['type' => 'TEXT', 'null' => true],
            'media_url'   => ['type' => 'VARCHAR', 'constraint' => 500],
            'media_type'  => ['type' => 'ENUM', 'constraint' => ['image', 'video'], 'default' => 'image'],
            'cover_url'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true], // thumbnail for video
            'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'status'      => ['type' => 'ENUM', 'constraint' => ['active', 'draft'], 'default' => 'active'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('category');
        $this->forge->createTable('gallery_items');
    }

    public function down()
    {
        $this->forge->dropTable('gallery_items');
    }
}
