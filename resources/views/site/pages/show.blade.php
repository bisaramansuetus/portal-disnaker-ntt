@extends('layouts.site')

@section('title', $page?->meta_title ?: $pageTitle)
@section('meta_description', $page?->meta_description ?: Str::limit(strip_tags($page?->content ?? ''), 150))

@section('content')
    @php
        // Mengambil logo dari pengaturan admin
        $logo = \App\Models\SiteSetting::get('logo_path');
    @endphp

    <div class="max-w-5xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-sm border-t-4 border-ntt-gold p-8 md:p-12 relative overflow-hidden">
            
            {{-- WATERMARK LOGO DI LATAR BELAKANG --}}
            @if ($logo)
                <div class="absolute inset-0 z-0 opacity-[0.04] pointer-events-none bg-center bg-no-repeat" 
                     style="background-image: url('{{ asset('storage/' . $logo) }}'); background-size: 70%;">
                </div>
            @endif

            {{-- KONTEN UTAMA (Z-10 agar berada di atas watermark) --}}
            <div class="relative z-10">
                
                {{-- HEADER: KOTAK LOGO & JUDUL --}}
                <div class="flex items-center gap-5 md:gap-6 mb-10 pb-6 border-b border-gray-200">
                    
                    {{-- Kotak Logo --}}
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-white border-2 border-gray-100 rounded-xl flex items-center justify-center p-2 shadow-sm shrink-0">
                        @if ($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo Dinas" class="w-full h-full object-contain">
                        @else
                            <span class="text-[10px] text-gray-400 text-center leading-tight">Belum ada<br>logo</span>
                        @endif
                    </div>
                    
                    {{-- Judul Halaman --}}
                    <h1 class="text-3xl md:text-4xl font-bold text-ntt-red font-serif leading-tight">
                        {{ $page->title ?? $pageTitle }}
                    </h1>
                </div>

                {{-- ISI KONTEN --}}
                @if ($page)
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed 
                                prose-headings:text-ntt-red prose-headings:font-serif 
                                prose-hr:border-ntt-gold">
                        {!! $page->content !!}
                    </div>

                    {{-- GAMBAR STRUKTUR (JIKA ADA) --}}
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
    </div>
@endsection