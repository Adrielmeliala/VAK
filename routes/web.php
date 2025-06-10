<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

// Halaman utama
Route::get('/', function () {
    $products = Product::latest()->get();
    return view('welcome', compact('products'));
});

// Dashboard untuk Customer (role 2)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:2'])->name('dashboard'); // PERUBAHAN DI SINI


// Grup Route untuk Admin (role 1)
Route::middleware(['auth', 'verified', 'role:1'])->group(function () { // PERUBAHAN DI SINI
    
    // Route ini akan menangani redirect setelah login. Diberi nama 'admin' untuk mengatasi error sebelumnya.
    Route::get('/admin', [ProductController::class, 'index'])->name('admin');

    // Mengelompokkan semua route admin di bawah prefix /admin
    Route::prefix('admin')->name('admin.')->group(function () {
        // Manajemen Produk
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
});


// Route untuk Profile (berlaku untuk semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
