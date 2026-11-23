@props(['variant' => 'primary', 'type' => 'submit', 'url' => null])

@php
    $baseClasses = "inline-flex items-center justify-center font-semibold px-6 py-2.5 rounded-full transition duration-150 ease-in-out text-sm focus:outline-none";
    
    $variants = [
        'primary' => "bg-[#112F28] hover:bg-[#1B4A40] text-white",
        'secondary' => "bg-[#D1E7DD] hover:bg-[#A3CFBB] text-[#112F28]",
        'white' => "bg-white hover:bg-gray-100 text-[#112F28]",
        'danger' => "bg-[#DC3545] hover:bg-red-700 text-white",
        'outline' => "border border-[#112F28] bg-transparent hover:bg-[#112F28] text-[#112F28] hover:text-white"
    ];
    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($url)
    <a href="{{ $url }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif