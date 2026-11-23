@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Hero Image Banner -->
    @if(!empty($post->image))
        <div class="w-full h-64 sm:h-80 md:h-[420px] rounded-3xl overflow-hidden shadow-sm mb-8 bg-gray-200">
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> /
        <a href="{{ route('site.posts.index') }}" class="hover:underline">Informasi</a> /
        <span class="text-gray-900 font-medium line-clamp-1 inline">{{ $post->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <!-- Main Article Column -->
        <article class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-xs">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                {{ $post->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 pb-6 mb-6 border-b border-gray-100">
                <x-badge variant="success">{{ $post->category->name ?? 'Ketenagakerjaan' }}</x-badge>
                <span>{{ \Carbon\Carbon::parse($post->published_at ?? $post->created_at)->translatedFormat('d F Y') }}</span>
                <span>&bull;</span>
                <span>Oleh {{ $post->author->name ?? 'Tim Publikasi' }}</span>
            </div>

            <!-- Konten HTML dari TinyMCE -->
            <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed space-y-4">
                {!! $post->content !!}
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('site.posts.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-full bg-[#E3EAE5] hover:bg-[#D1E7DD] text-[#112F28] text-xs font-semibold transition">
                    &larr; Kembali ke berita
                </a>
            </div>
        </article>

        <!-- Sidebar "Baca juga" -->
        <aside class="lg:col-span-4 space-y-4">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-xs">
                <h2 class="text-base font-bold text-gray-900 mb-4">Baca juga</h2>
                <div class="space-y-4 divide-y divide-gray-100">
                    @forelse($related ?? [] as $rel)
                        <div class="pt-4 first:pt-0">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block mb-1">
                                {{ $rel->category->name ?? 'Kabar NTT' }}
                            </span>
                            <h3 class="text-sm font-bold text-gray-900 hover:text-[#112F28] leading-snug mb-1.5">
                                <a href="{{ route('site.posts.show', $rel->slug) }}">{{ $rel->title }}</a>
                            </h3>
                            <span class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($rel->published_at ?? $rel->created_at)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400">Tidak ada artikel terkait lainnya.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection