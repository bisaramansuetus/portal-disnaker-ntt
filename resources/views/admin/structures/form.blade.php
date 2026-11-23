@extends('layouts.admin')
@section('content')
<div class="max-w-4xl space-y-6">
    <h1 class="text-2xl font-extrabold text-gray-900">{{ $structure->exists ? 'Edit Struktur' : 'Tambah Struktur' }}</h1>

    <form action="{{ $structure->exists ? route('admin.structures.update', $structure->id) : route('admin.structures.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-xs space-y-6">
        @csrf
        @if($structure->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold mb-2">Tahun *</label>
                <input type="number" name="year" value="{{ old('year', $structure->year ?? date('Y')) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Judul Tampilan *</label>
                <input type="text" name="title" value="{{ old('title', $structure->title ?? 'Struktur Organisasi') }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300">
            </div>
        </div>

        <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-xl border">
            <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $structure->is_active ?? false)) class="w-5 h-5 text-[#112F28] rounded border-gray-300">
            <label for="is_active" class="text-sm font-medium text-gray-800">Jadikan Struktur Utama (Tampil Pertama di Publik)</label>
        </div>

        <div class="border-t pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <label class="block text-sm font-semibold">Nama Kepala Dinas</label>
                <input type="text" name="head_name" value="{{ old('head_name', $structure->head_name ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300">
                <label class="block text-sm font-semibold">Foto Kepala Dinas (JPG/PNG)</label>
                @if($structure->head_photo) <img src="{{ asset('storage/'.$structure->head_photo) }}" class="h-20 mb-2 rounded"> @endif
                <input type="file" name="head_photo" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#D1E7DD] file:text-[#112F28]">
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-semibold">Nama Sekretaris</label>
                <input type="text" name="secretary_name" value="{{ old('secretary_name', $structure->secretary_name ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300">
                <label class="block text-sm font-semibold">Foto Sekretaris (JPG/PNG)</label>
                @if($structure->secretary_photo) <img src="{{ asset('storage/'.$structure->secretary_photo) }}" class="h-20 mb-2 rounded"> @endif
                <input type="file" name="secretary_photo" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#D1E7DD] file:text-[#112F28]">
            </div>
        </div>

        <div class="border-t pt-6 space-y-3">
            <label class="block text-sm font-semibold">Gambar Bagan Lengkap (JPG/PNG/PDF)</label>
            @if($structure->chart_image) <img src="{{ asset('storage/'.$structure->chart_image) }}" class="h-40 mb-2 rounded border"> @endif
            <input type="file" name="chart_image" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#D1E7DD] file:text-[#112F28]">
            <p class="text-xs text-gray-500">Unggah gambar bagan struktur (seperti yang Anda kirimkan di gambar).</p>
        </div>

        <div class="space-y-3">
            <label class="block text-sm font-semibold">Keterangan Tambahan (Opsional)</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-300">{{ old('description', $structure->description ?? '') }}</textarea>
        </div>

        <div class="pt-4 border-t flex justify-end">
            <button type="submit" class="bg-[#112F28] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#1B4A40]">Simpan Struktur</button>
        </div>
    </form>
</div>
@endsection