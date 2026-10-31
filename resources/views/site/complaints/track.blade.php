@extends('layouts.site')
@section('title', 'Lacak Pengaduan')

@section('content')
    <div class="max-w-xl mx-auto px-4 py-16">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center border-t-4 border-slate-800">
            <div class="text-5xl mb-4">🎫</div>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Lacak Status Pengaduan</h1>
            <p class="text-gray-600 mb-6 text-sm">Masukkan Nomor Tiket yang Anda dapatkan saat mengirim laporan.</p>

            @if(session('success_ticket'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg mb-6 text-left">
                    <p class="font-bold mb-1">✅ {{ session('success_msg') }}</p>
                    <p class="text-sm">Nomor Tiket Anda:</p>
                    <p class="text-2xl font-mono font-bold mt-1 tracking-wider bg-white p-2 rounded border border-green-300 text-center select-all">{{ session('success_ticket') }}</p>
                    <p class="text-xs mt-2 text-green-700">Silakan salin nomor tiket di atas. Nomor ini juga telah otomatis terisi di bawah.</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 p-3 rounded mb-4 text-sm text-left">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('site.complaints.trackResult') }}" class="flex flex-col gap-3">
                @csrf
                <input type="text" name="ticket_number" value="{{ session('success_ticket') ?? old('ticket_number') }}" required placeholder="Contoh: REQ-20261031-A1B2" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 text-center text-lg font-mono focus:border-slate-800 focus:ring-0 uppercase">
                <button type="submit" class="bg-slate-800 text-white font-bold py-3 rounded-lg hover:bg-slate-900 transition shadow">Lacak Laporan</button>
            </form>
        </div>
    </div>
@endsection