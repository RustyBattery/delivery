<?php

use App\Http\Controllers\BanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::middleware('auth')->middleware('admin')->group(function () {
    Route::prefix('profile')->group(function (){
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::resource('restaurant', RestaurantController::class)->except(['edit']);
    Route::resource('menu', MenuController::class)->except(['index', 'edit']);
    Route::resource('dish', DishController::class)->except(['index', 'edit', 'update', 'create']);
    Route::resource('ban', BanController::class)->except(['store', 'index', 'edit', 'show', 'create']);
    Route::resource('category', CategoryController::class)->except(['show', 'edit', 'create']);
    Route::resource('user', UserController::class)->except(['edit']);
    Route::prefix('restaurant/{restaurant}')->group(function (){
        Route::get('/cook', [RestaurantController::class, 'cook_index'])->name('restaurant.cook.index');
        Route::get('/manager', [RestaurantController::class, 'manager_index'])->name('restaurant.manager.index');
    });
    Route::prefix('/user/{user}')->group(function (){
        Route::post('/ban', [BanController::class, 'store'])->name('user.ban.create');
        Route::get('/ban', [BanController::class, 'index'])->name('user.ban.index');
        Route::post('/manager', [UserController::class, 'manager_upsert'])->name('user.manager.upsert');
        Route::delete('/manager', [UserController::class, 'manager_delete'])->name('user.manager.delete');
        Route::post('/cook', [UserController::class, 'cook_upsert'])->name('user.cook.upsert');
        Route::delete('/cook', [UserController::class, 'cook_delete'])->name('user.cook.delete');
    });
    Route::get('menu/{menu}/dish/create', [DishController::class, 'create'])->name('dish.create');
    Route::post('dish/{dish}/update', [DishController::class, 'update'])->name('dish.update');
});

require __DIR__.'/auth.php';
