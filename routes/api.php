<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



/*
|--------------------------------------------------------------------------
| Order API Routes
|--------------------------------------------------------------------------
|
*/
Route::post('/payment/initiate', [PaymentController::class, 'initiatPayment']);//->name('payment.initiate');
Route::get('orders', [OrderController::class, 'index'])->name('orders.all');
Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.order');
Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.delete');

