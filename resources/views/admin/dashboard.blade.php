@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-100">Total Sales</h3>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-200">{{ $stats['total_sales'] }}</p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-green-800 dark:text-green-100">Total Products</h3>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-200">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-100">Total Users</h3>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-200">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-100">Total Revenue</h3>
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-200">${{ number_format($stats['total_revenue'], 2) }}</p>
                    </div>
                </div>

                <!-- Recent Sales -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Recent Sales</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recent_sales as $sale)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $sale->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $sale->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">${{ number_format($sale->final_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $sale->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 