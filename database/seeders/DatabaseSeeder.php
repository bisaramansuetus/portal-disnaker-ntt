<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SiteSettingSeeder::class,
            PageSeeder::class,
            ContentSeeder::class,
            ComplaintCategorySeeder::class,
            PpidPageSeeder::class, // Tambahkan ini
        ]);
    }
}