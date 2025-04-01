@props(['product' => null, 'categories', 'brands'])

<form action="{{ $product ? route('products.update', $product) : route('products.store') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      class="space-y-6">
    @csrf
    @if($product) @method('PUT') @endif

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name', $product?->name) }}" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            {{ old('category_id', $product?->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Add other fields similarly -->
    </div>

    <div class="mt-6">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ $product ? 'Update' : 'Create' }} Product
        </button>
    </div>
</form>
