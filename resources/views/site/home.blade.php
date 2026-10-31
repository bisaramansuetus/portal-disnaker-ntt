@extends('layouts.site')
@section('title', \App\Models\SiteSetting::get('site_name', 'Disnaker NTT').' — '.\App\Models\SiteSetting::get('site_tagline', 'Portal Informasi Publik'))

@section('content')
    {{-- HERO SECTION DENGAN SLIDER --}}
    <section class="relative bg-slate-800 text-white overflow-hidden">
        
        {{-- LOGIKA GAMBAR SLIDER --}}
        @php
            $heroImages = [];
            for ($i = 1; $i <= 5; $i++) {
                $img = \App\Models\SiteSetting::get("hero_image_$i");
                if ($img) $heroImages[] = asset('storage/' . $img);
            }
        @endphp

        @if(count($heroImages) > 0)
            {{-- Render Gambar Background --}}
            <div class="absolute inset-0 z-0">
                @foreach($heroImages as $index => $img)
                    <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" style="background-image: url('{{ $img }}');"></div>
                @endforeach
                {{-- Lapisan Gelap (Overlay) agar teks tetap terbaca --}}
                <div class="absolute inset-0 bg-slate-900 bg-opacity-75"></div>
            </div>
        @else
            {{-- Fallback jika belum ada gambar --}}
            <div class="absolute inset-0 bg-gradient-to-r from-slate-800 to-slate-700 z-0"></div>
        @endif

        {{-- KONTEN TEKS --}}
        <div class="relative z-10 max-w-6xl mx-auto px-4 py-20 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-lg">{{ \App\Models\SiteSetting::get('site_name', 'Disnaker NTT') }}</h1>
            <p class="text-lg md:text-xl text-slate-200 max-w-2xl mx-auto mb-8 drop-shadow-md">{{ \App\Models\SiteSetting::get('site_tagline', 'Portal Informasi Publik') }}</p>
            <div class="flex gap-3 justify-center flex-wrap">
                <a href="{{ route('site.jobs.index') }}" class="bg-white text-slate-800 px-6 py-3 rounded-lg font-semibold hover:bg-slate-100 transition shadow">Cari Lowongan</a>
                <a href="{{ route('site.programs.index') }}" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-slate-700 transition shadow">Lihat Program</a>
            </div>
        </div>
    </section>

    {{-- BERITA TERBARU --}}
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Berita Terbaru</h2>
            <a href="{{ route('site.posts.index') }}" class="text-blue-600 hover:underline text-sm">Lihat semua</a>
        </div>
        @if ($latestBerita->isEmpty())
            <p class="text-gray-500">Belum ada berita.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($latestBerita as $post)
                    <a href="{{ route('site.posts.show', $post->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg overflow-hidden transition">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-40 object-cover" alt="">
                        @endif
                        <div class="p-4">
                            <p class="text-xs text-blue-600 mb-1">{{ $post->category->name ?? 'Berita' }} • {{ $post->published_at?->format('d M Y') }}</p>
                            <h3 class="font-semibold line-clamp-2">{{ $post->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    {{-- PENGUMUMAN --}}
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Pengumuman</h2>
            <a href="{{ route('site.announcements.index') }}" class="text-blue-600 hover:underline text-sm">Lihat semua</a>
        </div>
        @if ($latestPengumuman->isEmpty())
            <p class="text-gray-500">Belum ada pengumuman.</p>
        @else
            <div class="bg-white rounded-lg shadow divide-y">
                @foreach ($latestPengumuman as $post)
                    <a href="{{ route('site.posts.show', $post->slug) }}" class="block px-4 py-3 hover:bg-gray-50">
                        <p class="font-medium">{{ $post->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $post->published_at?->format('d M Y') }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    {{-- LOWONGAN --}}
    <section class="bg-gray-100 py-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold">Lowongan Kerja</h2>
                <a href="{{ route('site.jobs.index') }}" class="text-blue-600 hover:underline text-sm">Lihat semua</a>
            </div>
            @if ($featuredJobs->isEmpty())
                <p class="text-gray-500">Belum ada lowongan aktif.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($featuredJobs as $job)
                        <a href="{{ route('site.jobs.show', $job->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg p-4 transition">
                            <p class="text-xs text-slate-500">{{ $job->company_name }}</p>
                            <h3 class="font-semibold mt-1 mb-2">{{ $job->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">📍 {{ $job->location }}</p>
                            <p class="text-xs text-slate-500">Deadline: {{ $job->deadline->format('d M Y') }}</p>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- PROGRAM --}}
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Program & Pelatihan</h2>
            <a href="{{ route('site.programs.index') }}" class="text-blue-600 hover:underline text-sm">Lihat semua</a>
        </div>
        @if ($featuredPrograms->isEmpty())
            <p class="text-gray-500">Belum ada program.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($featuredPrograms as $program)
                    <a href="{{ route('site.programs.show', $program->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg p-4 transition">
                        <p class="text-xs uppercase text-orange-600 font-semibold">{{ $program->type }}</p>
                        <h3 class="font-semibold mt-1 mb-2">{{ $program->title }}</h3>
                        @if ($program->start_date)
                            <p class="text-sm text-gray-600">📅 {{ $program->start_date->format('d M Y') }} – {{ $program->end_date?->format('d M Y') ?? '-' }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        
        // Hanya jalankan slider jika gambar lebih dari 1
        if (slides.length > 1) {
            let currentSlide = 0;
            const slideInterval = 5000; // 5000 ms = 5 detik

            setInterval(() => {
                // Sembunyikan gambar saat ini
                slides[currentSlide].classList.remove('opacity-100');
                slides[currentSlide].classList.add('opacity-0');

                // Pindah ke gambar berikutnya (kembali ke 0 jika sudah di ujung)
                currentSlide = (currentSlide + 1) % slides.length;

                // Tampilkan gambar baru
                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100');
            }, slideInterval);
        }
    });
</script>
@endpush