@extends('layouts.admin')
@section('title', $post->exists ? 'Edit Konten' : 'Konten Baru')

@section('content')
    <h1 class="text-2xl font-bold text-slate-800 mb-6">
        {{ $post->exists ? 'Edit Konten' : 'Konten Baru' }}
    </h1>

    <form method="POST"
          action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
          enctype="multipart/form-data"
          class="bg-white rounded-lg shadow p-6 max-w-4xl space-y-4">
        @csrf
        @if ($post->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required maxlength="200"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tipe <span class="text-red-500">*</span></label>
                <select name="type" required class="w-full border rounded px-3 py-2">
                    <option value="berita" @selected(old('type', $post->type)==='berita')>Berita</option>
                    <option value="pengumuman" @selected(old('type', $post->type)==='pengumuman')>Pengumuman</option>
                    <option value="page" @selected(old('type', $post->type)==='page')>Halaman (Profil/FAQ)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    <option value="">— Pilih —</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('category_id', $post->category_id)==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full border rounded px-3 py-2">
                    <option value="draft" @selected(old('status', $post->status)==='draft')>Draft</option>
                    <option value="published" @selected(old('status', $post->status)==='published')>Published</option>
                </select>
            </div>

            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $post->is_featured))>
                    Tampilkan sebagai unggulan
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Konten <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="12"
                          class="w-full border rounded px-3 py-2">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Gambar Utama</label>
                @if ($post->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $post->image) }}" class="h-24 rounded border">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">JPG/PNG/WEBP, maks 2MB. Untuk halaman Profil, unggah bagan struktur organisasi di sini.</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Meta Title (SEO)</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" maxlength="200"
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Meta Description (SEO)</label>
                <input type="text" name="meta_description" value="{{ old('meta_description', $post->meta_description) }}" maxlength="300"
                       class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="flex gap-2 pt-2">
            <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">Simpan</button>
            <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    tinymce.init({
        selector: '#content',
        height: 500,
        menubar: false,
        plugins: 'lists link image table code preview fullscreen',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image table | code preview fullscreen',
        branding: false,
        promotion: false,
        convert_urls: false,
        
        // FITUR TAB YANG AMAN (Tanpa merusak toolbar)
            setup: function (editor) {
            editor.on('keydown', function (e) {
                // Dapatkan elemen blok (paragraf/heading) tempat kursor berada
                var block = editor.dom.getParent(editor.selection.getNode(), 'p,h1,h2,h3,h4,h5,h6');

                if (e.keyCode === 9) { // Jika tombol TAB ditekan
                    e.preventDefault(); // Cegah pindah menu
                    if (block) {
                        if (e.shiftKey) {
                            editor.dom.setStyle(block, 'text-indent', ''); // Shift+Tab = Mundur
                        } else {
                            editor.dom.setStyle(block, 'text-indent', '2em'); // Tab = Maju
                        }
                    }
                } 
                else if (e.keyCode === 8 && block) { // Jika tombol BACKSPACE ditekan
                    var rng = editor.selection.getRng();
                    
                    // Cek apakah kursor berada tepat di awal teks (offset 0) dan tidak sedang menyeleksi teks
                    if (rng.startOffset === 0 && rng.collapsed) {
                        // Jika paragraf ini memiliki gaya text-indent, hapus indentasinya
                        if (editor.dom.getStyle(block, 'text-indent')) {
                            e.preventDefault(); // Cegah paragraf terhapus
                            editor.dom.setStyle(block, 'text-indent', ''); // Kembalikan ke rata kiri
                        }
                    }
                }
            });
        }
    });
</script>
@endpush