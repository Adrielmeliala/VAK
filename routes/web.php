<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController; 
use App\Models\Product;                     

Route::get('/', function () {
    $products = Product::latest()->get();
    return view('welcome', compact('products'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Ganti grup route admin Anda dengan ini
Route::middleware(['auth', 'verified', 'rolemanager-admin'])->group(function () {
    
    // Route ini akan menangani redirect setelah login ke /admin
    // Dan kita beri nama 'admin' agar tidak error.
    Route::get('/admin', [ProductController::class, 'index'])->name('admin');

    // Route-route untuk manajemen produk
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
});


require __DIR__.'/auth.php';
