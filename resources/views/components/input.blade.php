@props(['disabled' => false, 'label' => '', 'error' => ''])

<div class="mb-4">
    @if($label)
        <label class="block text-gray-700 text-sm font-bold mb-2">
            {{ $label }}
        </label>
    @endif

    <input {{ $disabled ? 'disabled' : '' }} 
           {!! $attributes->merge(['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' . ($error ? ' border-red-500' : '')]) !!}>

    @if($error)
        <p class="text-red-500 text-xs italic mt-1">{{ $error }}</p>
    @endif
</div>
