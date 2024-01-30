<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProductAttributesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RoutesController;
use App\Models\RoutesConf;
use Illuminate\Support\Facades\Auth;
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

$routeConfigurations = RoutesConf::all();

Route::get('/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

foreach($routeConfigurations as $route) {
    switch($route->route_controller) {
        case 'RoutesController':
            Route::{$route->route_method}($route->route_uri, [RoutesController::class, $route->controller_method])->name($route->route_name)->middleware($route->route_middleware);
            break;
        case 'ProductsController':
            Route::{$route->route_method}($route->route_uri, [ProductController::class, $route->controller_method])->name($route->route_name)->middleware($route->route_middleware);
            break;
        case 'RolesController':
            Route::{$route->route_method}($route->route_uri, [RolesController::class, $route->controller_method])->name($route->route_name)->middleware($route->route_middleware);
            break;
        case 'ProductAttributesController':
            Route::{$route->route_method}($route->route_uri, [ProductAttributesController::class, $route->controller_method])->name($route->route_name)->middleware($route->route_middleware);
            break;
        case 'ExportController':
            Route::{$route->route_method}($route->route_uri, [ExportController::class, $route->controller_method])->name($route->route_name)->middleware($route->route_middleware);
            break;
        case 'DashboardController':
            Route::{$route->route_method}($route->route_uri, [DashboardController::class, $route->controller_method])->name($route->route_name)->middleware($route->route_middleware);
            break;
        default:
            break;
    }

}

/* Route::middleware(['role:SEG_SPAI, SEG_SSMT'])->group(function() {
    Route::get('/segretariato', [DashboardController::class, 'segretariato'])->name('dashboard.segretariato');

    Route::get('/products/segretariato', [ProductController::class, 'index'])->name('products.index.segretariato');
    Route::get('/products/lessProducts/segretariato', [ProductController::class, 'lessProducts'])->name('products.lessProducts.segretariato');
    Route::get('/products/create/segretariato', [ProductController::class, 'create'])->name('products.create.segretariato');
    Route::get('/products/segretariato/update/{product_id}', [ProductController::class, 'update'])->name('products.update.segretariato');
    Route::get('/products/segretariato/update/{product_id}/showHistory/{product_attr_id}', [ProductAttributesController::class, 'showHistory'])->name('products.update.showHistory.segretariato');
    Route::get('/products/segretariato/movements', [ProductController::class, 'movements'])->name('products.movements.segretariato');
    Route::get('/products/segretariato/lessProducts/', [ProductController::class, 'lessProducts'])->name('products.lessProducts.segretariato');

    Route::post('/products/segretariato/store', [ProductController::class, 'store'])->name('products.store.segratariato');
    Route::post('/products/segretariato/attributes/store', [ProductAttributesController::class, 'storeAttribute'])->name('products.attribute.store.segratariato');
    Route::post('/products/segretariato/duplicate', [ProductController::class, 'duplicateProduct'])->name('products.duplicate.segratariato');
});


Route::middleware(['role:CUSTODE_SPAI, CUSTODE_SSMT'])->group(function() {
    Route::get('/custode', [DashboardController::class, 'custode'])->name('dashboard.custode');

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/update/{product_id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/update/{product_id}/showHistory/{product_attr_id}', [ProductAttributesController::class, 'showHistory'])->name('products.update.showHistory');
    Route::get('/products/movements', [ProductController::class, 'movements'])->name('products.movements');
    Route::get('/products/lessProducts/', [ProductController::class, 'lessProducts'])->name('products.lessProducts');

    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/attributes/store', [ProductAttributesController::class, 'storeAttribute'])->name('products.attribute.store');
    Route::post('/products/duplicate', [ProductController::class, 'duplicateProduct'])->name('products.duplicate');
});


Route::middleware(['role:ADMIN'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/roles/', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/user', [RolesController::class, 'userRoles'])->name('roles.user_roles');
    Route::get('routes/config', [RoutesController::class, 'index'])->name('routes.config');
    Route::get('routes/config/create', [RoutesController::class, 'create'])->name('routes.create');

    Route::post(getRouteUri(Auth::id(), 'SAVE_NEW_ROUTE'), [RoutesController::class, 'store'])->name(getRoute(Auth::id(), 'SAVE_NEW_ROUTE'));

    Route::get('/products/create/admin', [ProductController::class, 'create'])->name('products.create.admin');
    Route::get('/products/admin', [ProductController::class, 'index'])->name('products.index.admin');
    Route::get('/products/lessProducts/admin', [ProductController::class, 'lessProducts'])->name('products.lessProducts.admin');
});


Route::middleware(['role:EXPORTER'])->group(function () {
    Route::get('/products/export', [ExportController::class, 'exportToExcel'])->name('products.export_to_excel');
}); */
