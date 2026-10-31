@extends('layouts.site')
@section('title', 'Kirim Pengaduan')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-10">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Kirim Pengaduan</h1>
            <p class="text-gray-600 mt-2">Sampaikan laporan Anda terkait pelayanan atau masalah ketenagakerjaan. Identitas Anda dilindungi.</p>
            <a href="{{ route('site.complaints.track') }}" class="inline-block bg-blue-100 text-blue-800 font-semibold px-4 py-2 rounded-lg hover:bg-blue-200 transition text-sm">
                🔍 Sudah punya Nomor Tiket? Lacak Pengaduan
            </a>
        </div>

        <form method="POST" action="{{ route('site.complaints.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-6 md:p-8 space-y-6">
            @csrf

            <div class="bg-slate-50 p-4 border rounded-lg mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" class="w-5 h-5 text-slate-800 rounded">
                    <div>
                        <span class="font-bold text-slate-800">Kirim sebagai Anonim</span>
                        <p class="text-xs text-gray-500 mt-1">Centang ini jika Anda tidak ingin identitas Anda ditampilkan di halaman publik. (Admin tetap bisa melihat data asli untuk verifikasi).</p>
                    </div>
                </label>
            </div>

            <div id="identity_fields" class="space-y-4 border-l-4 border-blue-500 pl-4">
                <h3 class="font-semibold text-lg border-b pb-2">Data Diri</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">NIK / No. KTP <span class="text-red-500">*</span></label>
                        {{-- maxlength mencegah ketik lebih dari 16. oninput mencegah ketik huruf --}}
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full border rounded px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">Wajib 16 digit angka.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Pekerjaan <span class="text-red-500">*</span></label>
                        <input type="text" name="job" value="{{ old('job') }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                        {{-- maxlength mencegah ketik lebih dari 15. oninput mencegah ketik huruf/simbol --}}
                        <input type="text" name="phone" value="{{ old('phone') }}" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full border rounded px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">Gunakan angka saja (10-15 digit).</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="2" class="w-full border rounded px-3 py-2">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t">
                <h3 class="font-semibold text-lg border-b pb-2">Detail Pengaduan</h3>
                <div>
                    <label class="block text-sm font-medium mb-1">Kategori Pengaduan <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full border rounded px-3 py-2">
                        <option value="">— Pilih Kategori —</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Judul Laporan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required maxlength="200" placeholder="Contoh: Fasilitas Toilet di Kantor Disnaker Rusak" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Isi Laporan <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="5" required placeholder="Jelaskan kronologi atau detail masalah secara jelas..." class="w-full border rounded px-3 py-2">{{ old('content') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Foto Bukti (Opsional)</label>
                    <input type="file" name="photo_proof" accept="image/*" class="w-full border rounded px-3 py-2">
                    <p class="text-xs text-gray-500 mt-1">Maks 3MB (JPG/PNG).</p>
                </div>
            </div>

            <div class="pt-4 border-t">
                <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3 rounded-lg hover:bg-slate-900 transition shadow-lg">
                    Kirim Pengaduan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const anonymousCheckbox = document.getElementById('is_anonymous');
    const identityFields = document.getElementById('identity_fields');
    const inputs = identityFields.querySelectorAll('input, textarea');

    anonymousCheckbox.addEventListener('change', function() {
        if (this.checked) {
            identityFields.classList.add('opacity-50');
            inputs.forEach(input => {
                input.required = false;
                input.value = ''; // Kosongkan form
            });
        } else {
            identityFields.classList.remove('opacity-50');
            inputs.forEach(input => {
                input.required = true;
            });
        }
    });
</script>
@endpush