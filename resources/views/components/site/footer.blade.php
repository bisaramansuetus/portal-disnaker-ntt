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
                        'facebook' => ['icon' => '<path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>', 'url' => \App\Models\SiteSetting::get('facebook_url')],
                        'instagram' => ['icon' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>', 'url' => \App\Models\SiteSetting::get('instagram_url')],
                        'youtube' => ['icon' => '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>', 'url' => \App\Models\SiteSetting::get('youtube_url')]
                    ];
                @endphp
                @foreach($sosmeds as $key => $data)
                    @if(!empty($data['url']))
                        <a href="{{ $data['url'] }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition" title="{{ ucfirst($key) }}">
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