@extends('layouts.site')
@section('title', $pageTitle)

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-6">{{ $pageTitle }}</h1>

        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('site.posts.index') }}" class="text-xs px-3 py-1 rounded border {{ request()->routeIs('site.posts.index') ? 'bg-slate-800 text-white' : 'bg-white' }}">Semua Berita</a>
            @foreach ($categories as $c)
                <a href="{{ route('site.posts.category', $c->slug) }}" class="text-xs px-3 py-1 rounded border {{ ($category ?? null)?->id === $c->id ? 'bg-slate-800 text-white' : 'bg-white' }}">{{ $c->name }}</a>
            @endforeach
        </div>

        @if ($posts->isEmpty())
            <p class="text-gray-500">Belum ada konten.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($posts as $post)
                    <a href="{{ route('site.posts.show', $post->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg overflow-hidden transition">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-40 object-cover" alt="">
                        @endif
                        <div class="p-4">
                            <p class="text-xs text-blue-600 mb-1">{{ $post->category->name ?? 'Umum' }} • {{ $post->published_at?->format('d M Y') }}</p>
                            <h3 class="font-semibold line-clamp-2">{{ $post->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">{{ $posts->links() }}</div>
        @endif
    </div>
@endsection