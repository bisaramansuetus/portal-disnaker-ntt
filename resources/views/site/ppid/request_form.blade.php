@extends('layouts.site')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <a href="{{ route('site.ppid.profile') }}" class="hover:underline">PPID</a> / <span class="text-gray-900 font-medium">Permohonan Informasi</span>
    </nav>

    <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-100 shadow-sm space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Permohonan informasi</h1>
            <p class="text-gray-600 text-sm">Ajukan kebutuhan informasi publik secara mudah, transparan, dan tanpa dipungut biaya.</p>
        </div>

        <form action="{{ route('site.ppid.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama lengkap *</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Nama lengkap pemohon">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="nama@example.com">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK / Identitas Pemohon *</label>
                    <input type="text" name="nik" required maxlength="16" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Nomor KTP / Identitas resmi">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon / WhatsApp *</label>
                    <input type="text" name="phone" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="081234567890">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat lengkap *</label>
                <textarea name="address" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Alamat domisili pemohon"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Informasi yang dimohon *</label>
                <textarea name="info_needed" rows="3" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Contoh: Laporan realisasi program pelatihan tahun 2025..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan penggunaan informasi *</label>
                <textarea name="purpose" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Jelaskan tujuan penggunaan informasi secara jelas..."></textarea>
            </div>

            <div class="flex items-center space-x-3 pt-2">
                <input type="checkbox" id="consent" required class="w-4 h-4 text-[#112F28] border-gray-300 rounded focus:ring-[#112F28]">
                <label for="consent" class="text-sm text-gray-600">Saya menyatakan data yang disampaikan benar dan menyetujui penggunaan data untuk layanan permohonan informasi.</label>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-500">Nomor tiket permohonan diberikan setelah pengiriman berhasil.</p>
                <x-button variant="primary">Ajukan permohonan &rarr;</x-button>
            </div>
        </form>
    </div>
</div>
@endsection