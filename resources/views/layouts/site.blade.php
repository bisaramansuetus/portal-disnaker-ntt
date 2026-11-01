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

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $defaultTitle)">
    <meta name="twitter:description" content="@yield('meta_description', $defaultDesc)">

    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    @stack('head')
</head>
@stack('head')
<body class="bg-gray-50 text-slate-800 flex flex-col min-h-screen">

<header class="bg-slate-800 text-white shadow sticky top-0 z-30">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                {{-- Logika Menampilkan Logo --}}
                @php $logo = \App\Models\SiteSetting::get('logo_path'); @endphp
                @if ($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-10 w-auto bg-white rounded p-0.5">
                @else
                    {{-- Kotak Placeholder jika logo belum di-upload --}}
                    <div class="h-10 w-10 bg-slate-700 border border-slate-600 rounded flex items-center justify-center text-[10px] text-slate-400">Logo</div>
                @endif

                {{-- Teks Judul & Sub-judul --}}
                <div class="flex flex-col leading-tight">
                    <span class="font-bold text-lg">{{ \App\Models\SiteSetting::get('site_name', 'Disnaker NTT') }}</span>
                    <span class="text-[11px] text-slate-300 tracking-wide">{{ \App\Models\SiteSetting::get('site_tagline', 'Portal Informasi Publik') }}</span>
                </div>
            </a>
            <button id="navToggle" class="md:hidden text-2xl leading-none">☰</button>
                        {{-- MENU DESKTOP --}}
            <nav class="hidden md:flex items-center gap-1 text-sm font-medium">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('home') ? 'bg-slate-700' : '' }}">Beranda</a>
                <a href="{{ route('site.profile') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('site.profile') ? 'bg-slate-700' : '' }}">Profil Dinas</a>

                                {{-- DROPDOWN DESKTOP (Click to Toggle) --}}
                <div class="relative" id="dropdownInformasiContainer">
                    <button type="button" id="dropdownInformasiButton" class="px-3 py-2 rounded hover:bg-slate-700 flex items-center gap-1 focus:outline-none">
                        Informasi <span class="text-xs transition-transform duration-200" id="dropdownArrow">▼</span>
                    </button>
                    {{-- Dropdown Menu (Awalnya hidden) --}}
                    <div id="dropdownInformasiMenu" class="hidden absolute left-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-slate-800 z-50 border border-gray-100">
                        <a href="{{ route('site.posts.index') }}" class="block px-4 py-2 hover:bg-slate-100 transition">Berita</a>
                        <a href="{{ route('site.announcements.index') }}" class="block px-4 py-2 hover:bg-slate-100 transition">Pengumuman</a>
                        <a href="{{ route('site.jobs.index') }}" class="block px-4 py-2 hover:bg-slate-100 transition">Lowongan</a>
                        <a href="{{ route('site.transmigrasi.index') }}" class="block px-4 py-2 hover:bg-slate-100 transition">Transmigrasi</a>
                    </div>
                </div>

                <a href="{{ route('site.programs.index') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('site.programs.*') ? 'bg-slate-700' : '' }}">Program</a>
                <a href="{{ route('site.complaints.create') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('site.complaints.create') ? 'bg-slate-700' : '' }}">Pengaduan</a>
                <a href="{{ route('site.contact') }}" class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('site.contact') ? 'bg-slate-700' : '' }}">Kontak</a>
                
                <a href="{{ route('site.complaints.track') }}" class="ml-2 px-3 py-2 rounded text-yellow-300 hover:bg-slate-700 hover:text-white transition font-semibold border border-yellow-500/30">
                    Lacak Pengaduan
                </a>
            </nav>
        </div>

        {{-- MENU MOBILE (HAMBURGER) --}}
        <nav id="mobileNav" class="hidden md:hidden pb-3 space-y-1 text-sm border-t border-slate-700 mt-2 pt-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Beranda</a>
            <a href="{{ route('site.profile') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Profil Dinas</a>

            {{-- ACCORDION MOBILE (Menggunakan tag details/summary bawaan HTML) --}}
            <details class="group">
                <summary class="cursor-pointer list-none flex justify-between items-center px-3 py-2 rounded hover:bg-slate-700 select-none">
                    <span>Informasi</span>
                    <span class="text-xs transition-transform group-open:rotate-180">▼</span>
                </summary>
                <div class="pl-4 pb-2 space-y-1 text-slate-300">
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
                <a href="{{ route('site.complaints.track') }}" class="block px-3 py-2 rounded bg-slate-700 text-yellow-300 font-semibold text-center hover:bg-slate-600 transition">
                    🔍 Lacak Pengaduan
                </a>
            </div>
        </nav>
</header>

<main class="flex-1">
    @yield('content')
</main>

<footer class="bg-slate-900 text-slate-300 text-sm">
    <div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <h3 class="font-bold text-white text-base mb-2">{{ \App\Models\SiteSetting::get('site_name', 'Disnaker NTT') }}</h3>
            <p>{{ \App\Models\SiteSetting::get('site_tagline', 'Portal Informasi Publik') }}</p>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-2">Kontak</h4>
            <p>{{ \App\Models\SiteSetting::get('office_address') }}</p>
            <p>Telp: {{ \App\Models\SiteSetting::get('office_phone') }}</p>
            <p>Email: {{ \App\Models\SiteSetting::get('office_email') }}</p>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-2">Navigasi</h4>
            <ul class="space-y-1">
                <li><a href="{{ route('site.profile') }}" class="hover:text-white">Profil Dinas</a></li>
                <li><a href="{{ route('site.jobs.index') }}" class="hover:text-white">Lowongan Kerja</a></li>
                <li><a href="{{ route('site.programs.index') }}" class="hover:text-white">Program & Pelatihan</a></li>
                <li><a href="{{ route('site.transmigrasi.index') }}" class="hover:text-white">Transmigrasi</a></li>
                <li><a href="{{ route('site.contact') }}" class="hover:text-white">Kontak & Bantuan</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-slate-800 text-center py-3 text-xs">
        © {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'Disnaker NTT') }}. Hak cipta dilindungi.
    </div>
</footer>

<script>
    document.getElementById('navToggle')?.addEventListener('click', () => {
        document.getElementById('mobileNav')?.classList.toggle('hidden');
    });

        // Script untuk Dropdown Desktop
    document.addEventListener('DOMContentLoaded', function() {
        const dropBtn = document.getElementById('dropdownInformasiButton');
        const dropMenu = document.getElementById('dropdownInformasiMenu');
        const dropArrow = document.getElementById('dropdownArrow');

        if (dropBtn && dropMenu) {
            // Buka/Tutup saat tombol diklik
            dropBtn.addEventListener('click', function(e) {
                e.preventDefault();
                dropMenu.classList.toggle('hidden');
                dropArrow.classList.toggle('rotate-180');
            });

            // Tutup menu saat klik di luar area dropdown
            document.addEventListener('click', function(e) {
                if (!dropBtn.contains(e.target) && !dropMenu.contains(e.target)) {
                    dropMenu.classList.add('hidden');
                    dropArrow.classList.remove('rotate-180');
                }
            });
        }
    });
</script>
@stack('scripts')
</body>
</html>