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

$middlewareName = 'role:ADMIN';

$routes = collect(Route::getRoutes())->filter(function ($route) use ($middlewareName) {
    return collect($route->middleware())->contains($middlewareName);
})->map(function ($route) {
    return $route->uri();
})->values();
