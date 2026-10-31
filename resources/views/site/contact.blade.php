@extends('layouts.site')
@section('title', 'Kontak & Bantuan')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-2">Kontak & Bantuan</h1>
        <p class="text-gray-600 mb-8">Hubungi kami atau temukan jawaban atas pertanyaan umum.</p>

        {{-- Kontak Resmi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-lg mb-4">Kantor</h2>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Alamat</dt>
                        <dd class="font-medium">{{ \App\Models\SiteSetting::get('office_address', 'Belum diisi') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Telepon</dt>
                        <dd class="font-medium">{{ \App\Models\SiteSetting::get('office_phone', 'Belum diisi') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Email</dt>
                        <dd class="font-medium">
                            @php $email = \App\Models\SiteSetting::get('office_email'); @endphp
                            @if ($email)
                                <a href="mailto:{{ $email }}" class="text-blue-600 hover:underline">{{ $email }}</a>
                            @else Belum diisi @endif
                        </dd>
                    </div>
                </dl>

                <div class="mt-4 flex gap-2">
                    @if ($fb = \App\Models\SiteSetting::get('facebook_url'))
                        <a href="{{ $fb }}" target="_blank" rel="noopener" class="text-xs px-3 py-1 bg-blue-600 text-white rounded">Facebook</a>
                    @endif
                    @if ($ig = \App\Models\SiteSetting::get('instagram_url'))
                        <a href="{{ $ig }}" target="_blank" rel="noopener" class="text-xs px-3 py-1 bg-pink-600 text-white rounded">Instagram</a>
                    @endif
                    @if ($yt = \App\Models\SiteSetting::get('youtube_url'))
                        <a href="{{ $yt }}" target="_blank" rel="noopener" class="text-xs px-3 py-1 bg-red-600 text-white rounded">YouTube</a>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                @php $map = \App\Models\SiteSetting::get('office_map_embed'); @endphp
                @if ($map)
                    <div class="aspect-video w-full">{!! $map !!}</div>
                @else
                    <div class="aspect-video bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                        Peta belum disetel
                    </div>
                @endif
            </div>
        </div>

        {{-- FAQ --}}
        <div class="mb-10">
            <h2 class="text-2xl font-bold mb-4">Pertanyaan Umum (FAQ)</h2>
            @if ($faq)
                <div class="bg-white rounded-lg shadow p-6 prose max-w-none">
                    {!! $faq->content !!}
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-6 text-gray-500 text-sm">
                    FAQ belum tersedia. Admin dapat membuatnya di Panel Admin → Berita & Pengumuman → Konten tipe <strong>Halaman</strong> dengan slug <code>faq</code>.
                </div>
            @endif
        </div>

        {{-- Layanan Terkait --}}
        <div>
            <h2 class="text-2xl font-bold mb-4">Layanan Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @php
                    $links = [
                        ['label' => 'Kementerian Ketenagakerjaan RI', 'url' => 'https://kemnaker.go.id'],
                        ['label' => 'Kartu Prakerja', 'url' => 'https://www.prakerja.go.id'],
                        ['label' => 'BPJS Ketenagakerjaan', 'url' => 'https://www.bpjsketenagakerjaan.go.id'],
                        ['label' => 'Portal Pemerintah Provinsi NTT', 'url' => 'https://nttprov.go.id'],
                    ];
                @endphp
                @foreach ($links as $link)
                    <a href="{{ $link['url'] }}" target="_blank" rel="noopener"
                       class="bg-white rounded-lg shadow hover:shadow-lg px-4 py-3 flex items-center justify-between transition">
                        <span class="font-medium text-sm">{{ $link['label'] }}</span>
                        <span class="text-blue-600 text-sm">↗</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection