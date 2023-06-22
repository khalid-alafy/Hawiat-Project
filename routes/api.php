<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthCompanyController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| User API Routes
|--------------------------------------------------------------------------
|
| User API routes for your application
|
*/

Route::get('users', [UserController::class, 'index'])->name('users.all');
Route::post('users', [UserController::class, 'store'])->name('users.create');
Route::get('users/{id}', [UserController::class, 'show'])->name('userss.user');
Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.delete');


Route::post('/login',[AuthCompanyController::class,'login']);
Route::post('/register',[AuthCompanyController::class,'register']);
Route::post('/logout',[AuthCompanyController::class,'logout']);

Route::apiResource('companies', CompanyController::class);



/*
|--------------------------------------------------------------------------
| Branche API Routes
|--------------------------------------------------------------------------
|
|
*/
Route::apiResource('branches', BranchController::class);
