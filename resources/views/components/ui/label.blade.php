@props(['error' => false])

<label {!! $attributes->merge(['class' => 'text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 ' . ($error ? 'text-red-500' : 'text-gray-700')]) !!}>
    {{ $slot }}
</label> 