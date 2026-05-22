<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPublishedAtToBlogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('blogs', [
            'published_at' => [
                'type'    => 'DATE',
                'null'    => true,
                'default' => null,
                'after'   => 'category',
            ],
        ]);

        // Backfill existing rows with their created_at date
        $this->db->query("UPDATE blogs SET published_at = DATE(created_at) WHERE published_at IS NULL");
    }

    public function down()
    {
        $this->forge->dropColumn('blogs', 'published_at');
    }
}
