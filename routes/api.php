<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Models\Company;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;

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
| User API Routes
|--------------------------------------------------------------------------
*/

Route::post('user/register',[RegisterController::class, 'userRegister']);
Route::post('company/register',[RegisterController::class,'companyRegister']);

Route::post('user/login', [LoginController::class, 'userLogin']);
Route::post('company/login',[LoginController::class, 'companyLogin']);



/*
|--------------------------------------------------------------------------
| User API Routes
|--------------------------------------------------------------------------
|
*/

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/auth',function(){
        return auth('sanctum')->user();
    });
    Route::apiResource('users',UserController::class)->middleware(['abilities:user']);
    Route::apiResource('companies', CompanyController::class)->middleware(['abilities:company']);
    Route::post('logout',[LoginController::class, 'logout']);

    Route::get('send-notification',function(){
        $user=auth('sanctum')->user();
        $user->notify(new OrderCreatedNotification);
        $user->unreadNotifications->markAsRead();
        return 'sent!';
    });
    
});
/*
|--------------------------------------------------------------------------
| company API Routes
|--------------------------------------------------------------------------
|
*/
// Route::middleware('auth:sanctum','abilities:company')->group( function () {
//     Route::apiResource('companies', CompanyController::class);
//     Route::post('logout',[LoginController::class,'logout']);
// });

/*
|--------------------------------------------------------------------------
| Other API Routes
|--------------------------------------------------------------------------
|
*/

Route::view('/test','checkingwebsockets');


