@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Lowongan kerja</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi lowongan kerja, batas lamaran, dan status tayang.</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#112F28] hover:bg-[#1B4A40] text-white text-sm font-semibold rounded-xl transition">
            + Tambah lowongan
        </a>
    </div>

    <!-- Filter Bar -->
    <form method="GET" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs flex flex-col sm:flex-row gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari posisi, perusahaan, atau lokasi..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#112F28] focus:outline-none">
        <select name="type" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white focus:ring-2 focus:ring-[#112F28] focus:outline-none">
            <option value="">Semua jenis</option>
            <option value="Full-time" {{ request('type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
            <option value="Kontrak" {{ request('type') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            <option value="Magang" {{ request('type') == 'Magang' ? 'selected' : '' }}>Magang</option>
        </select>
        <button type="submit" class="px-6 py-2.5 bg-[#E3EAE5] hover:bg-[#D1E7DD] text-[#112F28] font-semibold text-sm rounded-xl transition">
            Terapkan
        </button>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#E3EAE5]/60 text-xs font-semibold text-gray-700 border-b border-gray-200">
                        <th class="py-3.5 px-6">Posisi & perusahaan</th>
                        <th class="py-3.5 px-6">Jenis</th>
                        <th class="py-3.5 px-6">Batas lamaran</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($jobs ?? [] as $job)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-900">{{ $job->title }}</div>
                                <div class="text-xs text-gray-500">{{ $job->company_name }} &bull; {{ $job->location ?? 'Kupang' }}</div>
                            </td>
                            <td class="py-4 px-6 text-xs text-gray-700">{{ $job->job_type ?? 'Full-time' }}</td>
                            <td class="py-4 px-6 text-xs text-gray-600">
                                {{ !empty($job->deadline) ? \Carbon\Carbon::parse($job->deadline)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-6">
                                @if($job->status === 'published')
                                    <x-badge variant="success">Terbit</x-badge>
                                @else
                                    <x-badge variant="neutral">Draf</x-badge>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2 text-xs font-medium">
                                <a href="{{ route('site.jobs.show', $job->slug) }}" target="_blank" class="text-gray-600 hover:underline">Lihat</a>
                                <span class="text-gray-300">&bull;</span>
                                <a href="{{ route('admin.jobs.edit', $job->id) }}" class="text-[#112F28] hover:underline">Edit</a>
                                <span class="text-gray-300">&bull;</span>
                                <button type="button" onclick="openDeleteJobModal('{{ route('admin.jobs.destroy', $job->id) }}', '{{ addslashes($job->title) }}')" class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-6 text-center text-gray-400 text-sm">Belum ada data lowongan kerja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($jobs) && method_exists($jobs, 'links'))
        <x-pagination :paginator="$jobs" />
    @endif
</div>

<x-modal-delete id="deleteJobModal" title="Hapus lowongan ini?" message="Lowongan kerja yang dihapus tidak akan tampil lagi di portal publik." />

@push('scripts')
<script>
    function openDeleteJobModal(actionUrl, title) {
        const modal = document.getElementById('deleteJobModal');
        const form = document.getElementById('deleteJobModal-form');
        form.action = actionUrl;
        modal.querySelector('p').innerHTML = `Lowongan "<strong>${title}</strong>" akan dihapus. Tindakan ini tidak dapat dibatalkan.`;
        modal.classList.remove('hidden');
    }
</script>
@endpush
@endsection