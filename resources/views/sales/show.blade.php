@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold dark:text-gray-100">Sale Details #{{ $sale->id }}</h1>
                <a href="{{ route('sales.index') }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">Back to Sales</a>
            </div>

            <!-- Sale Information -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-gray-600 dark:text-gray-400">Sale Date</h3>
                    <p class="font-semibold dark:text-gray-100">{{ $sale->sale_date->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <h3 class="text-gray-600 dark:text-gray-400">Cashier</h3>
                    <p class="font-semibold dark:text-gray-100">{{ $sale->user->name }}</p>
                </div>
                <div>
                    <h3 class="text-gray-600 dark:text-gray-400">Payment Method</h3>
                    <p class="font-semibold dark:text-gray-100">{{ $sale->paymentMethod->name }}</p>
                </div>
                <div>
                    <h3 class="text-gray-600 dark:text-gray-400">Status</h3>
                    <p class="font-semibold dark:text-gray-100">{{ ucfirst($sale->status) }}</p>
                </div>
            </div>

            <!-- Items Table -->
            <table class="min-w-full mb-6">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Product</th>
                        <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Quantity</th>
                        <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Unit Price</th>
                        <th class="px-6 py-3 border-b-2 dark:border-gray-700 text-gray-900 dark:text-gray-100">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                        <tr>
                            <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ $item->product->name }}</td>
                            <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-4 border-b dark:border-gray-700 text-gray-900 dark:text-gray-100">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <div class="border-t dark:border-gray-700 pt-4">
                <div class="flex justify-between mb-2">
                    <span class="font-semibold dark:text-gray-300">Subtotal:</span>
                    <span class="dark:text-gray-100">${{ number_format($sale->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-semibold dark:text-gray-300">Tax:</span>
                    <span class="dark:text-gray-100">${{ number_format($sale->tax_amount, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-semibold dark:text-gray-300">Discount:</span>
                    <span class="dark:text-gray-100">${{ number_format($sale->discount_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold">
                    <span class="dark:text-gray-100">Total:</span>
                    <span class="dark:text-gray-100">${{ number_format($sale->final_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
