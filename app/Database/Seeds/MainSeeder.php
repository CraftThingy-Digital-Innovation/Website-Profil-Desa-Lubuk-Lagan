<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // 1. Contoh Seeder untuk Admin (Idempotent)
        // Mengecek apakah tabel users sudah ada dan apakah user admin sudah dibuat
        $db = \Config\Database::connect();
        
        if ($db->tableExists('users')) {
            $builder = $db->table('users');
            if ($builder->where('username', 'admin')->countAllResults() == 0) {
                // Shield User Provider
                $users = auth()->getProvider();
                
                $user = new \CodeIgniter\Shield\Entities\User([
                    'username' => 'admin',
                    'email'    => 'admin@desalubuklagan.local',
                    'password' => 'admin123',
                ]);
                $users->save($user);
                
                // Mendapatkan user yang baru dibuat
                $user = $users->findById($users->getInsertID());
                
                // Add to superadmin group
                if ($user) {
                    $user->addGroup('superadmin');
                }
            }
        }
    }
}
