<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;

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
});

Route::controller(AuthController::class)->group(function(){
// Route::controller(AuthController::class)->middleware('guest')->group(function(){
    Route::get('login', 'login')->name('login');
    Route::get('register', 'register')->name('register');
    Route::post('register_authenticate', 'register_authenticate')->name('register_authenticate');
    Route::post('login_authenticate', 'login_authenticate')->name('login_authenticate');
    Route::delete('logout', 'logout')->name('logout');
});