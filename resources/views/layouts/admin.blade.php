<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ \App\Models\SiteSetting::get('site_name', 'Disnaker NTT') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
    <style> [x-cloak] { display: none; } </style>
    @stack('head')
</head>
<body class="bg-gray-100 min-h-screen">

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-slate-800 text-slate-100 flex-shrink-0 hidden md:block">
        <div class="p-4 border-b border-slate-700">
            <h1 class="font-bold text-lg">Disnaker NTT</h1>
            <p class="text-xs text-slate-400">Panel Admin</p>
        </div>
        <nav class="p-2 space-y-1 text-sm">
            @php
            $menu = [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '🏠'],
                ['route' => 'admin.posts.index', 'label' => 'Berita & Pengumuman', 'icon' => '📰'],
                ['route' => 'admin.jobs.index', 'label' => 'Lowongan Kerja', 'icon' => '💼'],
                ['route' => 'admin.programs.index', 'label' => 'Program & Pelatihan', 'icon' => '🎓'],
                ['route' => 'admin.categories.index', 'label' => 'Kategori', 'icon' => '🏷️'],
                ['route' => 'admin.settings.edit', 'label' => 'Pengaturan Situs', 'icon' => '⚙️'],
            ];
            @endphp
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs($item['route'].'*') ? 'bg-slate-700' : '' }}">
                    <span>{{ $item['icon'] }}</span><span>{{ $item['label'] }}</span>
                </a>
            @endforeach
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-2 px-3 py-2 rounded hover:bg-slate-700 text-slate-300 mt-4 border-t border-slate-700 pt-4">
                <span>🔗</span><span>Lihat Website</span>
            </a>
        </nav>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b px-4 md:px-6 py-3 flex items-center justify-between">
            <div class="md:hidden font-bold">Admin</div>
            <div class="flex items-center gap-3 ml-auto">
                <span class="text-sm text-gray-600">{{ Auth::user()?->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline">Keluar</button>
                </form>
            </div>
        </header>

        <main class="p-4 md:p-6 flex-1">
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
