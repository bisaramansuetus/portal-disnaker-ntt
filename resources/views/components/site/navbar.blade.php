<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Logo & Title -->
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            @php $logo = \App\Models\SiteSetting::get('logo_path'); @endphp
            @if ($logo)
                <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-10 w-auto">
            @else
                <div class="h-10 w-10 bg-[#112F28] rounded flex items-center justify-center text-white font-bold text-xs">NTT</div>
            @endif
            <div class="flex flex-col leading-tight">
                <span class="text-lg font-bold tracking-tight text-[#112F28]">DISNAKERTRANS</span>
                <span class="text-[10px] tracking-widest text-gray-500 uppercase">PROVINSI NUSA TENGGARA TIMUR</span>
            </div>
        </a>

        <!-- Navigation Menu Desktop -->
        <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-700">
            <a href="{{ route('home') }}" class="hover:text-[#112F28] transition {{ request()->routeIs('home') ? 'text-[#112F28] font-bold' : '' }}">Beranda</a>
            <a href="{{ route('site.profile') }}" class="hover:text-[#112F28] transition {{ request()->routeIs('site.profile') ? 'text-[#112F28] font-bold' : '' }}">Profil Dinas</a>
            
            <!-- Dropdown Informasi -->
            <div class="relative" id="infoDropdownWrapper">
                <button type="button" id="infoDropdownBtn" class="flex items-center hover:text-[#112F28] transition focus:outline-none py-2">
                    <span>Informasi</span>
                    <svg id="infoDropdownChevron" class="w-4 h-4 ml-1 transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="infoDropdownMenu" class="hidden absolute left-0 mt-2 w-60 bg-white border border-gray-100 rounded-2xl shadow-xl p-2 z-50">
                    <p class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-gray-400">Jelajahi Informasi</p>
                    <a href="{{ route('site.posts.index') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Berita</span><span>&nearr;</span>
                    </a>
                    <a href="{{ route('site.announcements.index') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Pengumuman</span><span>&nearr;</span>
                    </a>
                    <a href="{{ route('site.jobs.index') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Lowongan Kerja</span><span>&nearr;</span>
                    </a>
                    <a href="{{ route('site.programs.index') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Program & Pelatihan</span><span>&nearr;</span>
                    </a>
                    <a href="{{ route('site.transmigrasi.index') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Transmigrasi</span><span>&nearr;</span>
                    </a>
                </div>
            </div>

            <!-- Dropdown PPID (KEMBALI DITAMBAHKAN) -->
            <div class="relative" id="ppidDropdownWrapper">
                <button type="button" id="ppidDropdownBtn" class="flex items-center hover:text-[#112F28] transition focus:outline-none py-2 {{ request()->routeIs('site.ppid.*') ? 'text-[#112F28] font-bold' : '' }}">
                    <span>PPID</span>
                    <svg id="ppidDropdownChevron" class="w-4 h-4 ml-1 transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="ppidDropdownMenu" class="hidden absolute left-0 mt-2 w-64 bg-white border border-gray-100 rounded-2xl shadow-xl p-2 z-50">
                    <p class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-gray-400">Layanan PPID</p>
                    <a href="{{ route('site.ppid.profile') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Profil PPID</span><span>&nearr;</span>
                    </a>
                    <a href="{{ route('site.ppid.documents') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Informasi Publik (DIP)</span><span>&nearr;</span>
                    </a>
                    <a href="{{ route('site.ppid.standards') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Standar Layanan</span><span>&nearr;</span>
                    </a>
                    <div class="h-px bg-gray-100 my-1 mx-2"></div>
                    <a href="{{ route('site.ppid.request_permohonan') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Permohonan Informasi</span><span>&nearr;</span>
                    </a>
                    <a href="{{ route('site.ppid.request_keberatan') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Pengajuan Keberatan</span><span>&nearr;</span>
                    </a>
                    <a href="{{ route('site.ppid.track') }}" class="flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 hover:bg-[#E3EAE5] hover:text-[#112F28] rounded-xl transition">
                        <span>Lacak Layanan PPID</span><span>&nearr;</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('site.contact') }}" class="hover:text-[#112F28] transition {{ request()->routeIs('site.contact') ? 'text-[#112F28] font-bold' : '' }}">Kontak & Bantuan</a>
        </nav>

        <!-- Right Action Button Desktop -->
        <div class="hidden md:flex items-center space-x-4">
            <a href="{{ route('site.complaints.create') }}" class="inline-flex items-center bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-medium px-5 py-2.5 rounded-full transition shadow-sm">
                Pengaduan &nearr;
            </a>
        </div>

        <!-- Mobile Menu Hamburger Button -->
        <div class="md:hidden flex items-center">
            <button type="button" id="openMobileDrawerBtn" aria-label="Buka menu navigasi" class="p-2 rounded-xl text-gray-700 hover:bg-gray-100 hover:text-[#112F28] focus:outline-none">
                <x-icon name="menu" class="w-6 h-6" />
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer Overlay -->
    <div id="mobileDrawerBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-xs z-50 hidden opacity-0 transition-opacity duration-200 md:hidden"></div>

    <!-- Mobile Navigation Drawer Panel -->
    <aside id="mobileDrawerPanel" class="fixed inset-y-0 right-0 w-80 max-w-[85vw] bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-out flex flex-col justify-between md:hidden">
        <div class="p-6 overflow-y-auto space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <span class="text-base font-bold text-[#112F28] block">DISNAKERTRANS</span>
                    <span class="text-[10px] tracking-widest text-gray-500 uppercase">PROVINSI NTT</span>
                </div>
                <button type="button" id="closeMobileDrawerBtn" aria-label="Tutup menu navigasi" class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 hover:text-gray-900">
                    <x-icon name="close" class="w-5 h-5" />
                </button>
            </div>

            <nav class="space-y-1 text-sm font-medium">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl {{ request()->routeIs('home') ? 'bg-[#D1E7DD] text-[#112F28] font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">Beranda</a>
                <a href="{{ route('site.profile') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Profil Dinas</a>

                <div class="pt-3 pb-1 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">Jelajahi Informasi</div>
                <a href="{{ route('site.posts.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Berita</a>
                <a href="{{ route('site.announcements.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Pengumuman</a>
                <a href="{{ route('site.jobs.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Lowongan Kerja</a>
                <a href="{{ route('site.programs.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Program & Pelatihan</a>
                <a href="{{ route('site.transmigrasi.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Transmigrasi</a>

                <div class="pt-3 pb-1 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">Layanan PPID</div>
                <a href="{{ route('site.ppid.profile') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Profil PPID</a>
                <a href="{{ route('site.ppid.documents') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Informasi Publik</a>
                <a href="{{ route('site.ppid.request_permohonan') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Permohonan Informasi</a>
                <a href="{{ route('site.ppid.track') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Lacak Layanan PPID</a>

                <div class="pt-3 pb-1 px-4 text-[10px] font-bold uppercase tracking-wider text-gray-400">Lainnya</div>
                <a href="{{ route('site.contact') }}" class="block px-4 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50">Kontak & Bantuan</a>
            </nav>
        </div>

        <div class="p-6 border-t border-gray-100 bg-gray-50">
            <a href="{{ route('site.complaints.create') }}" class="w-full inline-flex items-center justify-center bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold px-5 py-3 rounded-xl transition">
                Sampaikan Pengaduan &nearr;
            </a>
        </div>
    </aside>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Helper function for dropdowns
        function setupDropdown(btnId, menuId, chevronId, wrapperId) {
            const btn = document.getElementById(btnId);
            const menu = document.getElementById(menuId);
            const chevron = document.getElementById(chevronId);
            const wrapper = document.getElementById(wrapperId);

            if (btn && menu) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isHidden = menu.classList.contains('hidden');
                    
                    // Close all other dropdowns first
                    document.querySelectorAll('[id$="DropdownMenu"]').forEach(el => el.classList.add('hidden'));
                    document.querySelectorAll('[id$="DropdownChevron"]').forEach(el => el.classList.remove('rotate-180'));

                    if (isHidden) {
                        menu.classList.remove('hidden');
                        chevron.classList.add('rotate-180');
                    }
                });

                document.addEventListener('click', function (e) {
                    if (wrapper && !wrapper.contains(e.target)) {
                        menu.classList.add('hidden');
                        chevron.classList.remove('rotate-180');
                    }
                });
            }
        }

        // Initialize Dropdowns
        setupDropdown('infoDropdownBtn', 'infoDropdownMenu', 'infoDropdownChevron', 'infoDropdownWrapper');
        setupDropdown('ppidDropdownBtn', 'ppidDropdownMenu', 'ppidDropdownChevron', 'ppidDropdownWrapper');

        // Mobile Drawer Toggle
        const openBtn = document.getElementById('openMobileDrawerBtn');
        const closeBtn = document.getElementById('closeMobileDrawerBtn');
        const backdrop = document.getElementById('mobileDrawerBackdrop');
        const panel = document.getElementById('mobileDrawerPanel');

        function openDrawer() {
            backdrop.classList.remove('hidden');
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('translate-x-full');
            });
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            backdrop.classList.add('opacity-0');
            panel.classList.add('translate-x-full');
            setTimeout(() => {
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            }, 250);
        }

        if (openBtn) openBtn.addEventListener('click', openDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (backdrop) backdrop.addEventListener('click', closeDrawer);
    });
</script>
@endpush