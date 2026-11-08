<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $defaultTitle = \App\Models\SiteSetting::get('site_name', 'Disnaker NTT');
        $defaultDesc = \App\Models\SiteSetting::get('site_tagline', 'Portal Informasi Publik');
    @endphp

    <title>@yield('title', $defaultTitle)</title>
    <meta name="description" content="@yield('meta_description', $defaultDesc)">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="{{ $defaultTitle }}">
    <meta property="og:title" content="@yield('title', $defaultTitle)">
    <meta property="og:description" content="@yield('meta_description', $defaultDesc)">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @hasSection('meta_image')
        <meta property="og:image" content="@yield('meta_image')">
    @endif

    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ntt: {
                            red: '#7f1d1d',    // Merah Marun Gelap
                            lightred: '#991b1b',
                            gold: '#facc15',   // Kuning Emas
                            cream: '#fdfbf7',  // Latar belakang krem lembut
                        }
                    },
                    fontFamily: {
                        serif: ['Georgia', 'Cambria', 'Times New Roman', 'Times', 'serif'],
                    }
                }
            }
        }
    </script>
    @stack('head')
</head>
<body class="bg-ntt-cream text-slate-800 flex flex-col min-h-screen">

{{-- HEADER (Merah Marun + Ornamen Komodo) --}}
{{-- HEADER (Kembali ke Warna Awal) --}}
<header class="bg-slate-800 text-white shadow sticky top-0 z-50 relative">
    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @php $logo = \App\Models\SiteSetting::get('logo_path'); @endphp
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-12 w-auto bg-white rounded p-1 shadow">
                @else
                    <div class="h-12 w-12 bg-slate-700 rounded flex items-center justify-center text-[10px] text-slate-400 font-bold">Logo</div>
                @endif
                <div class="flex flex-col leading-tight">
                    <span class="font-bold text-xl tracking-wide">{{ \App\Models\SiteSetting::get('site_name', 'DISNAKERTRANS NTT') }}</span>
                    <span class="text-xs text-slate-300 tracking-wider">{{ \App\Models\SiteSetting::get('site_tagline', 'Portal Informasi Publik') }}</span>
                </div>
            </a>
            
            <button id="navToggle" class="md:hidden text-2xl leading-none text-white">☰</button>

            {{-- MENU DESKTOP --}}
            <nav class="hidden md:flex items-center gap-1 text-sm font-medium">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('home') ? 'bg-slate-700' : '' }}">Beranda</a>
                <a href="{{ route('site.profile') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('site.profile') ? 'bg-slate-700' : '' }}">Profil Dinas</a>

                {{-- DROPDOWN PPID DESKTOP --}}
                <div class="relative" id="dropdownPpidContainer">
                    <button type="button" id="dropdownPpidButton" class="px-3 py-2 rounded hover:bg-slate-700 flex items-center gap-1 focus:outline-none">
                        PPID <span class="text-xs transition-transform duration-200" id="dropdownPpidArrow">▼</span>
                    </button>
                    <div id="dropdownPpidMenu" class="hidden absolute left-0 top-full mt-2 w-56 bg-white rounded-md shadow-lg py-1 text-slate-800 z-50 border border-gray-100">
                        <a href="{{ route('site.ppid.profile') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Profil PPID</a>
                        <a href="{{ route('site.ppid.documents') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Informasi Publik</a>
                        <a href="{{ route('site.ppid.standards') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Standar Layanan & Regulasi</a>
                        <a href="{{ route('site.ppid.request_permohonan') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Formulir Permohonan</a>
                        <a href="{{ route('site.ppid.track') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Lacak Layanan PPID</a>
                    </div>
                </div>

                {{-- DROPDOWN DESKTOP --}}
                <div class="relative" id="dropdownInformasiContainer">
                    <button type="button" id="dropdownInformasiButton" class="px-3 py-2 rounded hover:bg-slate-700 flex items-center gap-1 focus:outline-none">
                        Informasi <span class="text-xs transition-transform duration-200" id="dropdownArrow">▼</span>
                    </button>
                    <div id="dropdownInformasiMenu" class="hidden absolute left-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-slate-800 z-50 border border-gray-100">
                        <a href="{{ route('site.posts.index') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Berita</a>
                        <a href="{{ route('site.announcements.index') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Pengumuman</a>
                        <a href="{{ route('site.jobs.index') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Lowongan</a>
                        <a href="{{ route('site.transmigrasi.index') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Transmigrasi</a>
                    </div>
                </div>

                <a href="{{ route('site.programs.index') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('site.programs.*') ? 'bg-slate-700' : '' }}">Program</a>
                <a href="{{ route('site.complaints.create') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('site.complaints.create') ? 'bg-slate-700' : '' }}">Pengaduan</a>
                <a href="{{ route('site.contact') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('site.contact') ? 'bg-slate-700' : '' }}">Kontak</a>
                
                <a href="{{ route('site.complaints.track') }}" class="ml-2 px-4 py-2 rounded-md bg-ntt-gold text-ntt-red font-bold hover:bg-yellow-300 transition shadow">
                    Lacak Pengaduan
                </a>
            </nav>
        </div>

        {{-- MENU MOBILE --}}
        <nav id="mobileNav" class="hidden md:hidden pb-3 space-y-1 text-sm border-t border-slate-700 mt-2 pt-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Beranda</a>
            <a href="{{ route('site.profile') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Profil Dinas</a>

            <details class="group">
                <summary class="cursor-pointer list-none flex justify-between items-center px-3 py-2 rounded hover:bg-slate-700 select-none">
                    <span>PPID</span>
                    <span class="text-xs transition-transform group-open:rotate-180 text-slate-300">▼</span>
                </summary>
                <div class="pl-4 pb-2 space-y-1 text-slate-300 bg-slate-700/50 rounded mt-1">
                    <a href="{{ route('site.ppid.profile') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Profil PPID</a>
                    <a href="{{ route('site.ppid.documents') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Informasi Publik</a>
                    <a href="{{ route('site.ppid.standards') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Standar Layanan</a>
                    <a href="{{ route('site.ppid.request_permohonan') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Formulir Permohonan</a>
                    <a href="{{ route('site.ppid.track') }}" class="block px-4 py-2 hover:bg-slate-100 hover:text-slate-800 transition font-medium">Lacak Layanan PPID</a>
                </div>
            </details>

            <details class="group">
                <summary class="cursor-pointer list-none flex justify-between items-center px-3 py-2 rounded hover:bg-slate-700 select-none">
                    <span>Informasi</span>
                    <span class="text-xs transition-transform group-open:rotate-180 text-slate-300">▼</span>
                </summary>
                <div class="pl-4 pb-2 space-y-1 text-slate-300 bg-slate-700/50 rounded mt-1">
                    <a href="{{ route('site.posts.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Berita</a>
                    <a href="{{ route('site.announcements.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Pengumuman</a>
                    <a href="{{ route('site.jobs.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Lowongan</a>
                    <a href="{{ route('site.transmigrasi.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Transmigrasi</a>
                </div>
            </details>

            <a href="{{ route('site.programs.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Program</a>
            <a href="{{ route('site.complaints.create') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Pengaduan</a>
            <a href="{{ route('site.contact') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Kontak</a>
            
            <div class="pt-2 mt-2 border-t border-slate-700">
                <a href="{{ route('site.complaints.track') }}" class="block px-3 py-2 rounded bg-ntt-gold text-ntt-red font-bold text-center hover:bg-yellow-300 transition">
                    🔍 Lacak Pengaduan
                </a>
            </div>
        </nav>
    </div>
</header>

{{-- MAIN CONTENT --}}
<main class="flex-1 relative z-10">
    @yield('content')
</main>

{{-- FOOTER (Merah Marun + Garis Emas) --}}
<footer class="bg-ntt-red text-gray-200 text-sm border-t-4 border-ntt-gold">
    <div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
        
        {{-- KOLOM 1: LOGO & MEDIA SOSIAL --}}
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-3">
                @php $logo = \App\Models\SiteSetting::get('logo_path'); @endphp
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-12 w-auto bg-white rounded p-1 shadow">
                @endif
                <h3 class="font-bold text-white text-lg tracking-wide">{{ \App\Models\SiteSetting::get('site_name', 'DISNAKERTRANS NTT') }}</h3>
            </div>
            <p class="text-yellow-100/80">{{ \App\Models\SiteSetting::get('site_tagline', 'Portal Informasi Publik') }}</p>
            
            {{-- IKON MEDIA SOSIAL (DI BAWAH LOGO) --}}
            <div class="flex gap-3 mt-2">
                @php
                    $sosmeds = [
                        'facebook' => [
                            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>',
                            'bg' => 'hover:bg-blue-600',
                            'url' => \App\Models\SiteSetting::get('facebook_url')
                        ],
                        'instagram' => [
                            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
                            'bg' => 'hover:bg-pink-600',
                            'url' => \App\Models\SiteSetting::get('instagram_url')
                        ],
                        'tiktok' => [
                            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>',
                            'bg' => 'hover:bg-black',
                            'url' => \App\Models\SiteSetting::get('tiktok_url')
                        ],
                        'whatsapp' => [
                            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
                            'bg' => 'hover:bg-green-500',
                            'url' => \App\Models\SiteSetting::get('whatsapp_url')
                        ]
                    ];
                @endphp

                @foreach($sosmeds as $key => $data)
                    @if(!empty($data['url']))
                        <a href="{{ $data['url'] }}" target="_blank" rel="noopener" 
                           class="w-8 h-8 rounded-full bg-red-900/50 text-yellow-100 flex items-center justify-center {{ $data['bg'] }} hover:text-white transition duration-300 border border-red-900/50"
                           title="{{ ucfirst($key) }}">
                            {!! $data['icon'] !!}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        
        {{-- KOLOM 2: KONTAK --}}
        <div>
            <h4 class="font-bold text-ntt-gold mb-3 uppercase tracking-wider text-xs">Kontak Kami</h4>
            <ul class="space-y-2 text-gray-300">
                <li class="flex gap-2"><span>📍</span> {{ \App\Models\SiteSetting::get('office_address') }}</li>
                <li class="flex gap-2"><span>📞</span> {{ \App\Models\SiteSetting::get('office_phone') }}</li>
                <li class="flex gap-2"><span>✉️</span> {{ \App\Models\SiteSetting::get('office_email') }}</li>
            </ul>
        </div>
        
        {{-- KOLOM 3: NAVIGASI --}}
        <div>
            <h4 class="font-bold text-ntt-gold mb-3 uppercase tracking-wider text-xs">Navigasi</h4>
            <ul class="space-y-2">
                <li><a href="{{ route('site.profile') }}" class="hover:text-white hover:underline transition">Profil Dinas</a></li>
                <li><a href="{{ route('site.jobs.index') }}" class="hover:text-white hover:underline transition">Lowongan Kerja</a></li>
                <li><a href="{{ route('site.programs.index') }}" class="hover:text-white hover:underline transition">Program & Pelatihan</a></li>
                <li><a href="{{ route('site.transmigrasi.index') }}" class="hover:text-white hover:underline transition">Transmigrasi</a></li>
                <li><a href="{{ route('site.contact') }}" class="hover:text-white hover:underline transition">Kontak & Bantuan</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-red-900/50 text-center py-4 text-xs text-gray-400">
        © {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'DISNAKERTRANS NTT') }}. Hak cipta dilindungi.
    </div>
</footer>

<script>
    // Toggle Mobile Nav {{ \App\Models\SiteSetting::get('site_name', 'Disnaker NTT') }}
    document.getElementById('navToggle')?.addEventListener('click', () => {
        document.getElementById('mobileNav')?.classList.toggle('hidden');
    });

    // Toggle Dropdown Desktop
    document.addEventListener('DOMContentLoaded', function() {
        const dropBtn = document.getElementById('dropdownInformasiButton');
        const dropMenu = document.getElementById('dropdownInformasiMenu');
        const dropArrow = document.getElementById('dropdownArrow');

        if (dropBtn && dropMenu) {
            dropBtn.addEventListener('click', function(e) {
                e.preventDefault();
                dropMenu.classList.toggle('hidden');
                dropArrow.classList.toggle('rotate-180');
            });

            document.addEventListener('click', function(e) {
                if (!dropBtn.contains(e.target) && !dropMenu.contains(e.target)) {
                    dropMenu.classList.add('hidden');
                    dropArrow.classList.remove('rotate-180');
                }
            });
        }
    });

    // Dropdown PPID
    const ppidBtn = document.getElementById('dropdownPpidButton');
    const ppidMenu = document.getElementById('dropdownPpidMenu');
    const ppidArrow = document.getElementById('dropdownPpidArrow');
    if (ppidBtn && ppidMenu) {
        ppidBtn.addEventListener('click', function(e) {
            e.preventDefault();
            ppidMenu.classList.toggle('hidden');
            ppidArrow.classList.toggle('rotate-180');
        });
        document.addEventListener('click', function(e) {
            if (!ppidBtn.contains(e.target) && !ppidMenu.contains(e.target)) {
                ppidMenu.classList.add('hidden');
                ppidArrow.classList.remove('rotate-180');
            }
        });
    }
            
</script>
@stack('scripts')
</body>
</html>