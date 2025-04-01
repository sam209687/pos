<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $sale->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-info {
            margin-bottom: 20px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .totals {
            text-align: right;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <p>Receipt #{{ $sale->id }}</p>
    </div>

    <div class="receipt-info">
        <p>Date: {{ $sale->sale_date->format('M d, Y h:i A') }}</p>
        <p>Cashier: {{ $sale->user->name }}</p>
        <p>Payment Method: {{ $sale->paymentMethod->name }}</p>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->unit_price, 2) }}</td>
                <td>${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>Subtotal: ${{ number_format($sale->total_amount, 2) }}</p>
        <p>Tax: ${{ number_format($sale->tax_amount, 2) }}</p>
        <p>Discount: ${{ number_format($sale->discount_amount, 2) }}</p>
        <p><strong>Total: ${{ number_format($sale->final_amount, 2) }}</strong></p>
        <p>Amount Paid: ${{ number_format($sale->paid_amount, 2) }}</p>
        <p>Change: ${{ number_format($sale->change_amount, 2) }}</p>
    </div>

    <div class="qr-code text-center mb-4">
        <img src="{{ $qrCodeUrl }}" alt="Scan for digital receipt" style="width: 150px; margin: 0 auto;">
        <p class="text-sm">Scan to view digital receipt</p>
    </div>

    <div class="footer">
        <p>Thank you for your purchase!</p>
        <p>{{ config('app.name') }}</p>
    </div>
</body>
</html>
