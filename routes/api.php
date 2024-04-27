<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiOrdersController;
use App\Http\Controllers\Api\ApiProductsController;
use App\Http\Controllers\Backend\BackendAdminController;
use App\Http\Controllers\Backend\BackendHelperController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::post('/refresh', [ApiAuthController::class, 'refresh']);
    Route::get('/user-profile', [ApiAuthController::class, 'userProfile']);
});
Route::get('del/{param}', [BackendAdminController::class, 'helper']);

Route::get('/must_login', [BackendHelperController::class, 'must_login'])->name('must_login');

Route::middleware(['api'])->prefix('products')->name('products.')->group(function () {
    Route::get('/get', [ApiProductsController::class, 'index'])->name('get');
    Route::get('/get/{category}', [ApiProductsController::class, 'getProductsByCategory'])->name('getProductsByCategory');
});


Route::get('/payments/verify/{payment?}', [ApiOrdersController::class, 'payment_verify'])->name('orders-verify-payment');

Route::group([
    'middleware' => ['api', 'ApiActiveAccount'],
], function ($router) {
    Route::middleware(['api', 'ApiActiveAccount'])->prefix('orders')->name('orders.')->group(function () {
        Route::post('/create', [ApiOrdersController::class, 'store'])->name('create');
    });
});
