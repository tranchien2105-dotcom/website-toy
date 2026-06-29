<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerAdminController;
use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LayoutController::class, 'home'])
    ->name('layout.home');

Route::post('/cart/add/{id}', [LayoutController::class, 'addCart'])
    ->name('cart.add');

Route::get('/cart', [LayoutController::class, 'cart'])
    ->name('layout.cart');

Route::get('/cart/remove/{id}', [LayoutController::class, 'removeCart'])
    ->name('layout.cart.remove');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::middleware('auth')
//     ->prefix('admin')
//     ->group(function () {

//         Route::prefix('products')->group(function () {

//             Route::get('/', [AdminController::class, 'listProducts'])
//                 ->name('admin.products');

//             Route::get('/create', [AdminController::class, 'createProduct'])
//                 ->name('admin.products.create');

//             Route::post('/', [AdminController::class, 'addProduct'])
//                 ->name('admin.products.add');

//             Route::get('/{id}/edit', [AdminController::class, 'editProduct'])
//                 ->name('admin.products.edit');

//             Route::put('/{id}', [AdminController::class, 'updateProduct'])
//                 ->name('admin.products.update');

//             Route::delete('/{id}', [AdminController::class, 'deleteProduct'])
//                 ->name('admin.products.delete');

//             Route::get('/search', [AdminController::class, 'searchProducts'])
//                 ->name('admin.products.search');

//             Route::get('/{id}/gallery', [AdminController::class, 'productGallery'])
//                 ->name('admin.products.gallery');

//             Route::post('/{id}/gallery/add', [AdminController::class, 'addProductGallery'])
//                 ->name('admin.products.gallery.add');

//             Route::delete('/{product}/gallery/{image}', [AdminController::class, 'deleteProductGallery'])
//                 ->name('admin.products.gallery.delete');

//         });

//         Route::prefix('categories')->group(function () {

//             Route::get('/', [CategoryAdminController::class, 'listCategories'])
//                 ->name('admin.categories');

//             Route::get('/create', [CategoryAdminController::class, 'createCategory'])
//                 ->name('admin.categories.create');
//             Route::post('/', [CategoryAdminController::class, 'addCategory'])
//                 ->name('admin.categories.add');
//             Route::get('/{id}/edit', [CategoryAdminController::class, 'editCategory'])
//                 ->name('admin.categories.edit');
//             Route::put('/{id}', [CategoryAdminController::class, 'updateCategory'])
//                 ->name('admin.categories.update');
//             Route::delete('/{id}', [CategoryAdminController::class, 'deleteCategory'])
//                 ->name('admin.categories.delete');
//         });

//         Route::prefix('banners')->group(function () {
//             Route::get('/', [BannerAdminController::class, 'listBanners'])
//                 ->name('admin.banners');
//             Route::get('/create', [BannerAdminController::class, 'createBanner'])
//                 ->name('admin.banners.create');
//             Route::post('/', [BannerAdminController::class, 'addBanner'])
//                 ->name('admin.banners.add');
//             Route::get('/{id}/edit', [BannerAdminController::class, 'editBanner'])
//                 ->name('admin.banners.edit');
//             Route::put('/{id}', [BannerAdminController::class, 'updateBanner'])
//                 ->name('admin.banners.update');
//             Route::delete('/{id}', [BannerAdminController::class, 'deleteBanner'])
//                 ->name('admin.banners.delete');
//         });

//     });
/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

require __DIR__ . '/auth.php';

