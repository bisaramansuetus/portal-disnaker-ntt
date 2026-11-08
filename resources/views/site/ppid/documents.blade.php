@extends('layouts.site')
@section('title', 'Informasi Publik (PPID)')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-sm border-t-4 border-ntt-gold p-8 md:p-12">
            <h1 class="text-3xl font-bold text-ntt-red font-serif mb-2">Daftar Informasi Publik</h1>
            <p class="text-gray-600 mb-8 border-b pb-4">Sesuai dengan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.</p>

            @foreach($categories as $cat)
                @if(isset($documents[$cat]))
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-slate-800 mb-4 bg-gray-100 p-3 rounded">{{ $cat }}</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left border">
                                <thead class="bg-slate-800 text-white">
                                    <tr>
                                        <th class="px-4 py-3">Nama Dokumen</th>
                                        <th class="px-4 py-3 w-32 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($documents[$cat] as $doc)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">{{ $doc->title }}</td>
                                            <td class="px-4 py-3 text-center space-x-2 whitespace-nowrap">
                                                
                                                {{-- TOMBOL BACA / LIHAT (Buka di Tab Baru) --}}
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" rel="noopener" 
                                                   class="inline-block border border-blue-600 text-blue-600 px-3 py-1 rounded text-xs hover:bg-blue-50 transition font-semibold">
                                                    👁️ Baca
                                                </a>

                                                {{-- TOMBOL UNDUH --}}
                                                <a href="{{ route('site.ppid.download', $doc) }}" 
                                                   class="inline-block bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition font-semibold">
                                                    ⬇ Unduh
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection