<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // ============================================
        // 1. Seed Admin User (Idempotent)
        // ============================================
        if ($db->tableExists('users')) {
            $builder = $db->table('users');
            if ($builder->where('username', 'admin')->countAllResults() == 0) {
                $users = auth()->getProvider();

                $user = new \CodeIgniter\Shield\Entities\User([
                    'username' => 'admin',
                    'email'    => 'admin@desalubuklagan.local',
                    'password' => 'admin123',
                ]);
                $users->save($user);

                $user = $users->findById($users->getInsertID());
                if ($user) {
                    $user->addGroup('superadmin');
                }
            }
        }

        // ============================================
        // 2. Seed Settings Desa (Idempotent)
        // ============================================
        if ($db->tableExists('settings')) {
            $settingsTable = $db->table('settings');

            $defaults = [
                'site_name'        => 'Desa Lubuk Lagan',
                'site_tagline'     => 'Harmoni Alam, Budaya & Inovasi Digital',
                'site_description' => 'Website resmi Desa Lubuk Lagan — merajut harmoni antara kelestarian alam, kearifan budaya lokal, dan inovasi teknologi digital untuk kesejahteraan masyarakat bersama.',
                'site_keywords'    => 'Desa Lubuk Lagan, Bengkulu, profil desa, wisata alam, KKN 107',
                'site_logo'        => '',
                'site_og_image'    => '',
                'contact_email'    => 'pemdes@lubuklagan.desa.id',
                'contact_phone'    => '',
                'contact_address'  => 'Desa Lubuk Lagan, Bengkulu Selatan, Provinsi Bengkulu',
                'facebook_url'     => '',
                'instagram_url'    => '',
                'youtube_url'      => '',
            ];

            foreach ($defaults as $key => $value) {
                if ($settingsTable->where('key', $key)->countAllResults() == 0) {
                    $settingsTable->insert([
                        'key'        => $key,
                        'value'      => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }
}
