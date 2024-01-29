<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProuctAttributesController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\PaginationController;

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

Route::middleware(['role:CUSTODE_SPAI, CUSTODE_SSMT, ADMIN'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'custode'])->name('dashboard.custode');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/update/{product_id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/update/{product_id}/showHistory/{product_attr_id}', [ProductController::class, 'showHistory'])->name('products.update.showHistory');
    Route::get('/products/movements', [ProductController::class, 'movements'])->name('products.movements');
    Route::get('/products/export', [ExportController::class, 'exportToExcel'])->name('products.export_to_excel');

    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/attributes/store', [ProuctAttributesController::class, 'storeAttribute'])->name('products.attribute.store');
});


Route::middleware(['role:ADMIN'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/roles/', [RolesController::class, 'index'])->name('roles.index')->middleware('role:ADMIN');
    Route::get('/roles/user', [RolesController::class, 'userRoles'])->name('roles.user_roles');
});
