@extends('layouts.admin')
@section('title', $job->exists ? 'Edit Lowongan' : 'Lowongan Baru')

@section('content')
    <h1 class="text-2xl font-bold text-slate-800 mb-6">{{ $job->exists ? 'Edit Lowongan' : 'Lowongan Baru' }}</h1>

    <form method="POST"
          action="{{ $job->exists ? route('admin.jobs.update', $job) : route('admin.jobs.store') }}"
          class="bg-white rounded-lg shadow p-6 max-w-4xl space-y-4">
        @csrf
        @if ($job->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Judul Lowongan <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $job->title) }}" required maxlength="200" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nama Perusahaan <span class="text-red-500">*</span></label>
                <input type="text" name="company_name" value="{{ old('company_name', $job->company_name) }}" required maxlength="150" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="location" value="{{ old('location', $job->location) }}" required maxlength="150" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Pekerjaan <span class="text-red-500">*</span></label>
                <select name="job_type" required class="w-full border rounded px-3 py-2">
                    @foreach (['Full-time', 'Part-time', 'Kontrak', 'Magang', 'Freelance'] as $jt)
                        <option value="{{ $jt }}" @selected(old('job_type', $job->job_type)===$jt)>{{ $jt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Pendidikan Minimal <span class="text-red-500">*</span></label>
                <input type="text" name="education" value="{{ old('education', $job->education) }}" required maxlength="100" placeholder="Contoh: SMA/SMK, D3, S1" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deadline <span class="text-red-500">*</span></label>
                <input type="date" name="deadline" value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full border rounded px-3 py-2">
                    <option value="draft" @selected(old('status', $job->status)==='draft')>Draft</option>
                    <option value="published" @selected(old('status', $job->status)==='published')>Published</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="8" class="w-full border rounded px-3 py-2">{{ old('description', $job->description) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Persyaratan <span class="text-red-500">*</span></label>
                <textarea name="requirements" id="requirements" rows="8" class="w-full border rounded px-3 py-2">{{ old('requirements', $job->requirements) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Cara Melamar (URL/Email/Alamat)</label>
                <input type="text" name="application_url" value="{{ old('application_url', $job->application_url) }}" maxlength="255" placeholder="https://... atau email atau alamat fisik" class="w-full border rounded px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $job->is_featured))>
                    Tampilkan sebagai unggulan
                </label>
            </div>
        </div>

        <div class="flex gap-2 pt-2">
            <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">Simpan</button>
            <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 rounded border">Batal</a>
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