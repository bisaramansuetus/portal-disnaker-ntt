@extends('layouts.site')

@section('title', $page?->meta_title ?: $pageTitle)
@section('meta_description', $page?->meta_description ?: Str::limit(strip_tags($page?->content ?? ''), 150))

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-12">
        
        <div class="bg-white rounded-xl shadow-sm border-t-4 border-ntt-gold p-8 md:p-12">
            <h1 class="text-3xl md:text-4xl font-bold text-ntt-red mb-8 font-serif">{{ $page->title ?? $pageTitle }}</h1>

            @if ($page)
                {{-- Class 'prose' dari Tailwind akan otomatis memformat teks, kita tinggal override warnanya sedikit --}}
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed 
                            prose-headings:text-ntt-red prose-headings:font-serif 
                            prose-hr:border-ntt-gold">
                    {!! $page->content !!}
                </div>

                @if ($page->image)
                    <div class="mt-10 pt-8 border-t-2 border-dashed border-gray-200">
                        <img src="{{ asset('storage/' . $page->image) }}" alt="Struktur Organisasi" class="w-full rounded-lg shadow-md">
                    </div>
                @endif

                <p class="text-xs text-gray-400 mt-12 pt-4 border-t border-gray-100">
                    Terakhir diperbarui: {{ $page->updated_at->translatedFormat('d F Y') }}
                </p>
            @else
                <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded p-4">
                    Konten halaman belum tersedia.
                </div>
            @endif
        </div>

    </div>
@endsection