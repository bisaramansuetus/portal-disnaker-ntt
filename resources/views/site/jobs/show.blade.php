@extends('layouts.site')
@section('title', $job->title.' — '.$job->company_name)

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10">
        <a href="{{ route('site.jobs.index') }}" class="text-sm text-blue-600 hover:underline">← Semua lowongan</a>

        <div class="bg-white rounded-lg shadow p-6 mt-4">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h1 class="text-2xl font-bold">{{ $job->title }}</h1>
                    <p class="text-slate-600">{{ $job->company_name }} • {{ $job->location }}</p>
                </div>
                @if ($job->isClosed())
                    <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded">Ditutup</span>
                @else
                    <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded">Aktif</span>
                @endif
            </div>

            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-6 text-sm">
                <div><dt class="text-gray-500">Jenis</dt><dd class="font-medium">{{ $job->job_type }}</dd></div>
                <div><dt class="text-gray-500">Pendidikan</dt><dd class="font-medium">{{ $job->education }}</dd></div>
                <div><dt class="text-gray-500">Deadline</dt><dd class="font-medium">{{ $job->deadline->format('d M Y') }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mt-4">
            <h2 class="font-bold text-lg mb-2">Deskripsi</h2>
            <div class="prose max-w-none">{!! $job->description !!}</div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mt-4">
            <h2 class="font-bold text-lg mb-2">Persyaratan</h2>
            <div class="prose max-w-none">{!! $job->requirements !!}</div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mt-4">
            <h2 class="font-bold text-lg mb-2">Cara Melamar</h2>
            @if ($job->application_url)
                @if (str_starts_with($job->application_url, 'http'))
                    <a href="{{ $job->application_url }}" target="_blank" rel="noopener" class="inline-block bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">Lamar Sekarang →</a>
                @else
                    <p>Kirim lamaran ke: <strong>{{ $job->application_url }}</strong></p>
                @endif
            @else
                <p class="text-gray-500">Informasi cara melamar belum tersedia.</p>
            @endif
        </div>

        @if ($others->isNotEmpty())
            <div class="mt-8">
                <h3 class="font-bold mb-3">Lowongan Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach ($others as $o)
                        <a href="{{ route('site.jobs.show', $o->slug) }}" class="bg-white rounded shadow p-3 hover:shadow-lg">
                            <p class="font-medium text-sm">{{ $o->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $o->company_name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@push('head')
@php
    $jobSchema = [
        "@context" => "https://schema.org/",
        "@type" => "JobPosting",
        "title" => $job->title,
        "description" => strip_tags($job->description),
        "datePosted" => $job->published_at?->toIso8601String(),
        "validThrough" => $job->deadline->endOfDay()->toIso8601String(),
        "employmentType" => strtoupper(str_replace('-', '_', $job->job_type)),
        "hiringOrganization" => [
            "@type" => "Organization",
            "name" => $job->company_name
        ],
        "jobLocation" => [
            "@type" => "Place",
            "address" => [
                "@type" => "PostalAddress",
                "addressLocality" => $job->location,
                "addressRegion" => "Nusa Tenggara Timur",
                "addressCountry" => "ID"
            ]
        ],
        "educationRequirements" => $job->education
    ];
@endphp
<script type="application/ld+json">
    {!! json_encode($jobSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush