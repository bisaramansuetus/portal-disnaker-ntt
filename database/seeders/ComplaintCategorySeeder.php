<?php
namespace Database\Seeders;
use App\Models\ComplaintCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComplaintCategorySeeder extends Seeder {
    public function run(): void {
        $categories = ['Infrastruktur', 'Pelayanan Publik', 'Ketenagakerjaan', 'Ketertiban Umum', 'Lainnya'];
        foreach ($categories as $name) {
            ComplaintCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}