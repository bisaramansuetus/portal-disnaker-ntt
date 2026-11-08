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
                            <form method="POST" action="{{ route('admin.ppid.destroy', $doc) }}" class="inline" onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-6 text-gray-500">Belum ada dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $documents->links() }}</div>
@endsection