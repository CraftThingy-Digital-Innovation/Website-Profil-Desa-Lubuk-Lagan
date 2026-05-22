<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryToBlogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('blogs', [
            'category' => [
                'type'       => 'ENUM',
                'constraint' => ['blog', 'kkn'],
                'default'    => 'blog',
                'after'      => 'author_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('blogs', 'category');
    }
}
