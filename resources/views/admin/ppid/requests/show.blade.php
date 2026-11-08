@extends('layouts.admin')
@section('title', 'Detail Layanan PPID')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.ppid.requests.index') }}" class="text-blue-600 hover:underline text-sm">← Kembali ke Daftar</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Detail Permohonan --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start border-b pb-4 mb-4">
                    <div>
                        <span class="font-mono bg-gray-100 px-2 py-1 rounded text-sm">{{ $req->ticket_number }}</span>
                        <h1 class="text-xl font-bold mt-2 capitalize">{{ $req->type === 'permohonan' ? 'Formulir Permohonan Informasi' : 'Formulir Pengajuan Keberatan' }}</h1>
                        <p class="text-sm text-gray-500">{{ $req->created_at->translatedFormat('l, d F Y - H:i') }} WITA</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">
                            {{ $req->type === 'permohonan' ? 'Informasi yang Dibutuhkan' : 'Alasan Keberatan' }}
                        </p>
                        <div class="bg-gray-50 p-4 rounded border text-gray-800">
                            {!! nl2br(e($req->info_needed)) !!}
                        </div>
                    </div>

                    @if($req->type === 'permohonan')
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-1">Tujuan Penggunaan Informasi</p>
                        <div class="bg-gray-50 p-4 rounded border text-gray-800">
                            {!! nl2br(e($req->purpose)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Data Pemohon & Aksi --}}
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold mb-4 border-b pb-2">Identitas Pemohon</h2>
                <dl class="space-y-3 text-sm">
                    <div><dt class="text-gray-500">Nama Lengkap</dt><dd class="font-medium">{{ $req->name }}</dd></div>
                    <div><dt class="text-gray-500">NIK / No. KTP</dt><dd class="font-medium">{{ $req->nik }}</dd></div>
                    <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $req->email }}</dd></div>
                    <div><dt class="text-gray-500">No. HP / WA</dt><dd class="font-medium">{{ $req->phone }}</dd></div>
                    <div><dt class="text-gray-500">Alamat</dt><dd class="font-medium">{{ $req->address }}</dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-bold mb-4 border-b pb-2">Tanggapan & Status</h2>
                <form method="POST" action="{{ route('admin.ppid.requests.update', $req) }}">
                    @csrf @method('PUT')
                    
                    <label class="block text-sm font-medium mb-1">Ubah Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2 mb-4">
                        <option value="pending" @selected($req->status=='pending')>Pending</option>
                        <option value="proses" @selected($req->status=='proses')>Proses</option>
                        <option value="selesai" @selected($req->status=='selesai')>Selesai</option>
                        <option value="ditolak" @selected($req->status=='ditolak')>Ditolak</option>
                    </select>

                    <label class="block text-sm font-medium mb-1">Tanggapan / Catatan</label>
                    <textarea name="admin_response" rows="4" class="w-full border rounded px-3 py-2 mb-4" placeholder="Tuliskan tanggapan atau alasan jika ditolak...">{{ $req->admin_response }}</textarea>

                    <button class="w-full bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900 font-semibold">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
@endsection