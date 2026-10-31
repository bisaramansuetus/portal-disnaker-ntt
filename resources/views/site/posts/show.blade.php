@extends('layouts.site')
@section('title', $post->meta_title ?: $post->title)
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->content), 150))
@section('meta_image', $post->image ? asset('storage/' . $post->image) : '')

@section('content')
    <article class="max-w-3xl mx-auto px-4 py-10">
        <a href="{{ route('site.posts.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        <p class="text-xs text-blue-600 mt-4 mb-1">{{ $post->category->name ?? 'Umum' }} • {{ $post->published_at?->format('d M Y') }}</p>
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="w-full rounded mb-6" alt="">
        @endif
        <div class="prose max-w-none text-gray-800 leading-relaxed">
            {!! $post->content !!}
        </div>

        @if ($related->isNotEmpty())
            <hr class="my-8">
            <h2 class="font-bold mb-3">Baca juga</h2>
            <ul class="space-y-2 text-sm">
                @foreach ($related as $r)
                    <li><a href="{{ route('site.posts.show', $r->slug) }}" class="text-blue-600 hover:underline">{{ $r->title }}</a></li>
                @endforeach
            </ul>
        @endif
    </article>
@endsection

@push('head')
@php
    $postSchema = [
        "@context" => "https://schema.org",
        "@type" => "NewsArticle",
        "headline" => $post->title,
        "datePublished" => $post->published_at?->toIso8601String(),
        "dateModified" => $post->updated_at->toIso8601String(),
        "author" => [
            "@type" => "Organization",
            "name" => \App\Models\SiteSetting::get('site_name', 'Disnaker NTT')
        ],
        "publisher" => [
            "@type" => "Organization",
            "name" => \App\Models\SiteSetting::get('site_name', 'Disnaker NTT')
        ]
    ];
    if ($post->image) {
        $postSchema["image"] = [asset('storage/' . $post->image)];
    }
@endphp
<script type="application/ld+json">
    {!! json_encode($postSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush