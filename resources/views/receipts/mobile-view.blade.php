<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $sale->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden my-4">
        <div class="px-4 py-6">
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold">{{ config('app.name') }}</h1>
                <p class="text-gray-600">Receipt #{{ $sale->id }}</p>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600">Date: {{ $sale->sale_date->format('M d, Y h:i A') }}</p>
                <p class="text-sm text-gray-600">Cashier: {{ $sale->user->name }}</p>
                <p class="text-sm text-gray-600">Payment: {{ $sale->paymentMethod->name }}</p>
            </div>

            <div class="border-t border-b border-gray-200 py-4 mb-6">
                @foreach($sale->items as $item)
                <div class="flex justify-between py-2">
                    <div>
                        <p class="font-medium">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-600">{{ $item->quantity }} x ${{ number_format($item->unit_price, 2) }}</p>
                    </div>
                    <p class="font-medium">${{ number_format($item->subtotal, 2) }}</p>
                </div>
                @endforeach
            </div>

            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal:</span>
                    <span>${{ number_format($sale->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tax:</span>
                    <span>${{ number_format($sale->tax_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Discount:</span>
                    <span>${{ number_format($sale->discount_amount, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total:</span>
                    <span>${{ number_format($sale->final_amount, 2) }}</span>
                </div>
            </div>

            <div class="text-center mt-8 text-sm text-gray-600">
                <p>Thank you for your purchase!</p>
                <p>{{ config('app.name') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
