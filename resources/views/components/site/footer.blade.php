<footer class="bg-[#112F28] text-white pt-16 pb-12 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
        <div>
            <div class="flex items-center gap-3 mb-4">
                @php $logo = \App\Models\SiteSetting::get('logo_path'); @endphp
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-10 w-auto bg-white rounded p-1">
                @endif
                <h3 class="text-lg font-bold">DISNAKERTRANS NTT</h3>
            </div>
            <p class="text-sm text-gray-300 leading-relaxed mb-6">
                Portal informasi publik, kesempatan kerja, pelatihan kompetensi, dan layanan transmigrasi Provinsi Nusa Tenggara Timur.
            </p>
            <!-- Ikon Medsos -->
            <div class="flex gap-3">
                @php
                    $sosmeds = [
                        'facebook' => [
                            'icon' => '<path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>', 
                            'url' => \App\Models\SiteSetting::get('facebook_url'),
                            'hover' => 'hover:bg-[#1877F2] hover:text-white'
                        ],
                        'instagram' => [
                            'icon' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>', 
                            'url' => \App\Models\SiteSetting::get('instagram_url'),
                            'hover' => 'hover:bg-[#E1306C] hover:text-white' // Instagram Pink
                        ],
                        'tiktok' => [
                            'icon' => '<path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>', 
                            'url' => \App\Models\SiteSetting::get('tiktok_url'),
                            'hover' => 'hover:bg-black hover:text-white' // TikTok Hitam
                        ],
                        'whatsapp' => [
                            'icon' => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>', 
                            'url' => \App\Models\SiteSetting::get('whatsapp_url'),
                            'hover' => 'hover:bg-[#25D366] hover:text-white' // WhatsApp Hijau
                        ],
                        'youtube' => [
                            'icon' => '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>', 
                            'url' => \App\Models\SiteSetting::get('youtube_url'),
                            'hover' => 'hover:bg-[#FF0000] hover:text-white' // YouTube Merah
                        ]
                    ];
                @endphp

                @foreach($sosmeds as $key => $data)
                    @if(!empty($data['url']))
                        <a href="{{ $data['url'] }}" target="_blank" rel="noopener" 
                           class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center transition duration-300 {{ $data['hover'] }}" 
                           title="{{ ucfirst($key) }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">{!! $data['icon'] !!}</svg>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        
        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-gray-300 mb-4">Menu Utama</h4>
            <ul class="space-y-2 text-sm text-gray-300">
                <li><a href="{{ route('home') }}" class="hover:underline">Beranda</a></li>
                <li><a href="{{ route('site.posts.index') }}" class="hover:underline">Berita & Pengumuman</a></li>
                <li><a href="{{ route('site.jobs.index') }}" class="hover:underline">Lowongan Kerja</a></li>
                <li><a href="{{ route('site.programs.index') }}" class="hover:underline">Program & Pelatihan</a></li>
            </ul>
        </div>
        
        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-gray-300 mb-4">Layanan Publik</h4>
            <ul class="space-y-2 text-sm text-gray-300">
                <li><a href="{{ route('site.ppid.profile') }}" class="hover:underline">PPID DISNAKERTRANS</a></li>
                <li><a href="{{ route('site.ppid.documents') }}" class="hover:underline">Dokumen Publik (DIP)</a></li>
                <li><a href="{{ route('site.complaints.create') }}" class="hover:underline">Pengaduan Masyarakat</a></li>
                <li><a href="{{ route('site.contact') }}" class="hover:underline">Kontak & Bantuan</a></li>
            </ul>
        </div>
        
        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-gray-300 mb-4">Akses Sistem</h4>
            <p class="text-sm text-gray-300 mb-4">Masuk ke ruang kelola khusus administrator berwenang.</p>
            <a href="{{ route('admin.login') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-medium rounded-xl transition">
                Akses admin &rarr;
            </a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400">
        <p>&copy; {{ date('Y') }} DISNAKERTRANS NTT. Hak cipta dilindungi undang-undang.</p>
        <p class="mt-2 sm:mt-0">Layanan terbuka, transparan, dan terpercaya untuk masyarakat NTT.</p>
    </div>
</footer>