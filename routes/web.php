<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\ProductAttrDefController;

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

Route::get('/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');


Route::middleware(['auth'])->group(function() {
    // GET
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/update/{product_id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/update/{product_id}/showHistory/{product_attr_id}', [ProductController::class, 'showHistory'])->name('products.update.showHistory');

    // POST
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
});


