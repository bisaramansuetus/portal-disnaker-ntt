@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">Pengaduan masyarakat</h1>
        <p class="text-sm text-gray-500 mt-1">Tinjau tiket pengaduan, perbarui status penanganan, dan kirim tanggapan resmi.</p>
    </div>

    <form method="GET" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs flex flex-col sm:flex-row gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode tiket atau judul..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
        <select name="status" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white focus:ring-2 focus:ring-[#112F28] focus:outline-none">
            <option value="">Semua status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button type="submit" class="px-6 py-2.5 bg-[#E3EAE5] hover:bg-[#D1E7DD] text-[#112F28] font-semibold text-sm rounded-xl transition">Terapkan</button>
    </form>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#E3EAE5]/60 text-xs font-semibold text-gray-700 border-b border-gray-200">
                        <th class="py-3.5 px-6">Tiket</th>
                        <th class="py-3.5 px-6">Judul & pelapor</th>
                        <th class="py-3.5 px-6">Tanggal</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($complaints ?? [] as $complaint)
                        @php $st = $complaint->status ?? 'pending'; @endphp
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-4 px-6 font-mono text-xs font-bold text-[#112F28]">
                                {{ $complaint->ticket_number }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-900">{{ $complaint->title }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $complaint->is_anonymous ? 'Anonim' : $complaint->name }}
                                    &bull; {{ $complaint->category->name ?? 'Umum' }}
                                </div>
                            </td>
                            <td class="py-4 px-6 text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($complaint->created_at)->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-4 px-6">
                                @if($st === 'selesai')
                                    <x-badge variant="success">Selesai</x-badge>
                                @elseif($st === 'proses')
                                    <x-badge variant="warning">Proses</x-badge>
                                @else
                                    <x-badge variant="neutral">Pending</x-badge>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2 text-xs font-medium">
                                <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="text-[#112F28] hover:underline font-semibold">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-8 px-6 text-center text-gray-400 text-sm">Belum ada pengaduan masyarakat masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($complaints) && method_exists($complaints, 'links'))
        <x-pagination :paginator="$complaints" />
    @endif
</div>
@endsection