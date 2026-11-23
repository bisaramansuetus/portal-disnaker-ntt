@extends('layouts.admin')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Struktur Kedinasan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola bagan struktur organisasi per tahun.</p>
        </div>
        <a href="{{ route('admin.structures.create') }}" class="bg-[#112F28] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#1B4A40]">+ Tambah Struktur</a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-[#E3EAE5]/60 text-xs font-semibold text-gray-700 border-b">
                <tr>
                    <th class="py-4 px-6">Tahun</th>
                    <th class="py-4 px-6">Judul / Keterangan</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($structures as $item)
                    <tr>
                        <td class="py-4 px-6 font-bold text-[#112F28]">{{ $item->year }}</td>
                        <td class="py-4 px-6">{{ $item->title }}</td>
                        <td class="py-4 px-6">
                            @if($item->is_active) <x-badge variant="success">Aktif (Tahun Ini)</x-badge>
                            @else <x-badge variant="neutral">Arsip</x-badge> @endif
                        </td>
                        <td class="py-4 px-6 text-right space-x-3">
                            <a href="{{ route('admin.structures.edit', $item->id) }}" class="text-blue-600 font-medium hover:underline">Edit</a>
                            <form action="{{ route('admin.structures.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus struktur ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 font-medium hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-8 text-gray-500">Belum ada data struktur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $structures->links() }}</div>
</div>
@endsection