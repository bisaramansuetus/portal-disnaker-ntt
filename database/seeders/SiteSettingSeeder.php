<?php
namespace Database\Seeders;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder {
    public function run(): void {
        $defaults = [
            'site_name' => 'DISNAKERTRANS-NTT',
            'site_tagline' => 'Portal Informasi Publik',
            'office_address' => 'Jl. ... (lengkapi alamat kantor)',
            'office_phone' => '(0380) ...',
            'office_email' => 'info@disnakerntt.go.id',
            'office_map_embed' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'youtube_url' => '',
            'logo_path' => '',
        ];
        foreach ($defaults as $k => $v) {
            SiteSetting::updateOrCreate(['setting_key' => $k], ['setting_value' => $v]);
        }
    }
}