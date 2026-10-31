@extends('layouts.admin')
@section('title', 'Lowongan Kerja')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-slate-800">Lowongan Kerja</h1>
        <a href="{{ route('admin.jobs.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">+ Lowongan</a>
    </div>

    <form method="GET" class="bg-white rounded-lg shadow p-4 mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul..." class="border rounded px-3 py-2 md:col-span-2">
        <select name="status" class="border rounded px-3 py-2">
            <option value="">— Status —</option>
            <option value="draft" @selected(request('status')==='draft')>Draft</option>
            <option value="published" @selected(request('status')==='published')>Published</option>
        </select>
        <button class="bg-slate-800 text-white rounded px-4 py-2">Terapkan</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Judul / Perusahaan</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3">Deadline</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($jobs as $j)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="font-medium">{{ $j->title }}</p>
                            <p class="text-xs text-gray-500">{{ $j->company_name }}</p>
                        </td>
                        <td class="px-4 py-3">{{ $j->location }}</td>
                        <td class="px-4 py-3">
                            {{ $j->deadline->format('d M Y') }}
                            @if ($j->isClosed())
                                <span class="ml-1 text-xs text-red-600">(tutup)</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded {{ $j->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $j->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.jobs.edit', $j) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.jobs.destroy', $j) }}" class="inline" onsubmit="return confirm('Hapus lowongan ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-6 text-gray-500">Belum ada lowongan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $jobs->links() }}</div>
@endsection