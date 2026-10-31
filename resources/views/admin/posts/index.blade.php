@extends('layouts.admin')
@section('title', 'Berita & Pengumuman')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-slate-800">Berita & Pengumuman</h1>
        <a href="{{ route('admin.posts.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">+ Konten</a>
    </div>

    <form method="GET" class="bg-white rounded-lg shadow p-4 mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul..."
               class="border rounded px-3 py-2">
        <select name="type" class="border rounded px-3 py-2">
            <option value="">— Semua Tipe —</option>
            <option value="berita" @selected(request('type')==='berita')>Berita</option>
            <option value="pengumuman" @selected(request('type')==='pengumuman')>Pengumuman</option>
            <option value="page" @selected(request('type')==='page')>Halaman</option>
        </select>
        <select name="status" class="border rounded px-3 py-2">
            <option value="">— Semua Status —</option>
            <option value="draft" @selected(request('status')==='draft')>Draft</option>
            <option value="published" @selected(request('status')==='published')>Published</option>
        </select>
        <button class="bg-slate-800 text-white rounded px-4 py-2">Terapkan</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($posts as $p)
                    <tr>
                        <td class="px-4 py-3 font-medium max-w-xs truncate">{{ $p->title }}</td>
                        <td class="px-4 py-3">{{ $p->type }}</td>
                        <td class="px-4 py-3">{{ $p->category->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded {{ $p->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.posts.edit', $p) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $p) }}" class="inline"
                                  onsubmit="return confirm('Hapus konten ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-6 text-gray-500">Belum ada konten.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $posts->links() }}</div>
@endsection