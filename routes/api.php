<?php

use App\Http\Controllers\DepartmentController;
use Illuminate\Http\Request;
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
Route::apiResource('departments', DepartmentController::class);
Route::get('department-products', [DepartmentController::class, 'departmentProducts'])->name('department_products');
Route::get('department-branches', [DepartmentController::class, 'departmentBranches'])->name('department_branches');

