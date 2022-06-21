<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\TravelController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{slug}', [DetailController::class, 'index'])->name('detail');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout-success');


Route::prefix('admin')
    ->namespace('admin')
    ->middleware(['auth', 'admin'])
    ->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    }); 
    Route::resource('travel', TravelController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('transaction', TransactionController::class);
Auth::routes(['verify' => true]);
