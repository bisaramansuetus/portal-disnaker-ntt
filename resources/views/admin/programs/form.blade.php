@extends('layouts.admin')
@section('title', $program->exists ? 'Edit Program' : 'Program Baru')

@section('content')
    <h1 class="text-2xl font-bold text-slate-800 mb-6">{{ $program->exists ? 'Edit Program' : 'Program Baru' }}</h1>

    <form method="POST"
          action="{{ $program->exists ? route('admin.programs.update', $program) : route('admin.programs.store') }}"
          class="bg-white rounded-lg shadow p-6 max-w-4xl space-y-4">
        @csrf
        @if ($program->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Judul Program <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $program->title) }}" required maxlength="200" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tipe <span class="text-red-500">*</span></label>
                <select name="type" required class="w-full border rounded px-3 py-2">
                    <option value="program" @selected(old('type', $program->type)==='program')>Program</option>
                    <option value="pelatihan" @selected(old('type', $program->type)==='pelatihan')>Pelatihan</option>
                    <option value="transmigrasi" @selected(old('type', $program->type)==='transmigrasi')>Transmigrasi</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full border rounded px-3 py-2">
                    <option value="draft" @selected(old('status', $program->status)==='draft')>Draft</option>
                    <option value="published" @selected(old('status', $program->status)==='published')>Published</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date', $program->start_date?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date', $program->end_date?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kuota</label>
                <input type="number" name="quota" value="{{ old('quota', $program->quota) }}" min="0" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Biaya (Rp)</label>
                <input type="number" name="fee" value="{{ old('fee', $program->fee) }}" min="0" step="1000" class="w-full border rounded px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="6" class="w-full border rounded px-3 py-2">{{ old('description', $program->description) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Persyaratan <span class="text-red-500">*</span></label>
                <textarea name="requirements" id="requirements" rows="6" class="w-full border rounded px-3 py-2">{{ old('requirements', $program->requirements) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Info Jadwal (teks bebas)</label>
                <input type="text" name="schedule_info" value="{{ old('schedule_info', $program->schedule_info) }}" maxlength="1000" placeholder="Contoh: Setiap Senin–Jumat, 08.00–16.00 WITA" class="w-full border rounded px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">URL Pendaftaran (eksternal)</label>
                <input type="text" name="registration_url" value="{{ old('registration_url', $program->registration_url) }}" maxlength="255" class="w-full border rounded px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $program->is_featured))>
                    Tampilkan sebagai unggulan
                </label>
            </div>
        </div>

        <div class="flex gap-2 pt-2">
            <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">Simpan</button>
            <a href="{{ route('admin.programs.index') }}" class="px-4 py-2 rounded border">Batal</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    tinymce.init({ 
        selector: '#description, #requirements', 
        height: 300, 
        menubar: false,
        plugins: 'lists link table code preview', 
        // TAMBAHKAN ALIGN DI SINI
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link table | code preview',
        branding: false, 
        promotion: false 
    });
</script>
@endpush