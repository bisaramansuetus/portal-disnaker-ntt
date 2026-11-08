@extends('layouts.admin')
@section('title', 'Permohonan & Keberatan PPID')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-slate-800">Permohonan & Keberatan PPID</h1>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b text-gray-600">
                <tr>
                    <th class="px-4 py-3">No. Tiket</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Pemohon</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($requests as $req)
                    <tr>
                        <td class="px-4 py-3 font-mono text-xs font-bold">{{ $req->ticket_number }}</td>
                        <td class="px-4 py-3">{{ $req->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            @if($req->type === 'permohonan')
                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">Permohonan</span>
                            @else
                                <span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded">Keberatan</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $req->name }}</td>
                        <td class="px-4 py-3">
                            @if($req->status == 'pending')
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">Pending</span>
                            @elseif($req->status == 'proses')
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">Proses</span>
                            @elseif($req->status == 'selesai')
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.ppid.requests.show', $req) }}" class="text-blue-600 hover:underline font-semibold">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-6 text-gray-500">Belum ada permohonan atau keberatan masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $requests->links() }}</div>
@endsection