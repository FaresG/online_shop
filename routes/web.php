<?php

use App\Http\Controllers\CartItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::get('/test', function () {

})->name('home');

// Home
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::middleware('guest')->group(function () {
    // Authentication
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'doLogin']);
});

Route::middleware('auth')->group(function () {
    // Article
    Route::resource('products', \App\Http\Controllers\ProductController::class)->except('show');
    Route::get('/products/{slug}-{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

    // Cart
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');

    // Cart Item
    Route::post('/cart-item/{cartItem}', [CartItemController::class, 'update'])->name('cart-item.update');
    Route::delete('/cart-item/{cartItem}', [CartItemController::class, 'delete'])->name('cart-item.delete');

    // Order
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');


    // Authentication
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    // Stripe Payment
    Route::get('/pay/{cart}', [\App\Http\Controllers\StripeController::class, 'pay'])->name('stripe.pay');
    Route::get('/success', [\App\Http\Controllers\StripeController::class, 'success'])->name('stripe.success');
});

Route::post('/webhook', [\App\Http\Controllers\StripeController::class, 'webhook'])->name('stripe.webhook');
