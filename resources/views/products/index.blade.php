@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold dark:text-gray-100">Products</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-100 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded my-6">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Code</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Name</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Category</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Brand</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Price</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Stock</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ $product->code }}</td>
                        <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                        <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ $product->brand->name }}</td>
                        <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 border-b dark:border-gray-700">
                            <span class="{{ $product->isLowStock() ? 'text-red-500 dark:text-red-400' : 'text-green-500 dark:text-green-400' }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 border-b dark:border-gray-700">
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 mr-2">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure?')">Delete</button>
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
