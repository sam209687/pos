<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QRCodeController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        // Add other admin routes here
    });

    // Cashier routes
    Route::middleware('role:cashier,admin')->group(function () {
        Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
        Route::get('/pos/product', [POSController::class, 'getProduct'])->name('pos.get-product');
        Route::post('/pos/process-sale', [POSController::class, 'processSale'])->name('pos.process-sale');
        // Add other POS routes here
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
        Route::get('sales/{sale}', [SalesController::class, 'show'])->name('sales.show');
        Route::get('sales/export/pdf', [SalesController::class, 'exportPDF'])->name('sales.export-pdf');
        Route::get('sales/export/excel', [SalesController::class, 'exportExcel'])->name('sales.export-excel');
        Route::post('/payments/validate', [PaymentController::class, 'validatePayment'])
            ->name('payments.validate');
        Route::get('/payments/receipt/{sale}', [PaymentController::class, 'generateReceipt'])
            ->name('payments.receipt');
        Route::get('/payments/methods', [PaymentController::class, 'getPaymentMethods'])
            ->name('payments.methods');
    });

    Route::get('/qr/receipt/{sale}', [QRCodeController::class, 'generateReceiptQR'])
        ->name('qrcode.receipt');

    Route::get('/receipts/{sale}/view', [QRCodeController::class, 'viewReceipt'])
        ->name('receipts.view');
});

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

// Apply rate limiting to routes
Route::middleware(['throttle:login'])->group(function () {
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware(['throttle:api'])->group(function () {
    // API routes
});
