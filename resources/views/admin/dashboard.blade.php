@extends('layouts.admin')

@section('content')
@php
    $fallbackMonths = [
        ['name' => 'Jun', 'complaints' => 0, 'ppid' => 0, 'total' => 0, 'height_percent' => 25, 'active' => false],
        ['name' => 'Jul', 'complaints' => 0, 'ppid' => 0, 'total' => 0, 'height_percent' => 45, 'active' => false],
        ['name' => 'Agu', 'complaints' => 0, 'ppid' => 0, 'total' => 0, 'height_percent' => 35, 'active' => false],
        ['name' => 'Sep', 'complaints' => 0, 'ppid' => 0, 'total' => 0, 'height_percent' => 65, 'active' => false],
        ['name' => 'Okt', 'complaints' => 0, 'ppid' => 0, 'total' => 0, 'height_percent' => 55, 'active' => false],
        ['name' => now()->locale('id')->translatedFormat('M'), 'complaints' => 0, 'ppid' => 0, 'total' => 0, 'height_percent' => 85, 'active' => true],
    ];
    $monthsData = $chartMonths ?? $fallbackMonths;
@endphp

<div class="space-y-8">
    <!-- Header Greeting -->
    <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Selamat pagi, {{ auth()->user()->name ?? 'Administrator' }}.</h1>
        <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }} · Ringkasan aktivitas dan layanan hari ini.</p>
    </div>

    <!-- 6 Grid Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <p class="text-xs font-medium text-gray-500">Berita</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['posts'] ?? 0 }}</p>
            <p class="text-xs text-emerald-700 mt-2">Data tersinkronisasi</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <p class="text-xs font-medium text-gray-500">Pengumuman</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['announcements'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-2">Terpublikasi</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <p class="text-xs font-medium text-gray-500">Lowongan aktif</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['jobs'] ?? 0 }}</p>
            <p class="text-xs text-amber-600 mt-2">Tersedia di portal</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <p class="text-xs font-medium text-gray-500">Total program</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['programs'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-2">Pelatihan & Transmigrasi</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <p class="text-xs font-medium text-gray-500">Pengaduan masuk</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['complaints'] ?? 0 }}</p>
            <p class="text-xs text-amber-600 mt-2">{{ $attention['unresponded_complaints'] ?? 0 }} perlu respons</p>
        </div>

        <div class="bg-[#D1E7DD] p-6 rounded-2xl border border-[#A3CFBB] shadow-xs">
            <p class="text-xs font-semibold text-[#112F28]">PPID pending</p>
            <p class="text-3xl font-extrabold text-[#112F28] mt-2">{{ $stats['ppid_pending'] ?? 0 }}</p>
            <p class="text-xs font-medium text-[#112F28]/80 mt-2">Perlu ditinjau</p>
        </div>
    </div>

    <!-- Grafik Layanan Dinamis 6 Bulan & Panel Butuh Perhatian -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Grafik Batang Dinamis 6 Bulan -->
        <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-gray-100 shadow-xs flex flex-col justify-between">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-gray-900">Layanan masyarakat</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pengaduan dan PPID · 6 bulan terakhir (database)</p>
                </div>
                <span class="text-xs font-semibold text-[#112F28] bg-[#E3EAE5] px-3 py-1 rounded-full">
                    Total: {{ collect($monthsData)->sum('total') }}
                </span>
            </div>

            <div class="grid grid-cols-6 gap-3 sm:gap-4 items-end h-48 pt-8 px-2">
                @foreach($monthsData as $m)
                    <div class="flex flex-col items-center h-full justify-end space-y-2 group">
                        <span class="text-[11px] font-mono font-semibold text-gray-600">
                            {{ $m['total'] }}
                        </span>
                        <div class="w-full max-w-[42px] rounded-t-xl transition-all duration-300 {{ !empty($m['active']) ? 'bg-[#112F28]' : 'bg-[#D1E7DD] group-hover:bg-[#A3CFBB]' }}"
                             style="height: {{ $m['height_percent'] }}%;"
                             title="{{ $m['name'] }}: {{ $m['total'] }} layanan (Pengaduan: {{ $m['complaints'] }}, PPID: {{ $m['ppid'] }})">
                        </div>
                        <span class="text-xs text-gray-500 font-medium">{{ $m['name'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Butuh Perhatian Anda -->
        <div class="lg:col-span-5 bg-[#E3EAE5] p-6 rounded-2xl border border-[#D1E7DD] flex flex-col justify-between">
            <div>
                <h2 class="text-base font-bold text-[#112F28] mb-4">Butuh perhatian Anda</h2>
                <ul class="space-y-3 text-sm text-[#112F28]">
                    <li class="flex items-center justify-between pb-2.5 border-b border-[#112F28]/10">
                        <span>Pengaduan belum direspons</span>
                        <span class="font-mono font-bold bg-white px-2.5 py-0.5 rounded-lg">
                            {{ str_pad((string) ($attention['unresponded_complaints'] ?? 0), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </li>
                    <li class="flex items-center justify-between pb-2.5 border-b border-[#112F28]/10">
                        <span>Permohonan PPID menunggu</span>
                        <span class="font-mono font-bold bg-white px-2.5 py-0.5 rounded-lg">
                            {{ str_pad((string) ($attention['pending_ppid'] ?? 0), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Konten masih berupa draf</span>
                        <span class="font-mono font-bold bg-white px-2.5 py-0.5 rounded-lg">
                            {{ str_pad((string) ($attention['draft_posts'] ?? 0), 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </li>
                </ul>
            </div>

            <a href="{{ route('admin.complaints.index') }}" class="mt-6 w-full py-3 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl text-center transition">
                Tinjau layanan &rarr;
            </a>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
        <h2 class="text-sm font-bold text-gray-900 mb-3">Ringkasan operasional</h2>
        <div class="flex flex-wrap gap-6 text-xs text-gray-600">
            <span><strong class="text-gray-900 font-mono">BULAN INI</strong> {{ collect($monthsData)->last()['total'] ?? 0 }} pengajuan layanan tercatat</span>
            <span>&bull;</span>
            <span><strong class="text-gray-900 font-mono">STATUS</strong> Terhubung ke MySQL via Laravel 12</span>
        </div>
    </div>
</div>
@endsection