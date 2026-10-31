@extends('layouts.site')
@section('title', 'Hasil Pelacakan')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="mb-4">
            <a href="{{ route('site.complaints.track') }}" class="text-blue-600 hover:underline text-sm">← Lacak Tiket Lain</a>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 {{ $complaint->status == 'selesai' ? 'border-green-500' : ($complaint->status == 'proses' ? 'border-yellow-500' : 'border-red-500') }}">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-6 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Nomor Tiket</p>
                        <h2 class="text-2xl font-mono font-bold text-slate-800">{{ $complaint->ticket_number }}</h2>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Status Saat Ini</p>
                        @if($complaint->status == 'pending')
                            <span class="inline-block bg-red-100 text-red-700 font-bold px-4 py-1 rounded-full text-sm">Menunggu Verifikasi</span>
                        @elseif($complaint->status == 'proses')
                            <span class="inline-block bg-yellow-100 text-yellow-700 font-bold px-4 py-1 rounded-full text-sm">Sedang Diproses</span>
                        @else
                            <span class="inline-block bg-green-100 text-green-700 font-bold px-4 py-1 rounded-full text-sm">Selesai</span>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $complaint->title }}</h3>
                    <div class="flex gap-4 text-xs text-gray-500 mb-4">
                        <span>📅 {{ $complaint->created_at->translatedFormat('d F Y - H:i') }} WITA</span>
                        <span>📁 {{ $complaint->category->name }}</span>
                        <span>👤 {{ $complaint->is_anonymous ? 'Anonim' : $complaint->name }}</span>
                    </div>
                    <div class="prose max-w-none text-gray-700 bg-gray-50 p-4 rounded-lg border">
                        {!! nl2br(e($complaint->content)) !!}
                    </div>
                </div>

                @if($complaint->photo_proof)
                    <div class="mb-8">
                        <h4 class="text-sm font-bold text-slate-800 mb-2">Foto Bukti Terlampir:</h4>
                        <a href="{{ asset('storage/' . $complaint->photo_proof) }}" target="_blank">
                            <img src="{{ asset('storage/' . $complaint->photo_proof) }}" class="h-48 rounded border object-cover hover:opacity-75 transition">
                        </a>
                    </div>
                @endif

                <div class="border-t pt-6">
                    <h4 class="font-bold text-lg text-slate-800 mb-4">Riwayat Tanggapan Petugas</h4>
                    @if($complaint->responses->isEmpty())
                        <p class="text-gray-500 italic text-sm">Belum ada tanggapan dari petugas. Laporan Anda sedang dalam antrean.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($complaint->responses as $res)
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="font-bold text-blue-900 text-sm">Petugas Disnaker NTT</p>
                                        <p class="text-xs text-blue-600">{{ $res->created_at->translatedFormat('d M Y - H:i') }}</p>
                                    </div>
                                    <p class="text-gray-700 text-sm leading-relaxed">{{ $res->response }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    {{-- BLOK RATING KEPUASAN --}}
    @if($complaint->status == 'selesai')
        <div class="mt-8 border-t pt-6">
            <h4 class="font-bold text-lg text-slate-800 mb-2">Penilaian Kinerja Petugas</h4>
            
            @if($complaint->rating)
                <div class="bg-green-50 border border-green-200 p-4 rounded-lg flex items-center gap-4">
                    <p class="text-sm text-green-800 font-medium">Anda telah memberikan rating:</p>
                    <div class="flex gap-1 text-yellow-400 text-2xl">
                        @for($i=1; $i<=5; $i++)
                            {{ $i <= $complaint->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                </div>
            @else
                <div class="bg-gray-50 p-4 rounded-lg border">
                    <p class="text-sm text-gray-700 mb-3">Seberapa puas Anda dengan penanganan laporan ini?</p>
                    <form method="POST" action="{{ route('site.complaints.submitRating', $complaint) }}" class="flex gap-2">
                        @csrf
                        <select name="rating" required class="border rounded px-3 py-2 text-sm">
                            <option value="">— Pilih Bintang —</option>
                            <option value="5">★★★★★ (Sangat Puas)</option>
                            <option value="4">★★★★☆ (Puas)</option>
                            <option value="3">★★★☆☆ (Cukup)</option>
                            <option value="2">★★☆☆☆ (Kurang)</option>
                            <option value="1">★☆☆☆☆ (Sangat Kurang)</option>
                        </select>
                        <button class="bg-yellow-500 text-white font-bold px-4 py-2 rounded hover:bg-yellow-600 text-sm">Kirim Rating</button>
                    </form>
                </div>
            @endif
        </div>
    @endif
    </div>
@endsection