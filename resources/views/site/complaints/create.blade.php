@extends('layouts.site')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:underline">Beranda</a> / <span class="text-gray-900 font-medium">Pengaduan Masyarakat</span>
    </nav>

    <div class="bg-white rounded-3xl p-8 md:p-10 border border-gray-100 shadow-sm space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Suara Anda, langkah perbaikan kami.</h1>
            <p class="text-gray-600 text-sm">Sampaikan pengaduan atau kendala layanan dengan aman. Tidak perlu membuat akun.</p>
        </div>

        <form action="{{ route('site.complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Pengaduan *</label>
                <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm bg-white">
                    <option value="">Pilih kategori pengaduan...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Nama lengkap">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK / No. KTP *</label>
                    <input type="text" name="nik" required maxlength="16" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="16 digit NIK">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="nama@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. HP / WhatsApp *</label>
                    <input type="text" name="phone" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="081234567890">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan *</label>
                    <input type="text" name="job" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Pekerjaan saat ini">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                    <textarea name="address" rows="2" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Alamat domisili"></textarea>
                </div>
            </div>

            <div class="flex items-center space-x-3 bg-gray-50 p-4 rounded-xl border border-gray-200">
                <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" class="w-4 h-4 text-[#112F28] border-gray-300 rounded focus:ring-[#112F28]">
                <label for="is_anonymous" class="text-sm text-gray-700 font-medium">
                    Laporkan secara anonim di publik <span class="block text-xs font-normal text-gray-500">Identitas asli disembunyikan dan hanya dapat diakses petugas berwenang.</span>
                </label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Laporan *</label>
                <input type="text" name="title" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Ringkasan singkat pengaduan Anda">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Uraian Pengaduan *</label>
                <textarea name="content" rows="4" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#112F28] focus:outline-none text-sm" placeholder="Jelaskan kejadian, lokasi, waktu, dan informasi pendukung secara rinci..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran Bukti Pendukung (Opsional)</label>
                <input type="file" name="photo_proof" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#D1E7DD] file:text-[#112F28] hover:file:bg-[#A3CFBB]">
                <p class="text-xs text-gray-500 mt-1">JPG/PNG/PDF, maksimal 5 MB per berkas.</p>
            </div>

            <div class="flex items-center space-x-3 pt-2">
                <input type="checkbox" id="complaint_consent" required class="w-4 h-4 text-[#112F28] border-gray-300 rounded focus:ring-[#112F28]">
                <label for="complaint_consent" class="text-sm text-gray-600">Saya menyatakan informasi yang disampaikan adalah benar dan sesuai fakta di lapangan.</label>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('site.complaints.track') }}" class="text-sm font-semibold text-[#112F28] hover:underline">Lacak pengaduan aktif &rarr;</a>
                <x-button variant="primary">Kirim pengaduan &rarr;</x-button>
            </div>
        </form>
    </div>
</div>
@endsection