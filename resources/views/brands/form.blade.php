@props(['brand' => null])

<div class="max-w-2xl mx-auto">
    <form action="{{ $brand ? route('brands.update', $brand) : route('brands.store') }}" 
          method="POST" 
          class="space-y-6 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @if($brand) @method('PUT') @endif

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Name
            </label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name', $brand?->name) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Description
            </label>
            <textarea name="description" 
                      rows="3"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $brand?->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Status
            </label>
            <select name="status" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="1" {{ old('status', $brand?->status) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !old('status', $brand?->status) ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ $brand ? 'Update' : 'Create' }} Brand
            </button>
            <a href="{{ route('brands.index') }}" 
               class="text-blue-500 hover:text-blue-700">Cancel</a>
        </div>
    </form>
</div>
