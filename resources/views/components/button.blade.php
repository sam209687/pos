@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md'
])

@php
    $variantClasses = [
        'primary' => 'bg-blue-500 hover:bg-blue-700 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-700 text-white',
        'success' => 'bg-green-500 hover:bg-green-700 text-white',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white',
    ][$variant];

    $sizeClasses = [
        'sm' => 'px-2 py-1 text-sm',
        'md' => 'px-4 py-2',
        'lg' => 'px-6 py-3 text-lg',
    ][$size];
@endphp

<button type="{{ $type }}" 
        {{ $attributes->merge(['class' => "$variantClasses $sizeClasses font-bold rounded focus:outline-none focus:shadow-outline"]) }}>
    {{ $slot }}
</button>
