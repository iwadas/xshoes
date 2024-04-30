<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AddressController;
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