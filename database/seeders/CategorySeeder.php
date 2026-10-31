<?php
namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder {
    public function run(): void {
        foreach (['Berita', 'Pengumuman', 'Siaran Pers'] as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => "Kategori {$name}"]
            );
        }
    }
}