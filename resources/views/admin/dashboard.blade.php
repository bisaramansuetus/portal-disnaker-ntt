@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Dashboard</h1>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @php
            $cards = [
                ['label' => 'Total Konten', 'value' => $stats['posts_total'], 'color' => 'bg-blue-500'],
                ['label' => 'Konten Terbit', 'value' => $stats['posts_published'], 'color' => 'bg-green-500'],
                ['label' => 'Lowongan Aktif', 'value' => $stats['jobs_active'], 'color' => 'bg-indigo-500'],
                ['label' => 'Total Lowongan', 'value' => $stats['jobs_total'], 'color' => 'bg-purple-500'],
                ['label' => 'Program', 'value' => $stats['programs_total'], 'color' => 'bg-orange-500'],
                ['label' => 'Kategori', 'value' => $stats['categories_total'], 'color' => 'bg-gray-500'],
            ];
        @endphp
        @foreach ($cards as $c)
            <div class="bg-white rounded-lg shadow p-4 border-l-4 {{ $c['color'] }}">
                <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $c['label'] }}</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">{{ $c['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-3 border-b flex items-center justify-between">
            <h2 class="font-semibold text-slate-800">Konten Terbaru</h2>
            <a href="{{ route('admin.posts.index') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y">
            @forelse ($recentPosts as $post)
                <div class="px-4 py-3 flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="font-medium text-slate-800 truncate">{{ $post->title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $post->type }} • {{ $post->category->name ?? '-' }}
                            • {{ $post->created_at->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $post->status }}
                    </span>
                </div>
            @empty
                <p class="p-4 text-center text-gray-500 text-sm">Belum ada konten.</p>
            @endforelse
        </div>
    </div>
@endsection