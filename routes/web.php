<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CartController;
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

// Shopping session
    Route::get('/shopping', [\App\Http\Controllers\ShoppingSessionController::class, 'index'])->name('shopping.index');
    Route::post('/shopping/{product}', [\App\Http\Controllers\ShoppingSessionController::class, 'add'])->name('shopping.add');

// Cart Item
    Route::post('/cart-item/{cartItem}', [CartItemController::class, 'update'])->name('cart-item.update');
    Route::delete('/cart-item/{cartItem}', [CartItemController::class, 'delete'])->name('cart-item.delete');

// Authentication
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Stripe Payment
    Route::get('/pay', [\App\Http\Controllers\StripeController::class, 'pay'])->name('stripe.pay');
    Route::get('/success', [\App\Http\Controllers\StripeController::class, 'success'])->name('stripe.success');
});

Route::post('/webhook', [\App\Http\Controllers\StripeController::class, 'webhook'])->name('stripe.webhook');
