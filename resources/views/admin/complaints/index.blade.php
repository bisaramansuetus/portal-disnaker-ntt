@extends('layouts.admin')
@section('title', 'Pengaduan Masyarakat')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-slate-800">Pengaduan Masyarakat</h1>
    </div>

    <form method="GET" class="bg-white rounded-lg shadow p-4 mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari No. Tiket / Judul..." class="border rounded px-3 py-2 md:col-span-2">
        <select name="status" class="border rounded px-3 py-2">
            <option value="">— Semua Status —</option>
            <option value="pending" @selected(request('status')==='pending')>Pending</option>
            <option value="proses" @selected(request('status')==='proses')>Proses</option>
            <option value="selesai" @selected(request('status')==='selesai')>Selesai</option>
        </select>
        <button class="bg-slate-800 text-white rounded px-4 py-2">Cari</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b text-gray-600">
                <tr>
                    <th class="px-4 py-3">No. Tiket</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Pelapor</th>
                    <th class="px-4 py-3">Judul Laporan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($complaints as $c)
                    <tr>
                        <td class="px-4 py-3 font-mono text-xs font-bold">{{ $c->ticket_number }}</td>
                        <td class="px-4 py-3">{{ $c->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            {{ $c->is_anonymous ? 'Anonim' : $c->name }}
                            <span class="block text-xs text-gray-500">{{ $c->category->name }}</span>
                        </td>
                        <td class="px-4 py-3 font-medium">{{ Str::limit($c->title, 40) }}</td>
                        <td class="px-4 py-3">
                            @if($c->status == 'pending')
                                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">Pending</span>
                            @elseif($c->status == 'proses')
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">Proses</span>
                            @else
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Selesai</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.complaints.show', $c) }}" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-6 text-gray-500">Belum ada pengaduan masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $complaints->links() }}</div>
@endsection