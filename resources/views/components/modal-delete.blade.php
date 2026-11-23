@props(['id' => 'deleteModal', 'title' => 'Hapus konten ini?', 'message' => 'Tindakan ini tidak dapat dibatalkan.'])

<div id="{{ $id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-xl border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $title }}</h3>
        <p class="text-sm text-gray-600 mb-6">{{ $message }}</p>
        <div class="flex items-center justify-end space-x-3">
            <button type="button" onclick="document.getElementById('{{ $id }}').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                Batal
            </button>
            <form id="{{ $id }}-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-[#DC3545] hover:bg-red-700 rounded-xl transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>