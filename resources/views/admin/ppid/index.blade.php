@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">Dokumen PPID</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola Daftar Informasi Publik (DIP), peraturan, dan dokumen resmi PPID.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-gray-100 shadow-xs">
            <h2 class="text-base font-bold text-gray-900 mb-4">Unggah dokumen publik</h2>

            <form action="{{ route('admin.ppid.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Judul dokumen *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           placeholder="Contoh: Laporan Tahunan PPID 2026"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Kategori *</label>
                    <select name="category" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm bg-white focus:ring-2 focus:ring-[#112F28] focus:outline-none">
                        <option value="DIP">Daftar Informasi Publik (DIP)</option>
                        <option value="Berkala">Informasi Berkala</option>
                        <option value="Setiap Saat">Informasi Setiap Saat</option>
                        <option value="Serta-Merta">Informasi Serta-Merta</option>
                        <option value="Regulasi">Regulasi / Produk Hukum</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Berkas dokumen (PDF) *</label>
                    <input type="file" name="file" accept=".pdf,.doc,.docx" required
                           class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#D1E7DD] file:text-[#112F28] hover:file:bg-[#A3CFBB]">
                    <p class="text-[11px] text-gray-400 mt-1">PDF/DOCX, maksimal 10 MB.</p>
                </div>

                <button type="submit" class="w-full py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-xs font-semibold rounded-xl transition">
                    Publikasikan dokumen &rarr;
                </button>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#E3EAE5]/60 text-xs font-semibold text-gray-700 border-b border-gray-200">
                            <th class="py-3.5 px-6">Judul dokumen</th>
                            <th class="py-3.5 px-6">Kategori</th>
                            <th class="py-3.5 px-6">Diunduh</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($documents ?? [] as $doc)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-gray-900">{{ $doc->title }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <x-badge variant="success">{{ $doc->category }}</x-badge>
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-500">
                                    {{ $doc->download_count ?? 0 }}x
                                </td>
                                <td class="py-4 px-6 text-right space-x-2 text-xs font-medium">
                                    @if(!empty($doc->file_path))
                                        <a href="{{ asset('uploads/' . $doc->file_path) }}" target="_blank" class="text-[#112F28] hover:underline">Buka</a>
                                        <span class="text-gray-300">&bull;</span>
                                    @endif
                                    <button type="button" onclick="openDeleteDocModal('{{ route('admin.ppid.destroy', $doc->id) }}', '{{ addslashes($doc->title) }}')" class="text-red-600 hover:underline">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-8 px-6 text-center text-gray-400 text-sm">Belum ada dokumen PPID yang dipublikasikan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<x-modal-delete id="deleteDocModal" title="Hapus dokumen PPID ini?" message="Dokumen publik akan dihapus dari daftar informasi PPID." />

@push('scripts')
<script>
    function openDeleteDocModal(actionUrl, title) {
        const modal = document.getElementById('deleteDocModal');
        const form = document.getElementById('deleteDocModal-form');
        form.action = actionUrl;
        modal.querySelector('p').innerHTML = `Dokumen "<strong>${title}</strong>" akan dihapus. Tindakan ini tidak dapat dibatalkan.`;
        modal.classList.remove('hidden');
    }
</script>
@endpush
@endsection