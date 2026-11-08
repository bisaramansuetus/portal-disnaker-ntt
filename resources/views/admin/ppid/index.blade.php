@extends('layouts.admin')
@section('title', 'Kelola Dokumen PPID')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-slate-800">Dokumen PPID</h1>
        <a href="{{ route('admin.ppid.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">+ Unggah Dokumen</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b text-gray-600">
                <tr>
                    <th class="px-4 py-3">Judul Dokumen</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3 text-center">Diunduh</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($documents as $doc)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $doc->title }}</td>
                        <td class="px-4 py-3"><span class="bg-slate-100 px-2 py-1 rounded text-xs">{{ $doc->category }}</span></td>
                        <td class="px-4 py-3 text-center">{{ $doc->download_count }}x</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-green-600 hover:underline">Lihat</a>
                            <a href="{{ route('admin.ppid.edit', $doc) }}" class="text-blue-600 hover:underline">Edit</a>
                            
                            {{-- TOMBOL HAPUS DENGAN MODAL KUSTOM --}}
                            <button type="button" onclick="confirmDelete('{{ route('admin.ppid.destroy', $doc) }}', '{{ addslashes($doc->title) }}')" class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-6 text-gray-500">Belum ada dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $documents->links() }}</div>

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white rounded-xl shadow-2xl p-6 max-w-sm w-full border-t-4 border-red-600">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <span class="text-red-600 text-2xl">⚠️</span>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Dokumen?</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Apakah Anda yakin ingin menghapus dokumen <br>
                    <strong id="deleteTitle" class="text-slate-800"></strong>?<br>
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">Batal</button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition font-medium shadow-md">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function confirmDelete(url, title) {
        // Set action URL pada form di dalam modal
        document.getElementById('deleteForm').action = url;
        // Set judul dokumen yang akan dihapus
        document.getElementById('deleteTitle').innerText = '"' + title + '"';
        // Tampilkan modal
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeModal() {
        // Sembunyikan modal
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Menutup modal jika area gelap di luar kotak diklik
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endpush