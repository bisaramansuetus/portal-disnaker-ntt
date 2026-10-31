<?php
namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder {
    public function run(): void {
        $admin = User::first();
        if (!$admin) return;

        $pages = [
            [
                'title' => 'Profil Dinas',
                'slug' => 'profil-dinas',
                'content' => '<h2>Tentang</h2><p>Isi profil dinas di sini.</p><h2>Visi</h2><p>...</p><h2>Misi</h2><ol><li>...</li></ol><h2>Tugas dan Fungsi</h2><p>...</p><h2>Struktur Organisasi</h2><p>Unggah gambar bagan struktur melalui gambar utama halaman ini.</p>',
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'content' => '<h2>Pertanyaan Umum</h2><p><strong>Q:</strong> ...</p><p><strong>A:</strong> ...</p>',
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