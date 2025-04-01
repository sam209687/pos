@props(['header' => null])

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    @if($header)
        <div class="px-6 py-4 bg-gray-50 border-b">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
