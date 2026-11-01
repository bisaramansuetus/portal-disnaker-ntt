<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ \App\Models\SiteSetting::get('site_name', 'Disnaker NTT') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="flex min-h-screen relative overflow-hidden">
    
    {{-- OVERLAY GELAP (Hanya muncul di HP saat menu dibuka) --}}
    <div id="adminOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden transition-opacity"></div>

    {{-- SIDEBAR --}}
    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-800 text-slate-100 flex-shrink-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
        <div class="p-4 border-b border-slate-700">
            <h1 class="font-bold text-lg">Disnaker NTT</h1>
            <p class="text-xs text-slate-400">Panel Admin</p>
        </div>
        <nav class="p-2 space-y-1 text-sm flex-1 overflow-y-auto">
            @php
                $menu = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '🏠'],
                    ['route' => 'admin.posts.index', 'label' => 'Berita & Pengumuman', 'icon' => '📰'],
                    ['route' => 'admin.jobs.index', 'label' => 'Lowongan Kerja', 'icon' => '💼'],
                    ['route' => 'admin.programs.index', 'label' => 'Program & Pelatihan', 'icon' => '🎓'],
                    ['route' => 'admin.complaints.index', 'label' => 'Pengaduan Masyarakat', 'icon' => '📢'],
                    ['route' => 'admin.categories.index', 'label' => 'Kategori', 'icon' => '🏷️'],
                    ['route' => 'admin.settings.edit', 'label' => 'Pengaturan Situs', 'icon' => '⚙️'],
                ];
            @endphp
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs($item['route'].'*') ? 'bg-slate-700 font-semibold' : '' }}">
                    <span>{{ $item['icon'] }}</span><span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
        <div class="p-4 border-t border-slate-700">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white">
                <span>🔗</span><span>Lihat Website</span>
            </a>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
        <header class="bg-white border-b px-4 py-3 flex items-center justify-between sticky top-0 z-30">
            {{-- Tombol Hamburger (Khusus HP) --}}
            <button id="adminNavToggle" class="md:hidden text-slate-800 text-2xl font-bold focus:outline-none">
                ☰
            </button>
            <div class="flex items-center gap-3 ml-auto">
                <span class="text-sm text-gray-600 hidden sm:block">{{ Auth::user()?->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline font-medium">Keluar</button>
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

<script>
    // Script untuk Toggle Sidebar di HP
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminOverlay');
    const toggleBtn = document.getElementById('adminNavToggle');

    function toggleSidebar() {
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }

    toggleBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
</script>

@stack('scripts')
</body>
</html>