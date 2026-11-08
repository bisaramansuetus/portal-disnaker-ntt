@extends('layouts.site')
@section('title', 'Lacak Layanan PPID')

@section('content')
    <div class="max-w-xl mx-auto px-4 py-16">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center border-t-4 border-slate-800">
            <div class="text-5xl mb-4">🎫</div>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Lacak Layanan PPID</h1>
            <p class="text-gray-600 mb-6 text-sm">Masukkan Nomor Tiket Permohonan/Keberatan Anda.</p>

            @if(session('success_ticket'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg mb-6 text-left">
                    <p class="font-bold mb-1">✅ Formulir Berhasil Dikirim!</p>
                    <p class="text-2xl font-mono font-bold mt-1 tracking-wider bg-white p-2 rounded border text-center select-all">{{ session('success_ticket') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('site.ppid.trackResult') }}" class="flex flex-col gap-3">
                @csrf
                <input type="text" name="ticket_number" value="{{ session('success_ticket') ?? old('ticket_number') }}" required placeholder="Contoh: REQ-PPID-20231108-A1B2" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-center text-lg font-mono focus:border-slate-800 focus:ring-0 uppercase">
                <button type="submit" class="bg-slate-800 text-white font-bold py-3 rounded-lg hover:bg-slate-900 transition shadow">Lacak Status</button>
            </form>
        </div>
    </div>
@endsection