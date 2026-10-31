<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::pluck('setting_value', 'setting_key')->toArray();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'        => 'required|string|max:100',
            'site_tagline'     => 'nullable|string|max:200',
            'office_address'   => 'nullable|string|max:500',
            'office_phone'     => 'nullable|string|max:50',
            'office_email'     => 'nullable|email|max:150',
            'office_map_embed' => 'nullable|string',
            'facebook_url'     => 'nullable|url|max:255',
            'instagram_url'    => 'nullable|url|max:255',
            'youtube_url'      => 'nullable|url|max:255',
            'logo'             => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'hero_image_1'     => 'nullable|image|max:3072',
            'hero_image_2'     => 'nullable|image|max:3072',
            'hero_image_3'     => 'nullable|image|max:3072',
            'hero_image_4'     => 'nullable|image|max:3072',
            'hero_image_5'     => 'nullable|image|max:3072',
        ]);

        // 1. Proses upload logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');
            SiteSetting::set('logo_path', $logoPath);
        }

        // 2. Proses upload 5 Gambar Slider (Hero)
        for ($i = 1; $i <= 5; $i++) {
            $key = "hero_image_$i";
            
            // Hapus gambar jika dicentang
            if ($request->has("hapus_$key")) {
                $oldPath = SiteSetting::get($key);
                if ($oldPath) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                    SiteSetting::set($key, null);
                }
            }

            // Upload gambar baru
            if ($request->hasFile($key)) {
                // Hapus gambar lama jika ada sebelum ditimpa
                $oldPath = SiteSetting::get($key);
                if ($oldPath) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                }
                
                $path = $request->file($key)->store('hero', 'public');
                SiteSetting::set($key, $path);
            }
        }

        unset($validated['logo']); // Buang agar tidak error saat looping

        foreach ($validated as $key => $value) {
            // Abaikan input hero dan hapus dari sini karena sudah diproses di atas
            if (str_starts_with($key, 'hero_image_')) continue;
            SiteSetting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}