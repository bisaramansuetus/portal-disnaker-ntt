@extends('layouts.site')
@section('title', $type === 'permohonan' ? 'Formulir Permohonan Informasi' : 'Formulir Keberatan Informasi')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-sm border-t-4 border-ntt-gold p-8 md:p-12">
            <h1 class="text-2xl font-bold text-ntt-red font-serif mb-2">
                {{ $type === 'permohonan' ? 'Formulir Permohonan Informasi Publik' : 'Formulir Pengajuan Keberatan Informasi' }}
            </h1>
            <p class="text-gray-600 mb-8 border-b pb-4 text-sm">Sesuai UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.</p>

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ $type === 'permohonan' ? route('site.ppid.store') : route('site.ppid.store_keberatan') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">NIK / No. KTP <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="2" required class="w-full border rounded px-3 py-2">{{ old('address') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">{{ $type === 'permohonan' ? 'Rincian Informasi yang Dibutuhkan' : 'Alasan Pengajuan Keberatan' }} <span class="text-red-500">*</span></label>
                        <textarea name="info_needed" rows="4" required class="w-full border rounded px-3 py-2">{{ old('info_needed') }}</textarea>
                    </div>
                    @if($type === 'permohonan')
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Tujuan Penggunaan Informasi <span class="text-red-500">*</span></label>
                        <textarea name="purpose" rows="2" required class="w-full border rounded px-3 py-2">{{ old('purpose') }}</textarea>
                    </div>
                    @endif
                </div>
                <div class="pt-4 border-t mt-6">
                    <button type="submit" class="bg-slate-800 text-white font-bold px-6 py-2.5 rounded hover:bg-slate-900 transition shadow">Kirim Formulir</button>
                </div>
            </form>
        </div>
    </div>
@endsection