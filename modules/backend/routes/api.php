<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CookController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RestaurantController;
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

Route::prefix('public')->group(function () {
    Route::get('/restaurant', [RestaurantController::class, 'index']);
    Route::get('/restaurant/{restaurant}', [RestaurantController::class, 'get']);
    Route::get('/menu/{menu}/dish', [DishController::class, 'menus_dish']);
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/dish', [DishController::class, 'index']);
    Route::get('/dish/{dish}/rating', [DishController::class, 'dish_ratings']);
});

Route::middleware('auth')->group(function () {
    Route::get('/user', function () {
        return auth()->user;
    });
    Route::prefix('customer')->middleware('role:customer')->group(function () {
        Route::prefix('cart')->group(function () {
            Route::get('/', [CustomerController::class, 'get_dishes_in_cart']);
            Route::post('/add/{dish}', [CustomerController::class, 'add_dish_to_cart']);
            Route::post('/remove/{dish}', [CustomerController::class, 'remove_dish_from_cart']);
            Route::post('/count/{dish}', [CustomerController::class, 'change_count_dish_in_cart']);
        });
        Route::prefix('order')->group(function () {
            Route::post('/', [OrderController::class, 'create']);
            Route::get('/', [OrderController::class, 'customer_orders']);
            Route::get('/{order}', [OrderController::class, 'customer_order_details']);
            Route::post('/{order}/{status}', [OrderController::class, 'change_status']);//отменить заказ
        });
        Route::prefix('rating')->group(function () {
            Route::get('/', [RatingController::class, 'index']);
            Route::get('/{dish}', [RatingController::class, 'check']);
            Route::post('/{dish}', [RatingController::class, 'create']);
            Route::put('/{rating}', [RatingController::class, 'update']);
            Route::delete('/{rating}', [RatingController::class, 'delete']);
        });
        Route::prefix('profile')->group(function () {
            Route::get('/', [CustomerController::class, 'get']);
            Route::put('/', [CustomerController::class, 'update']);
        });
    });
    Route::prefix('manager')->middleware('role:manager')->group(function () {
        Route::get('/cook', [ManagerController::class, 'get_cooks']);
        Route::prefix('order')->group(function () {
            Route::get('/', [ManagerController::class, 'get_orders']);
            Route::post('/{order}/{status}', [OrderController::class, 'change_status']);
            Route::put('/{order}/', [ManagerController::class, 'order_update']);
        });
        Route::prefix('profile')->group(function () {
            Route::get('/', [ManagerController::class, 'get']);
        });
    });
    Route::prefix('cook')->middleware('role:cook')->group(function () {
        Route::prefix('profile')->group(function () {
            Route::get('/', [CookController::class, 'get']);
        });
        Route::prefix('order')->group(function (){
            Route::post('/{order}/{status}', [OrderController::class, 'change_status']);
            Route::get('/', [CookController::class, 'get_orders_history']);
        });
    });
    Route::prefix('courier')->middleware('role:courier')->group(function () {
        Route::prefix('profile')->group(function () {
            Route::get('/', [CourierController::class, 'get']);//
        });
        Route::prefix('order')->group(function (){
            Route::get('/available', [CourierController::class, 'get_available_orders']);
            Route::post('/{order}/execute', [CourierController::class, 'execute_order']);
            Route::post('/{order}/{status}', [CourierController::class, 'change_status']);
            Route::get('/', [CourierController::class, 'get_orders_history']);
        });
    });
});
