@props(['variant' => 'success'])

@php
    $variants = [
        'success' => 'bg-[#D1E7DD] text-[#112F28]',
        'warning' => 'bg-amber-100 text-amber-800',
        'danger' => 'bg-red-100 text-red-800',
        'neutral' => 'bg-gray-100 text-gray-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wide " . ($variants[$variant] ?? $variants['success'])] ) }}>
    {{ $slot }}
</span>