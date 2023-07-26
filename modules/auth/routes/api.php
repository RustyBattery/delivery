<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function (){
    Route::post('register', [UserController::class, 'create']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('refresh')->post('refresh', [AuthController::class, 'refresh']);
    Route::middleware('auth')->group(function (){
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('check', function (){});
        Route::prefix('profile')->group(function (){
            Route::get('/', [UserController::class, 'get']);
            Route::put('/', [UserController::class, 'update']);
            Route::delete('/', [UserController::class, 'delete']);
        });
    });
});
