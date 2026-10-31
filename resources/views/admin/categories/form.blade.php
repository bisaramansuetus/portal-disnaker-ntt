@extends('layouts.admin')
@section('title', $category->exists ? 'Edit Kategori' : 'Kategori Baru')

@section('content')
    <h1 class="text-2xl font-bold text-slate-800 mb-6">
        {{ $category->exists ? 'Edit Kategori' : 'Kategori Baru' }}
    </h1>

    <form method="POST"
          action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          class="bg-white rounded-lg shadow p-6 max-w-xl space-y-4">
        @csrf
        @if ($category->exists) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium mb-1">Nama <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required maxlength="100"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="3" maxlength="500"
                      class="w-full border rounded px-3 py-2">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="flex gap-2">
            <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection