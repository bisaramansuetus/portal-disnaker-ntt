@extends('layouts.admin')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">Pengaturan situs</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi kontak instansi, alamat kantor, identitas portal, dan media sosial.</p>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-[#D1E7DD] text-[#112F28] text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-xs space-y-8">
        @csrf
        @method('PUT')

        <!-- Identitas Instansi -->
        <div class="space-y-4">
            <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">Identitas instansi</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama instansi</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tagline</label>
                    <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email resmi layanan</label>
                    <input type="email" name="office_email" value="{{ old('office_email', $settings['office_email'] ?? '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nomor telepon kantor</label>
                    <input type="text" name="office_phone" value="{{ old('office_phone', $settings['office_phone'] ?? '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Alamat kantor</label>
                <textarea name="office_address" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">{{ old('office_address', $settings['office_address'] ?? '') }}</textarea>
            </div>

            <!-- Logo & Maps -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Logo Dinas</label>
                    @if(!empty($settings['logo_path']))
                        <img src="{{ asset('uploads/' . $settings['logo_path']) }}" class="h-12 object-contain mb-2 bg-white p-1 rounded border">
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-[#112F28] file:text-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Google Maps Embed (HTML)</label>
                    <textarea name="office_map_embed" rows="2" class="w-full px-2 py-1 text-xs border rounded font-mono">{{ old('office_map_embed', $settings['office_map_embed'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Media Sosial -->
        <div class="space-y-4 pt-2">
            <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">Media Sosial</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Facebook URL</label>
                    <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Instagram URL</label>
                    <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">TikTok URL</label>
                    <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">WhatsApp URL</label>
                    <input type="url" name="whatsapp_url" value="{{ old('whatsapp_url', $settings['whatsapp_url'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">YouTube URL</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm">
                </div>
            </div>
        </div>

        <!-- Hero Slider -->
        <div class="space-y-4 pt-2">
            <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">Gambar Slider Beranda (Max 5)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @for ($i = 1; $i <= 5; $i++)
                    @php $heroKey = "hero_image_$i"; @endphp
                    <div class="bg-gray-50 p-3 border rounded-xl">
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Gambar Ke-{{ $i }}</label>
                        @if (!empty($settings[$heroKey]))
                            <img src="{{ asset('uploads/' . $settings[$heroKey]) }}" class="w-full h-24 object-cover rounded mb-2">
                            <label class="inline-flex items-center text-xs text-red-600 mb-2 cursor-pointer">
                                <input type="checkbox" name="hapus_{{ $heroKey }}" value="1" class="mr-1"> Hapus gambar ini
                            </label>
                        @endif
                        <input type="file" name="{{ $heroKey }}" accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-[#112F28] file:text-white">
                    </div>
                @endfor
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl transition shadow-xs">
                Simpan pengaturan &rarr;
            </button>
        </div>
    </form>
</div>
@endsection