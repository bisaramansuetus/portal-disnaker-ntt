@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <span class="text-gray-900 font-medium">Profil PPID</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Sidebar Menu PPID -->
        <div class="lg:col-span-4 space-y-2">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-1">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">PPID NTT</h3>
                <a href="{{ route('site.ppid.profile') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold bg-[#112F28] text-white">Profil PPID</a>
                <a href="{{ route('site.ppid.documents') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Informasi Publik (DIP)</a>
                <a href="{{ route('site.ppid.standards') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Standar & Regulasi</a>
                <a href="{{ route('site.ppid.request_permohonan') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Permohonan Informasi</a>
                <a href="{{ route('site.ppid.request_keberatan') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Pengajuan Keberatan</a>
                <a href="{{ route('site.ppid.track') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Lacak Layanan PPID</a>
            </div>
            
            <div class="bg-[#112F28] text-white rounded-2xl p-6 shadow-sm">
                <h4 class="text-sm font-bold mb-2">Tidak perlu akun</h4>
                <p class="text-xs text-gray-300 leading-relaxed mb-4">Simpan nomor tiket Anda untuk melacak permohonan atau keberatan layanan informasi.</p>
                <a href="{{ route('site.ppid.track') }}" class="inline-flex items-center text-xs font-bold text-[#D1E7DD] hover:underline">
                    Lacak layanan sekarang &rarr;
                </a>
            </div>
        </div>

        <!-- Konten Utama Profil PPID -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm space-y-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-3">Informasi terbuka, layanan terpercaya.</h1>
                    <p class="text-gray-600 leading-relaxed">
                        Pejabat Pengelola Informasi dan Dokumentasi (PPID) DISNAKERTRANS NTT mengelola, mendokumentasikan, dan melayani kebutuhan informasi publik secara transparan, akuntabel, dan tidak diskriminatif.
                    </p>
                </div>

                <div class="border-t border-gray-100 pt-6 space-y-4">
                    <h3 class="text-lg font-bold text-gray-900">Tentang PPID</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Kami berkomitmen menghadirkan akses data yang mudah dijangkau oleh seluruh lapisan masyarakat sesuai dengan amanat Undang-Undang Keterbukaan Informasi Publik.
                    </p>
                </div>

                <div class="border-t border-gray-100 pt-6 space-y-4">
                    <h3 class="text-lg font-bold text-gray-900">Tugas & Tanggung Jawab</h3>
                    <ul class="space-y-3 text-sm text-gray-600 list-disc list-inside">
                        <li>Menyediakan dan memperbarui Daftar Informasi Publik (DIP) secara berkala.</li>
                        <li>Melayani permohonan informasi serta menindaklanjuti pengajuan keberatan.</li>
                        <li>Mendokumentasikan seluruh arsip dan informasi sesuai ketentuan hukum yang berlaku.</li>
                        <li>Menjaga kerahasiaan informasi yang dikecualikan secara sah menurut undang-undang.</li>
                    </ul>
                </div>

                <div class="border-t border-gray-100 pt-6 space-y-4">
                    <h3 class="text-lg font-bold text-gray-900">Struktur Pelayanan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-center">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Pimpinan</p>
                            <h4 class="text-sm font-bold text-gray-900 mt-1">Atasan PPID</h4>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-center">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Pelaksana</p>
                            <h4 class="text-sm font-bold text-gray-900 mt-1">PPID Pelaksana</h4>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-center">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Layanan</p>
                            <h4 class="text-sm font-bold text-gray-900 mt-1">Petugas Informasi</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection