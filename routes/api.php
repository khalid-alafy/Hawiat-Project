<?php
namespace App\Http\Controllers;

use App\Http\Controllers\DepartmentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RateController;


/*
|--------------------------------------------------------------------------
| API Routes for reviews and rates modues
|--------------------------------------------------------------------------
*/

Route::apiResource('reviews', ReviewController::class);
Route::apiResource('rates', RateController::class);


/*
|--------------------------------------------------------------------------
| Product API Routes
|--------------------------------------------------------------------------
|
*/
Route::apiResource('products', ProductController::class);
Route::post('/insertBranchProducts',[ProductController::class,'insertBranchProducts']);
Route::post('/nearestBranchesProducts',[ProductController::class,'nearestBranchesProducts']);
Route::post('/searchProduct',[ProductController::class,'searchProduct']);
Route::get('/companyProducts/{id}',[ProductController::class,'companyProducts']);

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

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('users',UserController::class);
    Route::post('logout',[LoginController::class,'logout']);
});

/*
|--------------------------------------------------------------------------
| Department API Routes
|--------------------------------------------------------------------------
*/
Route::apiResource('departments', DepartmentController::class);
Route::get('department-products', [DepartmentController::class, 'departmentProducts'])->name('department_products');
Route::get('department-branches', [DepartmentController::class, 'departmentBranches'])->name('department_branches');

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
| Branche API Routes
|--------------------------------------------------------------------------
|
|
*/

Route::apiResource('branches', BranchController::class);

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



