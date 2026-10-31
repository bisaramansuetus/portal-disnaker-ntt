@extends('layouts.site')
@section('title', $pageTitle)

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-6">{{ $pageTitle }}</h1>

        @if ($pageTitle === 'Program & Pelatihan')
            <form method="GET" class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari program..." class="border rounded px-3 py-2 md:col-span-2">
                <select name="type" class="border rounded px-3 py-2">
                    <option value="">— Semua Tipe —</option>
                    <option value="program" @selected(request('type')==='program')>Program</option>
                    <option value="pelatihan" @selected(request('type')==='pelatihan')>Pelatihan</option>
                </select>
            </form>
        @endif

        @if ($programs->isEmpty())
            <p class="text-gray-500">Belum ada program tersedia.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($programs as $p)
                    <a href="{{ route('site.programs.show', $p->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg p-5 transition flex flex-col">
                        <p class="text-xs uppercase font-semibold text-orange-600">{{ $p->type }}</p>
                        <h3 class="font-semibold text-lg mt-1 mb-2">{{ $p->title }}</h3>
                        @if ($p->start_date)
                            <p class="text-sm text-gray-600">📅 {{ $p->start_date->format('d M Y') }} – {{ $p->end_date?->format('d M Y') ?? '-' }}</p>
                        @endif
                        @if ($p->schedule_info)
                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $p->schedule_info }}</p>
                        @endif
                        @if ($p->quota)
                            <p class="text-xs text-slate-500 mt-auto pt-3">Kuota: {{ $p->quota }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
            <div class="mt-6">{{ $programs->links() }}</div>
        @endif
    </div>
@endsection