@extends('layouts.site')
@section('title', $program->title)

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10">
        <a href="{{ route('site.programs.index') }}" class="text-sm text-blue-600 hover:underline">← Semua program</a>

        <div class="bg-white rounded-lg shadow p-6 mt-4">
            <p class="text-xs uppercase font-semibold text-orange-600 mb-1">{{ $program->type }}</p>
            <h1 class="text-2xl font-bold mb-3">{{ $program->title }}</h1>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                @if ($program->start_date)
                    <div><dt class="text-gray-500">Jadwal</dt><dd class="font-medium">{{ $program->start_date->format('d M Y') }} – {{ $program->end_date?->format('d M Y') ?? '-' }}</dd></div>
                @endif
                @if ($program->schedule_info)
                    <div><dt class="text-gray-500">Waktu</dt><dd class="font-medium">{{ $program->schedule_info }}</dd></div>
                @endif
                @if ($program->quota)
                    <div><dt class="text-gray-500">Kuota</dt><dd class="font-medium">{{ $program->quota }}</dd></div>
                @endif
                @if ($program->fee !== null)
                    <div><dt class="text-gray-500">Biaya</dt><dd class="font-medium">{{ $program->fee > 0 ? 'Rp '.number_format($program->fee, 0, ',', '.') : 'Gratis' }}</dd></div>
                @endif
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mt-4">
            <h2 class="font-bold text-lg mb-2">Deskripsi</h2>
            <div class="prose max-w-none">{!! $program->description !!}</div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mt-4">
            <h2 class="font-bold text-lg mb-2">Persyaratan</h2>
            <div class="prose max-w-none">{!! $program->requirements !!}</div>
        </div>

        @if ($program->registration_url)
            <div class="mt-4">
                <a href="{{ $program->registration_url }}" target="_blank" rel="noopener" class="inline-block bg-slate-800 text-white px-5 py-2 rounded hover:bg-slate-900">Daftar Sekarang (Eksternal) →</a>
            </div>
        @endif
    </div>
@endsection