@props(['post'])

<div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
    <div>
        <!-- Thumbnail -->
        <div class="h-48 bg-gray-200 overflow-hidden">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
            @else
                <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=80" alt="Default" class="w-full h-full object-cover">
            @endif
        </div>
        <div class="p-6">
            <div class="mb-3">
                <x-badge variant="success">{{ $post->category->name ?? 'Ketenagakerjaan' }}</x-badge>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-[#112F28]">
                <a href="{{ route('site.posts.show', $post->slug) }}">{{ $post->title }}</a>
            </h3>
            <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                {{ Str::limit(strip_tags($post->content), 100) }}
            </p>
        </div>
    </div>
    <div class="px-6 pb-6 pt-0 flex items-center justify-between text-xs text-gray-500 border-t border-gray-50 pt-4">
        <span>{{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}</span>
        <a href="{{ route('site.posts.show', $post->slug) }}" class="inline-flex items-center font-bold text-[#112F28] hover:underline">
            Baca selengkapnya 
            <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
        </a>
    </div>
</div>