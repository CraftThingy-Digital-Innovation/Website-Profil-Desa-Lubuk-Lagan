<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThumbnailToBlogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('blogs', [
            'thumbnail' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'default'    => null,
                'after'      => 'published_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('blogs', 'thumbnail');
    }
}
