<?php

use App\Http\Controllers\BannerAdminController;
use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Jobs\TestJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {

    return response()->json([
        'message' => 'API OK'
    ]);
});

Route::post('/api-login', function (Request $request) {

    $user = User::where(
        'email',
        $request->email
    )->first();

    if (
        !$user ||
        !Hash::check(
            $request->password,
            $user->password
        )
    ) {

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    return response()->json([
        'token' => $user
            ->createToken('api-token')
            ->plainTextToken
    ]);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post(
        '/test-post',
        [ProfileController::class, 'TestAPI']
    );
});

Route::get('/test-job', function () {

    dispatch(new TestJob());

    return response()->json([
        'message' => 'job dispatched'
    ]);
});


Route::middleware('auth:sanctum')
    ->get('/profile', function (Request $request) {

        return response()->json([
            'user' => $request->user()
        ]);
    });

Route::middleware('auth:sanctum')
    ->prefix('products')
    ->name('api.products.')
    ->group(function () {

        Route::get(
            '/',
            [ProductController::class, 'listProductsApi']
        )->name('list');

        Route::get(
            '/{id}',
            [ProductController::class, 'getProductApi']
        )->name('show');

        Route::post(
            '/',
            [ProductController::class, 'createProductsApi']
        )->name('create');

        Route::put(
            '/{id}',
            [ProductController::class, 'updateProductApi']
        )->name('update');

        Route::delete(
            '/{id}',
            [ProductController::class, 'deleteProductApi']
        )->name('delete');
    });

Route::prefix('categories')
    ->name('api.categories.')
    ->group(function () {

        Route::get(
            '/',
            [CategoryAdminController::class, 'listCategoriesApi']
        )->name('list');

        Route::get(
            '/{id}',
            [CategoryAdminController::class, 'getCategoryApi']
        )->name('show');

         Route::put(
            '/{id}',
            [CategoryAdminController::class, 'updateCategoryApi']
        )->name('update');


    });


Route::prefix('banners')
    ->name('api.banners.')
    ->group(function () {

        Route::get(
            '/',
            [BannerAdminController::class, 'listBannerApi']
        )->name('list');

        Route::get(
            '/{id}',
            [BannerAdminController::class, 'getBannerApi']
        )->name('show');

        Route::put(
            '/{id}',
            [BannerAdminController::class, 'updateBannerApi']
        )->name('update');

        Route::post('/create', [BannerAdminController::class, 'storeBannerApi']);


    });

Route::prefix('orders')
    ->name('api.orders.')
    ->group(function () {

        Route::get(
            '/',
            [OrderAdminController::class, 'listOrdersApi']
        )->name('order.list');

        Route::get('/{id}', [OrderAdminController::class, 'detailOrder']);

        Route::put('/status/{id}', [OrderAdminController::class, 'updateOrderStatus']);
    });