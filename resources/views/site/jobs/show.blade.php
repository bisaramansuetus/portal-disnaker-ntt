@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> /
        <a href="{{ route('site.jobs.index') }}" class="hover:underline">Lowongan</a> /
        <span class="text-gray-900 font-medium">{{ $job->title }}</span>
    </nav>

    <!-- Job Title Header -->
    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
            {{ $job->title }}
        </h1>
        <p class="text-base text-gray-600 mb-4">
            <strong class="text-gray-900">{{ $job->company_name }}</strong> &bull; {{ $job->location ?? 'Kupang, Nusa Tenggara Timur' }}
        </p>
        @if($job->isClosed())
            <x-badge variant="danger">Pendaftaran Ditutup</x-badge>
        @else
            <x-badge variant="success">Pendaftaran Buka</x-badge>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Kolom Kiri: Detail Pekerjaan -->
        <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-xs space-y-8">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-3">Tentang pekerjaan</h2>
                <div class="text-sm sm:text-base text-gray-600 leading-relaxed prose max-w-none">
                    {!! $job->description !!}
                </div>
            </div>

            @if(!empty($job->requirements))
                <div class="pt-6 border-t border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Persyaratan</h2>
                    <div class="text-sm text-gray-600 leading-relaxed prose max-w-none">
                        {!! nl2br(e($job->requirements)) !!}
                    </div>
                </div>
            @endif

            <div class="pt-6 border-t border-gray-100">
                <a href="{{ route('site.jobs.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-full bg-[#E3EAE5] hover:bg-[#D1E7DD] text-[#112F28] text-xs font-semibold transition">
                    &larr; Kembali ke lowongan kerja
                </a>
            </div>
        </div>

        <!-- Kolom Kanan: Langkah Anda Berikutnya -->
        <aside class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xs space-y-6">
            <h2 class="text-lg font-bold text-gray-900">Langkah Anda berikutnya</h2>

            <div class="space-y-4 text-sm">
                <div class="pb-3 border-b border-gray-100">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">Jenis Pekerjaan</span>
                    <span class="font-semibold text-gray-900 mt-0.5 block">{{ $job->job_type ?? 'Full-time' }}</span>
                </div>

                <div class="pb-3 border-b border-gray-100">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">Pendidikan</span>
                    <span class="font-semibold text-gray-900 mt-0.5 block">{{ $job->education ?? 'Minimal SMA/SMK' }}</span>
                </div>

                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">Batas Lamaran</span>
                    <span class="font-semibold text-gray-900 mt-0.5 block">
                        {{ !empty($job->deadline) ? \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') : '-' }}
                    </span>
                </div>
            </div>

            <div class="pt-2 space-y-3">
                @if(!empty($job->application_url))
                    <a href="{{ $job->application_url }}" target="_blank" rel="noopener noreferrer"
                       class="w-full inline-flex items-center justify-center px-5 py-3 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl transition">
                        Lamar di situs perusahaan &nearr;
                    </a>
                @else
                    <a href="{{ route('site.contact') }}"
                       class="w-full inline-flex items-center justify-center px-5 py-3 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl transition">
                        Hubungi petugas penempatan &nearr;
                    </a>
                @endif

                <p class="text-xs text-gray-400 leading-relaxed">
                    Anda akan diarahkan ke tautan eksternal perusahaan penyelenggara. Tidak perlu akun di portal ini.
                </p>
            </div>
        </aside>
    </div>
</div>
@endsection