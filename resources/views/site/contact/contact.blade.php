@extends('layouts.site')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
    <!-- Breadcrumb -->
    <nav class="text-xs text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <span class="text-gray-900 font-medium">Bantuan dan kontak</span>
    </nav>

    <!-- Header -->
    <div class="max-w-2xl mb-10">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Mari terhubung.</h1>
        <p class="text-sm sm:text-base text-gray-600">Kami siap membantu Anda menemukan informasi dan layanan yang tepat.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Kolom Kiri: Kantor & Layanan Terkait -->
        <div class="lg:col-span-6 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xs space-y-4">
                <h2 class="text-lg font-bold text-gray-900">Kantor DISNAKERTRANS NTT</h2>
                <div class="text-sm text-gray-600 space-y-2">
                    <p><strong class="text-gray-900">Alamat kantor:</strong> {{ \App\Models\SiteSetting::get('office_address', 'Jl. Basuki Rahmat, Kota Kupang, NTT') }}</p>
                    <p><strong class="text-gray-900">Telepon:</strong> {{ \App\Models\SiteSetting::get('office_phone', '(0380) 123-456') }}</p>
                    <p><strong class="text-gray-900">Email:</strong> {{ \App\Models\SiteSetting::get('office_email', 'layanan@disnakertrans.nttprov.go.id') }}</p>
                    <p><strong class="text-gray-900">Jam layanan:</strong> Senin–Jumat, 08.00–16.00 WITA</p>
                </div>
                <div class="pt-2">
                    <a href="https://maps.google.com/?q={{ urlencode(\App\Models\SiteSetting::get('office_address', 'Jl. Basuki Rahmat, Kota Kupang, NTT')) }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center px-5 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-xs font-semibold rounded-xl transition">
                        Buka di Google Maps &nearr;
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xs space-y-4">
                <h2 class="text-base font-bold text-gray-900">Layanan yang mungkin Anda butuhkan</h2>
                <div class="space-y-3">
                    <a href="https://kemnaker.go.id" target="_blank" rel="noopener noreferrer"
                       class="block p-4 rounded-2xl bg-[#F8F9FA] hover:bg-[#E3EAE5] transition">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-900">Kemnaker RI</span>
                            <span class="text-xs text-[#112F28]">&nearr;</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Informasi ketenagakerjaan nasional dan layanan SIAPkerja.</p>
                    </a>

                    <a href="https://prakerja.go.id" target="_blank" rel="noopener noreferrer"
                       class="block p-4 rounded-2xl bg-[#F8F9FA] hover:bg-[#E3EAE5] transition">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-900">Prakerja</span>
                            <span class="text-xs text-[#112F28]">&nearr;</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Pengembangan kompetensi dan informasi program Prakerja.</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Pertanyaan yang Sering Ditanyakan (FAQ) -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xs">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Pertanyaan yang sering ditanyakan</h2>
            @php
                $faqs = [
                    ['q' => 'Apakah perlu akun untuk mengakses layanan?', 'a' => 'Tidak. Semua informasi, pengaduan, dan layanan PPID dapat diakses tanpa akun. Simpan nomor tiket untuk pelacakan.'],
                    ['q' => 'Bagaimana cara melamar lowongan kerja?', 'a' => 'Buka menu Lowongan Kerja, pilih posisi yang diminati, lalu ikuti petunjuk atau tautan pendaftaran resmi yang tersedia.'],
                    ['q' => 'Bagaimana melacak pengaduan saya?', 'a' => 'Buka halaman Lacak Pengaduan dan masukkan kode tiket (misalnya REQ-2026-001) yang Anda terima setelah mengirim pengaduan.'],
                ];
            @endphp
            <div class="divide-y divide-gray-100" id="faqAccordion">
                @foreach($faqs as $idx => $faq)
                    <div class="py-4 first:pt-0 last:pb-0">
                        <button type="button" onclick="toggleFaq({{ $idx }})" class="w-full flex items-center justify-between text-left gap-4 focus:outline-none">
                            <span class="text-sm font-bold text-gray-900">{{ $faq['q'] }}</span>
                            <span id="faqIcon-{{ $idx }}" class="text-lg font-light text-gray-400 transition-transform">+</span>
                        </button>
                        <div id="faqBody-{{ $idx }}" class="{{ $idx === 0 ? '' : 'hidden' }} mt-2 text-xs sm:text-sm text-gray-600 leading-relaxed">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleFaq(index) {
        const body = document.getElementById('faqBody-' + index);
        const icon = document.getElementById('faqIcon-' + index);
        if (!body || !icon) return;
        body.classList.toggle('hidden');
        icon.textContent = body.classList.contains('hidden') ? '+' : '−';
    }
</script>
@endpush
@endsection