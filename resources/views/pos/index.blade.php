@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="flex h-screen">
        <!-- Left Side - Products -->
        <div class="w-2/3 p-4 bg-gray-100 overflow-y-auto">
            <!-- Search Bar -->
            <div class="mb-4">
                <input type="text" 
                       id="product-search" 
                       placeholder="Search products..." 
                       class="w-full p-2 border rounded">
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-3 gap-4" id="products-grid">
                @foreach($products as $product)
                <div class="product-card bg-white p-4 rounded-lg shadow cursor-pointer"
                     data-product="{{ json_encode($product) }}">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}"
                         class="w-full h-32 object-cover mb-2 rounded">
                    <h3 class="font-bold">{{ $product->name }}</h3>
                    <p class="text-gray-600">{{ $product->code }}</p>
                    <p class="text-green-600 font-bold">${{ number_format($product->price, 2) }}</p>
                    <p class="text-sm text-gray-500">Stock: {{ $product->quantity }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Side - Cart -->
        <div class="w-1/3 bg-white p-4 flex flex-col">
            <!-- Cart Header -->
            <div class="mb-4">
                <h2 class="text-2xl font-bold">Current Sale</h2>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto mb-4">
                <table class="min-w-full" id="cart-items">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Item</th>
                            <th class="px-4 py-2">Qty</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- Cart Totals -->
            <div class="border-t pt-4">
                <div class="flex justify-between mb-2">
                    <span>Subtotal:</span>
                    <span id="subtotal">$0.00</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Tax (10%):</span>
                    <span id="tax">$0.00</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Discount:</span>
                    <div>
                        <input type="number" 
                               id="discount" 
                               class="w-20 text-right border rounded p-1" 
                               value="0">
                    </div>
                </div>
                <div class="flex justify-between mb-4 text-xl font-bold">
                    <span>Total:</span>
                    <span id="total">$0.00</span>
                </div>

                <!-- Payment Section -->
                <div class="mb-4">
                    <select id="payment-method" class="w-full p-2 border rounded mb-2">
                        @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                        @endforeach
                    </select>
                    <div class="flex space-x-2">
                        <input type="number" 
                               id="amount-paid" 
                               placeholder="Amount Paid" 
                               class="flex-1 p-2 border rounded">
                        <div class="text-right">
                            <div>Change:</div>
                            <div id="change-amount" class="font-bold">$0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <button id="process-sale" 
                            class="flex-1 bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                        Process Sale
                    </button>
                    <button id="clear-cart" 
                            class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
const TAX_RATE = 0.10;

// Add to cart function
function addToCart(product) {
    const existingItem = cart.find(item => item.product_id === product.id);
    
    if (existingItem) {
        if (existingItem.quantity < product.quantity) {
            existingItem.quantity++;
            existingItem.subtotal = existingItem.quantity * existingItem.unit_price;
        } else {
            alert('Not enough stock!');
            return;
        }
    } else {
        cart.push({
            product_id: product.id,
            name: product.name,
            quantity: 1,
            unit_price: product.price,
            subtotal: product.price
        });
    }
    
    updateCartDisplay();
}

// Update cart display
function updateCartDisplay() {
    const tbody = document.querySelector('#cart-items tbody');
    tbody.innerHTML = '';
    
    cart.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td class="px-4 py-2">${item.name}</td>
                <td class="px-4 py-2">
                    <input type="number" 
                           value="${item.quantity}" 
                           min="1" 
                           class="w-16 border rounded p-1"
                           onchange="updateQuantity(${index}, this.value)">
                </td>
                <td class="px-4 py-2">$${item.unit_price.toFixed(2)}</td>
                <td class="px-4 py-2">$${item.subtotal.toFixed(2)}</td>
                <td class="px-4 py-2">
                    <button onclick="removeItem(${index})" 
                            class="text-red-500 hover:text-red-700">
                        ×
                    </button>
                </td>
            </tr>
        `;
    });
    
    calculateTotals();
}

// Calculate totals
function calculateTotals() {
    const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
    const tax = subtotal * TAX_RATE;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const total = subtotal + tax - discount;
    
    document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
    document.getElementById('total').textContent = `$${total.toFixed(2)}`;
    
    // Calculate change
    const amountPaid = parseFloat(document.getElementById('amount-paid').value) || 0;
    const change = amountPaid - total;
    document.getElementById('change-amount').textContent = `$${Math.max(0, change).toFixed(2)}`;
}

// Event Listeners
document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('click', () => {
        const product = JSON.parse(card.dataset.product);
        addToCart(product);
    });
});

document.getElementById('clear-cart').addEventListener('click', () => {
    cart = [];
    updateCartDisplay();
});

document.getElementById('process-sale').addEventListener('click', processSale);

// Process sale function
async function processSale() {
    if (cart.length === 0) {
        alert('Cart is empty!');
        return;
    }
    
    const amountPaid = parseFloat(document.getElementById('amount-paid').value);
    const total = parseFloat(document.getElementById('total').textContent.replace('$', ''));
    
    if (amountPaid < total) {
        alert('Insufficient payment amount!');
        return;
    }
    
    try {
        const response = await fetch('/pos/process-sale', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                items: cart,
                payment_method_id: document.getElementById('payment-method').value,
                total_amount: parseFloat(document.getElementById('subtotal').textContent.replace('$', '')),
                tax_amount: parseFloat(document.getElementById('tax').textContent.replace('$', '')),
                discount_amount: parseFloat(document.getElementById('discount').value) || 0,
                final_amount: total,
                paid_amount: amountPaid,
                change_amount: parseFloat(document.getElementById('change-amount').textContent.replace('$', ''))
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Sale completed successfully!');
            cart = [];
            updateCartDisplay();
            document.getElementById('amount-paid').value = '';
        } else {
            alert('Error processing sale: ' + result.message);
        }
    } catch (error) {
        alert('Error processing sale');
        console.error(error);
    }
}

async function validatePayment() {
    const amountPaid = parseFloat(document.getElementById('amount-paid').value);
    const total = parseFloat(document.getElementById('total').textContent.replace('$', ''));
    const paymentMethodId = document.getElementById('payment-method').value;

    try {
        const response = await fetch('/payments/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                payment_method_id: paymentMethodId,
                amount_paid: amountPaid,
                total_amount: total
            })
        });

        const result = await response.json();
        
        if (!result.success) {
            throw new Error(result.message);
        }

        return true;
    } catch (error) {
        alert(error.message || 'Payment validation failed');
        return false;
    }
}

// Update the processSale function
async function processSale() {
    if (cart.length === 0) {
        alert('Cart is empty!');
        return;
    }

    // Validate payment first
    if (!await validatePayment()) {
        return;
    }

    // ... rest of the existing processSale function ...

    // After successful sale, open receipt in new window
    if (result.success) {
        window.open(`/payments/receipt/${result.sale_id}`, '_blank');
        // ... rest of success handling ...
    }
}
</script>
@endpush
