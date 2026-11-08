@extends('layouts.site')
@section('title', 'Status Layanan PPID')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 border-t-4 {{ $ticket->status == 'selesai' ? 'border-green-500' : ($ticket->status == 'ditolak' ? 'border-red-500' : 'border-yellow-500') }}">
            <h2 class="text-2xl font-mono font-bold text-slate-800 mb-2">{{ $ticket->ticket_number }}</h2>
            <p class="text-sm text-gray-500 mb-6 border-b pb-4">Dikirim pada: {{ $ticket->created_at->translatedFormat('d F Y - H:i') }}</p>

            <div class="mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Status Permohonan</span>
                <div class="mt-1">
                    @if($ticket->status == 'pending') <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded font-bold">Menunggu Diproses</span>
                    @elseif($ticket->status == 'proses') <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded font-bold">Sedang Diproses</span>
                    @elseif($ticket->status == 'selesai') <span class="bg-green-100 text-green-800 px-3 py-1 rounded font-bold">Selesai</span>
                    @else <span class="bg-red-100 text-red-800 px-3 py-1 rounded font-bold">Ditolak</span>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ $ticket->type === 'permohonan' ? 'Informasi yang Diminta' : 'Alasan Keberatan' }}</span>
                <p class="mt-1 text-gray-800 bg-gray-50 p-3 rounded border">{!! nl2br(e($ticket->info_needed)) !!}</p>
            </div>

            @if($ticket->admin_response)
            <div class="mt-8 border-t pt-6">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Tanggapan Petugas PPID</span>
                <div class="mt-2 bg-blue-50 border border-blue-100 p-4 rounded text-gray-800 text-sm leading-relaxed">
                    {!! nl2br(e($ticket->admin_response)) !!}
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection