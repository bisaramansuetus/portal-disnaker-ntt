@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <nav class="text-xs text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <span>Layanan publik</span> / <span class="text-gray-900 font-medium">Lacak pengaduan</span>
    </nav>

    <div class="max-w-2xl mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Pantau tindak lanjut pengaduan.</h1>
        <p class="text-sm sm:text-base text-gray-600">Masukkan nomor tiket untuk melihat status dan tanggapan petugas.</p>
    </div>

    <!-- PENTING: Gunakan POST ke trackResult -->
    <form method="POST" action="{{ route('site.complaints.trackResult') }}" class="bg-white rounded-2xl p-2.5 border border-gray-200/80 shadow-xs flex flex-col sm:flex-row items-stretch sm:items-center gap-2 mb-8 max-w-3xl">
        @csrf
        <div class="flex-1 flex items-center px-3">
            <x-icon name="search" class="w-4 h-4 text-gray-400 mr-2.5 flex-shrink-0" />
            <input type="text" name="ticket_number" value="{{ session('success_ticket') ?? old('ticket_number', $complaint->ticket_number ?? '') }}"
                   placeholder="Nomor tiket (contoh: REQ-2026-001)"
                   class="w-full py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none font-mono uppercase">
        </div>
        <button type="submit" class="px-7 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-full transition">
            Lacak pengaduan
        </button>
    </form>

    @if(session('success_ticket'))
        <div class="mb-6 p-4 rounded-2xl bg-[#D1E7DD] text-[#112F28] text-sm font-medium max-w-3xl">
            Pengaduan berhasil dikirim! Nomor tiket Anda: <strong>{{ session('success_ticket') }}</strong>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-white rounded-3xl p-8 border border-amber-200 text-sm text-amber-800 max-w-3xl mb-6">
            {{ $errors->first() }}
        </div>
    @endif

    @if(!empty($complaint))
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xs space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-gray-100">
                    <div>
                        <span class="text-xs font-mono font-bold text-[#112F28] bg-[#E3EAE5] px-3 py-1 rounded-full">
                            {{ $complaint->ticket_number }}
                        </span>
                        <h2 class="text-xl font-bold text-gray-900 mt-2">{{ $complaint->title }}</h2>
                    </div>
                    <x-badge variant="{{ $complaint->status === 'selesai' ? 'success' : ($complaint->status === 'proses' ? 'warning' : 'neutral') }}">
                        {{ strtoupper($complaint->status) }}
                    </x-badge>
                </div>

                <div class="flex flex-wrap gap-3 text-xs text-gray-500">
                    <span>Kategori: <strong class="text-gray-800">{{ $complaint->category->name ?? '-' }}</strong></span>
                    <span>&bull;</span>
                    <span>Pelapor: <strong class="text-gray-800">{{ $complaint->is_anonymous ? 'Anonim' : $complaint->name }}</strong></span>
                    <span>&bull;</span>
                    <span>{{ \Carbon\Carbon::parse($complaint->created_at)->translatedFormat('d M Y') }}</span>
                </div>

                <div class="text-sm text-gray-700 leading-relaxed">
                    {!! nl2br(e($complaint->content)) !!}
                </div>

                <div class="pt-4 border-t border-gray-100 space-y-3">
                    <h3 class="text-sm font-bold text-gray-900">Tanggapan petugas</h3>
                    @forelse($complaint->responses as $resp)
                        <div class="p-4 rounded-2xl bg-[#F4F6F4] border border-[#E3EAE5] space-y-1.5">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="font-bold text-[#112F28]">{{ $resp->user->name ?? 'Petugas layanan' }}</span>
                                <span>{{ \Carbon\Carbon::parse($resp->created_at)->translatedFormat('d F Y, H.i') }} WITA</span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $resp->response }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400">Belum ada tanggapan resmi dari petugas.</p>
                    @endforelse
                </div>
            </div>

            <aside class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xs space-y-5">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Bagaimana pengalaman layanan Anda?</h3>
                    <p class="text-xs text-gray-500 mt-1">Penilaian 1–5 bintang tersedia setelah pengaduan selesai.</p>
                </div>

                @if($complaint->status === 'selesai')
                    @if($complaint->rating)
                        <div class="p-4 rounded-xl bg-green-50 text-green-800 text-sm font-medium flex items-center gap-3">
                            Rating Anda: <div class="flex text-amber-400 text-xl">@for($i=1;$i<=5;$i++) {{ $i <= $complaint->rating ? '★' : '☆' }} @endfor</div>
                        </div>
                    @else
                        <form action="{{ route('site.complaints.submitRating', $complaint) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex items-center space-x-2" id="starRatingGroup">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" data-rating="{{ $i }}" onclick="setRating({{ $i }})"
                                            class="star-btn text-2xl transition text-gray-300 hover:text-amber-400">
                                        &#9733;
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="ratingValueInput" value="5">
                            <button type="submit" class="px-5 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-xs font-semibold rounded-xl transition">
                                Kirim penilaian
                            </button>
                        </form>
                    @endif
                @else
                    <div class="p-4 rounded-xl bg-gray-50 text-gray-500 text-sm">
                        Form penilaian akan muncul setelah status pengaduan menjadi "Selesai".
                    </div>
                @endif
            </aside>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function setRating(val) {
        document.getElementById('ratingValueInput').value = val;
        document.querySelectorAll('#starRatingGroup .star-btn').forEach(btn => {
            const starVal = parseInt(btn.getAttribute('data-rating'), 10);
            if (starVal <= val) {
                btn.classList.remove('text-gray-300');
                btn.classList.add('text-amber-400');
            } else {
                btn.classList.remove('text-amber-400');
                btn.classList.add('text-gray-300');
            }
        });
    }
</script>
@endpush
@endsection