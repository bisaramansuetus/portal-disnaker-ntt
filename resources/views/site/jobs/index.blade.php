@extends('layouts.site')
@section('title', 'Lowongan Kerja')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-6">Lowongan Kerja Aktif</h1>

        <form method="GET" class="bg-white rounded-lg shadow p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul lowongan..." class="border rounded px-3 py-2 md:col-span-2">
            <select name="job_type" class="border rounded px-3 py-2">
                <option value="">— Jenis —</option>
                @foreach (['Full-time', 'Part-time', 'Kontrak', 'Magang', 'Freelance'] as $jt)
                    <option value="{{ $jt }}" @selected(request('job_type')===$jt)>{{ $jt }}</option>
                @endforeach
            </select>
            <button class="bg-slate-800 text-white rounded px-4 py-2">Cari</button>
        </form>

        @if ($jobs->isEmpty())
            <p class="text-gray-500">Belum ada lowongan aktif saat ini.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($jobs as $job)
                    <a href="{{ route('site.jobs.show', $job->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg p-5 transition flex flex-col">
                        <p class="text-xs text-slate-500">{{ $job->company_name }}</p>
                        <h3 class="font-semibold text-lg mt-1 mb-2">{{ $job->title }}</h3>
                        <p class="text-sm text-gray-600">📍 {{ $job->location }}</p>
                        <p class="text-sm text-gray-600">🎓 {{ $job->education }}</p>
                        <p class="text-sm text-gray-600">💼 {{ $job->job_type }}</p>
                        <div class="mt-auto pt-3 text-xs text-slate-500 border-t mt-3">
                            Deadline: <strong>{{ $job->deadline->format('d M Y') }}</strong>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">{{ $jobs->links() }}</div>
        @endif
    </div>
@endsection