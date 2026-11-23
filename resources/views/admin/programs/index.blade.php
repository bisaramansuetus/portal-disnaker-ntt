@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Program & pelatihan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola program pelatihan vokasi, kuota peserta, dan informasi transmigrasi.</p>
        </div>
        <a href="{{ route('admin.programs.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl transition">
            + Tambah program
        </a>
    </div>

    <form method="GET" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs flex flex-col sm:flex-row gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama program..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
        <select name="category" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white focus:ring-2 focus:ring-[#112F28] focus:outline-none">
            <option value="">Semua jenis program</option>
            <option value="pelatihan" {{ request('category') == 'pelatihan' ? 'selected' : '' }}>Pelatihan Vokasi</option>
            <option value="transmigrasi" {{ request('category') == 'transmigrasi' ? 'selected' : '' }}>Transmigrasi</option>
        </select>
        <button type="submit" class="px-6 py-2.5 bg-[#E3EAE5] hover:bg-[#D1E7DD] text-[#112F28] font-semibold text-sm rounded-xl transition">Terapkan</button>
    </form>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#E3EAE5]/60 text-xs font-semibold text-gray-700 border-b border-gray-200">
                        <th class="py-3.5 px-6">Nama program</th>
                        <th class="py-3.5 px-6">Kuota & Biaya</th>
                        <th class="py-3.5 px-6">Jadwal</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($programs ?? [] as $program)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-900">{{ $program->title }}</div>
                                <div class="text-xs text-gray-500 capitalize">{{ $program->type }}</div>
                            </td>
                            <td class="py-4 px-6 text-xs text-gray-600">
                                {{ $program->quota ?? '-' }} peserta &bull; {{ $program->fee == 0 ? 'Gratis' : 'Rp '.number_format($program->fee, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-xs text-gray-600">
                                {{ $program->start_date ? $program->start_date->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-6">
                                @if($program->status === 'published')
                                    <x-badge variant="success">Terbit</x-badge>
                                @else
                                    <x-badge variant="neutral">Draf</x-badge>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2 text-xs font-medium">
                                <a href="{{ route('site.programs.show', $program->slug) }}" target="_blank" class="text-gray-600 hover:underline">Lihat</a>
                                <span class="text-gray-300">&bull;</span>
                                <a href="{{ route('admin.programs.edit', $program->id) }}" class="text-[#112F28] hover:underline">Edit</a>
                                <span class="text-gray-300">&bull;</span>
                                <button type="button" onclick="openDeleteProgramModal('{{ route('admin.programs.destroy', $program->id) }}', '{{ addslashes($program->title) }}')" class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-8 px-6 text-center text-gray-400 text-sm">Belum ada program terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($programs) && method_exists($programs, 'links'))
        <x-pagination :paginator="$programs" />
    @endif
</div>

<x-modal-delete id="deleteProgramModal" title="Hapus program ini?" message="Program yang dihapus tidak akan tampil di halaman informasi publik." />

@push('scripts')
<script>
    function openDeleteProgramModal(actionUrl, title) {
        const modal = document.getElementById('deleteProgramModal');
        const form = document.getElementById('deleteProgramModal-form');
        form.action = actionUrl;
        modal.querySelector('p').innerHTML = `Program "<strong>${title}</strong>" akan dihapus. Tindakan ini tidak dapat dibatalkan.`;
        modal.classList.remove('hidden');
    }
</script>
@endpush
@endsection