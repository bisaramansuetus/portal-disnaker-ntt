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
    </div>
@endsection