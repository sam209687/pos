@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Products</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2">Code</th>
                    <th class="px-6 py-3 border-b-2">Name</th>
                    <th class="px-6 py-3 border-b-2">Category</th>
                    <th class="px-6 py-3 border-b-2">Brand</th>
                    <th class="px-6 py-3 border-b-2">Price</th>
                    <th class="px-6 py-3 border-b-2">Stock</th>
                    <th class="px-6 py-3 border-b-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 border-b">{{ $product->code }}</td>
                        <td class="px-6 py-4 border-b">{{ $product->name }}</td>
                        <td class="px-6 py-4 border-b">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 border-b">{{ $product->brand->name }}</td>
                        <td class="px-6 py-4 border-b">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 border-b">
                            <span class="{{ $product->isLowStock() ? 'text-red-500' : 'text-green-500' }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 border-b">
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
