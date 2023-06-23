<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthCompanyController;
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
