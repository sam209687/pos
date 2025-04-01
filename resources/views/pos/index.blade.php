@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold mb-6">Point of Sale</h1>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Products Grid -->
                    <div class="lg:col-span-2">
                        <div class="mb-4 flex gap-4">
                            <div class="flex-1">
                                <x-ui.input
                                    type="text"
                                    id="product-search"
                                    placeholder="Search products..."
                                    class="w-full"
                                />
                            </div>
                            <button onclick="toggleScanner()"
                                    id="scan-button"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                <span id="scanner-status" class="w-2 h-2 rounded-full bg-gray-400"></span>
                                <span id="scanner-text">Scan QR Code</span>
                            </button>
                        </div>
                        <!-- QR Scanner Modal -->
                        <div id="qr-scanner-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg max-w-md w-full mx-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Scan Product QR Code</h3>
                                    <button onclick="toggleScanner()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="reader"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($products as $product)
                                <div class="bg-white dark:bg-gray-700 border dark:border-gray-600 rounded-lg p-4 hover:shadow-lg transition-shadow">
                                    <div class="aspect-w-1 aspect-h-1 mb-4">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" 
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-48 object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $product->code }}</p>
                                    <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">₹{{ number_format($product->price, 2) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Stock: {{ $product->quantity }}</p>
                                    <button onclick="addToCart({{ $product->id }})"
                                            class="mt-2 w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
                                        Add to Cart
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Cart -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Shopping Cart</h2>
                            <div id="cart-items" class="space-y-4">
                                <!-- Cart items will be dynamically added here -->
                            </div>
                            <div class="mt-4 pt-4 border-t dark:border-gray-600">
                                <div class="flex justify-between mb-2 text-gray-900 dark:text-gray-100">
                                    <span>Subtotal:</span>
                                    <span id="subtotal">₹0.00</span>
                                </div>
                                <div class="flex justify-between mb-2 text-gray-900 dark:text-gray-100">
                                    <span>Tax (10%):</span>
                                    <span id="tax">₹0.00</span>
                                </div>
                                <div class="flex justify-between mb-2 text-gray-900 dark:text-gray-100">
                                    <span>Total:</span>
                                    <span id="total" class="font-bold">₹0.00</span>
                                </div>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <x-ui.label for="payment-method" class="text-gray-900 dark:text-gray-100">Payment Method</x-ui.label>
                                        <x-ui.select id="payment-method" class="w-full mt-1">
                                            <option value="">Select Payment Method</option>
                                            @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                                            @endforeach
                                        </x-ui.select>
                                    </div>
                                    <button onclick="processSale()"
                                            class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                                        Complete Sale
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let cart = [];
    let products = @json($products);
    let html5QrCode = null;
    let isScannerReady = false;

    function updateScannerStatus(ready) {
        const statusDot = document.getElementById('scanner-status');
        const statusText = document.getElementById('scanner-text');
        const scanButton = document.getElementById('scan-button');
        
        if (ready) {
            statusDot.classList.remove('bg-gray-400');
            statusDot.classList.add('bg-green-500');
            statusText.textContent = 'Scanner Ready';
            scanButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
            scanButton.classList.add('bg-green-600', 'hover:bg-green-700');
        } else {
            statusDot.classList.remove('bg-green-500');
            statusDot.classList.add('bg-gray-400');
            statusText.textContent = 'Scan QR Code';
            scanButton.classList.remove('bg-green-600', 'hover:bg-green-700');
            scanButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
        }
    }

    function toggleScanner() {
        const modal = document.getElementById('qr-scanner-modal');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            startScanner();
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            stopScanner();
        }
    }

    function startScanner() {
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
                showTorchButtonIfSupported: true,
                showZoomSliderIfSupported: true,
                supportedScanTypes: [
                    Html5QrcodeScanType.SCAN_TYPE_CAMERA,
                    Html5QrcodeScanType.SCAN_TYPE_FILE
                ]
            };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanError
            ).then(() => {
                isScannerReady = true;
                updateScannerStatus(true);
            }).catch(err => {
                console.error('Error starting scanner:', err);
                isScannerReady = false;
                updateScannerStatus(false);
                if (err.name === 'NotAllowedError') {
                    alert('Camera access was denied. Please enable camera permissions in your browser settings.');
                } else if (err.name === 'NotFoundError') {
                    alert('No camera found. Please connect a camera and try again.');
                } else {
                    alert('Error starting QR scanner: ' + err.message);
                }
                toggleScanner();
            });
        }
    }

    function stopScanner() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                html5QrCode = null;
                isScannerReady = false;
                updateScannerStatus(false);
            }).catch(err => {
                console.error('Error stopping scanner:', err);
            });
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Stop scanning after successful scan
        stopScanner();
        
        // Try to find product by code
        const product = products.find(p => p.code === decodedText);
        if (product) {
            addToCart(product.id);
            toggleScanner();
        } else {
            alert('Product not found with this QR code.');
        }
    }

    function onScanError(errorMessage, error) {
        // Only log errors that aren't the common "no code detected" errors
        if (!errorMessage.includes('No MultiFormat Readers were able to detect the code')) {
            console.error('Scan error:', errorMessage);
        }
    }

    function initializeProductSearch() {
        const productSearchInput = document.getElementById('product-search');
        if (!productSearchInput) return;

        productSearchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const productGrid = document.querySelector('.grid');
            if (!productGrid) return;

            const productCards = productGrid.querySelectorAll('.bg-white');
            productCards.forEach(card => {
                const productName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const productCode = card.querySelector('.text-sm')?.textContent.toLowerCase() || '';
                
                if (productName.includes(searchTerm) || productCode.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Initialize search functionality when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeProductSearch();
    });

    function addToCart(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

        const existingItem = cart.find(item => item.product_id === productId);
        if (existingItem) {
            if (existingItem.quantity < product.quantity) {
                existingItem.quantity++;
                existingItem.subtotal = existingItem.quantity * parseFloat(existingItem.unit_price);
            }
        } else {
            cart.push({
                product_id: product.id,
                name: product.name,
                unit_price: parseFloat(product.price),
                quantity: 1,
                subtotal: parseFloat(product.price)
            });
        }

        updateCartDisplay();
    }

    function updateCartDisplay() {
        const cartItems = document.getElementById('cart-items');
        cartItems.innerHTML = '';

        let subtotal = 0;

        cart.forEach(item => {
            subtotal += parseFloat(item.subtotal);
            cartItems.innerHTML += `
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">${item.name}</h3>
                        <p class="text-sm text-gray-600">₹${parseFloat(item.unit_price).toFixed(2)} x ${item.quantity}</p>
                        <p class="text-sm font-semibold">₹${parseFloat(item.subtotal).toFixed(2)}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="updateQuantity(${item.product_id}, ${item.quantity - 1})"
                                class="text-red-600 hover:text-red-800">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQuantity(${item.product_id}, ${item.quantity + 1})"
                                class="text-green-600 hover:text-green-800">+</button>
                    </div>
                </div>
            `;
        });

        const tax = subtotal * 0.1;
        const total = subtotal + tax;

        document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
        document.getElementById('tax').textContent = `₹${tax.toFixed(2)}`;
        document.getElementById('total').textContent = `₹${total.toFixed(2)}`;
    }

    function updateQuantity(productId, newQuantity) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

        if (newQuantity <= 0) {
            cart = cart.filter(item => item.product_id !== productId);
        } else if (newQuantity <= product.quantity) {
            const item = cart.find(item => item.product_id === productId);
            if (item) {
                item.quantity = newQuantity;
                item.subtotal = item.quantity * parseFloat(item.unit_price);
            }
        }

        updateCartDisplay();
    }

    function processSale() {
        const paymentMethodId = document.getElementById('payment-method').value;
        if (!paymentMethodId) {
            alert('Please select a payment method');
            return;
        }

        if (cart.length === 0) {
            alert('Cart is empty');
            return;
        }

        const subtotal = cart.reduce((sum, item) => sum + parseFloat(item.subtotal), 0);
        const tax = subtotal * 0.1;
        const total = subtotal + tax;

        const saleData = {
            payment_method_id: parseInt(paymentMethodId),
            items: cart.map(item => ({
                product_id: item.product_id,
                quantity: item.quantity,
                unit_price: parseFloat(item.unit_price),
                subtotal: parseFloat(item.subtotal)
            })),
            total_amount: subtotal,
            tax_amount: tax,
            final_amount: total,
            paid_amount: total,
            change_amount: 0,
            discount_amount: 0,
            notes: ''
        };

        fetch('/pos/process-sale', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(saleData)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Error processing sale');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Sale completed successfully!');
                cart = [];
                updateCartDisplay();
            } else {
                alert('Error processing sale: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Error processing sale');
        });
    }
</script>
@endpush
