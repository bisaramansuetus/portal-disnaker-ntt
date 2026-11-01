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
            <nav class="hidden md:flex items-center gap-1 text-sm">
                @php
                    $navItems = [
                        ['route' => 'home', 'label' => 'Beranda'],
                        ['route' => 'site.profile', 'label' => 'Profil Dinas'],
                        ['route' => 'site.posts.index', 'label' => 'Berita'],
                        ['route' => 'site.announcements.index', 'label' => 'Pengumuman'],
                        ['route' => 'site.jobs.index', 'label' => 'Lowongan'],
                        ['route' => 'site.programs.index', 'label' => 'Program'],
                        ['route' => 'site.transmigrasi.index', 'label' => 'Transmigrasi'],
                        ['route' => 'site.complaints.create', 'label' => 'Pengaduan'],
                        ['route' => 'site.contact', 'label' => 'Kontak'],
                    ];
                @endphp
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'bg-slate-700' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                {{-- Tambahan menu Lacak untuk Desktop --}}
                <a href="{{ route('site.complaints.track') }}" class="px-3 py-2 rounded text-yellow-300 hover:bg-slate-700 hover:text-white transition font-semibold">
                    Lacak Pengaduan
                </a>
            </nav>
        </div>

        {{-- MENU MOBILE (HAMBURGER) --}}
        <nav id="mobileNav" class="hidden md:hidden pb-3 space-y-1 text-sm border-t border-slate-700 mt-2 pt-2">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" class="block px-3 py-2 rounded hover:bg-slate-700">{{ $item['label'] }}</a>
            @endforeach
            
            {{-- Tambahan menu Lacak untuk Mobile (Diletakkan di LUAR perulangan) --}}
            <a href="{{ route('site.complaints.track') }}" class="block px-3 py-2 rounded text-yellow-300 hover:bg-slate-700 hover:text-white transition font-semibold">
                🔍 Lacak Pengaduan
            </a>
        </nav>
        </div>
        <nav id="mobileNav" class="hidden md:hidden pb-3 space-y-1 text-sm">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" class="block px-3 py-2 rounded hover:bg-slate-700">{{ $item['label'] }}</a>
                <li><a href="{{ route('site.complaints.track') }}" class="hover:text-white">Lacak Pengaduan</a></li>
            @endforeach
        </nav>
    </div>
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
</script>
@stack('scripts')
</body>
</html>