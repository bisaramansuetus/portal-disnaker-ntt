<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ruang Kelola') — DISNAKERTRANS NTT</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#112F28', dark: '#0B1F1B', light: '#1B4A40' },
                        accent: { DEFAULT: '#D1E7DD', light: '#E3EAE5', dark: '#A3CFBB' }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
    @stack('head')
</head>
<body class="bg-[#F4F6F4] text-[#1A1A1A] min-h-screen flex antialiased overflow-hidden">

    {{-- OVERLAY MOBILE --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar Kiri -->
    <aside id="adminSidebar" class="w-64 bg-[#112F28] text-white flex-shrink-0 flex flex-col justify-between min-h-screen fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-200">
        <div>
            <!-- Brand Header -->
            <div class="px-6 py-7 border-b border-white/10 flex items-center gap-3">
                @php $logo = \App\Models\SiteSetting::get('logo_path'); @endphp
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-8 w-auto bg-white rounded p-0.5">
                @endif
                <div>
                    <span class="text-sm font-bold tracking-tight block">DISNAKERTRANS</span>
                    <span class="text-[9px] tracking-widest text-[#A3CFBB] uppercase font-semibold">RUANG KELOLA · NTT</span>
                </div>
            </div>

            <!-- Menu Utama -->
            <div class="px-4 py-6 overflow-y-auto h-[calc(100vh-160px)]">
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-3">MENU UTAMA</p>
                <nav class="space-y-1 text-sm">
                    @php
                        $menu = [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '🏠', 'pattern' => 'admin.dashboard'],
                            ['route' => 'admin.posts.index', 'label' => 'Berita & Pengumuman', 'icon' => '📰', 'pattern' => 'admin.posts.*'],
                            ['route' => 'admin.categories.index', 'label' => 'Kategori', 'icon' => '🏷️', 'pattern' => 'admin.categories.*'],
                            ['route' => 'admin.jobs.index', 'label' => 'Lowongan Kerja', 'icon' => '💼', 'pattern' => 'admin.jobs.*'],
                            ['route' => 'admin.programs.index', 'label' => 'Program & Pelatihan', 'icon' => '🎓', 'pattern' => 'admin.programs.*'],
                            ['route' => 'admin.complaints.index', 'label' => 'Pengaduan Masyarakat', 'icon' => '📢', 'pattern' => 'admin.complaints.*'],
                            ['route' => 'admin.ppid.index', 'label' => 'Dokumen PPID', 'icon' => '📂', 'pattern' => 'admin.ppid.index'],
                            ['route' => 'admin.ppid.requests.index', 'label' => 'Permohonan PPID', 'icon' => '📝', 'pattern' => 'admin.ppid.requests.*'],
                            
                            // --- MENU BARU STRUKTUR ---
                            ['route' => 'admin.structures.index', 'label' => 'Struktur Organisasi', 'icon' => '🏢', 'pattern' => 'admin.structures.*'],
                            
                            ['route' => 'admin.settings.edit', 'label' => 'Pengaturan Situs', 'icon' => '⚙️', 'pattern' => 'admin.settings.*'],
                        ];
                    @endphp

                                    
                    @foreach($menu as $item)
                        @php $isActive = request()->routeIs($item['pattern']); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center px-3 py-2.5 rounded-xl transition {{ $isActive ? 'bg-[#D1E7DD] text-[#112F28] font-semibold' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                            <span class="text-base mr-3 {{ $isActive ? 'opacity-100' : 'opacity-70' }}">
                                {{ $item['icon'] }}
                            </span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
                </nav>
            </div>
        </div>

        <!-- Footer Sidebar & Tombol Keluar -->
        <div class="p-4 border-t border-white/10 space-y-4">
            <div class="px-2 text-[11px] text-gray-400 leading-relaxed">
                <p>Hanya untuk administrator</p>
                <p>Sesi Anda dilindungi.</p>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-white text-[#112F28] hover:bg-[#D1E7DD] font-semibold text-sm rounded-xl transition">
                    Keluar akun &nearr;
                </button>
            </form>
        </div>
    </aside>

    <!-- Area Konten Utama -->
    <div class="flex-1 md:ml-64 flex flex-col min-h-screen h-screen overflow-y-auto">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-gray-200 px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <button type="button" onclick="toggleSidebar()" class="md:hidden text-gray-600 hover:text-[#112F28]">
                    <x-icon name="menu" class="w-6 h-6" />
                </button>
                <span class="text-sm text-gray-500 hidden sm:block">Portal Informasi Publik / <strong class="text-gray-800 font-medium">Ruang kelola</strong></span>
            </div>

            <div class="flex items-center space-x-4 text-sm">
                <a href="{{ route('home') }}" target="_blank" class="text-gray-600 hover:text-[#112F28] font-medium flex items-center">
                    Lihat website &nearr;
                </a>
                <span class="text-gray-300">|</span>
                <span class="font-semibold text-[#112F28]">{{ auth()->user()->name ?? 'Administrator' }}</span>
            </div>
        </header>

        <!-- Dynamic Page Content -->
        <main class="flex-grow p-4 md:p-8 max-w-7xl w-full mx-auto">
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer Admin -->
        <footer class="px-8 py-4 border-t border-gray-200 text-xs text-gray-400 flex justify-between">
            <span>&copy; {{ date('Y') }} DISNAKERTRANS NTT</span>
            <span>Ruang Kelola Portal Informasi Publik</span>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>