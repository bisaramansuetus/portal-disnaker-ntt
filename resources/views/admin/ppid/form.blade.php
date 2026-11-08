@extends('layouts.admin')
@section('title', $document->exists ? 'Edit Dokumen' : 'Unggah Dokumen')

@section('content')
    <h1 class="text-2xl font-bold text-slate-800 mb-6">{{ $document->exists ? 'Edit Dokumen' : 'Unggah Dokumen PPID' }}</h1>

    <form method="POST" action="{{ $document->exists ? route('admin.ppid.update', $document) : route('admin.ppid.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 max-w-2xl space-y-4">
        @csrf
        @if ($document->exists) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1">Judul Dokumen <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $document->title) }}" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kategori Perki 1/2021 <span class="text-red-500">*</span></label>
            <select name="category" required class="w-full border rounded px-3 py-2">
                <option value="DIP" @selected(old('category', $document->category) === 'DIP')>Daftar Informasi Publik (DIP)</option>
                <option value="Berkala" @selected(old('category', $document->category) === 'Berkala')>Informasi Berkala</option>
                <option value="Setiap Saat" @selected(old('category', $document->category) === 'Setiap Saat')>Informasi Setiap Saat</option>
                <option value="Serta-Merta" @selected(old('category', $document->category) === 'Serta-Merta')>Informasi Serta-Merta</option>
                <option value="Regulasi" @selected(old('category', $document->category) === 'Regulasi')>Regulasi / Produk Hukum</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">File Dokumen (PDF/DOC/XLS) <span class="text-red-500">{{ $document->exists ? '' : '*' }}</span></label>
            @if ($document->file_path)
                <p class="text-xs text-green-600 mb-2">File saat ini: {{ basename($document->file_path) }}</p>
            @endif
            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="w-full border rounded px-3 py-2" {{ $document->exists ? '' : 'required' }}>
            <p class="text-xs text-gray-500 mt-1">Maksimal 10MB.</p>
        </div>

        <div class="pt-4 flex gap-2">
            <button class="bg-slate-800 text-white px-5 py-2 rounded hover:bg-slate-900">Simpan</button>
            <a href="{{ route('admin.ppid.index') }}" class="px-5 py-2 rounded border hover:bg-gray-50">Batal</a>
        </div>
    </form>
@endsection