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
            'tiktok_url'       => 'nullable|url|max:255',
            'whatsapp_url'     => 'nullable|url|max:255',
            'youtube_url'      => 'nullable|url|max:255',
            'logo'             => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'hero_image_1'     => 'nullable|image|max:3072',
            'hero_image_2'     => 'nullable|image|max:3072',
            'hero_image_3'     => 'nullable|image|max:3072',
            'hero_image_4'     => 'nullable|image|max:3072',
            'hero_image_5'     => 'nullable|image|max:3072',
        ]);

        // Proses upload logo
        // Ganti kode upload logo menjadi seperti ini:
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/settings'), $filename);
            \App\Models\SiteSetting::set('logo_path', 'uploads/settings/' . $filename);
        }
        // Proses upload 5 Gambar Slider
        for ($i = 1; $i <= 5; $i++) {
            $key = "hero_image_$i";
            
            if ($request->has("hapus_$key")) {
                $oldPath = SiteSetting::get($key);
                if ($oldPath) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                    SiteSetting::set($key, null);
                }
            }

            if ($request->hasFile($key)) {
                $oldPath = SiteSetting::get($key);
                if ($oldPath) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file($key)->store('hero', 'public');
                SiteSetting::set($key, $path);
            }
        }

        unset($validated['logo']); 

        foreach ($validated as $key => $value) {
            if (str_starts_with($key, 'hero_image_')) continue;
            SiteSetting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}