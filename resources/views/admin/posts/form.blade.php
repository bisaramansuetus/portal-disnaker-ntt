@extends('layouts.admin')

@php
    $isEdit = isset($post) && !empty($post->id);
@endphp

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">
                {{ $isEdit ? 'Edit konten' : 'Tambah konten baru' }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Perbarui informasi, kategori, atau status publikasi konten.' : 'Tulis berita, pengumuman resmi, atau halaman informasi publik.' }}
            </p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition">
            &larr; Kembali ke daftar
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-sm text-red-700">
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $isEdit ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}"
          method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <!-- Kolom Utama (8 Kolom) -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-gray-100 shadow-xs space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1.5">Judul konten *</label>
                <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1.5">Isi lengkap konten *</label>
                <textarea id="tinymceContentEditor" name="content" rows="14"
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">{{ old('content', $post->content ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">Meta Title (SEO)</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">Meta Description (SEO)</label>
                    <input type="text" name="meta_description" value="{{ old('meta_description', $post->meta_description ?? '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Kolom Samping Pengaturan Publikasi (4 Kolom) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs space-y-4">
                <h2 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">Publikasi & klasifikasi</h2>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Jenis konten *</label>
                    <select name="type" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm bg-white focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                        @php $currentType = old('type', $post->type ?? 'berita'); @endphp
                        <option value="berita" {{ $currentType === 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="pengumuman" {{ $currentType === 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="page" {{ $currentType === 'page' ? 'selected' : '' }}>Halaman Statis</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Kategori</label>
                    <select name="category_id" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm bg-white focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                        <option value="">-- Pilih kategori --</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ (string) old('category_id', $post->category_id ?? '') === (string) $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Status publikasi *</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm bg-white focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                        @php $currentStatus = old('status', $post->status ?? 'published'); @endphp
                        <option value="published" {{ $currentStatus === 'published' ? 'selected' : '' }}>Terpublikasi</option>
                        <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Draf</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" @checked(old('is_featured', $post->is_featured ?? false)) class="w-4 h-4 text-[#112F28] rounded border-gray-300">
                    <label for="is_featured" class="text-xs text-gray-700">Jadikan Konten Unggulan</label>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs space-y-4">
                <h2 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">Gambar utama</h2>

                @if($isEdit && !empty($post->image))
                    <div class="rounded-xl overflow-hidden border border-gray-200 h-36 bg-gray-50">
                        <img src="{{ asset('uploads/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#D1E7DD] file:text-[#112F28] hover:file:bg-[#A3CFBB]">
                <p class="text-[11px] text-gray-400">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
            </div>

            <button type="submit" class="w-full py-3 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl transition shadow-xs">
                {{ $isEdit ? 'Simpan perubahan' : 'Simpan konten' }} &rarr;
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#tinymceContentEditor',
        height: 500,
        menubar: false,
        plugins: 'lists link image table code preview fullscreen',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code preview fullscreen',
        branding: false,
        promotion: false,
        convert_urls: false,
        setup: function (editor) {
            editor.on('keydown', function (e) {
                if (e.keyCode === 9) { // Tab key
                    e.preventDefault();
                    var node = editor.selection.getNode();
                    if (e.shiftKey) {
                        editor.dom.setStyle(node, 'text-indent', '');
                    } else {
                        editor.dom.setStyle(node, 'text-indent', '2em');
                    }
                }
            });
        }
    });
</script>
@endpush