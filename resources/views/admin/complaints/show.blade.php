@extends('layouts.admin')
@section('title', 'Detail Pengaduan')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.complaints.index') }}" class="text-blue-600 hover:underline text-sm">← Kembali ke Daftar</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Laporan --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start border-b pb-4 mb-4">
                    <div>
                        <span class="font-mono bg-gray-100 px-2 py-1 rounded text-sm">{{ $complaint->ticket_number }}</span>
                        <h1 class="text-xl font-bold mt-2">{{ $complaint->title }}</h1>
                        <p class="text-sm text-gray-500">{{ $complaint->created_at->translatedFormat('l, d F Y - H:i') }} WITA</p>
                    </div>
                    <div>
                        @if($complaint->status == 'pending') <span class="bg-red-100 text-red-700 px-3 py-1 rounded text-sm">Pending</span>
                        @elseif($complaint->status == 'proses') <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-sm">Proses</span>
                        @else <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm">Selesai</span>
                        @endif
                    </div>
                </div>

                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($complaint->content)) !!}
                </div>

                @if($complaint->photo_proof)
                    <div class="mb-4">
                        <p class="text-sm font-semibold mb-2">Foto Bukti:</p>
                        <a href="{{ asset('storage/' . $complaint->photo_proof) }}" target="_blank">
                            <img src="{{ asset('storage/' . $complaint->photo_proof) }}" class="h-48 rounded border object-cover hover:opacity-75 transition">
                        </a>
                    </div>
                @endif

                <div class="bg-gray-50 p-4 rounded text-sm text-gray-700">
                    <p><strong>Kategori:</strong> {{ $complaint->category->name }}</p>
                    <p><strong>Status Pelapor:</strong> {{ $complaint->is_anonymous ? 'Anonim (Disembunyikan dari Publik)' : 'Terbuka' }}</p>
                </div>
            </div>

            {{-- Riwayat Tanggapan --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold text-lg mb-4">Tanggapan Petugas</h2>
                @forelse($complaint->responses as $res)
                    <div class="border-l-4 border-blue-500 pl-4 mb-4">
                        <p class="text-sm font-semibold">{{ $res->user->name }} <span class="text-xs text-gray-500 font-normal">({{ $res->created_at->diffForHumans() }})</span></p>
                        <p class="text-gray-700 mt-1">{{ $res->response }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic mb-4">Belum ada tanggapan.</p>
                @endforelse

                <hr class="my-6">
                
                {{-- Form Balasan --}}
                <form method="POST" action="{{ route('admin.complaints.storeResponse', $complaint) }}">
                    @csrf
                    <label class="block text-sm font-medium mb-2">Berikan Tanggapan Baru</label>
                    <textarea name="response" rows="4" required class="w-full border rounded px-3 py-2 mb-2" placeholder="Tulis tanggapan untuk pelapor..."></textarea>
                    <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900 text-sm">Kirim Tanggapan</button>
                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Data Pelapor & Aksi --}}
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold mb-4 border-b pb-2">Data Pelapor</h2>
                @if($complaint->is_anonymous)
                    <div class="bg-red-50 text-red-700 text-xs p-2 rounded mb-3">Pelapor memilih Anonim. Data asli hanya untuk verifikasi internal.</div>
                @endif
                <dl class="space-y-3 text-sm">
                    <div><dt class="text-gray-500">Nama Lengkap</dt><dd class="font-medium">{{ $complaint->name ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">NIK / No. KTP</dt><dd class="font-medium">{{ $complaint->nik ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Pekerjaan</dt><dd class="font-medium">{{ $complaint->job ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">No. HP / WA</dt><dd class="font-medium">{{ $complaint->phone ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $complaint->email ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Alamat</dt><dd class="font-medium">{{ $complaint->address ?? '-' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold mb-4 border-b pb-2">Ubah Status Laporan</h2>
                <form method="POST" action="{{ route('admin.complaints.updateStatus', $complaint) }}">
                    @csrf @method('PUT')
                    <select name="status" class="w-full border rounded px-3 py-2 mb-3">
                        <option value="pending" @selected($complaint->status=='pending')>Pending</option>
                        <option value="proses" @selected($complaint->status=='proses')>Proses</option>
                        <option value="selesai" @selected($complaint->status=='selesai')>Selesai</option>
                    </select>
                    <button class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Update Status</button>
                </form>
            </div>
        </div>
    </div>
@endsection