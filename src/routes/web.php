<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LayoutController::class, 'home'])->name('layout.home');

Route::prefix('admin')->group(function () {

    Route::get('/products', [AdminController::class, 'listProducts'])
        ->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])
        ->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'addProduct'])
        ->name('admin.products.add');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])
        ->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])
        ->name('admin.products.delete');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__ . '/auth.php';
