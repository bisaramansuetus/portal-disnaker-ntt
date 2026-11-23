@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <span>Informasi</span> / <span class="text-gray-900 font-medium">Kabar baik dari NTT</span>
    </nav>

    <!-- Page Header -->
    <div class="max-w-2xl mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Kabar baik dari NTT</h1>
        <p class="text-sm sm:text-base text-gray-600">Ikuti cerita, kegiatan, dan langkah bersama membangun masyarakat yang berdaya.</p>
    </div>

    <!-- Search & Filter Capsule Bar -->
    <form method="GET" action="{{ route('site.posts.index') }}" class="bg-white rounded-2xl p-2.5 border border-gray-200/80 shadow-xs flex flex-col md:flex-row items-stretch md:items-center gap-2 mb-6">
        <div class="flex-1 flex items-center px-3">
            <x-icon name="search" class="w-4 h-4 text-gray-400 mr-2.5 flex-shrink-0" />
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita atau kata kunci..."
                   class="w-full py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none">
        </div>

        <div class="hidden md:block w-px h-6 bg-gray-200"></div>

        <div class="px-2">
            <select name="category" class="w-full md:w-44 py-2 text-sm text-gray-700 bg-transparent focus:outline-none">
                <option value="">Kategori / jenis</option>
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="hidden md:block w-px h-6 bg-gray-200"></div>

        <div class="px-2">
            <input type="month" name="month" value="{{ request('month') }}" class="w-full md:w-40 py-2 text-sm text-gray-700 bg-transparent focus:outline-none">
        </div>

        <button type="submit" class="px-7 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-full transition">
            Cari
        </button>
    </form>

    <!-- Category Pills -->
    <div class="flex flex-wrap items-center gap-2 mb-8">
        <a href="{{ route('site.posts.index') }}"
           class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ !request('category') ? 'bg-[#112F28] text-white' : 'bg-[#E3EAE5] text-[#112F28] hover:bg-[#D1E7DD]' }}">
            Semua berita
        </a>
        @foreach($categories ?? [] as $cat)
            <a href="{{ route('site.posts.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ request('category') == $cat->slug ? 'bg-[#112F28] text-white' : 'bg-[#E3EAE5] text-[#112F28] hover:bg-[#D1E7DD]' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
            <x-site.card-news :post="$post" />
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100">
                <p class="text-gray-500 text-sm">Belum ada berita atau artikel yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="{{ route('site.posts.index') }}" class="inline-block mt-4 text-xs font-semibold text-[#112F28] hover:underline">Reset pencarian &rarr;</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <x-pagination :paginator="$posts" />
</div>
@endsection