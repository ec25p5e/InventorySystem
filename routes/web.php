<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use \App\Http\Controllers\AuthController;

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

Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', [AuthController::class, 'login'])->name('login');

// Proteggi le route che necessitano di login
Route::middleware(['auth'])->group(function() {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
});

// Backend
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
