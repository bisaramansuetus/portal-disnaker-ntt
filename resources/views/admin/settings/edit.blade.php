@extends('layouts.admin')
@section('title', 'Pengaturan Situs')

@section('content')
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Pengaturan Situs</h1>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" 
            class="bg-white rounded-lg shadow p-6 max-w-3xl space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Situs <span class="text-red-500">*</span></label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required maxlength="100" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tagline</label>
                <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" maxlength="200" class="w-full border rounded px-3 py-2">
            </div>

                        <!-- TAMBAHKAN BLOK INI UNTUK LOGO -->
            <div class="md:col-span-2 bg-gray-50 p-4 rounded border">
                <label class="block text-sm font-medium mb-2">Logo Dinas</label>
                @if (!empty($settings['logo_path']))
                    <div class="mb-3 p-2 bg-white inline-block border rounded">
                        <img src="{{ asset('storage/' . $settings['logo_path']) }}" alt="Logo Saat Ini" class="h-16 object-contain">
                    </div>
                @endif
                <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-slate-800 file:text-white hover:file:bg-slate-900">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP, SVG. Maks: 2MB. Disarankan gambar berlatar transparan (PNG).</p>
            </div>
            <!-- AKHIR BLOK LOGO -->

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Alamat Kantor</label>
                <textarea name="office_address" rows="2" maxlength="500" class="w-full border rounded px-3 py-2">{{ old('office_address', $settings['office_address'] ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Telepon</label>
                <input type="text" name="office_phone" value="{{ old('office_phone', $settings['office_phone'] ?? '') }}" maxlength="50" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="office_email" value="{{ old('office_email', $settings['office_email'] ?? '') }}" maxlength="150" class="w-full border rounded px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Google Maps Embed (HTML iframe)</label>
                <textarea name="office_map_embed" rows="4" class="w-full border rounded px-3 py-2 font-mono text-xs"
                          placeholder='Contoh: <iframe src="https://www.google.com/maps/embed?pb=..." ...></iframe>'>{{ old('office_map_embed', $settings['office_map_embed'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Cara mendapatkan: buka Google Maps → cari lokasi kantor → Share → Embed a map → Copy HTML.</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Facebook URL</label>
                <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="https://facebook.com/...">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Instagram URL</label>
                <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="https://instagram.com/...">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">YouTube URL</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="https://youtube.com/...">
            </div>
             <!-- TAMBAHKAN 2 INPUT INI -->
            <div>
                <label class="block text-sm font-medium mb-1">TikTok URL</label>
                <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="https://tiktok.com/@...">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">WhatsApp URL</label>
                <input type="url" name="whatsapp_url" value="{{ old('whatsapp_url', $settings['whatsapp_url'] ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="https://wa.me/628...">
            </div>
        </div>

                <!-- BLOK GAMBAR SLIDER BERANDA (HERO) -->
            <div class="md:col-span-2 bg-gray-50 p-4 rounded border mt-6">
                <h3 class="font-bold text-slate-800 mb-2 border-b pb-2">Gambar Latar Beranda (Slider)</h3>
                <p class="text-xs text-gray-500 mb-4">Maksimal 5 gambar. Disarankan berukuran landscape (lebar) dan ukuran di bawah 1MB agar website cepat dibuka.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @for ($i = 1; $i <= 5; $i++)
                        @php $heroKey = "hero_image_$i"; @endphp
                        <div class="bg-white p-3 border rounded shadow-sm">
                            <label class="block text-sm font-medium mb-2">Gambar Ke-{{ $i }}</label>
                            
                            @if (!empty($settings[$heroKey]))
                                <div class="mb-2 relative">
                                    <img src="{{ asset('storage/' . $settings[$heroKey]) }}" class="w-full h-32 object-cover rounded border">
                                </div>
                                <label class="inline-flex items-center text-xs text-red-600 mb-2 cursor-pointer">
                                    <input type="checkbox" name="hapus_{{ $heroKey }}" value="1" class="mr-1"> Hapus gambar ini
                                </label>
                            @endif

                            <input type="file" name="{{ $heroKey }}" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-white hover:file:bg-slate-900">
                        </div>
                    @endfor
                </div>
            </div>
            <!-- AKHIR BLOK GAMBAR SLIDER -->
                        
        <div>
            <button class="bg-slate-800 text-white px-5 py-2 rounded hover:bg-slate-900">Simpan Pengaturan</button>
        </div>
    </form>
@endsection