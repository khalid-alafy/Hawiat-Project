<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthCompanyController;
use App\Http\Controllers\CompanyController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthCompanyController::class,'login']);
Route::post('/register',[AuthCompanyController::class,'register']);
Route::post('/logout',[AuthCompanyController::class,'logout']);

Route::apiResource('companies', CompanyController::class);
