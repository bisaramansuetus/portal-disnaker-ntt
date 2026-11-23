@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <span>Informasi</span> / <span class="text-gray-900 font-medium">Temukan pekerjaan yang tepat</span>
    </nav>

    <!-- Page Header -->
    <div class="max-w-2xl mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Temukan pekerjaan yang tepat</h1>
        <p class="text-sm sm:text-base text-gray-600">Peluang terkurasi untuk melangkah lebih dekat ke masa depan Anda.</p>
    </div>

    <!-- Search & Filter Bar -->
    <form method="GET" action="{{ route('site.jobs.index') }}" class="bg-white rounded-2xl p-2.5 border border-gray-200/80 shadow-xs flex flex-col md:flex-row items-stretch md:items-center gap-2 mb-6">
        <div class="flex-1 flex items-center px-3">
            <x-icon name="search" class="w-4 h-4 text-gray-400 mr-2.5 flex-shrink-0" />
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari jabatan, perusahaan, atau lokasi..."
                   class="w-full py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none">
        </div>

        <div class="hidden md:block w-px h-6 bg-gray-200"></div>

        <div class="px-2">
            <select name="job_type" class="w-full md:w-44 py-2 text-sm text-gray-700 bg-transparent focus:outline-none">
                <option value="">Kategori / jenis</option>
                <option value="Full-time" {{ request('job_type') == 'Full-time' ? 'selected' : '' }}>Penuh waktu</option>
                <option value="Part-time" {{ request('job_type') == 'Part-time' ? 'selected' : '' }}>Paruh waktu</option>
                <option value="Kontrak" {{ request('job_type') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                <option value="Magang" {{ request('job_type') == 'Magang' ? 'selected' : '' }}>Magang</option>
            </select>
        </div>

        <div class="hidden md:block w-px h-6 bg-gray-200"></div>

        <div class="px-2">
            <input type="date" name="deadline" value="{{ request('deadline') }}" class="w-full md:w-40 py-2 text-sm text-gray-700 bg-transparent focus:outline-none">
        </div>

        <button type="submit" class="px-7 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-full transition">
            Cari
        </button>
    </form>

    <!-- Job Type Filter Pills -->
    @php
        $jobTypes = ['Semua lowongan', 'Full-time', 'Kontrak', 'Magang'];
    @endphp
    <div class="flex flex-wrap items-center gap-2 mb-8">
        @foreach($jobTypes as $type)
            @php
                $isAll = $type === 'Semua lowongan';
                $isActive = $isAll ? !request('job_type') : request('job_type') === $type;
                $url = $isAll
                    ? route('site.jobs.index', request()->except('job_type', 'page'))
                    : route('site.jobs.index', array_merge(request()->except('page'), ['job_type' => $type]));
            @endphp
            <a href="{{ $url }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ $isActive ? 'bg-[#112F28] text-white' : 'bg-[#E3EAE5] text-[#112F28] hover:bg-[#D1E7DD]' }}">
                {{ $type === 'Full-time' ? 'Penuh waktu' : $type }}
            </a>
        @endforeach
    </div>

    <!-- Jobs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($jobs as $job)
            <a href="{{ route('site.jobs.show', $job->slug) }}"
               class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-xs hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <x-badge variant="success">{{ $job->job_type ?? 'Full-time' }}</x-badge>
                        @if(!empty($job->is_featured))
                            <x-badge variant="warning">Pilihan</x-badge>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 group-hover:text-[#112F28] transition mb-1">
                        {{ $job->title }}
                    </h2>
                    <p class="text-sm font-medium text-gray-600 mb-4">
                        {{ $job->company_name }}
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2 text-xs text-gray-500">
                    <div class="flex flex-wrap items-center gap-2">
                        <span>{{ $job->location ?? 'Kupang, NTT' }}</span>
                        <span>&bull;</span>
                        <span>{{ $job->education ?? 'SMA/SMK' }}</span>
                        <span>&bull;</span>
                        <span class="text-amber-700 font-medium">
                            Batas lamaran {{ !empty($job->deadline) ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : '-' }}
                        </span>
                    </div>
                    <span class="text-base font-bold text-[#112F28] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform">&nearr;</span>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-gray-100">
                <p class="text-gray-500 text-sm">Belum ada lowongan kerja aktif yang sesuai dengan pencarian Anda.</p>
                <a href="{{ route('site.jobs.index') }}" class="inline-block mt-4 text-xs font-semibold text-[#112F28] hover:underline">Tampilkan semua lowongan &rarr;</a>
            </div>
        @endforelse
    </div>

    <x-pagination :paginator="$jobs" />

    <p class="text-xs text-gray-400 mt-8">
        Hanya lowongan aktif yang ditampilkan. Lowongan kedaluwarsa disembunyikan otomatis.
    </p>
</div>
@endsection