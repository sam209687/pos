<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login routes without middleware
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Product management routes
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);

    // POS routes
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::get('/pos/product', [POSController::class, 'getProduct'])->name('pos.get-product');
    Route::post('/pos/process-sale', [POSController::class, 'processSale'])->name('pos.process-sale');

    // Sales routes
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/{sale}', [SalesController::class, 'show'])->name('sales.show');
    Route::get('/sales/export/pdf', [SalesController::class, 'exportPDF'])->name('sales.export-pdf');
    Route::get('/sales/export/excel', [SalesController::class, 'exportExcel'])->name('sales.export-excel');

    // Payment routes
    Route::post('/payments/validate', [PaymentController::class, 'validatePayment'])->name('payments.validate');
    Route::get('/payments/receipt/{sale}', [PaymentController::class, 'generateReceipt'])->name('payments.receipt');
    Route::get('/payments/methods', [PaymentController::class, 'getPaymentMethods'])->name('payments.methods');

    // QR Code routes
    Route::get('/qr/receipt/{sale}', [QRCodeController::class, 'generateReceiptQR'])->name('qrcode.receipt');
    Route::get('/receipts/{sale}/view', [QRCodeController::class, 'viewReceipt'])->name('receipts.view');

    // Profile routes
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::put('/profile', function (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('status', 'Profile updated successfully.');
    })->name('profile.update');
});

// Database test route
Route::get('/db-test', function() {
    try {
        DB::connection()->getPdo();
        return "✓ Database connected successfully: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "✗ Database connection failed: " . $e->getMessage();
    }
});

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

Route::middleware(['throttle:api'])->group(function () {
    // API routes
});
