@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Sales History</h1>
        <div class="flex space-x-2">
            <a href="{{ route('sales.export-pdf') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Export PDF
            </a>
            <a href="{{ route('sales.export-excel') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Export Excel
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form action="{{ route('sales.index') }}" method="GET" class="flex space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">All</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Sales</h3>
            <p class="text-3xl font-bold">${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Items Sold</h3>
            <p class="text-3xl font-bold">{{ number_format($totalItems) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Transactions</h3>
            <p class="text-3xl font-bold">{{ $sales->total() }}</p>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2">Invoice #</th>
                    <th class="px-6 py-3 border-b-2">Date</th>
                    <th class="px-6 py-3 border-b-2">Cashier</th>
                    <th class="px-6 py-3 border-b-2">Items</th>
                    <th class="px-6 py-3 border-b-2">Total</th>
                    <th class="px-6 py-3 border-b-2">Status</th>
                    <th class="px-6 py-3 border-b-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td class="px-6 py-4 border-b">{{ $sale->id }}</td>
                        <td class="px-6 py-4 border-b">{{ $sale->sale_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 border-b">{{ $sale->user->name }}</td>
                        <td class="px-6 py-4 border-b">{{ $sale->items->sum('quantity') }}</td>
                        <td class="px-6 py-4 border-b">${{ number_format($sale->final_amount, 2) }}</td>
                        <td class="px-6 py-4 border-b">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $sale->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($sale->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 border-b">
                            <a href="{{ route('sales.show', $sale) }}" class="text-blue-500 hover:text-blue-700">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $sales->links() }}
    </div>
</div>
@endsection
