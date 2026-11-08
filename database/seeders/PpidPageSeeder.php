<?php
namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PpidPageSeeder extends Seeder {
    public function run(): void {
        $admin = User::first();
        if (!$admin) return;

        $pages = [
            [
                'title' => 'Profil PPID',
                'slug' => 'profil-ppid',
                'content' => '<h2>Kedudukan PPID</h2><p>PPID Pelaksana DISNAKERTRANS NTT...</p><h2>Visi & Misi</h2><p>...</p><h2>Struktur Organisasi</h2><p>...</p>',
            ],
            [
                'title' => 'Standar Layanan & Regulasi',
                'slug' => 'standar-layanan-ppid',
                'content' => '<h2>Prosedur Layanan</h2><p>Alur permohonan informasi...</p><h2>Waktu & Biaya</h2><p>Gratis...</p><h2>Regulasi</h2><p>Tautan UU KIP...</p>',
            ],
        ];

        foreach ($pages as $p) {
            Post::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'title' => $p['title'],
                    'content' => $p['content'],
                    'type' => 'page',
                    'status' => 'published',
                    'author_id' => $admin->id,
                    'published_at' => now(),
                ]
            );
        }
    }
}