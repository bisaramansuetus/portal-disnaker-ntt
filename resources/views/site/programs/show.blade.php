@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> /
        <a href="{{ route('site.programs.index') }}" class="hover:underline">Informasi</a> /
        <span class="text-gray-900 font-medium">{{ $program->title }}</span>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
            {{ $program->title }}
        </h1>
        <p class="text-base text-gray-600 mb-4">
            UPTD Pelatihan Kerja Kupang &bull; Kupang, Nusa Tenggara Timur
        </p>
        <x-badge variant="success">Pendaftaran dibuka</x-badge>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Kolom Kiri -->
        <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-xs space-y-8">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-3">Tentang program</h2>
                <div class="text-sm sm:text-base text-gray-600 leading-relaxed prose max-w-none">
                    {!! $program->description !!}
                </div>
            </div>

            @if(!empty($program->requirements))
                <div class="pt-6 border-t border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Persyaratan</h2>
                    <div class="text-sm text-gray-600 leading-relaxed prose max-w-none">
                        {!! nl2br(e($program->requirements)) !!}
                    </div>
                </div>
            @endif

            <div class="pt-6 border-t border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-3">Tahapan kegiatan</h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Pendaftaran &rarr; Verifikasi berkas &rarr; Seleksi peserta &rarr; Pembekalan &rarr; Pelaksanaan program dan pendampingan.
                </p>
            </div>

            <div class="pt-6 border-t border-gray-100">
                <a href="{{ route('site.programs.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-full bg-[#E3EAE5] hover:bg-[#D1E7DD] text-[#112F28] text-xs font-semibold transition">
                    &larr; Kembali ke daftar program
                </a>
            </div>
        </div>

        <!-- Kolom Kanan: Langkah Anda Berikutnya -->
        <aside class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xs space-y-6">
            <h2 class="text-lg font-bold text-gray-900">Langkah Anda berikutnya</h2>

            <div class="space-y-4 text-sm">
                <div class="pb-3 border-b border-gray-100">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">Kuota & Biaya</span>
                    <span class="font-semibold text-gray-900 mt-0.5 block">
                        {{ $program->quota ?? '30' }} peserta &bull; {{ $program->fee == 0 ? 'Gratis' : 'Rp '.number_format($program->fee, 0, ',', '.') }}
                    </span>
                </div>

                <div class="pb-3 border-b border-gray-100">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">Jadwal Pelaksanaan</span>
                    <span class="font-semibold text-gray-900 mt-0.5 block">
                        {{ $program->schedule_info ?? 'Jadwal menyusul' }}
                    </span>
                </div>
            </div>

            <div class="pt-2 space-y-3">
                @if(!empty($program->registration_url))
                    <a href="{{ $program->registration_url }}" target="_blank" rel="noopener noreferrer"
                       class="w-full inline-flex items-center justify-center px-5 py-3 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl transition">
                        Daftar di situs penyelenggara &nearr;
                    </a>
                @else
                    <a href="{{ route('site.contact') }}"
                       class="w-full inline-flex items-center justify-center px-5 py-3 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl transition">
                        Informasi pendaftaran &nearr;
                    </a>
                @endif
            </div>
        </aside>
    </div>
</div>
@endsection