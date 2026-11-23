@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">Kategori</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola kategori berita, pengumuman, dan topik layanan publik.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-gray-100 shadow-xs">
            @php $editing = isset($category) && !empty($category->id); @endphp
            <h2 class="text-base font-bold text-gray-900 mb-4">
                {{ $editing ? 'Edit kategori' : 'Tambah kategori baru' }}
            </h2>

            <form action="{{ $editing ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}"
                  method="POST" class="space-y-4">
                @csrf
                @if($editing) @method('PUT') @endif

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama kategori *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Slug (opsional)</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" placeholder="otomatis"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="description" rows="2"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <button type="submit" class="flex-1 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-xs font-semibold rounded-xl transition">
                        {{ $editing ? 'Perbarui' : 'Simpan' }}
                    </button>
                    @if($editing)
                        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition">Batal</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#E3EAE5]/60 text-xs font-semibold text-gray-700 border-b border-gray-200">
                            <th class="py-3.5 px-6">Nama kategori</th>
                            <th class="py-3.5 px-6">Slug</th>
                            <th class="py-3.5 px-6">Jumlah konten</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($categories ?? [] as $cat)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="py-4 px-6 font-semibold text-gray-900">{{ $cat->name }}</td>
                                <td class="py-4 px-6 text-xs font-mono text-gray-500">{{ $cat->slug }}</td>
                                <td class="py-4 px-6"><x-badge variant="neutral">{{ $cat->posts_count ?? 0 }} item</x-badge></td>
                                <td class="py-4 px-6 text-right space-x-2 text-xs font-medium">
                                    <a href="{{ route('admin.categories.edit', $cat->id) }}" class="text-[#112F28] hover:underline">Edit</a>
                                    <span class="text-gray-300">&bull;</span>
                                    <button type="button" onclick="openDeleteCategoryModal('{{ route('admin.categories.destroy', $cat->id) }}', '{{ addslashes($cat->name) }}')" class="text-red-600 hover:underline">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-8 px-6 text-center text-gray-400 text-sm">Belum ada kategori terdaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<x-modal-delete id="deleteCategoryModal" title="Hapus kategori ini?" message="Kategori yang dihapus mungkin memengaruhi pengelompokan konten terkait." />

@push('scripts')
<script>
    function openDeleteCategoryModal(actionUrl, name) {
        const modal = document.getElementById('deleteCategoryModal');
        const form = document.getElementById('deleteCategoryModal-form');
        form.action = actionUrl;
        modal.querySelector('p').innerHTML = `Kategori "<strong>${name}</strong>" akan dihapus. Tindakan ini tidak dapat dibatalkan.`;
        modal.classList.remove('hidden');
    }
</script>
@endpush
@endsection