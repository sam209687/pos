@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold tracking-tight dark:text-gray-100">Add New Product</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Create a new product in your inventory</p>
            </div>
            <a href="{{ route('products.index') }}" 
                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Products
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
                @csrf
                
                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2">
                        <div class="h-6 w-1 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Basic Information</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Code -->
                        <div class="space-y-2">
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Code
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="code" 
                                    id="code" 
                                    value="{{ old('code') }}" 
                                    required 
                                    pattern="[0-9]{4}"
                                    minlength="4"
                                    maxlength="4"
                                    placeholder="Enter 4-digit code"
                                    class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-8"
                                />
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">#</span>
                            </div>
                            @error('code')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 dark:text-gray-400">Next available code: {{ $nextCode }}</p>
                        </div>

                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}" 
                                required
                                placeholder="Enter product name"
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('name')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="space-y-2 md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="3"
                                placeholder="Enter product description"
                                class="flex min-h-[80px] w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Category & Brand Section -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2">
                        <div class="h-6 w-1 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Category & Brand</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category -->
                        <div class="space-y-2">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category
                                <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="category_id" 
                                id="category_id" 
                                required
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Brand -->
                        <div class="space-y-2">
                            <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Brand
                                <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="brand_id" 
                                id="brand_id" 
                                required
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="">Select a brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2">
                        <div class="h-6 w-1 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pricing</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Price -->
                        <div class="space-y-2">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Selling Price
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                value="{{ old('price') }}" 
                                step="0.01" 
                                required
                                placeholder="Enter selling price"
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('price')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cost Price -->
                        <div class="space-y-2">
                            <label for="cost_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Cost Price
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="cost_price" 
                                id="cost_price" 
                                value="{{ old('cost_price') }}" 
                                step="0.01" 
                                required
                                placeholder="Enter cost price"
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('cost_price')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Inventory Section -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2">
                        <div class="h-6 w-1 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Inventory</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Quantity -->
                        <div class="space-y-2">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Quantity
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="quantity" 
                                id="quantity" 
                                value="{{ old('quantity') }}" 
                                required
                                placeholder="Enter quantity"
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('quantity')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alert Quantity -->
                        <div class="space-y-2">
                            <label for="alert_quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Alert Quantity
                                <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="alert_quantity" 
                                id="alert_quantity" 
                                value="{{ old('alert_quantity') }}" 
                                required
                                placeholder="Enter alert quantity"
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('alert_quantity')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Status
                                <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="status" 
                                id="status" 
                                required
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="">Select status</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Media Section -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2">
                        <div class="h-6 w-1 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Media</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Image -->
                        <div class="space-y-2">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Image
                            </label>
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/*"
                                class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('image')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- QR Code Generation -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    QR Code
                                </label>
                                <button 
                                    type="button" 
                                    id="generateQRBtn" 
                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-indigo-600 text-white hover:bg-indigo-700 h-10 px-4 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    Generate QR Code
                                </button>
                            </div>
                            
                            <!-- QR Code Preview -->
                            <div id="qrCodePreview" class="hidden">
                                <div class="bg-white dark:bg-gray-700 p-4 rounded-md border border-gray-200 dark:border-gray-600">
                                    <div class="flex flex-col items-center space-y-4">
                                        <div id="qrCodeContainer" class="w-48 h-48 bg-white dark:bg-gray-600 p-2 rounded-lg shadow-sm"></div>
                                        <div class="flex flex-col items-center gap-4">
                                            <button 
                                                type="button" 
                                                id="downloadQRBtn" 
                                                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-green-600 text-white hover:bg-green-700 h-10 px-4 py-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                Download QR Code
                                            </button>
                                            <button 
                                                type="button" 
                                                id="regenerateQRBtn" 
                                                class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white text-sm flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                                </svg>
                                                Generate New Code
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-indigo-600 text-white hover:bg-indigo-700 h-10 px-4 py-2">
                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const generateQRBtn = document.getElementById('generateQRBtn');
        const downloadQRBtn = document.getElementById('downloadQRBtn');
        const regenerateQRBtn = document.getElementById('regenerateQRBtn');
        const qrCodePreview = document.getElementById('qrCodePreview');
        const qrCodeContainer = document.getElementById('qrCodeContainer');
        const codeInput = document.getElementById('code');
        const nameInput = document.getElementById('name');

        let currentQRCode = null;

        function generateQRCode() {
            const code = codeInput.value;
            const name = nameInput.value;

            if (!code || !name) {
                alert('Please enter both product code and name to generate QR code');
                return;
            }

            // Clear previous QR code
            qrCodeContainer.innerHTML = '';
            
            // Generate new QR code
            currentQRCode = new QRCode(qrCodeContainer, {
                text: `${code} - ${name}`,
                width: 180,
                height: 180,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            qrCodePreview.classList.remove('hidden');
        }

        function downloadQRCode() {
            if (!currentQRCode) return;

            const canvas = qrCodeContainer.querySelector('canvas');
            const link = document.createElement('a');
            link.download = `qr-code-${codeInput.value}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        }

        generateQRBtn.addEventListener('click', generateQRCode);
        downloadQRBtn.addEventListener('click', downloadQRCode);
        regenerateQRBtn.addEventListener('click', generateQRCode);
    });
</script>
@endpush
@endsection 