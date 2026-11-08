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
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-3">
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-12 w-auto bg-white rounded p-1">
                @endif
                <h3 class="font-bold text-white text-lg tracking-wide">{{ \App\Models\SiteSetting::get('site_name', 'DISNAKERTRANS-NTT') }}</h3>
            </div>
            <p class="text-yellow-100/80">{{ \App\Models\SiteSetting::get('site_tagline', 'Portal Informasi Publik') }}</p>
        </div>
        
        <div>
            <h4 class="font-bold text-ntt-gold mb-3 uppercase tracking-wider text-xs">Kontak Kami</h4>
            <ul class="space-y-2 text-gray-300">
                <li class="flex gap-2"><span>📍</span> {{ \App\Models\SiteSetting::get('office_address') }}</li>
                <li class="flex gap-2"><span>📞</span> {{ \App\Models\SiteSetting::get('office_phone') }}</li>
                <li class="flex gap-2"><span>✉️</span> {{ \App\Models\SiteSetting::get('office_email') }}</li>
            </ul>
        </div>
        
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
        © {{ date('Y') }} Tim Kuliah Praktek CodeX. Hak cipta dilindungi.
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