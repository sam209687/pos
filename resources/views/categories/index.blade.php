@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Categories</h1>
        <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Category
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-100 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-100 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded my-6">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Name</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Description</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Products Count</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Status</th>
                    <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ $category->name }}</td>
                        <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ Str::limit($category->description, 50) }}</td>
                        <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ $category->products_count }}</td>
                        <td class="px-6 py-4 border-b dark:border-gray-700">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->status ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100' }}">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 border-b dark:border-gray-700">
                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 mr-2">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
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
        {{ $categories->links() }}
    </div>
</div>
@endsection
