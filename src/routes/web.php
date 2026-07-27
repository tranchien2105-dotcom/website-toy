<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/language/{locale}', function ($locale) {

    if (!in_array($locale, ['vi', 'en'])) {
        abort(404);
    }

    session(['locale' => $locale]);

    return back();

})->name('language');

Route::get('/', [LayoutController::class, 'home'])
    ->name('layout.home');

Route::get('/products/{slug}', [LayoutController::class, 'detailProduct'])
    ->name('layout.product.detail');

Route::post('/cart/add/{id}', [LayoutController::class, 'addCart'])
    ->name('cart.add');

Route::get('/checkout', [LayoutController::class, 'checkout'])
    ->middleware('auth')
    ->name('checkout');

Route::post('/checkout/store', [LayoutController::class, 'storeCheckout'])
    ->name('checkout.store');

Route::get('/cart', [LayoutController::class, 'cart'])
    ->name('layout.cart');

Route::post('/cart/update', [LayoutController::class, 'updateCart'])
    ->name('layout.cart.update');

Route::get('/cart/remove/{id}', [LayoutController::class, 'removeCart'])
    ->name('layout.cart.remove');

Route::get('/order/success/{id}', [LayoutController::class, 'orderSuccess'])
    ->name('order.success');

Route::get('/layout-login', [LayoutController::class, 'loginLayout'])
    ->name('layout.login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/search-suggestion', [LayoutController::class, 'searchSuggestion'])
    ->name('search.suggestion');

Route::post('/products/{slug}/comment', [LayoutController::class, 'submitProductComment'])
    ->name('layout.product.comment');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/settings', [SettingController::class, 'edit'])
        ->name('settings.edit');

    Route::post('/settings', [SettingController::class, 'update'])
        ->name('settings.update');

});

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

require __DIR__ . '/auth.php';

