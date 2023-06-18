<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;

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

Route::post('logout',[LoginController::class,'logout']);

/*
|--------------------------------------------------------------------------
| User API Routes
|--------------------------------------------------------------------------
|
*/


Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('users',UserController::class);
});
/*
|--------------------------------------------------------------------------
| company API Routes
|--------------------------------------------------------------------------
|
*/
Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('companies', CompanyController::class);
});

/*
|--------------------------------------------------------------------------
| Other API Routes
|--------------------------------------------------------------------------
|
*/

Route::get('unauthorized', function () {
    return  response()->json(
         [
        'status' => 401,
        'message' => 'Unauthorized',
    ]);
})->name('unauthorized');


