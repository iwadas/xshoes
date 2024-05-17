<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PromoCodeController;

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
Route::get('/', function(){
    return redirect()->route('home');
});

Route::controller(HomeController::class)->group(function(){
    Route::get('home', 'home')->name('home');
    Route::get('help', 'help')->name('help');
});

Route::prefix('store')->name('store.')->controller(StoreController::class)->group(function(){
    Route::get('', 'index')->name('index');
    Route::get('/{item}', 'show')->name('show');
});

Route::controller(AuthController::class)->group(function(){
// Route::controller(AuthController::class)->middleware('guest')->group(function(){
    Route::get('login', 'login')->name('login');
    Route::get('register', 'register')->name('register');
    Route::post('register_authenticate', 'register_authenticate')->name('register_authenticate');
    Route::post('login_authenticate', 'login_authenticate')->name('login_authenticate');
    Route::delete('logout', 'logout')->name('logout');
});

Route::controller(CartController::class)->name('cart.')->prefix('cart')->middleware('auth')->group(function(){
    Route::post('', 'store')->name('store');
    Route::get('', 'index')->name('index');
    Route::put('/{cart_item}', 'update')->name('update');
    Route::delete('/{cart_item}', 'destroy')->name('destroy');
});

Route::controller(PromoCodeController::class)->name('promo_code.')->prefix('promo_code')->middleware('auth')->group(function(){
    Route::post('verify', 'verify')->name('verify');
});

Route::controller(CheckoutController::class)->name('checkout.')->prefix('checkout')->middleware('auth')->group(function(){
    Route::get('', 'index')->name("index");
});

Route::resource('address', AddressController::class)->middleware('auth')->only(['store', 'update', 'destroy']);

Route::controller(PaymentController::class)->middleware('auth')->prefix('payment')->name('payment.')->group(function(){
    Route::post('complete/{order}', 'complete')->name('complete');
    Route::post('checkout/paypal', 'paypalCheckout')->name('checkout.paypal');
    Route::post('checkout/stripe', 'stripeCheckout')->name('checkout.stripe');
    Route::get('success/stripe', 'stripeSuccess')->name('success.stripe');
    Route::get('success/paypal', 'paypalSuccess')->name('success.paypal');
    Route::get('cancel/paypal', 'paypalCancel')->name('cancel.paypal');
    Route::get('cancel/stripe', 'stripeCancel')->name('cancel.stripe');
});
// Route::controller(PayPalController::class)->middleware('auth')->group(function(){
//     Route::post('payment/paypal', 'payment')->name('payment.paypal');
//     Route::get('payment_success/paypal', 'success')->name('payment_success.paypal');
//     Route::get('payment_cancel/paypal', 'cancel')->name('payment_cancel.paypal');
// });

// Route::controller(StripeController::class)->middleware('auth')->group(function(){
//     Route::post('payment/stripe', 'payment')->name('payment.stripe');
//     Route::get('payment_success/stripe', 'success')->name('payment_success.stripe');
//     Route::get('payment_cancel/stripe', 'cancel')->name('payment_cancel.stripe');
// });

Route::resource('order', OrderController::class)->middleware('auth')->only(['index', 'destroy', 'show']);