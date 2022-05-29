<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserController::class, 'login'])->middleware('guest');

// route group middleware
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [UserController::class, 'login']);
    Route::post('/login', [UserController::class, 'doLogin']);
});

// route group middleware
Route::group(['middleware' => 'auth'], function () {
    Route::resource('/product', ProductController::class);
    Route::resource('/category', CategoryController::class);
    Route::post('/product/multi-delete', [ProductController::class, 'deleteMulti']);
    Route::post('/category/multi-delete', [CategoryController::class, 'deleteMulti']);
});
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
