@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Sale Details #{{ $sale->id }}</h1>
                <a href="{{ route('sales.index') }}" class="text-blue-500 hover:text-blue-700">Back to Sales</a>
            </div>

            <!-- Sale Information -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-gray-600">Sale Date</h3>
                    <p class="font-semibold">{{ $sale->sale_date->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <h3 class="text-gray-600">Cashier</h3>
                    <p class="font-semibold">{{ $sale->user->name }}</p>
                </div>
                <div>
                    <h3 class="text-gray-600">Payment Method</h3>
                    <p class="font-semibold">{{ $sale->paymentMethod->name }}</p>
                </div>
                <div>
                    <h3 class="text-gray-600">Status</h3>
                    <p class="font-semibold">{{ ucfirst($sale->status) }}</p>
                </div>
            </div>

            <!-- Items Table -->
            <table class="min-w-full mb-6">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2">Product</th>
                        <th class="px-6 py-3 border-b-2">Quantity</th>
                        <th class="px-6 py-3 border-b-2">Unit Price</th>
                        <th class="px-6 py-3 border-b-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                        <tr>
                            <td class="px-6 py-4 border-b">{{ $item->product->name }}</td>
                            <td class="px-6 py-4 border-b">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 border-b">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-6 py-4 border-b">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals -->
            <div class="border-t pt-4">
                <div class="flex justify-between mb-2">
                    <span class="font-semibold">Subtotal:</span>
                    <span>${{ number_format($sale->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-semibold">Tax:</span>
                    <span>${{ number_format($sale->tax_amount, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-semibold">Discount:</span>
                    <span>${{ number_format($sale->discount_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold">
                    <span>Total:</span>
                    <span>${{ number_format($sale->final_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
