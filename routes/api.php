<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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


Route::apiResource('products', ProductController::class);
Route::post('/insertBranchProducts',[ProductController::class,'insertBranchProducts']);
Route::post('/nearestBranchesProducts',[ProductController::class,'nearestBranchesProducts']);
Route::post('/searchProduct',[ProductController::class,'searchProduct']);
Route::get('/companyProducts/{id}',[ProductController::class,'companyProducts']);
