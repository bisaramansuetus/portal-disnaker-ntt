@extends('layouts.site')

@section('content')
<!-- Hero Section (Split Layout) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-[#112F28] rounded-3xl p-8 md:p-12 text-white shadow-xl">
        <!-- Kolom Teks Kiri -->
        <div class="lg:col-span-7 space-y-6">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-[#D1E7DD] text-[#112F28]">
                Portal Resmi Pemerintah Provinsi NTT
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                Langkah baru, masa depan lebih baik.
            </h1>
            <p class="text-base sm:text-lg text-gray-200 max-w-xl leading-relaxed">
                Temukan peluang kerja, kembangkan keterampilan melalui pelatihan vokasi, dan akses layanan publik dalam satu tempat.
            </p>
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="{{ route('site.jobs.index') }}" class="px-6 py-3 bg-[#D1E7DD] hover:bg-[#A3CFBB] text-[#112F28] font-semibold rounded-xl transition shadow">
                    Temukan peluang &rarr;
                </a>
                <a href="{{ route('site.programs.index') }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition border border-white/20">
                    Kenali program kami
                </a>
            </div>
        </div>
        <!-- Kolom Gambar Kanan -->
        <div class="lg:col-span-5">
            <div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 h-72 md:h-80">
                @php
                    $heroImg = \App\Models\SiteSetting::get('hero_image_1');
                    $imgSrc = $heroImg ? asset('storage/' . $heroImg) : 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80';
                @endphp
                <img src="{{ $imgSrc }}" alt="Pelatihan Disnakertrans NTT" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Quick Links (Layanan Cepat) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('site.jobs.index') }}" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
            <p class="text-sm font-medium text-gray-500 mb-1">Peluang Kerja</p>
            <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#112F28]">Cari pekerjaan</h3>
        </a>
        <a href="{{ route('site.programs.index') }}" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
            <p class="text-sm font-medium text-gray-500 mb-1">Vokasi & Keahlian</p>
            <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#112F28]">Ikuti pelatihan</h3>
        </a>
        <a href="{{ route('site.ppid.profile') }}" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
            <p class="text-sm font-medium text-gray-500 mb-1">Transparansi Informasi</p>
            <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#112F28]">Layanan PPID</h3>
        </a>
        <a href="{{ route('site.complaints.create') }}" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition group">
            <p class="text-sm font-medium text-gray-500 mb-1">Suara Masyarakat</p>
            <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#112F28]">Sampaikan aduan</h3>
        </a>
    </div>
</section>

<!-- Berita & Kabar Terbaru -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Cerita dan kabar terbaru</h2>
            <p class="text-sm text-gray-600 mt-1">Ikuti kegiatan, pengumuman, dan langkah bersama membangun masyarakat berdaya.</p>
        </div>
        <a href="{{ route('site.posts.index') }}" class="hidden sm:inline-flex items-center font-semibold text-[#112F28] hover:underline text-sm">
            Lihat semua berita &rarr;
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($latestBerita ?? [] as $post)
            <x-site.card-news :post="$post" />
        @empty
            <p class="text-gray-500 col-span-3 text-center py-10">Belum ada berita terbaru.</p>
        @endforelse
    </div>
</section>

<!-- Lowongan Kerja (Tambahan dari kita agar sesuai PDF) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-[#E3EAE5] rounded-3xl p-8 md:p-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Peluang baik menanti Anda.</h2>
                <p class="text-sm text-gray-600 mt-1">Temukan pekerjaan yang sesuai dengan potensi Anda.</p>
            </div>
            <a href="{{ route('site.jobs.index') }}" class="hidden sm:inline-flex items-center font-semibold text-[#112F28] hover:underline text-sm">
                Lihat semua lowongan &rarr;
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($featuredJobs ?? [] as $job)
                <a href="{{ route('site.jobs.show', $job->slug) }}" class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition group flex flex-col h-full">
                    <h3 class="font-bold text-xl text-gray-900 mb-1 group-hover:text-[#112F28]">{{ $job->title }}</h3>
                    <p class="text-sm font-medium text-gray-600 mb-2">{{ $job->company_name }}</p>
                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-red-600">Batas {{ $job->deadline->format('d M Y') }}</span>
                    </div>
                </a>
            @empty
                <p class="text-gray-500 col-span-3 text-center">Belum ada lowongan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Program & Pelatihan -->
        {{-- 5. BELAJAR & BERTUMBUH (Program) --}}
        <section class="mt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <p class="text-xs font-bold text-[#112F28] uppercase tracking-widest mb-2">Belajar dan bertumbuh</p>
                    <h2 class="text-3xl font-bold text-gray-900">Upgrade kemampuan Anda</h2>
                </div>
                <a href="{{ route('site.programs.index') }}" class="text-sm font-bold text-[#112F28] flex items-center gap-1 hover:underline">
                    Semua program <x-icon name="arrow-right" class="w-4 h-4" />
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($featuredPrograms as $program)
                    <a href="{{ route('site.programs.show', $program->slug) }}" class="flex flex-col md:flex-row bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition group h-full">
                        {{-- Bagian Gambar --}}
                        <div class="w-full md:w-2/5 h-48 md:h-auto bg-gray-200 relative">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $program->title }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="{{ $program->title }}">
                            @endif
                        </div>
                        
                        {{-- Bagian Teks & Badge --}}
                        <div class="p-6 w-full md:w-3/5 flex flex-col justify-center">
                            <h3 class="font-bold text-xl text-gray-900 leading-tight mb-2 group-hover:text-[#112F28] transition">{{ $program->title }}</h3>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ Str::limit(strip_tags($program->description), 80) }}</p>
                            
                            {{-- Badge Warna-warni --}}
                            <div class="flex flex-wrap items-center gap-2 text-xs mb-4">
                                <span class="px-2.5 py-1 rounded-md font-semibold bg-[#DBEAFE] text-[#1D4ED8]">{{ $program->quota ?? '30' }} peserta</span>
                                <span class="px-2.5 py-1 rounded-md font-semibold bg-[#DCFCE7] text-[#15803D]">{{ $program->fee == 0 ? 'Gratis' : 'Rp '.number_format($program->fee, 0, ',', '.') }}</span>
                                <span class="px-2.5 py-1 rounded-md font-semibold bg-[#F3F4F6] text-[#374151]">Kupang</span>
                            </div>

                            <span class="text-sm font-bold text-[#112F28] flex items-center gap-1">Lihat program <x-icon name="arrow-right" class="w-4 h-4" /></span>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 col-span-2 text-center py-10">Belum ada program.</p>
                @endforelse
            </div>
        </section>

<!-- CTA Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mb-12">
    <div class="bg-[#FAFAF6] border border-gray-200 rounded-3xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
        <h2 class="text-3xl font-bold text-[#112F28] md:w-1/3 leading-tight">Hadir untuk NTT yang lebih berdaya.</h2>
        <div class="md:w-2/3">
            <p class="text-gray-600 mb-6 text-base leading-relaxed">
                DISNAKERTRANS NTT mendampingi masyarakat dalam ketenagakerjaan, pengembangan kompetensi, dan transmigrasi. Semua informasi dan layanan dapat diakses tanpa akun.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('site.profile') }}" class="px-6 py-3 bg-[#112F28] text-white font-semibold rounded-xl hover:bg-[#1B4A40] transition">Kenali Dinas</a>
                <a href="{{ route('site.announcements.index') }}" class="px-6 py-3 bg-white border border-gray-200 text-[#112F28] font-semibold rounded-xl hover:bg-gray-50 transition">Pengumuman</a>
            </div>
        </div>
    </div>
</section>
@endsection