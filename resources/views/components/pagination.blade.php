@props(['paginator'])

@if ($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator && $paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 mt-8 border-t border-gray-200/70">
        <p class="text-xs text-gray-500">
            Menampilkan <span class="font-semibold text-gray-800">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span> dari <span class="font-semibold text-gray-800">{{ $paginator->total() }}</span> data
        </p>

        <nav class="inline-flex items-center bg-white border border-gray-200 rounded-full p-1 shadow-xs" aria-label="Pagination">
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 text-xs text-gray-300 cursor-not-allowed">&larr; Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100 rounded-full transition">&larr; Sebelumnya</a>
            @endif

            <div class="flex items-center space-x-1 px-1">
                @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="w-7 h-7 flex items-center justify-center rounded-full bg-[#112F28] text-white text-xs font-bold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-7 h-7 flex items-center justify-center rounded-full text-xs font-medium text-gray-600 hover:bg-gray-100 transition">{{ $page }}</a>
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-medium text-[#112F28] hover:bg-[#E3EAE5] rounded-full transition">Berikutnya &rarr;</a>
            @else
                <span class="px-3 py-1.5 text-xs text-gray-300 cursor-not-allowed">Berikutnya &rarr;</span>
            @endif
        </nav>
    </div>
@endif