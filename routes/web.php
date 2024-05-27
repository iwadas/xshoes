<?php

use App\Http\Middleware\IsModerator;
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
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\ControlPanelItemController;
use App\Http\Controllers\ControlPanelNewsController;
use App\Http\Controllers\ControlPanelOrderController;
use App\Http\Controllers\ControlPanelSalesController;

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

Route::resource('order', OrderController::class)->middleware('auth')->only(['index', 'destroy', 'show']);

Route::name('control_panel.')->prefix('control_panel')->middleware(['auth', IsModerator::class])->group(function(){
    
    Route::get('index', [ControlPanelController::class, 'index'])->name('index');
    
    Route::name('order.')->prefix('order')->controller(ControlPanelOrderController::class)->group(function(){
        Route::get('index', 'index')->name('index');
        Route::put('{order}/update', 'update')->name('update');
        Route::put('{order}/complete', 'complete')->name('complete');
    });

    Route::get('sales', [ControlPanelSalesController::class, 'index'])->name('sales.index');

    Route::name('news.')->prefix('news')->controller(ControlPanelNewsController::class)->group(function(){
        Route::get('', 'index')->name('index');
        Route::post('', 'store')->name('store');
        Route::delete('{news}', 'destroy')->name('destroy');
    });
    
    Route::name('item.')->prefix('item')->controller(ControlPanelItemController::class)->group(function(){
        Route::get('', 'index')->name('index');
        Route::post('{item}', 'update')->name('update');
        Route::post('', 'store')->name('store');
        Route::delete('{item}', 'destroy')->name('destroy');
    });
    
    Route::name('promo_code.')->prefix('promo_code')->controller(PromoCodeController::class)->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::put('{promo_code}', 'update')->name('update');
        Route::post('', 'store')->name('store');
        Route::delete('{promo_code}', 'destroy')->name('destroy');
    });

});