<?php
namespace App\Http\Controllers;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Models\Company;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RateController;

/*
|--------------------------------------------------------------------------
| API Routes for reviews and rates modues
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('reviews', ReviewController::class);
    Route::apiResource('rates', RateController::class);
});


/*
|--------------------------------------------------------------------------
| Product API Routes
|--------------------------------------------------------------------------
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::post('/insertBranchProducts',[ProductController::class,'insertBranchProducts']);
    Route::post('/nearestBranchesProducts',[ProductController::class,'nearestBranchesProducts']);
    Route::post('/searchProduct',[ProductController::class,'searchProduct']);
    Route::get('/companyProducts/{id}',[ProductController::class,'companyProducts']);
});

/*
|--------------------------------------------------------------------------
| Auth API Routes
|--------------------------------------------------------------------------
*/

Route::post('user/register',[RegisterController::class, 'userRegister']);
Route::post('company/register',[RegisterController::class,'companyRegister']);

Route::post('user/login', [LoginController::class, 'userLogin']);
Route::post('company/login',[LoginController::class, 'companyLogin']);

/*
|--------------------------------------------------------------------------
| Department API Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('departments', DepartmentController::class);
    Route::get('department-products', [DepartmentController::class, 'departmentProducts'])->name('department_products');
    Route::get('department-branches', [DepartmentController::class, 'departmentBranches'])->name('department_branches');
});

/*
|--------------------------------------------------------------------------
| Company API Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('companies', CompanyController::class)->middleware(['abilities:company']);
    Route::post('logout',[LoginController::class, 'logout']);
});

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


Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('users',UserController::class)->middleware(['abilities:user']);
    Route::post('logout',[LoginController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Branche API Routes
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('branches', BranchController::class);
});

/*
|--------------------------------------------------------------------------
| Other API Routes
|--------------------------------------------------------------------------
|
*/
Broadcast::routes(['middleware' => ['auth:sanctum']]);
Route::view('/test','checkingwebsockets');

Route::middleware('auth:sanctum')->group(function () {
   
    Route::get('send-notification',function(){
        $user=auth('sanctum')->user();
        $user->notify(new OrderCreatedNotification);
        $user->unreadNotifications->markAsRead();
        return 'sent!';
    });
     Route::get('/auth',function(){
        return auth('sanctum')->user();
    });
});
