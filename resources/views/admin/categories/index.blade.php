@extends('layouts.admin')
@section('title', 'Kategori')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-slate-800">Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-900">+ Kategori</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-gray-600">
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Konten</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($categories as $c)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $c->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $c->slug }}</td>
                        <td class="px-4 py-3">{{ $c->posts_count }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $c) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" class="inline"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-6 text-gray-500">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
@endsection