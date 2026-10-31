@extends('layouts.site')

@section('title', $page?->meta_title ?: $pageTitle)
@section('meta_description', $page?->meta_description ?: Str::limit(strip_tags($page?->content ?? ''), 150))

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-6">{{ $page->title ?? $pageTitle }}</h1>

        @if ($page)
           
            <div class="prose max-w-none text-gray-800 leading-relaxed">
                {!! $page->content !!}
            </div>
            @if ($page->image)
                <img src="{{ asset('storage/' . $page->image) }}" alt=""
                     class="w-full rounded-lg shadow mb-6">
            @endif
            <p class="text-xs text-gray-400 mt-8">
                Terakhir diperbarui: {{ $page->updated_at->translatedFormat('d F Y') }}
            </p>
             
        @else
            <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded p-4">
                Konten halaman belum tersedia. Admin dapat mengisinya melalui Panel Admin → Berita & Pengumuman → Konten dengan tipe <strong>Halaman</strong> dan slug <code>profil-dinas</code>.
            </div>
        @endif
    </div>
@endsection