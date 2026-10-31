@extends('layouts.admin')
@section('title', 'Program & Pelatihan')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-slate-800">Program & Pelatihan</h1>
        <a href="{{ route('admin.programs.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">+ Program</a>
    </div>

    <form method="GET" class="bg-white rounded-lg shadow p-4 mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul..." class="border rounded px-3 py-2 md:col-span-2">
        <select name="type" class="border rounded px-3 py-2">
            <option value="">— Tipe —</option>
            <option value="program" @selected(request('type')==='program')>Program</option>
            <option value="pelatihan" @selected(request('type')==='pelatihan')>Pelatihan</option>
            <option value="transmigrasi" @selected(request('type')==='transmigrasi')>Transmigrasi</option>
        </select>
        <button class="bg-slate-800 text-white rounded px-4 py-2">Terapkan</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Jadwal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($programs as $p)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $p->title }}</td>
                        <td class="px-4 py-3 capitalize">{{ $p->type }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            @if ($p->start_date)
                                {{ $p->start_date->format('d M Y') }} – {{ $p->end_date?->format('d M Y') ?? '-' }}
                            @else - @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded {{ $p->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.programs.edit', $p) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.programs.destroy', $p) }}" class="inline" onsubmit="return confirm('Hapus program ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-6 text-gray-500">Belum ada program.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $programs->links() }}</div>
@endsection