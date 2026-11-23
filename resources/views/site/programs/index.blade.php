@extends('layouts.site')

@section('content')
@php
    $isTransmigration = request('type') === 'transmigrasi' || ($mode ?? '') === 'transmigration';
    $pageTitle = $isTransmigration ? 'Harapan baru, bersama transmigrasi.' : 'Belajar, tumbuh, berdaya.';
    $pageSubtitle = $isTransmigration
        ? 'Kenali program, persyaratan, dan proses pendampingan transmigrasi.'
        : 'Pilih pelatihan sesuai minat dan kembangkan keterampilan yang relevan.';
    $breadcrumbLabel = $isTransmigration ? 'Harapan baru, bersama transmigrasi' : 'Belajar, tumbuh, berdaya';
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <span>Informasi</span> / <span class="text-gray-900 font-medium">{{ $breadcrumbLabel }}</span>
    </nav>

    <!-- Header -->
    <div class="max-w-2xl mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">{{ $pageTitle }}</h1>
        <p class="text-sm sm:text-base text-gray-600">{{ $pageSubtitle }}</p>
    </div>

    <!-- Search & Filter Bar -->
    <form method="GET" action="{{ route('site.programs.index') }}" class="bg-white rounded-2xl p-2.5 border border-gray-200/80 shadow-xs flex flex-col md:flex-row items-stretch md:items-center gap-2 mb-6">
        @if($isTransmigration)
            <input type="hidden" name="type" value="transmigrasi">
        @endif

        <div class="flex-1 flex items-center px-3">
            <x-icon name="search" class="w-4 h-4 text-gray-400 mr-2.5 flex-shrink-0" />
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari program..."
                   class="w-full py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none">
        </div>

        <div class="hidden md:block w-px h-6 bg-gray-200"></div>

        <div class="px-2">
            <select name="category" class="w-full md:w-44 py-2 text-sm text-gray-700 bg-transparent focus:outline-none">
                <option value="">Kategori / jenis</option>
                <option value="pelatihan" {{ request('category') == 'pelatihan' ? 'selected' : '' }}>Pelatihan Vokasi</option>
                <option value="transmigrasi" {{ request('category') == 'transmigrasi' ? 'selected' : '' }}>Transmigrasi</option>
            </select>
        </div>

        <button type="submit" class="px-7 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-full transition">
            Cari
        </button>
    </form>

    <!-- Programs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($programs as $program)
            <a href="{{ route('site.programs.show', $program->slug) }}"
               class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-xs hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <div class="mb-4">
                        <x-badge variant="success">Pendaftaran dibuka</x-badge>
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 group-hover:text-[#112F28] transition mb-1">
                        {{ $program->title }}
                    </h2>
                    <p class="text-sm text-gray-600 mb-4">
                        UPTD Pelatihan Kerja Kupang
                    </p>

                    <div class="flex flex-wrap items-center gap-2 text-xs mb-5">
                        <span class="px-2.5 py-1 rounded-md font-semibold bg-[#DBEAFE] text-[#1D4ED8]">{{ $program->quota ?? '30' }} peserta</span>
                        <span class="px-2.5 py-1 rounded-md font-semibold bg-[#DCFCE7] text-[#15803D]">{{ $program->fee == 0 ? 'Gratis' : 'Rp '.number_format($program->fee, 0, ',', '.') }}</span>
                        <span class="px-2.5 py-1 rounded-md font-semibold bg-[#F3F4F6] text-[#374151]">Kupang</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                    <span class="text-amber-700 font-medium">
                        @if($program->start_date)
                            Pendaftaran ditutup: {{ $program->start_date->format('d M Y') }}
                        @else
                            Jadwal menyusul
                        @endif
                    </span>
                    <span class="text-base font-bold text-[#112F28] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform">&nearr;</span>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-gray-100">
                <p class="text-gray-500 text-sm">Belum ada program yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

    <x-pagination :paginator="$programs" />

    <p class="text-xs text-gray-400 mt-8">
        Informasi lengkap dan pendaftaran tersedia pada halaman masing-masing program.
    </p>
</div>
@endsection